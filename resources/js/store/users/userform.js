import axios from "axios";
import { reactive, ref } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";

export function addUser(getUsersFn) {
    const toastr = useToastr();
    const router = useRouter();
    const route = useRoute();
    const form = reactive({
        name: "",
        email: "",
        password: "",
    });

    const errors = ref([]);
    const dataTosave = () => {
        axios
            .post("/users", form)
            .then((response) => {
                toastr.success("User created successfully.");
                getUsersFn();
                errors.value = "";
                $("#createUsers").modal("hide");
                clearForm();
                router.push("/admin/users");
            })
            .catch((error) => {
                if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };

    const clearForm = () => {
        form.name = "";
        form.email = "";
        form.password = "";
    };

    return { errors, form, dataTosave, getUsersFn };
}