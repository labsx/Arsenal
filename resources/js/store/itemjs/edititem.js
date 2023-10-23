import axios from "axios";
import { ref, onMounted, watch, reactive } from "vue";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import { useRouter, useRoute } from "vue-router";

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

    const categories = ref([]);
    const categoryGroups = ref([]);

    const getCategory = () => {
        axios
            .get("/categories")
            .then((response) => {
                categories.value = response.data;
                categoryGroups.value = categories.value.filter(
                    (category) => category.parent_id === null
                );
                console.log("Car Groups:", categoryGroups.value);
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    };
    const filteredSamples = (categoryGroupsId) => {
        return categories.value.filter(
            (category) => category.parent_id === categoryGroupsId
        );
    };

    onMounted(() => {
        getCategory();
        getItems();
        getAttributes();

        flatpickr(".flatpickr", {
            enableTime: true,
            dateFormat: "Y-m-d h:i K",
            defaultHour: 10,
        });
    });
    
    return {
        errors, form, handleSubmit, addAttribute, removeAttribute,
        getAttributes, categories, categoryGroups, filteredSamples
    };
}