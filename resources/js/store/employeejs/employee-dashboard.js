import axios from "axios";
import { ref, onMounted, watch } from "vue";
import { deleteEmployees } from "../../store/swal.js";
import { debounce } from "lodash";
import Swal from "sweetalert2";

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

