<template>
  <div
    class="modal fade"
    id="createCategoryItem"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createCategoryItem"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 70%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createCategoryItem">ADD ITEM</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form>
                        <div class="row">

                          <!-- <div class="form-group">
                             <label for="fieldGroup">Name</label>
                            <select
                              name="fieldGroup"
                              id="fieldGroup"
                              v-model="form.parent_id"
                            >
                              <option value=""></option>
                              <option
                                :value="parent.id"
                                v-for="parent in parents"
                                :key="parent.id"
                              >
                                {{ parent.name }}
                              </option>
                            </select>
                            </div> -->
                          
                          <div class="col-md-6">
                        
                            <div class="form-group">
                              <label for="client">Category Name</label>
                              <select
                                name="fieldGroup"
                                id="fieldGroup"
                                v-model="form.item_id"
                              >
                                <option value=""></option>
                                <option
                                  :value="fields.id"
                                  v-for="fields in field_groups"
                                  :key="fields.id"
                                >
                                  {{ fields.name }}
                                </option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div v-for="(field, index) in fields" :key="index">
                            <label>{{ field.label }} : </label>
                            <input
                              v-model="form.fields[field.label]"
                              type="text"
                              class="form-control"
                            />
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button @click="createItem()" type="submit" class="btn btn-primary">
            <i class="fa fa-save mr-2"></i>Save Item
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { useToastr } from "../../toastr";

const toastr = useToastr();
//
const createItem = () => {
  const dataToSave = {
    item_id: form.value.item_id,
    //parent_id: form.value.parent_id,
    value: [],  
  };

  fields.value.forEach((field) => {
    const fieldName = field.label;
    const fieldValue = form.value.fields[fieldName];

    if (fieldValue) {
      dataToSave.value.push({
        label: field.label,
        value: fieldValue,
      });
    }
  });

  axios
    .post("/item-attributes", dataToSave)
    .then((response) => {
      toastr.success("Item saved successfully!");
      // clearForm();
      $("#createCategoryItem").modal("hide");
    })
    .catch((error) => {
      toastr.error("Error saving item: " + error);
      console.log('error');
    });
};

const form = ref({
 item_id: "",
 // parent_id: "",
  fields: {},
});

// const createItem = () => {
//   const dataToSave = {
//     fields_id: form.value.fields_id,
//     item_name: form.value.item_name,
//   };

//   // Iterate through fields and save the label and its corresponding value
//   fields.value.forEach((field) => {
//     const fieldName = field.name;
//     const fieldValue = form.value[fieldName];

//     dataToSave[fieldName] = fieldValue;
//     dataToSave[`${fieldName}_label`] = field.name;  // Save the label
//   });

//   axios
//     .post("/items", dataToSave)
//     .then((response) => {
//       toastr.success("Item saved successfully!");
//       clearForm();
//       $("#createCategoryItem").modal("hide");
//     })
//     .catch((error) => {
//       toastr.error("Error saving item: " + error);
//     });
// };

// const fields = ref([]);
// const selectedField = ref("");
// const selectedFieldId = ref(null);
// const selectedFieldData = ref([]);

// const createItems = () => {
//   const data = {
//     category_id: form.value.category_id,
//   };
//   const emptyFields = [];

//   selectedFieldData.value.forEach((field) => {
//     const name = field.name;
//     const inputValue = form.value[name];

//     if (!inputValue) {
//       emptyFields.push(name);
//     }

//     data[name] = inputValue;
//   });

//   if (emptyFields.length > 0) {
//     const errorMessages = {};
//     emptyFields.forEach((name) => {
//       errorMessages[name] = ["Field is required."];
//     });
//     errors.value = errorMessages;
//     return;
//   } else {
//     errors.value = {};
//   }

//   axios
//     .post("/category/data", data)
//     .then((response) => {
//       toastr.success("Data saved successfully!");
//       $("#createCategoryItem").modal("hide");
//       // clearForm();
//     })
//     .catch((error) => {
//       toastr.error("Error saving data: " + error);
//     });
// };
// // const createItems = () => {
// //   const data = {
// //     category_id: form.value.category_id,
// //   };

// //   selectedFieldData.value.forEach((field) => {
// //     const label = field.label;
// //     const inputValue = form.value[label];

// //     data[label] = inputValue;
// //   });

// //   axios
// //     .post("/category/data", data)
// //     .then((response) => {
// //       toastr.success("Data saved successfully!");
// //       $("#createCategoryItem").modal("hide");
// //       // clearForm();
// //     })
// //     .catch((error) => {
// //       toastr.error("Error saving data: " + error);
// //     });
// // };

// //

// const form = ref({
//   field_id: "",
//   name: "",
//   value: "",
//});
// const errors = ref([]);
// const toastr = useToastr();

// const subnames = ref([]);

// const getCategoryName = () => {
//   axios
//     .get("/category-sub")
//     .then((response) => {
//       subnames.value = response.data;
//     })
//     .catch((error) => {
//       console.error("Error fetching category names:", error);
//     });
// };
// //
// const fieldnames = ref([]);
// const getFields = () => {
//   const fieldsId = getFieldIdFromSelectedField();
//   if (fieldsId) {
//     axios
//       .get(`/fields-datas/${fieldsId}`)
//       .then((response) => {
//         selectedFieldData.value = response.data;
//       })
//       .catch((error) => {
//         console.error("Error fetching data from the other table:", error);
//       });
//   } else {
//     selectedFieldData.value = [];
//   }
// };

// watch(selectedField, getFields);

// const getFieldIdFromSelectedField = () => {
//   const selectedFieldObj = fieldnames.value.find(
//     (field) => field.name === selectedField.value
//   );
//   return selectedFieldObj ? selectedFieldObj.id : null;
// };

// const getFieldss = () => {
//   axios
//     .get("/fields-data")
//     .then((response) => {
//       fieldnames.value = response.data;
//     })
//     .catch((error) => {
//       console.error("Error fetching category names:", error);
//     });
// };

// onMounted(() => {
//   getFields();
//   getFieldss();
//   getCategoryName();
// });
const field_groups = ref();
const getFieldGroup = () => {
  axios
    .get("/field-group")
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching field_group:", error);
    });
};

const fields = ref();
const getFields = () => {
  axios
    .get("/fields")
    .then((response) => {
      fields.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching field_group:", error);
    });
};


const parents = ref();
const getParent = () => {
  axios
    .get("/parent")
    .then((response) => {
      parents.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching field_group:", error);
    });
};
onMounted(() => {
  getParent();
  getFieldGroup();
  getFields();
});
</script>
