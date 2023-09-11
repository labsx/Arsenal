

<template>
 <div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    <div class="col-sm-6">
    <h1 class="m-0">Dashboard</h1>
    </div>
    <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    </div>
    </div>
    </div>
    </div> 

 <div class="content">
        <div class="container-fluid">
         <div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <div class="d-flex justify-content-between">
                    <h3>User</h3>
                   
                </div>
                <p>Items</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <router-link to="/admin/items/list" class="small-box-footer">
                View Items List
                <i class="fas fa-arrow-circle-right"></i>
            </router-link>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <div class="d-flex justify-content-between">
                    <h3>User Count</h3>
                    
                </div>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <router-link to="" class="small-box-footer">
                View Users
                <i class="fas fa-arrow-circle-right"></i>
            </router-link>
        </div>
    </div>
</div>

        </div> 
 </div>
</template>

