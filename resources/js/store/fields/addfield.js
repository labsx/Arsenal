import axios from "axios";
import { onMounted, ref, reactive } from "vue";
import { useToastr } from "./../../toastr";
import { useRouter, useRoute } from "vue-router";

export function addField(getFieldByIdFn) {
    const router = useRouter();
    const route = useRoute();
    const toastr = useToastr();
    const errors = ref([]);
    const form = reactive({
        name: "",
        description: "",
        is_required: "",
        field_groups_id: "",
        field_id: "",
    });

    const dataTosave = () => {
        const isRequired = form.is_required ? "required" : "not required";
        const formData = {
            label: form.label,
            description: form.description,
            is_required: isRequired,
            field_groups_id: form.field_groups_id,
        };

        axios
            .post("/fields", formData)
            .then((response) => {
                toastr.success("Fields created successfully!");
                clearForm();
                $("#createFieldData").modal("hide");
                getFieldByIdFn();
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };

    const clearForm = () => {
        form.label = "";
        form.description = "";
        form.is_required = "";
    };

    const getFieldsGroupsId = () => {
        axios
            .get(`/field-group/${route.params.id}`)
            .then(({ data }) => {
                console.log("Fields data:", data);
                form.field_groups_id = data.id;
                form.name = data.name;
            })
            .catch((error) => {
                console.error("Error fetching category details:", error);
            });
    };

    onMounted(() => {
        getFieldsGroupsId();
    });

    return { errors, form, dataTosave };
}
