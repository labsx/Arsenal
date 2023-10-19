import axios from "axios";
import { ref, defineProps, onMounted } from "vue";
import { useToastr } from "../../toastr";

export function addCategory(getCategoryFn) {
    const toastr = useToastr();
    const errors = ref([]);
    const form = ref({
        name: "",
        field_groups_id: "",
    });

    const createItem = () => {
        const formData = {
            name: form.value.name,
            field_group_id: form.value.field_groups_id,
        };

        axios
            .post("/category", formData)
            .then((response) => {
                toastr.success("Category created successfully!");
                $("#createCategory").modal("hide");
                clearForm();
                getCategoryFn();
                errors.value = [];
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
        form.value.name = "";
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

    onMounted(() => {
        getFieldGroup();
    });
    return { errors, form, getFieldGroup, field_groups, createItem};
}