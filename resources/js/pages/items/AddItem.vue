<template>

    <!-- <form @submit.prevent="handleSubmit">
      <div class="form-group">
          <label for="client">Fields</label>
          <select
            name="fieldGroup"
            id="fieldGroup"
            v-model="form.item_id"
            @change="getFields"
          >
            <option value=""></option>
            <option
              :value="group.id"
              v-for="group in field_groups"
              :key="group.id"
            >
              {{ group.name }}
            </option>
          </select>
        </div>

      <label for="name">Item Name:</label>
      <input v-model="name" type="text" id="name" required /><br /><br />

        <div v-for="(field, index) in fieldsData" :key="index">
            <label for="">{{field.label}}</label>
        </div>

      <div v-for="(attribute, index) in attributes" :key="index" class="attribute">
        <label>Attribute Name:</label>
        <input v-model="attribute.name" type="text" placeholder="Attribute Name" required />

        <label>Attribute Value:</label>
        <input v-model="attribute.value" type="text" placeholder="Attribute Value" required />

        <button type="button" @click="removeAttribute(index)">Remove Attribute</button>
      </div>

      <button type="button" @click="addAttribute">Add Attribute</button>

      <button type="submit">Create Item</button>
    </form>
  </div> -->
  <form>
    <label for="">Item Name</label>
    <input v-model="form.name" type="text">

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="client">Fields</label>
          <select
            name="fieldGroup"
            id="fieldGroup"
            v-model="form.item_id"
            @change="getFields"
          >
            <option value=""></option>
            <option
              :value="group.id"
              v-for="group in field_groups"
              :key="group.id"
            >
              {{ group.name }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div v-for="(field, index) in fieldsData" :key="index">
      <label>{{ field.label }} : </label>
      <input
        v-model="form.fields[field.label]"
        type="text"
        class="form-control"
      />
    </div>
  </form>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { useToastr } from "../../toastr";

const toastr = useToastr();

const form = ref({
  item_id: "",
  fields: {},
});
//
// const category_id = ref('');
// const name = ref('');
// const attributes = ref([{ name: '', value: '' }]);

// const addAttribute = () => {
//   attributes.value.push({ name: '', value: '' });
// };

// const removeAttribute = (index) => {
//   attributes.value.splice(index, 1);
// };

// const handleSubmit = () => {

//   const formData = {
//     category_id: category_id.value,
//     name: name.value,
//     attributes: attributes.value,
//   };

//   console.log('Form Data:', formData);
// };
//

const field_groups = ref([]);
const fieldsData = ref([]);

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

const getFields = async () => {
  const selectedGroupId = form.value.item_id;
  if (selectedGroupId) {
    try {
      const response = await axios.get(
        `/fields?field_groups_id=${selectedGroupId}`
      );
      fieldsData.value = response.data;
    } catch (error) {
      console.error("Error fetching fields:", error);
    }
  } else {
    fieldsData.value = [];
  }
};

onMounted(() => {
  getFieldGroup();
});

watch(form, getFields);
</script>
