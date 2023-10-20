import axios from "axios";
import { ref, onMounted, watch } from "vue";
import Swal from "sweetalert2";
import { deleteCategoryData } from "../../store/swal.js";
import { useToastr } from "../../toastr";
import { debounce } from "lodash";

export function categoryDetails() {
    const showImage = ref(false);
    const toastr = useToastr();
    const errors = ref([]);
    const categories = ref({ data: [] });

    // const getFieldGroupName = async (fieldGroupId) => {
    //     if (fieldGroupId === null) {
    //         return "No field group selected";
    //     }

    //     try {
    //         const response = await axios.get(`/field-group/${fieldGroupId}`);
    //         return response.data.name || "No field group selected";
    //     } catch (error) {
    //         return "No field group selected";
    //     }
    // };

    // const getCategory = async (page = 1) => {
    //     try {
    //         const response = await axios.get(`/category?page=${page}`);
    //         const responseData = Array.isArray(response.data) ? response.data : response.data.data;

    //         if (responseData.length === 0) {
    //             categories.value.data = [];
    //         } else {
    //             categories.value.data = await Promise.all(
    //                 responseData.map(async (category) => ({
    //                     ...category,
    //                     field_group_name: await getFieldGroupName(category.field_group_id),
    //                 })
    //                 )
    //             );
    //         }
    //     } catch (error) {
    //         console.error("Error fetching category:", error);
    //     }
    // };

    const searchQuery = ref(null);

    const search = debounce(() => {
        axios.get("/category", { params: { query: searchQuery.value } })
            .then((response) => {
                categories.value = response.data;
            })
            .catch((error) => {
                console.error("Error searching for categories:", error);
            });
    }, 300);

    watch(searchQuery, search);

    const deleteCategory = async (id) => {
        try {
            const result = await deleteCategoryData();
            if (result.isConfirmed) {
                await axios.delete(`/category/${id}`);
                categories.value.data = categories.value.data.filter(category => category.id !== id);
                Swal.fire("Deleted!", "Category has been deleted.", "success");
                getItems(); // You should define getItems function
            }
        } catch (error) {
            console.error("Error deleting category:", error);
        }
    };

    const getCategory = (page = 1) => {
        axios
            .get(`/category?page=${page}`)
            .then((response) => {
                categories.value = response.data;
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    };

    onMounted(() => {
        
        getCategory();
        setTimeout(() => {
            showImage.value = categories.value.data.length === 0;
        }, 100);
    });

    return { errors, getCategory, categories, showImage, categories, deleteCategory, searchQuery };
}
