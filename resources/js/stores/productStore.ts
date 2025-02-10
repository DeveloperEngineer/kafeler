import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import type { ProductType } from "@/types/product";

export const useProductStore = defineStore("product", () => {
    const products = ref<ProductType[]>([]);


    const fetchProducts = async () => {
        try {
            const response = await axios.get("/api/products");
            products.value = response.data.products as ProductType[];
        } catch (error) {
            console.error("Ürünler alınamadı:", error);
        }
    };


    const addProduct = async (formData: FormData) => {
        try {
            const response = await axios.post("/api/products", formData, {
                headers: { "Content-Type": "multipart/form-data" }
            });
            products.value.push(response.data.product);
        } catch (error) {
            console.error("Ürün eklenemedi:", error);
        }
    };


    const updateProduct = async (id: number, formData: FormData) => {
        formData.append("_method", "PUT");
        console.log("Giden FormData:", Object.fromEntries(formData.entries()));
        console.log(id)
        try {
            await axios.post(`/api/products/${id}`, formData, {
                headers: { "Content-Type": "multipart/form-data" }
            });


            const index = products.value.findIndex((p) => p.id === id);
            if (index !== -1) {
                products.value[index] = {
                    ...products.value[index],
                    ...Object.fromEntries(formData.entries())
                };
            }
        } catch (error) {
            console.error("Ürün güncellenemedi:", error);
        }
    };


    const deleteProduct = async (id: number) => {
        try {
            await axios.delete(`/api/products/${id}`);
            products.value = products.value.filter((p) => p.id !== id);
        } catch (error) {
            console.error("Ürün silinemedi:", error);
        }
    };

    return { products, fetchProducts, addProduct, updateProduct, deleteProduct };
});
