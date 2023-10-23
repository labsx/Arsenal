import axios from "axios";
import { ref, onMounted, watch } from "vue";
import { debounce } from "lodash";
import { deleteItemsData } from "../../store/swal.js";
import Swal from "sweetalert2";
import { printItemsData } from "../../store/print.js";
import { formatDate } from "../../helper.js";

export function itemList() {
    const formatPrice = (price) => {
        if (!price) {
            return "none";
        }
        const parts = price.toString().split(".");
        const integerPart = parts[0]
            .split("")
            .reverse()
            .map((digit, index) => (index > 0 && index % 3 === 0 ? digit + " " : digit))
            .reverse()
            .join("");
        const decimalPart = parts[1] ? `.${parts[1]}` : "";
        return `₱ ${integerPart}${decimalPart}`;
    };

    const showImage = ref(false);
    const printItems = () => {
        printItemsData(items.value.data, formatDate);
    };
    const deleteItems = (id) => {
        deleteItemsData()
            .then((result) => {
                if (result.isConfirmed) {
                    return axios.delete(`/items/${id}`);
                }
                throw new Error("Deletion not confirmed.");
            })
            .then(() => {
                items.value.data = items.value.data.filter((item) => item.id !== id);
                Swal.fire("Deleted!", "Item has been deleted.", "success");
                getItems();
            })
            .catch((error) => {
                console.error("Error deleting event:", error);
            });
    };

    const items = ref({ data: [] });

    const getItems = (page = 1) => {
        axios
            .get(`/items?page=${page}`)
            .then((response) => {
                console.log("Response:", response.data);
                if (response.data) {
                    items.value = response.data || [];
                }
            })
            .catch((error) => {
                console.error("Error fetching items and attributes:", error);
            });
    };

    const searchQuery = ref(null);
    const search = () => {
        axios
            .get("/items", {
                params: {
                    query: searchQuery.value,
                },
            })
            .then((response) => {
                items.value = response.data;
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

    const getStatusClass = (status) => {
        if (status === "operating") {
            return "badge badge-success good-status";
        } else if (status === "decommissioned") {
            return "badge badge-danger bad-status";
        } else if (status === "under repair") {
            return "badge badge-warning bad-status";
        } else if (status === "issue") {
            return "badge badge-primary bad-status";
        } else {
            return "badge badge-default";
        }
    };

    const histories = ref([]);

    const fetchHistories = () => {
        axios
            .get("/histories")
            .then((response) => {
                histories.value = response.data || [];
            })
            .catch((error) => {
                console.error("Error fetching histories:", error);
            });
    };

    const hasHistory = (itemId) => {
        return histories.value.some((history) => history.item_id === itemId);
    };

    onMounted(() => {
        getItems();
        fetchHistories();
        setTimeout(() => {
            if (items.value.data.length === 0) {
                showImage.value = true;
            }
        }, 100);
    });

    return { formatPrice, printItems, deleteItems, items, searchQuery, getStatusClass, showImage, getItems, hasHistory };
}