<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Column (left) -->
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <DoctorSidebar />
      </div>
      
      <!-- Doctor Content (right) -->
      <div class="col-md-9 col-lg-10 p-4">
        <div class="dashboard-header">
          <h2>Welcome <span class="user-name">{{ user.name }}</span></h2>
          <p>Thanks for joinnig with us. We are always trying to get you a complete service
            You can view your dailly schedule, Reach Patients Appointment at home!</p>
        </div>

        <div class="status-section mb-4">
          <h3 class="center">Status Overview</h3>
        <div class="row">
          <div class="col-md-4">
            
              <div class="status-card">
                <router-link to="/my-schedules" class="no-underline">
                  <h5 class="card-label">Number of Schedules</h5>
                  <p class="card-count">{{ numberOfSchedules }}</p>
                </router-link>
              </div>
            </div>
          
          <div class="col-md-4">
            
              <div class="status-card">
                <router-link to="/my-appointments" class="no-underline">
                  <h5 class="card-label">Number of Appointments</h5>
                  <p class="card-count">{{ numberOfAppointments  }}</p>
                </router-link>
              </div>
            </div>
         
          <div class="col-md-4">
            
              <div class="status-card">
                <router-link to="/my-patients" class="no-underline">
                  <h5 class="card-label">Number of Patients</h5>
                  <p class="card-count">{{ numberOfPatients }}</p>
                </router-link>
              </div>
            </div>
      
        </div>
        <!-- Add more Doctor content here -->
      </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import DoctorSidebar from "../../layoutComponents/DoctorSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";
import { ref, onMounted } from 'vue';

export default {
  name: "DoctorDashboard",
  components: {
    DoctorSidebar,
    Navbar,
  },
  data() {
    return {
      numberOfSchedules: 0,
      numberOfAppointments: 0,
      numberOfPatiens: 0,
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
    const schedules = ref([]); // Store fetched schedules
    const appointments = ref([]); // Store fetched appointments
    const numberOfSchedules = ref(0); // Store number of schedules
    const numberOfAppointments = ref(0);
    const filteredAppointmentsByDoctor = ref([]);
    const numberOfPatients = ref(0);
    const error = ref(null); // Handle errors3.0
    

    const fetchSchedules = async () => {
      const doctorId = localStorage.getItem('doctor_id'); // Get doctor_id from localStorage
      try {
        const response = await axios.post(`/schedules/${doctorId}`);
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
  const doctorId = localStorage.getItem('doctor_id'); // Get doctor_id from localStorage
  try {
    const response = await axios.post(`/appointments`); // Fetch all appointments
    appointments.value = response.data; // Assign the fetched appointments
    
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
const fetchPatient = async () => {
  const doctorId = localStorage.getItem('doctor_id'); // Get doctor_id from localStorage
  try {
    const response = await axios.post(`/appointments`); // Fetch all appointments
    appointments.value = response.data; // Assign the fetched appointments
    
    // Filter appointments based on the doctor's ID
    filteredAppointmentsByDoctor.value = appointments.value.filter(appointment =>
      appointment.schedule.doctor_id === Number(doctorId) // Ensure comparison with number
    );

    // Assign the length of filtered appointments to numberOfAppointments
    numberOfPatients.value = filteredAppointmentsByDoctor.value.length;
  } catch (error) {
    console.error("Error fetching appointments:", error);
  }
};


    // Fetch schedules when the component is mounted
    onMounted(() => {
      fetchSchedules();
      fetchAppointments();
      fetchPatient();
    });

    return {
      schedules,
      numberOfSchedules,
      error,
      fetchAppointments,
      numberOfAppointments,
      numberOfPatients,
    fetchPatient
      };
  }
};
</script>

<style scoped>
@import "/public/assets/css/dashboard.css";
.card {
  margin-bottom: 20px;
}
h1 {
  padding: inherit;
  margin: revert;
  text-align: center;
}
body {
  background: tan;
}
.no-underline {
  text-decoration: none;
  color: rgb(0, 0, 0); /* Remove underline from links */
}

@media (max-width: 768px) {
  .card-title {
    font-size: 1rem; /* Smaller font size for smaller screens */
    white-space: normal; /* Allow wrapping */
    line-height: 1.5; /* Adjust line height for better spacing */
  }
}

.dashboard-header {
  background-image: url("/public/assets/images/doctor_dashboard.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  color: #000000;
  padding: 30px;
  border-radius: 8px;
  margin-bottom: 20px;
  background-position: bottom;
  height: 200px;
}

.dashboard-header h2 {
  margin-bottom: 10px;
  
}

.dashboard-header p {
  font-size: 17px;
  opacity: 1.8;
  margin-top: 30px;
  font-weight: 470;

}
.user-name {
    color: #df536b; /* Example: tomato red color */
    font-weight: bold;
    font-size: 28px;
    text-transform: uppercase;
  }
</style>
