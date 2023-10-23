import axios from "axios";
import { ref } from "vue";
import { useToastr } from "../../toastr";

export default function addFieldGroups(getFieldsGroupsFn) {
    const form = ref({
        name: "",
        description: "",
    });
    const errors = ref([]);
    const toastr = useToastr();

    const clearForm = () => {
        form.value.name = "";
        form.value.description = "";
    };

    const dataTosave = () => {
        axios
            .post("/field-group", form.value)
            .then((response) => {
                toastr.success("fields created successfully!");
                $("#createFieldsGroup").modal("hide");
                clearForm();
                getFieldsGroupsFn();
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

    return { errors, form, dataTosave };
}