import { useSettingStore } from "../../store/themeStore.js";
import { reactive, ref, onMounted } from "vue";
import axios from "axios";
import { useToastr } from "../../toastr";
import { useAuthUserStore } from "../../store/themeStore.js";

export function appNavBar() {
    const authUserStore = useAuthUserStore();

    const form = ref({
        notes: "",
    });
    const errors = ref([]);
    const toastr = useToastr();
    const notes = ref([]);

    const createNote = () => {
        axios
            .post("/notes", form.value)
            .then((response) => {
                toastr.success("Note successfully created !");
                clearForm();
                getNotes();
            })
            .catch((error) => {
                if (error.response && error.response.status === 400) {
                    toastr.error("Error: Bad request. Note could not be created.");
                } else if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                    clearForm();
                } else {
                    toastr.error("An unexpected error occurred. Please try again later.");
                }
            });
    };
    const clearForm = () => {
        form.value.notes = "";
    };
    const getNotes = () => {
        axios
            .get("/notes/data")
            .then((response) => {
                const notesData = response.data;
                const notePromises = notesData.map((note) => {
                    return axios
                        .get(`/user/${note.user_id}`)
                        .then((userResponse) => ({
                            id: note.id,
                            notes: note.notes,
                            date: note.date,
                            userName: userResponse.data.name,
                            userAvatar: userResponse.data.avatar,
                        }))
                        .catch((error) => {
                            console.error("Error fetching user:", error);
                            return null;
                        });
                });

                Promise.all(notePromises).then((notesWithUser) => {
                    notes.value = notesWithUser.filter((note) => note !== null);
                });
            })
            .catch((error) => {
                console.error("Error fetching all items:", error);
            });
    };

    const deleteNotes = (id) => {
        axios
            .delete(`/notes/${id}`)
            .then(() => {
                notes.value = notes.value.filter((note) => note.id !== id);
                toastr.success("Note has been removed.");
                getNotes();
            })
            .catch((error) => {
                console.error("Error deleting note:", error);
                toastr.error("An error occurred while deleting the note.");
            });
    };

    const itemNames = ref([]);
    const totalCount = ref(0);

    const fetchItemNamesAndCount = () => {
        axios
            .get("/notification")
            .then((response) => {
                itemNames.value = response.data.itemNames;
                totalCount.value = response.data.totalCount;
            })
            .catch((error) => {
                console.error("Error fetching item names and count:", error);
            });
    };

    const deleteNotification = (id) => {
        axios
            .delete(`/notification/${id}`)
            .then(() => {
                itemNames.value = itemNames.value.filter((item) => item.id !== id);
                totalCount.value -= 1;
                toastr.success("Notification deleted successfully!");
                fetchItemNamesAndCount();
            })
            .catch((error) => {
                console.error("Error deleting notification:", error);
            });
    };

    const settingStore = useSettingStore();

    document.addEventListener("DOMContentLoaded", () => {
        const toggleMenuIcon = document.getElementById("toggleMenuIcon");
        const body = document.querySelector("body");

        toggleMenuIcon.addEventListener("click", () => {
            if (body.classList.contains("sidebar-collapse")) {
                localStorage.setItem("sidebarState", "expanded");
            } else {
                localStorage.setItem("sidebarState", "collapsed");
            }
        });

        const sidebarState = localStorage.getItem("sidebarState");
        if (sidebarState === "collapsed") {
            body.classList.add("sidebar-collapse");
        }
    });

    onMounted(() => {
        getNotes();
        fetchItemNamesAndCount();
    });

    return { authUserStore, createNote, deleteNotes, deleteNotification, settingStore, errors, form, notes };
}