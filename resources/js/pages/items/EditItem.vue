<template>
  <form>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Item</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/admin/dashboard">Home</router-link>
              </li>
              <li class="breadcrumb-item">Items</li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Item Name</label>
                        <input
                          v-model="form.name"
                          type="text"
                          class="form-control"
                          id="title"
                          placeholder="Enter Title"
                        />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="client">Status</label>
                        <select
                          v-model="form.status"
                          id="client"
                          class="form-control"
                          :class="{ 'is-invalid': errors.status }"
                        >
                          <option value="" disabled selected hidden>
                            Select Status
                          </option>
                          <option value="operating">Operating</option>
                          <option value="decommissioned">Decommissioned</option>
                          <option value="under repair">Under Repair</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date">Serial</label>
                        <input
                          v-model="form.serial"
                          type="text"
                          class="form-control"
                          id="date"
                        />
                      </div>
                    </div>
                  </div>

                  <h4>Attributes:</h4>
                  <div
                    v-for="(attribute, index) in form.value"
                    :key="index"
                    class="attribute"
                  >
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="title">Name</label>
                          <input
                            v-model="attribute.name"
                            :name="`value[${index}][label]`"
                            type="text"
                            class="form-control"
                            id="title"
                            placeholder="Enter Title"
                          />
                        </div>
                      </div>

                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="date">Value</label>
                          <input
                            type="text"
                            class="form-control"
                            id="date"
                            v-model="attribute.value"
                            :name="`value[${index}][value]`"
                          />
                        </div>
                      </div>

                      <div class="col-md-1">
                        <div class="form-group">
                          <i
                            class="fa fa-times mt-4 text-danger"
                            @click="removeAttribute(index)"
                            style="cursor: pointer"
                          ></i>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="text-center">
                    <button
                      type="button"
                      class="btn btn-outline-info"
                      @click="addAttribute"
                    >
                      <i class="fa fa-plus"></i>
                      Add Attribute
                    </button>
                  </div>

                  <button
                    @click.prevent="handleSubmit()"
                    type="submit"
                    class="btn btn-outline-primary"
                  >
                    <i class="fa fa-save mr-2"></i>
                    Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>


<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";

const errors = ref([]);
const toastr = useToastr();
const router = useRouter();
const route = useRoute();
const form = reactive({
  name: "",
  serial: "",
  status: "",
  value: [{ name: "", value: "" }],
});

const addAttribute = () => {
  form.value.push({ name: "", value: "" });
};

const removeAttribute = (index) => {
  form.value.splice(index, 1);
};

//
const getItems = () => {
  axios
    .get(`/items/${route.params.id}/show`)
    .then((response) => {
      console.log("Response data:", response.data);

      if (response.data) {
        form.name = response.data.name;
        form.serial = response.data.serial;
        form.status = response.data.status;
      } else {
        console.error("Item data not found in the response.");
      }
    })
    .catch((error) => {
      console.error("Error fetching item details:", error);
    });
};

const getAttributes = () => {
  axios
    .get(`/items/${route.params.id}/attributes`)
    .then(({ data }) => {
      console.log("Attributes data:", data);

      if (Array.isArray(data)) {
        form.value = data.map((attribute) => ({
          name: attribute.name,
          value: attribute.value,
        }));
      } else {
        console.error("Invalid attributes data format.");
      }
    })
    .catch((error) => {
      console.error("Error fetching item attributes:", error);
    });
};
//edit the item
const handleSubmit = () => {
  console.log("Form submitted with data:", form.value);

  axios
    .put(`/items/${route.params.id}`, form)
    .then((response) => {
      toastr.success("Item updated successfully!");
    })
    .catch((error) => {
      toastr.error("Error updating item. Please try again.");
    });
};
onMounted(() => {
  getItems();
  getAttributes();
});
</script>

