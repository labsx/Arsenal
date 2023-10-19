import axios from "axios";
import { reactive, onMounted, ref, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";

export function returnFormItem() {
    const router = useRouter();
    const route = useRoute();
    const toastr = useToastr();
    const errors = ref([]);
    const form = reactive({
        history_id: "",
        remarks: "",
        status: "",
        return_at: "",
    });

    const returnItem = () => {
        axios.get(`/return/${route.params.id}`).then(({ data }) => {
            form.history_id = data.id;
            form.employee_id = data.employee_id;
        });
    };

    const UpdateHistory = () => {
        console.log("Form Data:", form);
        axios
            .put(`/return/${route.params.id}`, form)
            .then((response) => {
                toastr.success("Return item successfully!");
                errors.value = "";
                router.push("/admin/items/list");
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                } else {
                    toastr.error("An unexpected error occurred. Please try again.");
                }
            });
    };

    const setCurrentDate = () => {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, "0");
        const day = String(currentDate.getDate()).padStart(2, "0");

        form.return_at = `${year}-${month}-${day}`;
    };

    onMounted(() => {
        returnItem();
        setCurrentDate();
    });

    return { errors, form, setCurrentDate, UpdateHistory, returnItem };
}