import {defineStore} from "pinia";
import {ref} from "vue";
import axios from "axios";
import type {CategoryType} from "@/types/category";

export const useCategoryStore = defineStore("category", () => {
    const categories = ref<CategoryType[]>([]);

    const fetchCategories = async () => {
        try {
            const response = await axios.get("/api/categories");
            categories.value = response.data.categories as CategoryType[];
        } catch (error) {
            console.error("Kategoriler alınamadı:", error);
        }
    };

    const addCategory = async (formData: FormData) => {
        try {
            const response = await axios.post("/api/categories", formData, {
                headers: {"Content-Type": "multipart/form-data"}
            });
            categories.value.push(response.data);
        } catch (error) {
            console.error("Kategori eklenemedi:", error);
        }
    };

    const updateCategory = async (id: number, formData: FormData) => {
        formData.append("_method", "PUT");

        try {
            await axios.post(`/api/categories/${id}`, formData, {
                headers: {"Content-Type": "multipart/form-data"}
            });

            const index = categories.value.findIndex((c) => c.id === id);
            if (index !== -1) {
                categories.value[index] = {...categories.value[index], ...Object.fromEntries(formData.entries())};
            }
        } catch (error) {
            console.error("Kategori güncellenemedi:", error.response?.data || error);
        }
    };


    const deleteCategory = async (id: number) => {
        try {
            await axios.delete(`/api/categories/${id}`);
            categories.value = categories.value.filter((cat) => cat.id !== id);
        } catch (error) {
            console.error("Kategori silinemedi:", error);
        }
    };

    return {categories, fetchCategories, addCategory, updateCategory, deleteCategory};
});
