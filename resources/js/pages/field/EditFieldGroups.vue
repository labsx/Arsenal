<template>
<ContentHeader title="Edit Field Groups" data="item" datas="edit"/>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Field Groups</h3>
            </div>

            <form>
              <div class="card-body">
                <div class="form-group">
                  <label for="appName">Field Name</label>
                  <span class="text-danger"> *</span>
                  <input
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder=""
                    :class="{'is-invalid': errors.name}"
                  />
                  <span
                    v-if="errors && errors.name"
                    class="text-danger text-sm"
                    >{{ errors.name[0] }}</span
                  >
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea
                    v-model="form.description"
                    type="text"
                    class="form-control"
                  ></textarea>
                </div>
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="saveGroupFields"
                  type="submit"
                  class="btn btn-primary"
                >
                  <i class="fa fa-save mr-1"></i>Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { reactive, onMounted, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);

const form = reactive({
  name: "",
  description: "",
});

const groupDetails = () => {
  axios
    .get(`/field-group/${route.params.id}`)
    .then(({ data }) => {
      console.log("Field Group data:", data);
      form.name = data.name;
      form.description = data.description;
    })
    .catch((error) => {
      console.error("Error fetching field group details:", error);
    });
};

const saveGroupFields = () => {
  axios
    .put(`/field-group/${route.params.id}`, {
      name: form.name,
      description: form.description,
    })
    .then(() => {
      toastr.success("Group fields updated successfully!");
    })
   .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        toastr.error(message);
        // getItemsFn();
        errors.value = [];
      }
    });
};

onMounted(() => {
  groupDetails();
});
</script>
