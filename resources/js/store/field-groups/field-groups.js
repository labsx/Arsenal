import axios from "axios";
import { onMounted, ref, defineProps, reactive, watch } from "vue";
import { debounce } from "lodash";
import { deleteFieldGroups } from "../../store/swal.js";
import Swal from "sweetalert2";

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