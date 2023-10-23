import axios from "axios";
import { onMounted, ref, reactive } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";


export function editFieldGroups() {
    const router = useRouter();
    const route = useRoute();
    const toastr = useToastr();
    const errors = ref([]);

    const form = reactive({
        name: "",
        description: "",
    });

    const groupDetails = () => {
        axios
            .get(`/field-group/${route.params.id}`)
            .then(({ data }) => {
                console.log("Field Group data:", data);
                form.name = data.name;
                form.description = data.description;
            })
            .catch((error) => {
                console.error("Error fetching field group details:", error);
            });
    };

    const saveGroupFields = () => {
        axios
            .put(`/field-group/${route.params.id}`, {
                name: form.name,
                description: form.description,
            })
            .then(() => {
                toastr.success("Group fields updated successfully!");
                errors.value = [];
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
        groupDetails();
    });

    return { form, errors, saveGroupFields };
}
