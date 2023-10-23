import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";

export function updateEmployee() {
    const toastr = useToastr();
    const router = useRouter();
    const route = useRoute();
    const errors = ref([]);
    const form = reactive({
        first_name: "",
        last_name: "",
        position: "",
    });

    const getEmployee = () => {
        axios
            .get(`/employee/${route.params.id}`)
            .then(({ data }) => {
                form.first_name = data.first_name;
                form.last_name = data.last_name;
                form.position = data.position;
            })
            .catch((error) => {
                console.error("Error fetching employee details:", error);
            });
    };

    const saveEmployee = () => {
        axios
            .put(`/employee/${route.params.id}`, {
                first_name: form.first_name,
                last_name: form.last_name,
                position: form.position,
            })
            .then(() => {
                toastr.success("Employee updated successfully!");
                errors.value = [];
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };

    onMounted(() => {
        getEmployee();
    });

    return { form, errors, saveEmployee };
}
