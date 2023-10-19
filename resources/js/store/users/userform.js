import axios from "axios";
import { reactive, ref } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";

export function addUser() {
    const toastr = useToastr();
    const router = useRouter();
    const route = useRoute();
    const form = reactive({
        name: "",
        email: "",
        password: "",
    });

    const errors = ref([]);
    const creatUser = () => {
        axios
            .post("/users", form)
            .then((response) => {
                toastr.success("Successfully created user !");
                router.push("/admin/users");
            })
            .catch((error) => {
                if (error.response && error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            });
    };

    return { errors, form, creatUser };
}