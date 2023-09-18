<template>
    <footer class="main-footer text-center">
            <strong class="">Copyright &copy; sample <a href="#">{{user.name}}</a>.</strong> All rights reserved.
        </footer>
</template>
<script setup>

defineProps({
    user: Object,
})

</script>