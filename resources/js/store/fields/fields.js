import axios from "axios";
import { onMounted, ref, getCurrentInstance, watch } from "vue";
import Swal from "sweetalert2";
import { useToastr } from "./../../toastr";
import { deleteFieldGroups } from "./../../store/swal.js";
import { debounce } from "lodash";

export function fieldDetails() {

    const showImage = ref(false);
    const toastr = useToastr();
    const route = getCurrentInstance().proxy.$route;
    // const fields = ref({ data: [] });
    const fields = ref([]);

    const getFieldsById = () => {
        const fieldId = route.params.id;

        axios
            .get(`/fields/${fieldId}/show`)
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
                fields.value = fields.value.filter((field) => field.id !== id);
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
            if (fields.value.length === 0) {
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


