import axios from "axios";
import { onMounted, ref } from "vue";

export function displayCount() {
    const totalCategoryCount = ref(0);
    const totalFiedlsCount = ref(0);
    const totalUsersCount = ref(0);
    const totalNotes = ref(0);
    const totalItemsCount = ref(0);
    const totalHistoryCount = ref(0);

    const getCategoryCount = () => {
        axios
            .get("/dashboard/fields")
            .then((response) => {
                totalFiedlsCount.value = response.data.fields;
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const getFieldsCount = () => {
        axios
            .get("/dashboard/category")
            .then((response) => {
                totalCategoryCount.value = response.data.categories;
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const getUsersCount = () => {
        axios
            .get("/dashboard/users")
            .then((response) => {
                totalUsersCount.value = response.data.count;
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const fetchNote = () => {
        axios
            .get("/dashboard/notes")
            .then((response) => {
                totalNotes.value = response.data.count;
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const gettotalItemsCount = () => {
        axios
            .get("/dashboard/items")
            .then((response) => {
                totalItemsCount.value = response.data.items;
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const gettotalItemsHistory = () => {
        axios
            .get("/dashboard/history")
            .then((response) => {
                totalHistoryCount.value = response.data.histories;
            })
            .catch((error) => {
                console.error(error);
            });
    };

    onMounted(() => {
        getCategoryCount();
        getFieldsCount();
        getUsersCount();
        gettotalItemsCount();
        gettotalItemsHistory();
        fetchNote();
    });

    return { totalCategoryCount, totalUsersCount, totalFiedlsCount, totalNotes, totalItemsCount, totalHistoryCount };
}

export function progressBar() {
    const goodItemCountPercent = ref([]);
    const badItemCountPercent = ref([]);
    const issuedItemCountPercent = ref([]);
    const underRepairItemCountPercent = ref([]);

    const countAll = () => {
        axios
            .get("/dashboard/progress")
            .then((response) => {
                goodItemCountPercent.value = response.data.goodItemCountPercent;
                badItemCountPercent.value = response.data.badItemCountPercent;
                issuedItemCountPercent.value = response.data.issuedItemCountPercent;
                underRepairItemCountPercent.value = response.data.underRepairItemCountPercent;
            })
            .catch((error) => {
                console.error(error);
            });
    };

    onMounted(() => {
        countAll();
    });

    return { goodItemCountPercent, badItemCountPercent, issuedItemCountPercent, underRepairItemCountPercent };
}

export function displayNotes() {
    const totalNotes = ref(0);
    const notes = ref([]);

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
                            created_at: note.created_at,
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

    const fetchNote = () => {
        axios
            .get("/dashboard/notes")
            .then((response) => {
                totalNotes.value = response.data.count;
            })
            .catch((error) => {
                console.error(error);
            });
    };
    onMounted(() => {
        getNotes();
    });

    return { totalNotes, fetchNote, notes };
}

export function dashboardUsers() {
    const users = ref([]);
    const getUsersData = () => {
        axios
            .get("/dashboard/users/data")
            .then((response) => {
                users.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching users:", error);
            });
    };
    onMounted(() => {
        getUsersData();
    });

    return { users };
}