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
        <div class="row">
          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-body">
                <router-link to="/my-schedules" class="no-underline">
                  <h5 class="card-title">Number of Schedules</h5>
                  <p class="card-text">{{ numberOfSchedules }}</p>
                </router-link>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-body">
                <router-link to="/my-appointments" class="no-underline">
                  <h5 class="card-title">Number of Appointments</h5>
                  <p class="card-text">{{ numberOfAppointments }}</p>
                </router-link>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-body">
                <router-link to="/my-patients" class="no-underline">
                  <h5 class="card-title">Number of Patients</h5>
                  <p class="card-text">{{ numberOfDepartments }}</p>
                </router-link>
              </div>
            </div>
          </div>
        </div>
        <!-- Add more Doctor content here -->
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
      numberOfDepartments: 0,
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
    const numberOfSchedules = ref(0); // Store number of schedules
    const numberOfAppointments = ref(0);
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

    // Fetch schedules when the component is mounted
    onMounted(() => {
      fetchSchedules();
    });

    return {
      schedules,
      numberOfSchedules,
      error,
    };
  }
};
</script>

<style scoped>
/* Add any additional styles for DoctorHome if necessary */
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
