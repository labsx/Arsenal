import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useStorage } from '@vueuse/core'

export const useSettingStore = defineStore('SettingStore', () => {

    const theme = useStorage('SettingStore:theme', ref('light'));
    const changeTheme = () => {
        theme.value = theme.value === 'light' ? 'dark' : 'light';
    };

    return { theme, changeTheme };
});