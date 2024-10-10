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
                              <th>Schedule</th>
                              <th>Date</th>
                              <th>Time</th>
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
                              <td>{{ appointment.schedule.schedule_title }}</td>
                              <td>{{ formatDate(appointment.schedule.schedule_date) }}</td>
                              <td>{{ formatTime(appointment.schedule.start_time) }} - {{ formatTime(appointment.schedule.end_time) }}</td>
                              <td>{{ appointment.token }}</td>
                              <td>
                                <button class="action" @click="getPatient(appointment)">
                    <span class="tooltip-text">Get patient</span> <!-- Custom tooltip -->
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
import { useRouter } from "vue-router";
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

    const formatTime = (time) => {
      const [hours, minutes] = time.split(':');
      const date = new Date();
      date.setHours(hours);
      date.setMinutes(minutes);
      return date.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
      });
    };

    const formatDate = (dateString) => {
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
      });
    };
    const getPatient = (appointment) => {
  // Show confirmation dialog
  Swal.fire({
    title: 'Are you sure?',
    text: `You are about to search for schedule ${appointment.schedule.schedule_title} and token ${appointment.token}.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, proceed!',
    cancelButtonText: 'Cancel',
  }).then((result) => {
    if (result.isConfirmed) {
      // Navigate to the desired route and pass the schedule and token as query parameters
      router.push({
        path: '/my-patients', 
        query: { 
          schedule: appointment.schedule.schedule_title, 
          token: appointment.token 
        }
      });
    }
  });
};


    // Computed property to search through the filtered appointments (by doctor ID)
    const filteredAppointments = computed(() => {
      if (!searchQuery.value) {
        return filteredAppointmentsByDoctor.value; // Return all appointments if no search query
      }
      return filteredAppointmentsByDoctor.value.filter(appointment => {
        return (
          appointment.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          appointment.schedule.schedule_title.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
      });
    });



    onMounted(fetchAppointments); // Fetch appointments when the component is mounted

    return {
      filteredAppointments,
      searchQuery, // Return searchQuery to bind with input
      formatDate,
      formatTime,
      getPatient
    };
  },
}

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
