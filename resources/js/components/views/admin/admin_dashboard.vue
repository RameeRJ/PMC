<template>
  <Navbar />
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Column (left) -->
      <div class="col-md-3 col-lg-2 bg-light vh-100 p-0">
        <AdminSidebar />
      </div>
      
      <!-- Admin Content (right) -->
      <div class="col-md-9 col-lg-10 p-4">
        <h1>Admin Dashboard</h1>
        <div class="row">
          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title">Number of Doctors</h5>
                <p class="card-text">{{ doctors.length }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title">Number of Patients</h5>
                <p class="card-text">{{ numberOfPatients }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-center">
              <div class="card-body">
                <h5 class="card-title">Number of Appointments</h5>
                <p class="card-text">{{ numberOfAppointments }}</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Add more admin content here -->
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
import Navbar from "../../layoutComponents/Navbar.vue";

export default {
  name: 'AdminHome',
  components: {
    AdminSidebar,
    Navbar
  },
  data() {
    return {
      doctors: [], // Array to hold the list of doctors
      numberOfPatients: 0, // Number of patients (initialize as needed)
      numberOfAppointments: 0, // Number of appointments (initialize as needed)
    };
  },
  mounted() {
    this.fetchStats(); // Fetch statistics when component is mounted
  },
  methods: {
    fetchStats() {
      // Fetch the list of doctors from your API
      axios.get('/doctor') // Replace with your actual endpoint
        .then(response => {
          this.doctors = response.data; // Assume response contains an array of doctors
        })
        .catch(error => {
          console.error('Error fetching doctors:', error);
        });

      
    },
  },
};
</script>

<style scoped>
/* Add any additional styles for AdminHome if necessary */
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

@media (max-width: 768px) {
  .card-title {
    font-size: 1rem; /* Smaller font size for smaller screens */
    white-space: normal; /* Allow wrapping */
    line-height: 1.5; /* Adjust line height for better spacing */
  }
}
</style>
