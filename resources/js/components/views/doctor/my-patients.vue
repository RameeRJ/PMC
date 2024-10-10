<template>
  <Navbar />
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
              <DoctorSidebar />
          </div>
          <div class="col-md-9 col-lg-10 p-4">
              <div class="doctor-list-section">
                  <div class="doctor-list-header d-flex justify-content-between align-items-center margin">
                      
                      <input
        type="text"
        class="form-control"
        v-model="searchQuery"
        placeholder="Search Patient or Schedule"
      />
                  </div>
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>Patient Name</th>
                              <th>Age</th>
                              <th>Place</th>
                              <th>Phone</th>
                              <th>Schedule</th>
                              <th>Token</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-if="filteredAppointments.length === 0">
                              <td colspan="6" class="text-center">No appointments available</td>
                          </tr>
                          <tr v-for="appointment in filteredAppointments" :key="appointment.id">
                              <td>{{ appointment.name }}</td>
                              <td>{{ appointment.age }}</td>
                              <td>{{ appointment.place }}</td>
                              <td>{{ appointment.phone }}</td>
                              <td>{{ appointment.schedule.schedule_title }}</td>
                              <td>{{ appointment.token }}</td>


                             
                              <td>
                                <button class="action" @click="getPatient(appointment.name)">
                    <span class="tooltip-text">Send Priscription</span> <!-- Custom tooltip -->
                    <i class="fa-solid fa-share-from-square"></i>
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
import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useRoute , useRouter } from "vue-router";
import Swal from "sweetalert2";

export default {
  name: "MyAppointment",
  components: {
    DoctorSidebar,
    Navbar,
  },
  setup() {
    const appointments = ref([]); // All fetched appointments
    const filteredAppointmentsByDoctor = ref([]); // Appointments filtered by doctor ID
    const searchQuery = ref(""); // Search query
    const route = useRoute();
    const router = useRouter();

    const fetchAppointments = async () => {
      const doctorId = localStorage.getItem('doctor_id'); // Get doctor_id from localStorage
      try {
        const response = await axios.post(`/appointments`); // Fetch all appointments
        appointments.value = response.data; // Assign the fetched appointments
        // Filter appointments based on the doctor's ID
        filteredAppointmentsByDoctor.value = appointments.value.filter(appointment =>
          appointment.schedule.doctor_id === Number(doctorId) // Ensure comparison with number
        );
      } catch (error) {
        console.error("Error fetching appointments:", error);
      }
    };

    onMounted(() => {
      fetchAppointments();

      // Populate search query from URL if schedule or token is present
      const scheduleQuery = route.query.schedule ? route.query.schedule : "";
      const tokenQuery = route.query.token ? route.query.token : "";
      searchQuery.value = `${scheduleQuery} ${tokenQuery}`.trim(); // Combine schedule and token
    });

    // Computed property to search through the filtered appointments (by doctor ID)
    const filteredAppointments = computed(() => {
      if (!searchQuery.value) {
        return filteredAppointmentsByDoctor.value; // Return all appointments if no search query
      }

      // Split the search query into terms
      const queryTerms = searchQuery.value.toLowerCase().split(' ');

      return filteredAppointmentsByDoctor.value.filter(appointment => {
        // Check if the appointment matches any of the query terms
        const scheduleMatch = queryTerms.some(term =>
          appointment.schedule.schedule_title.toLowerCase().includes(term)
        );
        const tokenMatch = queryTerms.some(term =>
          appointment.token.toString() === term // Exact match for token
        );

        return scheduleMatch && tokenMatch; // Both conditions must be true
      });
    });

    return {
      filteredAppointments,
      searchQuery, // Return searchQuery to bind with input
    };
  },
};
</script>


<style scoped>
@import "/public/assets/css/view.css";
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
