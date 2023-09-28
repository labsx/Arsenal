<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
         <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <div class="row">

                        <!-- Item with serial -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                               <div class="d-flex justify-content-between mr-1">
                                  <h3></h3>
                                      <select
                                        v-model="statusFilter"
                                        style="height: 2rem; outline: 2px solid transparent"
                                        class="px-1 rounded border-0 hover"
                                        @change="getItemsCount"
                                      >
                                        <option value="TODAY" class="hover">All</option>
                                        <option value="Good" class="hover">Good</option>
                                        <option value="issued">Issued</option>
                                        <option value="Bad">Bad</option>
                                      </select>
                                </div>
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Item (Serial)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalItemsCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item count -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                               <div class="d-flex justify-content-between mr-1">
                                  <h3 class="text-white"></h3>
                                  <select
                                    v-model="statusFilters"
                                    style="
                                      height: 2rem;
                                      max-height: 50px;
                                      overflow-y: auto;
                                      outline: 2px solid transparent;
                                    "
                                    class="px-1 rounded border-0 hover"
                                    @change="getItemsCountByName"
                                  >
                                    <option value="All" class="hover">All</option>
                                    <option
                                      v-for="item in uniqueItems"
                                      :key="item.name"
                                      :value="item.name"
                                      class="hover"
                                    >
                                      {{ item.name }}
                                    </option>
                                  </select>
                                </div>
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Item Serial (Count)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                               {{
                                                  statusFilters === "All"
                                                    ? selectedItemCount
                                                    : selectedItemCount
                                                }}
                                              </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-info-circle fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- users count -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 custom-mt">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Users
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ totalUsersCount }}</div>
                                                </div>
                                             
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300 custom-mt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 custom-mt">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1 ">
                                                Notes </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalNotes }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300 custom-mt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- Items Count WithOutSerial -->
                    <div class="row">
                       <div class="col-md-3 mb-4">
                            <div class="card border-left-primary shadow h-50 py-6">
                               <div class="d-flex justify-content-between mr-1">
                                  <h3></h3>
                                      <select
                                        v-model="Filter"
                                        style="height: 2rem; outline: 2px solid transparent"
                                        class="px-1 rounded border-0 hover mt-2 "
                                        @change="getStatusWithoutSerial"
                                      >
                                        <option value="TODAY" class="hover">All</option>
                                        <option value="Good" class="hover">Good</option>
                                        <option value="issued">Issued</option>
                                        <option value="Bad">Bad</option>
                                      </select>
                                </div>
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ITEM STATUS (Without Serial)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ totalItemsCountWihtoutSerial }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-archive fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item CountwihtoutSerial -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-success shadow h-50 py-2">
                            <div class="d-flex justify-content-between mr-1">
                              <h3 class="text-white"></h3>
                              <select v-model="Filter" style="height: 2rem; outline: 2px solid transparent" class="px-1 rounded border-0 hover mt-2" @change="getCountWithoutSerial">
                                <option
                                  v-for="item in itemsWithoutSerialCount"
                                  :key="item.id"
                                  :value="item.name"
                                  class="hover"
                                >
                                  {{ item.name }} 
                                </option>
                              </select>
                            </div>
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Item available (Without Serial)
                                  </div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ itemsDisplayCount ? ` ${itemsDisplayCount}` : 'No data available' }}
                                  </div>
                                </div>
                                <div class="col-auto">
                                  <i class="fa fa-info-circle fa-2x text-gray-300"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Notes -->
                     <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-body" v-if="notes.length > 0">
                                <section style="background-color: #eee;">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center p-3"
                                            style="border-top: 4px solid #ffa900;">
                                            <h5 class="mb-0">Notes (latest)</h5>
                                        </div>
                                        <div class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 180px; overflow-y: auto;">
                                            <div v-for="note in notes" :key="note.id">
                                                <div class="d-flex flex-row justify-content-start">
                                                    <img :src="note.userAvatar" alt="avatar 1" style="width: 30px; height: 30%;">
                                                    <div>
                                                        <p class="small p-2 ms-3 mb-3 rounded-3 ml-3" style="background-color:#F5F5F5; color: black;">{{ note.notes }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div v-else>
                                <p>No notes available.</p>
                            </div>
                        </div>
                    </div>
                    </div>



                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                          <div class="card shadow mb-4">

                                <div class="card-header py-3">
                                  <h6 class="m-0 font-weight-bold text-primary">Items</h6>
                                </div>

                                <div class="card-body">
                                  <h4 class="small font-weight-bold">Bad Items <span class="float-right">{{ badItemCountPercent }}%</span></h4>
                                    <div class="progress mb-4">
                                      <div class="progress-bar bg-danger" role="progressbar" :style="{ width: badItemCountPercent + '%' }" :aria-valuenow="badItemCountPercent" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Issued Items <span class="float-right">{{ issuedItemCountPercent }}%</span></h4>
                                    <div class="progress mb-4">
                                      <div class="progress-bar" role="progressbar" :style="{ width: issuedItemCountPercent + '%' }" :aria-valuenow="issuedItemCountPercent" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">Good Items <span class="float-right">{{ goodItemCountPercent }}%</span></h4>
                                    <div class="progress">
                                      <div class="progress-bar bg-success" role="progressbar" :style="{ width: goodItemCountPercent + '%' }" :aria-valuenow="goodItemCountPercent" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                              </div>
                          </div>
                      </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                            src="img/undraw_posting_photo.svg" alt="...">
                                    </div>
                                    <p>Add some quality, svg illustrations to your project courtesy of <a
                                            target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                                        constantly updated collection of beautiful svg images that you can use
                                        completely free and without attribution!</p>
                                    <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                                        unDraw &rarr;</a>
                                </div>
                            </div>

                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                                        CSS bloat and poor page performance. Custom CSS classes are used to create
                                        custom components and custom utility classes.</p>
                                    <p class="mb-0">Before working with this theme, you should become familiar with the
                                        Bootstrap framework, especially the utility classes.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>             
          </div>
        <div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { timeDate } from './../helper.js';

const totalItemsCount = ref(0);
const statusFilter = ref("TODAY");
const statusFilters = ref();
const selectedItemCount = ref(0);
const totalNotes = ref(0);
const notes = ref([]); 
const goodItemCountPercent = ref([]);
const badItemCountPercent = ref([]);
const issuedItemCountPercent = ref([]);
const Filter = ref(0);
const Filters = ref(0);
const totalItemsCountWihtoutSerial = ref (0);
const itemsWithoutSerialCount = ref([]);


const uniqueItems = ref([]);
//
const AvailWithoutSerial = () => {
  axios
    .get("/dashboard/avail-without-serial")
    .then((response) => {
      itemsWithoutSerialCount.value = response.data.items;
    })
    .catch((error) => {
      console.error(error);
    });
};

const itemsDisplayCount = ref(null);
const getCountWithoutSerial = () => {
  axios
    .get("/dashboard/without-serial", {
      params: {
        status: Filter.value,
      },
    })
    .then((response) => {
      totalItemsCountWihtoutSerial.value = response.data.count;
      if (Filter.value !== "All") {
        const selectedItem = itemsWithoutSerialCount.value.find(item => item.name === Filter.value);
        if (selectedItem) {
          itemsDisplayCount.value = selectedItem.count;
        } else {
          itemsDisplayCount.value = null;  
        }
      }
    })
    .catch((error) => {
      console.error(error);
    });
};
const updateItemCount = () => {
    if (itemsDisplayCount.value) {
        const selectedName = selectedItem.value;
        itemsDisplayCount.value = itemsWithoutSerialCount.value.find(item => item.name === selectedName)?.count || 0;
    } else {
        itemsDisplayCount.value = 0;
    }
};
//
const getStatusWithoutSerial = () => {
  axios.get("/dashboard/without-serial", {
      params: {
        status: Filter.value,
      },
    })
    .then((response) => {
      totalItemsCountWihtoutSerial.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};

const countAll = () => {
  axios.get('/dashboard/count')
   .then((response) => {
      goodItemCountPercent.value = response.data.goodItemCountPercent;
      badItemCountPercent.value = response.data.badItemCountPercent;
      issuedItemCountPercent.value = response.data.issuedItemCountPercent;
    })
    .catch((error) => {
      console.error(error);
    });
};

const getNotes = () => {
  axios.get('/notes/data')
    .then((response) => {
      const notesData = response.data;
      const notePromises = notesData.map(note => {
        return axios.get(`/user/${note.user_id}`)  
          .then(userResponse => ({
            id: note.id,
            notes: note.notes,
            created_at: note.created_at,
            userName: userResponse.data.name,
            userAvatar: userResponse.data.avatar 
          }))
          .catch(error => {
            console.error('Error fetching user:', error);
            return null;
          });
      });

      Promise.all(notePromises)
        .then(notesWithUser => {
          notes.value = notesWithUser.filter(note => note !== null);
        });
    })
    .catch((error) => {
      console.error('Error fetching all items:', error);
    });
};

const fetchNote = () => {
  axios
    .get("/dashboard/notes")
    .then((response) => {
      totalNotes.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};

const fetchItems = () => {
  axios
    .get("/dashboard/items")
    .then((response) => {
      const itemsData = response.data.items;
      const uniqueItemNames = new Set(itemsData.map((item) => item.name));
      uniqueItems.value = Array.from(uniqueItemNames).map((name) => ({ name }));
    })
    .catch((error) => {
      console.error(error);
    });
};

const getItemsCountByName = () => {
  if (statusFilters.value === "All") {
    axios
      .get(`/dashboard/items/count-name`)
      .then((response) => {
        if (response.data && response.data.count) {
          selectedItemCount.value = response.data.count;
        }
      })
      .catch((error) => {
        console.error("Error fetching items data", error);
      });
  } else {
    axios
      .get(`/dashboard/items/count?name=${statusFilters.value}`)
      .then((response) => {
        if (response.data && response.data.count !== undefined) {
          selectedItemCount.value = response.data.count;
        } else {
          console.error(
            "Invalid or empty response for item count by name:",
            response
          );
        }
      })
      .catch((error) => {
        console.error("Error fetching item count by name:", error);
      });
  }
};

const getItemsCount = () => {
  axios
    .get("/dashboard", {
      params: {
        status: statusFilter.value,
      },
    })
    .then((response) => {
      totalItemsCount.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};

const totalUsersCount = ref(0);
const getUsersCount = () => {
  axios
    .get("/dashboard/users")
    .then((response) => {
      totalUsersCount.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};

onMounted(() => {
  getItemsCount();
  getStatusWithoutSerial();
  AvailWithoutSerial();
  getUsersCount();
  fetchItems();
  fetchNote();
  getNotes();
  countAll();
});
</script>
<style scoped>
.hover:hover {
  background-color: white;
}
.custom-mt {
  margin-top: 2rem;
}
</style>


