import axios from "axios";
import { ref, onMounted, watch, reactive } from "vue";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import { useRouter, useRoute } from "vue-router";

export function addItem() {
    const toastr = useToastr();
    const errors = ref([]);
    const fieldsData = ref([]);

    const form = ref({
        category_id: "",
        item_name: "",
        parent_id: "",
        price: "",
        mfg_date: "",
        model: "",
        serial: "",
        status: "",
        manufacturer: "",
        location: "",
        warranty: "",
        insurance: "",
        net_weight: "",
        fields: {},
    });

    const createItem = () => {
        const dataToSave = {
            category_id: form.value.category_id,
            parent_id: form.value.parent_id,
            item_name: form.value.item_name,
            price: form.value.price,
            mfg_date: form.value.mfg_date,
            model: form.value.model,
            serial: form.value.serial,
            status: form.value.status,
            manufacturer: form.value.manufacturer,
            location: form.value.location,
            warranty: form.value.warranty,
            insurance: form.value.insurance,
            net_weight: form.value.net_weight,
            value: Object.keys(form.value.fields).map((label) => ({
                label,
                value: form.value.fields[label],
            })),
        };

        axios
            .post("/items", dataToSave)
            .then((response) => {
                toastr.success("Item created successfully!");
                clearForm();
                errors.value = "";
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                    toastr.error(message);
                    errors.value = [];
                }
                s;
            });
    };

    const getFields = async () => {
        const selectedSubcategoryId = form.value.parent_id;

        if (selectedSubcategoryId) {
            try {
                const selectedSubcategory = subcategories.value.find((subcategory) =>
                    subcategory.parent_models.some(
                        (model) => model.id === selectedSubcategoryId
                    )
                );
                const fieldGroupId = selectedSubcategory.field_group_id;
                const response = await axios.get(`/field-groups/${fieldGroupId}`);
                fieldsData.value = response.data;
            } catch (error) {
                console.error("Error fetching fields:", error);
            }
        } else {
            fieldsData.value = [];
        }
    };

    const clearForm = () => {
        form.value.item_id = "";
        form.value.parent_id = "";
        form.value.serial = "";
        form.value.price = "";
        form.value.model = "";
        form.value.mfg_date = "";
        form.value.status = "";
        form.value.item_name = "";
        form.value.fields = {};
        form.value.category_id = "";
        form.value.manufacturer = "";
        form.value.location = "";
        form.value.warranty = "";
        form.value.net_weight = "";
    };

    const categories = ref();
    const getCategory = () => {
        axios
            .get("/category")
            .then((response) => {
                categories.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching field_group:", error);
            });
    };

    const subcategories = ref([]);
    const getSubCategory = () => {
        axios
            .get("/parent/sub")
            .then((response) => {
                subcategories.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching sub-category", error);
            });
    };

    onMounted(() => {
        getSubCategory();
        getCategory();

        flatpickr(".flatpickr", {
            enableTime: true,
            dateFormat: "Y-m-d h:i K",
            defaultHour: 10,
        });
    });
    watch(form.category_id, () => {
        getFields();
    });

    return { errors, subcategories, fieldsData, form, createItem, getSubCategory, getCategory, getFields };
}

export function editItems() {
    const errors = ref({});
    const toastr = useToastr();
    const router = useRouter();
    const route = useRoute();
    const form = reactive({
        name: "",
        serial: "",
        model: "",
        price: "",
        mfg_date: "",
        status: "",
        parent_id: "",
        value: [{ name: "", value: "" }],
    });

    const addAttribute = () => {
        form.value.push({ name: "", value: "" });
    };

    const removeAttribute = (index) => {
        form.value.splice(index, 1);
    };

    //
    const getItems = () => {
        axios
            .get(`/items/${route.params.id}`)
            .then((response) => {
                console.log("Response data:", response.data);

                if (response.data) {
                    form.name = response.data.name;
                    form.serial = response.data.serial;
                    form.status = response.data.status;
                    form.parent_id = response.data.parent_id;
                    form.model = response.data.model;
                    form.mfg_date = response.data.mfg_date;
                    form.price = response.data.price;
                    form.manufacturer = response.data.manufacturer;
                    form.location = response.data.location;
                    form.insurance = response.data.insurance;
                    form.net_weight = response.data.net_weight;
                    form.warranty = response.data.warranty;
                } else {
                    console.error("Item data not found in the response.");
                }
            })
            .catch((error) => {
                console.error("Error fetching item details:", error);
            });
    };

    const getAttributes = () => {
        axios
            .get(`/items/${route.params.id}/attributes`)
            .then(({ data }) => {
                console.log("Attributes data:", data);

                if (Array.isArray(data)) {
                    form.value = data.map((attribute) => ({
                        name: attribute.name,
                        value: attribute.value,
                    }));
                } else {
                    console.error("Invalid attributes data format.");
                }
            })
            .catch((error) => {
                console.error("Error fetching item attributes:", error);
            });
    };

    const handleSubmit = () => {
        console.log("Form submitted with data:", form.value);

        axios
            .put(`/items/${route.params.id}`, form)
            .then((response) => {
                toastr.success("Item updated successfully!");
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                    if (error.response.data.errors && error.response.data.errors[0]) {
                        toastr.error(error.response.data.errors[0]);
                    } else {
                        toastr.error("An error occurred while updating the item.");
                    }
                }
            });
    };

    // const parents = ref([]);
    // const getParent = () => {
    //     axios
    //         .get("/parent-data")
    //         .then((response) => {
    //             parents.value = response.data;
    //         })
    //         .catch((error) => {
    //             console.error("Error fetching field_group:", error);
    //         });
    // };

    const subcategories = ref([]);
    const getSubCategory = () => {
        axios
            .get("/parent/sub")
            .then((response) => {
                subcategories.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching sub-category", error);
            });
    };

    onMounted(() => {
        getSubCategory();
        // getParent();
        getItems();
        getAttributes();

        flatpickr(".flatpickr", {
            enableTime: true,
            dateFormat: "Y-m-d h:i K",
            defaultHour: 10,
        });
    });
    return { errors, form, handleSubmit, addAttribute, removeAttribute, getAttributes, subcategories };
}
