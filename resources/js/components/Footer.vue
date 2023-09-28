<template>
    <footer class="main-footer text-center">
            <strong class="">Copyright &copy; {{year(authuserStore.user.created_at)}} <a href="#">{{authuserStore.user.name}}</a>.</strong> All rights reserved.
        </footer>
</template>
<script setup>
import { useAuthUserStore } from "./../store/themeStore";
import { year } from './../helper.js';

const authuserStore = useAuthUserStore();

defineProps({
    user: Object,
})

</script>