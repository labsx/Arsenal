import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useStorage } from '@vueuse/core'

export const useAuthUserStore = defineStore('authuserStore', () => {
    const user = ref ({
        name: '',
        email: '',
        avatar: '',
        created_at: '',
    });
    const getAuthUser = () => {
        axios.get('/users/profile')
        .then((response)=> {
            user.value = response.data;
        });
    };
    return { user, getAuthUser };
});

export const useSettingStore = defineStore('SettingStore', () => {

    const theme = useStorage('SettingStore:theme', ref('light'));
    const changeTheme = () => {
        theme.value = theme.value === 'light' ? 'dark' : 'light';
    };

    return { theme, changeTheme };
});