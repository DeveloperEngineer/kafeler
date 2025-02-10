<script setup lang="ts">
import {useUserStore} from "@/stores/userStore";
import {computed, onMounted, ref} from "vue";
import type {UserType} from "@/types/user";

const userStore = useUserStore();
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

onMounted(async () => {
    await userStore.fetchUser();
});

const user = computed<UserType | null>(() => userStore.user);

const logout = async () => {
    await userStore.logout();
};

</script>

<template>
    <div class="flex h-screen">
        <aside class="w-64 bg-gray-800 text-white p-6">
            <h2 class="text-2xl font-bold mb-4">Admin Menü</h2>
            <ul class="space-y-2">
                <li>
                    <router-link to="/admin/dashboard" class="block p-2 rounded hover:bg-gray-700">
                        Dashboard
                    </router-link>
                </li>
                <li>
                    <router-link to="/admin/categories" class="block p-2 rounded hover:bg-gray-700">
                        Kategoriler
                    </router-link>
                </li>
                <li>
                    <router-link to="/admin/products" class="block p-2 rounded hover:bg-gray-700">
                        Ürünler
                    </router-link>
                </li>
            </ul>
        </aside>

        <div class="flex-1 flex flex-col">
            <nav class="bg-blue-600 text-white p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold">Admin Paneli</h1>

                <div class="relative">
                    <button @click="toggleDropdown" class="bg-blue-700 px-4 py-2 rounded">
                        <div v-if="user">
                            {{ user.name }} ▼
                        </div>
                    </button>
                    <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white text-black shadow-lg rounded">
                        <button @click="logout" class="block w-full text-left p-2 hover:bg-gray-200">
                            Çıkış Yap
                        </button>
                    </div>
                </div>
            </nav>

            <main class="p-6">
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>


