import {createRouter, createWebHistory } from "vue-router";
import Dashboard from "./pages/Dashboard.vue";
import Categories from "@/pages/Categories.vue";
import Products from "@/pages/Products.vue";

const routes = [
    { path: '/admin', redirect: '/admin/dashboard' },
    { path: '/admin/dashboard', component: Dashboard, name: 'admin.dashboard' },
    {path: '/admin/categories', component: Categories, name: 'admin.categories'},
    { path: '/admin/products', component: Products, name: 'admin.products' },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
