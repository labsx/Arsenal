<template>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="max-width: 70%;">
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
                            <form >
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input  type="text" class="form-control" id="title" placeholder="Enter item name">
                                             
                                        </div>
                                    </div>
                                 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input  type="date" class="form-control flatpickr">
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Count</label>
                                            <input type="number" class="form-control" placeholder="Enter model" >
                                           
                                        </div>
                                        
                                    </div>
                                
                                </div>

                               
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea  class="form-control" id="description" rows="3" 
                                        placeholder="Enter Description"></textarea>
                                        
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
        <button @click="createItem" type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save Item</button>
      </div>
    </div>
  </div>
</div> 
</template>

