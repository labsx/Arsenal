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
    const searchQuery = ref(null);

    const search = debounce(() => {
        axios.get("/category", { params: { query: searchQuery.value } })
            .then(async (response) => {
                const searchData = response.data;

                if (searchData.data.length === 0) {
                    categories.value.data = [];
                } else {
                    categories.value.data = await Promise.all(searchData.data.map(async (category) => {
                        const parentCategoryName = await getParentCategoryName(category.parent_id);
                        const fieldGroupName = await getFieldGroupName(category.field_group_id);
                        return {
                            ...category,
                            parent_name: parentCategoryName,
                            field_group_name: fieldGroupName,
                        };
                    }));
                }
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
                // getCategory();
            }
        } catch (error) {
            console.error("Error deleting category:", error);
        }
    };

    const getCategory = async (page = 1) => {
        try {
            const response = await axios.get(`/category?page=${page}`);
            categories.value = response.data;
            const responseData = Array.isArray(response.data) ? response.data : response.data.data;
            if (responseData.length === 0) {
                categories.value.data = [];
            } else {
                categories.value.data = await Promise.all(
                    responseData.map(async (category) => {
                        const parentCategoryName = await getParentCategoryName(category.parent_id);
                        const fieldGroupName = await getFieldGroupName(category.field_group_id);
                        return {
                            ...category,
                            parent_name: parentCategoryName,
                            field_group_name: fieldGroupName,
                        };
                    })
                );
            }
        } catch (error) {
            console.error("Error fetching category:", error);
        }
    };

    const getParentCategoryName = async (parent_id) => {
        if (parent_id === null) {
            return "Main Category";
        }

        const parentCategory = categories.value.data.find(category => category.id === parent_id);

        if (parentCategory) {
            return parentCategory.name;
        } else {
            try {
                const response = await axios.get(`/category/${parent_id}`);
                return response.data.name || "Unknown Parent Category";
            } catch (error) {
                return "Unknown Parent Category";
            }
        }
    };

    const getFieldGroupName = async (fieldGroupId) => {
        try {
            if (fieldGroupId === null) {
                return "Main Category";
            }

            const response = await axios.get(`/field-group/${fieldGroupId}`);
            if (response.data && response.data.name) {
                return response.data.name;
            } else {
                return "Main Category";
            }
        } catch (error) {
            return "Main Category";
        }
    };

    onMounted(() => {

        getCategory();
        setTimeout(() => {
            showImage.value = categories.value.data.length === 0;
        }, 100);
    });

    return { errors, getCategory, categories, showImage, categories, deleteCategory,
         searchQuery, getParentCategoryName, getFieldGroupName };
}
