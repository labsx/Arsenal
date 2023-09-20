<template>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="max-width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADD ITEM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
           <div class="content" >
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="createItemCount()">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input v-model="form.name" type="text" class="form-control" id="title" placeholder="Enter item name">
                                              <span v-if="errors && errors.name" class="text-danger text-sm">{{ errors.name[0]}}</span>
                                        </div>
                                    </div>
                                 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input v-model="form.date" type="date" class="form-control flatpickr">
                                            <span v-if="errors && errors.date" class="text-danger text-sm">{{ errors.date[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Count</label>
                                            <input v-model="form.count" type="number" class="form-control" placeholder="Enter items count" >
                                            <span v-if="errors && errors.count" class="text-danger text-sm">{{ errors.count[0]}}</span>
                                        </div>
                                        
                                    </div>

                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input v-model="form.status" type="text" class="form-control" Value="Good" disabled>
                                            
                                        </div>
                                        
                                    </div>
                                
                                </div>

                               
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="form.description" class="form-control" id="description" rows="3" 
                                        placeholder="Enter Description"></textarea>
                                         <span v-if="errors && errors.description" class="text-danger text-sm">{{ errors.description[0]}}</span>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2 text-danger"></i>Close</button>
        <button @click.prevent="createItemCount" type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save Item</button>
      </div>
    </div>
  </div>
</div> 
</template>
<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useToastr } from '../../toastr';

const toastr = useToastr();
const errors = ref([]);
const form = ref({
    name: '',
    date: '',
    count: '',
    description: '',
    status: 'Good',
});

const createItemCount = () => {
  axios
    .post('/data', form.value)
    .then((response) => {
      toastr.success('Item created successfully!');
      $('#createModal').modal('hide');
      clearForm();
    
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        
      }
    });
};

const clearForm = () => {
  form.value.name = '';
  form.value.date = '';
  form.value.count = '';
  form.value.description = '';
};
</script>


