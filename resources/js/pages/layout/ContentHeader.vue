<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{title}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">{{data}}</li>
            <li class="breadcrumb-item active">{{datas}}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
    data: {
      type: String,
      required: true,
    },
    datas: {
      type: String,
      required: true,
    }
  },
}
</script>
