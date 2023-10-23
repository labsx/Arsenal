import axios from "axios";
import { onMounted, ref, reactive } from "vue";
import { useToastr } from "./../../toastr";
import { useRouter, useRoute } from "vue-router";

export function editFields() {

    const router = useRouter();
    const route = useRoute();
    const toastr = useToastr();
    const errors = ref([]);

    const form = reactive({
        name: "",
        is_required: "",
        description: "",
    });

    const fieldsData = () => {
        axios
            .get(`/fields/${route.params.id}`)
            .then(({ data }) => {
                console.log("Fields data:", data);
                form.label = data.label;
                form.is_required = data.is_required;
                form.description = data.description;
            })
            .catch((error) => {
                console.error("Error fetching category details:", error);
            });
    };

    const saveField = () => {
        form.is_required = form.is_required ? "required" : "not required";
        axios
            .put(`/fields/${route.params.id}`, form)
            .then(() => {
                toastr.success("fields updated successfully.");
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                    toastr.error(message);
                    errors.value = [];
                }
            });
    };

    onMounted(() => {
        fieldsData();
    });

    return { errors, form, saveField };
}
