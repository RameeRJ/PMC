<template>
  <NavBar />
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Column (left) -->
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <PatientSidebar />
      </div>
      <!-- Main Content (right) -->
      <div class="col-md-9 col-lg-10 p-4">
        <div class="dashboard-header">
          <h2>Welcome <span class="user-name">{{ user.name }}</span></h2>
          <p>Manage your appointments, search for doctors, and review your medical history.</p>
        </div>

        <!-- Status Cards Section -->
        <div class="status-section mb-4">
          <h3 class="center">Status Overview</h3>
          <div class="row">
            <div class="col-md-4">
              <div class="status-card">
                <router-link to="/all-doctors" class="no-underline">
                <p class="card-count">{{ numberOfDoctors }}</p>
                <span class="card-label">Doctors Available</span>
                </router-link>
              </div>
            </div>
            <div class="col-md-4">
              <div class="status-card">
                <router-link to="/ongoing-schedules" class="no-underline">
                <p class="card-count">{{numberOfSchedules}}</p>
                <span class="card-label">Schedules Available</span>
              </router-link>
              </div>
            </div>
            <div class="col-md-4">
              <div class="status-card">
                <router-link to="/my-booking" class="no-underline">
                <p class="card-count">{{ numberOfAppointments }}</p>
                <span class="card-label">Appointments</span>
              </router-link>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from '../../layoutComponents/NavBar.vue';
import PatientSidebar from '../../layoutComponents/PatientSidebar.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';


export default {
  name: "PatientDashboard",
  components: {
    PatientSidebar,
    NavBar,
  },
  data() {
    return {
      numberOfSchedules: 0,
      numberOfAppointments: 0,
      numberOfDoctors: 0,
      user: {}
  };
},
  mounted() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
      }

  },  
  setup() {
    const schedules = ref([]); 
    const appointments = ref([]); 
    const doctors = ref([]);
    const numberOfSchedules = ref(0);
    const numberOfAppointments = ref(0);
    const filteredAppointmentsByDoctor = ref([]);
    const numberOfDoctors = ref(0);
    const error = ref(null); // Handle errors3.0
    

    const fetchSchedules = async () => { // Get doctor_id from localStorage
      try {
        const response = await axios.post(`/patient/schedules`);
        console.log("Schedules fetched:", response.data);
        schedules.value = response.data.schedules;

        // Get the length of the schedules
        numberOfSchedules.value = response.data.schedules.length;

      } catch (error) {
        console.error("Error fetching schedules:", error);
        error.value = 'Failed to load schedules. Please try again.';
      }
    };

    const fetchAppointments = async () => {
      const userId = localStorage.getItem('user_id'); // Get doctor_id from localStorage
  try {
    const response = await axios.post(`/appointments/${userId}`);
        console.log("appointments fetched:", response.data);
        appointments.value = response.data;

        numberOfAppointments.value = response.data.length;
    
    // Filter appointments based on the doctor's ID
    filteredAppointmentsByDoctor.value = appointments.value.filter(appointment =>
      appointment.schedule.doctor_id === Number(doctorId) // Ensure comparison with number
    );

    // Assign the length of filtered appointments to numberOfAppointments
    numberOfAppointments.value = filteredAppointmentsByDoctor.value.length;
  } catch (error) {
    console.error("Error fetching appointments:", error);
  }
};
const fetchDoctors = async () => {
  try {
    const response = await axios.post(`/doctors`); 
    doctors.value = response.data; 

    numberOfDoctors.value = response.data.length;
  } catch (error) {
    console.error("Error fetching appointments:", error);
  }
};


    // Fetch schedules when the component is mounted
    onMounted(() => {
      fetchSchedules();
      fetchAppointments();
      fetchDoctors();
    });

    return {
      schedules,
      numberOfSchedules,
      error,
      fetchAppointments,
      numberOfAppointments,
      numberOfDoctors,
      fetchDoctors
      };
  }
  
}
</script>

<style scoped>
@import "/public/assets/css/dashboard.css";
</style>
