<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <PatientSidebar />
      </div>
      <div class="col-md-9 col-lg-10 p-4">
        <div class="doctor-list-section">
          <div class="doctor-list-header d-flex justify-content-between align-items-center margin">
            <input
        type="text"
        class="form-control"
        v-model="searchQuery"
        placeholder="Search Doctor or Department"
      />
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Doctor Name</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!doctors ">
                <td colspan="6" class="text-center">No doctors available</td>
              </tr>
              <tr v-for="doctor in filteredDoctors" :key="doctor.id">
                <td>{{ doctor.name }}</td>
                <td>{{ doctor.phone }}</td>
                <td>{{ doctor.department }}</td>
                <td>
                  <button class="action" @click="getSession(doctor.id)">
                    <span class="tooltip-text">Get Session</span> <!-- Custom tooltip -->
                    <i class="fa-solid fa-file-waveform"></i>
                  </button>       
                </td>
              </tr>
            </tbody> 
          </table>
        </div>
      </div>
    </div>
      </div>
      </template>
      <script>
      import PatientSidebar from "../../layoutComponents/PatientSidebar.vue";
      import Navbar from "../../layoutComponents/NavBar.vue";
      import { ref,computed } from "vue";
      import axios from "axios";
      
      
      
      export default {
        name: "MyPatients",
        components: {
          PatientSidebar,
          Navbar,
        },
        setup() {
          const doctors = ref([]);
          const searchQuery = ref("");
          const error = ref(null);

          const fetchDoctors = async ()=> {
            try {
              const response = await axios.post("/doctors");
              doctors.value = response.data;
            } catch (error) {
              console.error('error fetchind ',error);
              error.value = 'failed to load doctors';
            }
          };

          fetchDoctors();

          const filteredDoctors = computed(() => {
      if (!searchQuery.value) {
        return doctors.value;
      }
      return doctors.value.filter(doctor => {
        return (
          doctor.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          doctor.department.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
      });
    });

          return {
            doctors,
            searchQuery,
            filteredDoctors,
            error,

          }

        }
      }

        </script>
        <style scoped>
        @import "/public/assets/css/view.css";

        .form-control{
          margin-bottom: 30px;
        }
        .form-control:focus {
        box-shadow: 0 0 5px 2px pink;
        border-color: pink;
        outline: none; /* Remove the default outline */
      }
      .tooltip-text {
        visibility: hidden;
        width: 100px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%; /* Position above the button */
        left: 50%;
        transform: translateX(-50%);
        opacity: 1.8;
        transition: opacity 0.2s; /* Fade in effect */
      }

      /* Tooltip arrow */
      .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%; /* Arrow at the bottom */
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
      }

      /* Show tooltip when hovering */
      .action:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
      }
      .action {
        position: relative; /* Needed for tooltip positioning */

      }
        </style>