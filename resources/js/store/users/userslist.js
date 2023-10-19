import { onMounted, ref, watch } from "vue";
import Swal from "sweetalert2";
import { useAuthUserStore } from "../../store/themeStore";
import { deleteProfile } from "../../store/swal.js";
import { debounce } from "lodash";

export function userList() {
    const authuserStore = useAuthUserStore();
    const users = ref({ data: [] });
    const getUsers = (page = 1) => {
        axios
            .get(`/users?page=${page}`)
            .then((response) => {
                users.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching items:", error);
            });
    };

    const searchQuery = ref(null);
    const search = () => {
        axios
            .get("/users", {
                params: {
                    query: searchQuery.value,
                },
            })
            .then((response) => {
                users.value = response.data;
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

    const deleteUsers = (id) => {
        deleteProfile()
            .then((result) => {
                if (result.isConfirmed) {
                    return axios.delete(`/users/${id}`);
                }
                throw new Error("Deletion not confirmed.");
            })
            .then(() => {
                users.value.data = users.value.data.filter((user) => user.id !== id);
                Swal.fire("Deleted!", "User has been deleted.", "success");
                getUsers();
            })
            .catch((error) => {
                console.error("Error deleting event:", error);
            });
    };

    onMounted(() => {
        getUsers();
    });

    return { users, searchQuery, authuserStore, deleteUsers, getUsers };
}
