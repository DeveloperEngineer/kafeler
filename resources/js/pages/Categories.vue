<script setup lang="ts">
import { computed, onMounted, ref } from "vue";
import { useCategoryStore } from "@/stores/categoryStore";
import type { CategoryType } from "@/types/category";

const categoryStore = useCategoryStore();
const isModalOpen = ref(false);
const isEditing = ref(false);
const categoryForm = ref<{ id: number; name: string; image: File | null }>({ id: 0, name: "", image: null });
const imagePreview = ref<string | null>(null);

onMounted(async () => {
    await categoryStore.fetchCategories();
});

const categories = computed(() => categoryStore.categories);

const openModal = (category?: CategoryType) => {
    isEditing.value = !!category;
    categoryForm.value = category
        ? { id: category.id, name: category.name, image: null }
        : { id: 0, name: "", image: null };
    imagePreview.value = category?.image ? `/storage/${category.image}` : null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    categoryForm.value = { id: 0, name: "", image: null };
    imagePreview.value = null;
};

const handleImageUpload = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        categoryForm.value.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const saveCategory = async () => {
    const formData = new FormData();
    formData.append("name", categoryForm.value.name);

    if (categoryForm.value.image) {
        formData.append("image", categoryForm.value.image);
    } else if (isEditing.value && imagePreview.value) {
        formData.append("existing_image", imagePreview.value.replace("/storage/", "")); // Eski resmi koru
    }

    if (isEditing.value) {
        await categoryStore.updateCategory(categoryForm.value.id, formData);
    } else {
        await categoryStore.addCategory(formData);
    }
    closeModal();
};

const deleteCategory = (id: number) => {
    categoryStore.deleteCategory(id);
};
</script>

<template>
    <div class="p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Kategoriler</h1>
            <button @click="openModal()" class="bg-green-500 text-white px-4 py-2 rounded">+ Kategori Ekle</button>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">#</th>
                <th class="border p-2">Kategori Adı</th>
                <th class="border p-2">Resim</th>
                <th class="border p-2 text-right">İşlemler</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(category, index) in categories" :key="category.id" class="border">
                <td class="border p-2">{{ index + 1 }}</td>
                <td class="border p-2">{{ category.name }}</td>
                <td class="border p-2">
                    <img v-if="category.image" :src="`/storage/${category.image}`" class="h-12 w-12 object-cover rounded" />
                    <span v-else>-</span>
                </td>
                <td class="border p-2 flex justify-end gap-2">
                    <button @click="openModal(category)" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</button>
                    <button @click="deleteCategory(category.id)" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">{{ isEditing ? "Kategoriyi Güncelle" : "Yeni Kategori Ekle" }}</h2>

                <label class="block mb-2">Kategori Adı</label>
                <input v-model="categoryForm.name" class="w-full border p-2 rounded mb-4" type="text" />

                <label class="block mb-2">Resim Seç</label>
                <input type="file" @change="handleImageUpload" class="w-full border p-2 rounded mb-4" />
                <img v-if="imagePreview" :src="imagePreview" class="h-20 w-20 object-cover rounded mb-4" />

                <div class="flex justify-end gap-2">
                    <button @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">İptal</button>
                    <button @click="saveCategory" class="bg-blue-500 text-white px-4 py-2 rounded">
                        {{ isEditing ? "Güncelle" : "Ekle" }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
