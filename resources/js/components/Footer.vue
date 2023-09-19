<template>
    <footer class="main-footer text-center">
            <strong class="">Copyright &copy; sample <a href="#">{{authuserStore.user.name}}</a>.</strong> All rights reserved.
        </footer>
</template>
<script setup>
import { useAuthUserStore } from "./../store/themeStore";

const authuserStore = useAuthUserStore();

defineProps({
    user: Object,
})

</script>