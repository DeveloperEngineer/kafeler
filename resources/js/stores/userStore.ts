import {defineStore} from "pinia";
import {ref} from "vue";
import axios from "axios";
import type {UserType} from "@/types/user";



export const useUserStore = defineStore('user', () => {
    const user = ref<UserType | null>(null);

    const fetchUser = async () => {
        try {
            const response = await axios.get('/api/user', { withCredentials: true });
            user.value = response.data as UserType;
        } catch (error) {
            // console.error("Kullanıcı bilgisi alınamadı:", error);
        }
    };

    const logout = async () => {
        try {
            await axios.post('/logout', {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            user.value = null;

            window.location.href = '/login';

        } catch (error) {
            // console.error("Çıkış işlemi başarısız:", error);
        }
    };

    return {
        user,
        fetchUser,
        logout
    }

});
