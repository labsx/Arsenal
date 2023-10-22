import axios from "axios";
import { ref, reactive } from "vue";
import { useAuthUserStore } from "../../store/themeStore";
import { useToastr } from "../../toastr";

export function userProfile() {
    const authuserStore = useAuthUserStore();

    const toastr = useToastr();
    const errors = ref([]);

    const updateProfile = () => {
        axios
            .put("/users/profile", {
                name: authuserStore.user.name,
                email: authuserStore.user.email,
            })
            .then((response) => {
                toastr.success("Successfully updated profile data!");
            })
            .catch((error) => {
                if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };

    const fileInput = ref(null);
    const openFileInput = () => {
        fileInput.value.click();
    };

    const handleFileChange = (event) => {
        const file = event.target.files[0];
        authuserStore.user.avatar = URL.createObjectURL(file);

        const formData = new FormData();
        formData.append("profile_picture", file);

        axios.post("/users/profile", formData).then((response) => {
            toastr.success("Image uploaded successfully!");
        });
    };

    const changePasswordForm = reactive({
        currentPassword: "",
        newPassword: "",
        passwordConfirmation: "",
    });

    const handleChangePassword = () => {
        axios
            .post("/users/profile", changePasswordForm)
            .then((response) => {
                toastr.success("Successfully updated password!");
                for (const field in changePasswordForm) {
                    changePasswordForm[field] = "";
                }
            })
            .catch((error) => {
                if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };
    return { updateProfile, openFileInput, fileInput, handleFileChange, handleChangePassword, authuserStore, errors, changePasswordForm };

}