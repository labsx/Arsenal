import axios from "axios";
import { ref } from "vue";
import { useToastr } from "../../toastr";

export default function addEmployee(getEmployeeFn) {
    const errors = ref([]);
    const toastr = useToastr();
    const form = ref({
        first_name: "",
        last_name: "",
        position: "",
    });

    const clearForm = () => {
        form.value.first_name = "";
        form.value.last_name = "";
        form.value.position = "";
    };

    const createEmployee = () => {
        axios
            .post("/employee", form.value)
            .then((response) => {
                toastr.success("Employee created successfully");
                clearForm();
                $("#addEmployee").modal("hide");
                getEmployeeFn();
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

    return { errors, form, createEmployee };
}