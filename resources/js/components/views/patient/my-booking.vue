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
            <h2>All Bookings</h2>
          </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Schedule Title</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Token</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr v-if="appointments.length === 0">
                <td colspan="6" class="text-center">No appointments available</td>
              </tr> -->
              <tr v-for="appointment in appointments" :key="appointment.id">
                <td>{{ appointment.schedule.schedule_title }}</td>
                <td>{{ appointment.schedule.doctor.name }}</td>
                <td>{{ formatDate(appointment.schedule.schedule_date) }}</td>
                <td>{{ formatTime(appointment.schedule.start_time) }}</td>
                <td>{{ (appointment.token) }}</td>
                <td>
                  <button class="action" @click="removeAppointment(appointment.id)">
                    <i class="fas fa-trash-alt"></i>
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
import axios from 'axios';
import PatientSidebar from "../../layoutComponents/PatientSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';

export default {
  name: "Appointment",
  components: {
    PatientSidebar,
    Navbar,
  },
  setup() {
    const appointments = ref([]); // Array to hold the fetched appointments


    // Fetch appointments from the server
    const fetchAppointments = async () => {
      const userId = localStorage.getItem('user_id'); // Get doctor_id from localStorage
      try {
        const response = await axios.post(`/appointments/${userId}`);
        console.log("appointments fetched:", response.data);
        appointments.value = response.data;
      } catch (error) {
        console.error("Error fetching appointments:", error);
        error.value = 'Failed to load doctors. Please try again.';
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
    day: 'numeric',    // Day of the month (e.g., "10")
    month: 'long',     // Full month name (e.g., "October")
    year: 'numeric'    // Full year (e.g., "2024")
  });
};

  onMounted(fetchAppointments);// Fetch appointments when the component is mounted

  return {
    appointments,
    fetchAppointments,
    formatDate,
    formatTime
  }
},
}
</script>
<style scoped>
@import "/public/assets/css/view.css";
</style>
  