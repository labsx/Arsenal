<template>
  <div class="col-xl-6 col-lg-5">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Notes (latest)</h6>
      </div>
      <div class="card-body" style="height: 180px; overflow-y: auto">
        <div v-if="notes.length > 0">
          <div v-for="note in notes" :key="note.id">
            <div class="d-flex flex-row justify-content-start">
              <img
                :src="note.userAvatar"
                alt="avatar 1"
                style="width: 30px; height: 30%"
              />
              <div>
                <p
                  class="small p-2 ms-3 mb-3 rounded-3 ml-3"
                  style="background-color: #f5f5f5; color: black"
                >
                  {{ note.notes }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <p class="text-danger mt-2 text-center">No notes available.</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { displayNotes } from "../../store/dashboardjs/dashboard.js";

const { totalNotes, fetchNote, notes } = displayNotes();
</script>
