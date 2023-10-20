import axios from "axios";
import { reactive, onMounted, ref, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";

export function editCategory() {
    const router = useRouter();
    const route = useRoute();
    const toastr = useToastr();
    const errors = ref([]);

    const form = reactive({
        name: "",
        field_group_id: "",
        parent_id: "",
    });

    const ItemDetails = () => {
        axios
            .get(`/category/${route.params.id}`)
            .then(({ data }) => {
                console.log("Category data:", data);
                if (data && data.name) {
                    form.name = data.name;
                    form.field_group_id = data.field_group_id;
                    form.parent_id = data.parent_id;
                } else {
                    console.error("Category name not found in the response data.");
                }
            })
            .catch((error) => {
                console.error("Error fetching category details:", error);
            });
    };

    const saveCategory = () => {
        axios
            .put(`/category/${route.params.id}`, {
                name: form.name,
                field_group_id: form.field_group_id,
                parent_id: form.parent_id,
            })
            .then(() => {
                toastr.success("Category updated successfully!");
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };

    const field_groups = ref([]);
    const getFieldGroup = () => {
        axios
            .get("/fields")
            .then((response) => {
                field_groups.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching field_group:", error);
            });
    };

    const categories = ref([]);

    const getCategory = () => {
        axios
            .get("/categories")
            .then((response) => {
                categories.value = response.data;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    };
    const filterCategory = computed(() => {
        return categories.value.filter((category) => category.parent_id === null);
    });

    onMounted(() => {
        getCategory();
        getFieldGroup();
        ItemDetails();
    });

    return { errors, form, field_groups, getFieldGroup, ItemDetails, saveCategory, categories, filterCategory };
}