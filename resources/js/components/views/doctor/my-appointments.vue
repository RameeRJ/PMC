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
                      <h2>My Appointments</h2>
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
import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: "MyAppointment",
  components: {
      DoctorSidebar,
      Navbar,
  },
  setup() {
      const appointments = ref([]);
      const filteredAppointments = ref([]);
      
      const fetchAppointments = async () => {
          const doctorId = localStorage.getItem('doctor_id'); // Get doctor_id from localStorage
          try {
              const response = await axios.post(`/appointments`); // Fetch all appointments
              appointments.value = response.data; // Assign the fetched appointments
              // Filter appointments based on the doctor's ID
              filteredAppointments.value = appointments.value.filter(appointment => 
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

      onMounted(fetchAppointments); // Fetch appointments when the component is mounted

      return {
          filteredAppointments,
          fetchAppointments,
          formatDate,
          formatTime,
      };
  },
}
</script>
<style scoped>
@import "/public/assets/css/view.css";
</style>
