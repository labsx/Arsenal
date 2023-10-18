import axios from "axios";
import { ref, onMounted, reactive, watch } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";
import { deleteEmployees } from "../../store/swal.js";
import { debounce } from "lodash";
import Swal from "sweetalert2";

export default function addEmployee(getEmployeeFn) {
    const errors = ref([]);
    const toastr = useToastr();
    const form = ref({
        first_name: "",
        last_name: "",
        position: "",
    });

    const clearForm = () => {
        form.value.first_name = "";
        form.value.last_name = "";
        form.value.position = "";
    };

    const createEmployee = () => {
        axios
            .post("/employee", form.value)
            .then((response) => {
                toastr.success("Employee created successfully");
                clearForm();
                $("#addEmployee").modal("hide");
                getEmployeeFn();
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

    return { errors, form, createEmployee };
}

export function updateEmployee() {
    const toastr = useToastr();
    const router = useRouter();
    const route = useRoute();
    const errors = ref([]);
    const form = reactive({
        first_name: "",
        last_name: "",
        position: "",
    });

    const getEmployee = () => {
        axios
            .get(`/employee/${route.params.id}`)
            .then(({ data }) => {
                console.log("Employee data:", data);
                form.first_name = data.first_name;
                form.last_name = data.last_name;
                form.position = data.position;
                console.error("Employee not found in the response data.");
            })
            .catch((error) => {
                console.error("Error fetching employee details:", error);
            });
    };

    const saveEmployee = () => {
        axios
            .put(`/employee/${route.params.id}`, {
                first_name: form.first_name,
                last_name: form.last_name,
                position: form.position,
            })
            .then(() => {
                toastr.success("Employee updated successfully!");
                errors.value = [];
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error(error.response.data.error);
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };

    onMounted(() => {
        getEmployee();
    });

    return { form, errors, saveEmployee };
}

export function employeeDetails() {
    const showImage = ref(false);
    const errors = ref([]);
    const employees = ref({ data: [] });
    const searchQuery = ref(null);

    const getEmployee = (page = 1) => {
        axios
            .get(`/employee?page=${page}`)
            .then((response) => {
                employees.value = response.data;
            })
            .catch((error) => {
                console.error("An error occurred:", error);
            });
    };

    const search = () => {
        axios
            .get("/employee", {
                params: {
                    query: searchQuery.value,
                },
            })
            .then((response) => {
                employees.value = response.data;
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

    const deleteEmployee = (id) => {
        deleteEmployees()
            .then((result) => {
                if (result.isConfirmed) {
                    return axios.delete(`/employee/${id}`);
                }
                throw new Error("Deletion not confirmed.");
            })
            .then(() => {
                employees.value.data = employees.value.data.filter(
                    (employee) => employee.id !== id
                );
                Swal.fire("Deleted!", "Employee has been deleted.", "success");
            })
            .catch((error) => {
                console.error("Error deleting Employee:", error);
            });
    };

    onMounted(() => {
        getEmployee();

        setTimeout(() => {
            if (employees.value.data.length === 0) {
                showImage.value = true;
            }
        }, 100);
    });

    return { showImage, errors, employees, searchQuery, getEmployee, deleteEmployee };
}

