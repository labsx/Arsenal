import axios from "axios";
import { onMounted, ref, reactive, defineProps, getCurrentInstance, watch } from "vue";
import Swal from "sweetalert2";
import { useToastr } from "./../../toastr";
import { useRouter, useRoute } from "vue-router";
import { deleteFieldGroups } from "./../../store/swal.js";
import { debounce } from "lodash";

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

    const createField = () => {
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

    return { errors, form, createField };
}

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
                toastr.success("fields updated successfully!");
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

export function fieldDetails() {

    const showImage = ref(false);
    const toastr = useToastr();
    const route = getCurrentInstance().proxy.$route;
    const fields = ref({ data: [] });

    const getFieldsById = (page = 1) => {
        const fieldId = route.params.id;

        axios
            .get(`/fields/${fieldId}/show?page=${page}`)
            .then((response) => {
                fields.value = response.data;
            })
            .catch((error) => {
                console.error("An error occurred:", error);
            });
    };

    const deleteFields = (id) => {
        deleteFieldGroups()
            .then((result) => {
                if (result.isConfirmed) {
                    return axios.delete(`/fields/${id}`);
                }
                throw new Error("Deletion not confirmed.");
            })
            .then(() => {
                fields.value.data = fields.value.data.filter((field) => field.id !== id);
                Swal.fire("Deleted!", "Fields has been deleted.", "success");
                getFieldsById();
            })
            .catch((error) => {
                console.error("Error deleting Fields:", error);
            });
    };
    const searchQuery = ref(null);
    const search = () => {
        const fieldId = route.params.id;

        axios
            .get(`/fields/${fieldId}/show?page=1`, {
                params: {
                    query: searchQuery.value,
                },
            })
            .then((response) => {
                fields.value = response.data;
            })
            .catch((error) => {
                console.error("Error in search:", error);
            });
    };

    watch(
        searchQuery,
        debounce(() => {
            search();
        }, 300)
    );

    onMounted(() => {
        getFieldsById();

        setTimeout(() => {
            if (fields.value.data.length === 0) {
                showImage.value = true;
            }
        }, 100);
    });

    return {
        showImage,
        toastr,
        route,
        fields,
        getFieldsById,
        deleteFields,
        searchQuery,
        search,
    };
}


