import axios from "axios";
import { ref, defineProps, onMounted, reactive, computed } from "vue";
import { useToastr } from "../../toastr";

export function addCategory(getCategoryFn) {
    const toastr = useToastr();
    const errors = ref([]);
    const form = reactive({
        name: "",
        field_groups_id: "",
        parent_id: "",
    });

    const dataTosave = () => {
        const formData = {
            name: form.name,
            field_group_id: form.field_groups_id,
            parent_id: form.parent_id,
        };

        axios
            .post("/category", formData)
            .then((response) => {
                toastr.success("Category created successfully!");
                getCategoryFn();
                $("#createCategory").modal("hide");
                errors.value = [];
                clearForm();
                categories.value.push(response.data);

            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors || {};
                }
            });
    };

    const clearForm = () => {
        form.name = "";
        form.parent_id = "";
        form.field_groups_id = "";
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
        getFieldGroup();
        getCategory();
    });
    return { errors, form, categories, filterCategory, getCategory, getFieldGroup, field_groups, dataTosave, getCategoryFn };
}