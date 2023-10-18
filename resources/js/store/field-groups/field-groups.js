import axios from "axios";
import { onMounted, ref, defineProps, reactive, watch } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";
import { debounce } from "lodash";
import { deleteFieldGroups } from "../../store/swal.js";
import Swal from "sweetalert2";
//import imagePath from "/resources/image/no data.gif";

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

    const createFields = () => {
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

    return { errors, form, createFields };
}

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
                    // getItemsFn();
                    errors.value = [];
                }
            });
    };

    onMounted(() => {
        groupDetails();
    });

    return { form, errors, saveGroupFields };
}

export function fieldGroupDetails() {
    const showImage = ref(false);
    const field_groups = ref({ data: [] });

    const getFieldsGroups = (page = 1) => {
        axios
            .get(`/field-group?page=${page}`)
            .then((response) => {
                field_groups.value = response.data;
            })
            .catch((error) => {
                console.error("An error occurred:", error);
            });
    };

    const deleteFields = (id) => {
        deleteFieldGroups()
            .then((result) => {
                if (result.isConfirmed) {
                    return axios.delete(`/field-group/${id}`);
                }
                throw new Error("Deletion not confirmed.");
            })
            .then(() => {
                field_groups.value.data = field_groups.value.data.filter(
                    (field) => field.id !== id
                );
                Swal.fire("Deleted!", "Fields has been deleted.", "success");
            })
            .catch((error) => {
                console.error("Error deleting Fields:", error);
            });
    };

    const searchQuery = ref(null);
    const search = () => {
        axios
            .get("/field-group", {
                params: {
                    query: searchQuery.value,
                },
            })
            .then((response) => {
                field_groups.value = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    };

    watch(
        searchQuery,
        debounce(() => {
            search();
        }, 300)
    );

    onMounted(() => {
        getFieldsGroups();

        setTimeout(() => {
            if (field_groups.value.data.length === 0) {
                showImage.value = true;
            }
        }, 100);
    });

    return { showImage, searchQuery, field_groups, getFieldsGroups, deleteFields };
}