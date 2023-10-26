import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import { reactive, onMounted, ref } from "vue";

export function employeeHistory() {
    const route = useRoute();
    const form = reactive({
        first_name: "",
        last_name: "",
        position: "",
    });

    const employeeDetails = () => {
        axios
            .get(`/employee/${route.params.id}`)
            .then((response) => {
                form.first_name = response.data.first_name;
                form.last_name = response.data.last_name;
                form.position = response.data.position;
            })
            .catch((error) => {
                console.error("Error fetching employee details:", error);
            });
    };

    const histories = ref([]);
    const itemNames = ref([]);

    const getEmployeeHistory = () => {
        axios
            .get(`/histories/${route.params.id}`)
            .then((response) => {
                histories.value = response.data;

                const itemMap = {};
                response.data.forEach((history) => {
                    itemMap[history.item_id] = "";
                });

                axios.get("/history").then((itemResponse) => {
                    itemResponse.data.forEach((item) => {
                        if (itemMap[item.id] !== undefined) {
                            itemMap[item.id] = item.name;
                        }
                    });
                    itemNames.value = itemMap;
                });
            })
            .catch((error) => {
                console.error("Error fetching employee history:", error);
            });
    };

    onMounted(() => {
        employeeDetails();
        getEmployeeHistory();
    });

    return { form, histories, itemNames };
}