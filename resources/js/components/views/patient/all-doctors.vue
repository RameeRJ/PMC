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
            <!-- <h2>All Doctors ({{ doctors.length }})</h2> -->
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
              <!-- <tr v-if="doctors.length === 0">
                <td colspan="6" class="text-center">No doctors available</td>
              </tr> -->
              <tr v-for="doctor in doctors" :key="doctor.id">
                <td>{{ doctor.name }}</td>
                <td>{{ doctor.phone }}</td>
                <td>{{ doctor.department }}</td>
                <td>
                  <button class="action" @click="getSession(doctor.id)">
                    <i class="fas fa-book-medical"></i>
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
      import { ref } from "vue";
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

          return {
            doctors,
            searchQuery,

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
        </style>