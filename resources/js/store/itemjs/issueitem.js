import axios from "axios";
import { reactive, onMounted, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";

export function IssueItem() {
    const router = useRouter();
    const route = useRoute();
    const toastr = useToastr();
    const errors = ref([]);
    const form = reactive({
        item_id: "",
        employee_id: "",
        issued_at: "",
        remarks: "",
    });

    const getItemsData = () => {
        axios.get(`/issue/${route.params.id}`).then(({ data }) => {
            form.item_id = data.id;
        });
    };

    const employees = ref([]);
    const getEmployee = () => {
        axios
            .get("/issue")
            .then((response) => {
                employees.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching employees:", error);
            });
    };

    const saveIssue = () => {
        axios
            .post("/issue", form)
            .then((response) => {
                toastr.success("Successfully issued item!");
                router.push("/admin/items/list");
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                } else {
                    toastr.error("An unexpected error occurred. Please try again.");
                }
            });
    };

    const setCurrentDate = () => {
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, "0");
        const day = String(currentDate.getDate()).padStart(2, "0");

        form.issued_at = `${year}-${month}-${day}`;
    };

    onMounted(() => {
        getItemsData();
        getEmployee();
        setCurrentDate();
    });

    return { getItemsData, getEmployee, setCurrentDate, employees, form, errors, saveIssue };
}