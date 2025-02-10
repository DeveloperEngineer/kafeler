<script setup lang="ts">
import { computed, onMounted, ref } from "vue";
import { useProductStore } from "@/stores/productStore";
import { useCategoryStore } from "@/stores/categoryStore";
import type { ProductType } from "@/types/product";

const productStore = useProductStore();
const categoryStore = useCategoryStore();
const isModalOpen = ref(false);
const isEditing = ref(false);

const productForm = ref<{
    id: number;
    name: string;
    price: number;
    description: string;
    categories: number[];
    image: File | null;
}>({
    id: 0, name: "", price: 0, description: "", categories: [], image: null
});

const imagePreview = ref<string | null>(null);

onMounted(async () => {
    await productStore.fetchProducts();
    await categoryStore.fetchCategories();
});

const products = computed(() => productStore.products);
const categories = computed(() => categoryStore.categories);

const openModal = (product?: ProductType) => {
    isEditing.value = !!product;
    productForm.value = product
        ? {
            id: product.id,
            name: product.name,
            price: product.price,
            description: product.description,
            categories: product.categories.map(c => c.id),
            image: null
        }
        : { id: 0, name: "", price: 0, description: "", categories: [], image: null };

    imagePreview.value = product?.image ? `/storage/${product.image}` : null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    productForm.value = { id: 0, name: "", price: 0, description: "", categories: [], image: null };
    imagePreview.value = null;
};

const handleImageUpload = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        productForm.value.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const saveProduct = async () => {
    const formData = new FormData();
    formData.append("name", productForm.value.name);
    formData.append("price", productForm.value.price.toString());
    formData.append("description", productForm.value.description);


    productForm.value.categories.forEach(category => {
        formData.append("categories[]", category.toString());
    });

    if (productForm.value.categories.length === 0 && isEditing.value) {
        productForm.value.categories = products.value.find(p => p.id === productForm.value.id)?.categories.map(c => c.id) || [];
    }

    if (productForm.value.image) {
        formData.append("image", productForm.value.image);
    } else if (isEditing.value && imagePreview.value) {
        formData.append("existing_image", imagePreview.value.replace("/storage/", ""));
    }

    if (isEditing.value) {
        await productStore.updateProduct(productForm.value.id, formData);
    } else {
        await productStore.addProduct(formData);
    }

    closeModal()
};


const deleteProduct = (id: number) => {
    productStore.deleteProduct(id);
};


</script>

<template>
    <div class="p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Ürünler</h1>
            <button @click="openModal()" class="bg-green-500 text-white px-4 py-2 rounded">+ Ürün Ekle</button>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">#</th>
                <th class="border p-2">Ürün Adı</th>
                <th class="border p-2">Fiyat</th>
                <th class="border p-2">Kategoriler</th>
                <th class="border p-2">Resim</th>
                <th class="border p-2 text-right">İşlemler</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product, index) in products" :key="product.id" class="border">
                <td class="border p-2">{{ index + 1 }}</td>
                <td class="border p-2">{{ product.name }}</td>
                <td class="border p-2">{{ product.price }} ₺</td>
                <td class="border p-2">
                        <span v-for="category in product.categories" :key="category.id" class="bg-gray-200 px-2 py-1 rounded mr-1">
                            {{ category.name }}
                        </span>
                </td>
                <td class="border p-2">
                    <img v-if="product.image" :src="`/storage/${product.image}`" class="h-12 w-12 object-cover rounded" />
                    <span v-else>-</span>
                </td>
                <td class="border p-2 flex justify-end gap-2">
                    <button @click="openModal(product)" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</button>
                    <button @click="deleteProduct(product.id)" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">{{ isEditing ? "Ürünü Güncelle" : "Yeni Ürün Ekle" }}</h2>

                <label class="block mb-2">Ürün Adı</label>
                <input v-model="productForm.name" class="w-full border p-2 rounded mb-4" type="text" />

                <label class="block mb-2">Fiyat</label>
                <input v-model="productForm.price" class="w-full border p-2 rounded mb-4" type="number" />

                <label class="block mb-2">Kategoriler</label>
                <div class="flex flex-wrap gap-2 mb-4">
                    <label v-for="category in categories" :key="category.id" class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            :value="category.id"
                            v-model="productForm.categories"
                            :disabled="productForm.categories.length === 1 && productForm.categories.includes(category.id)"
                        />
                        {{ category.name }}
                    </label>

                </div>

                <label class="block mb-2">Açıklama</label>
                <textarea v-model="productForm.description" class="w-full border p-2 rounded mb-4"></textarea>

                <label class="block mb-2">Resim Seç</label>
                <input type="file" @change="handleImageUpload" class="w-full border p-2 rounded mb-4" />
                <img v-if="imagePreview" :src="imagePreview" class="h-20 w-20 object-cover rounded mb-4" />

                <div class="flex justify-end gap-2">
                    <button @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">İptal</button>
                    <button @click="saveProduct" class="bg-blue-500 text-white px-4 py-2 rounded">
                        {{ isEditing ? "Güncelle" : "Ekle" }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

