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
                  <p class="card-text">{{ numberOfDoctors }}</p>
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
        numberOfDoctors: 0, // Replace with actual data from your API
        numberOfPatients: 0, // Replace with actual data from your API
        numberOfAppointments: 0, // Replace with actual data from your API
      };
    },
    mounted() {
      this.fetchStats(); // Fetch statistics when component is mounted
    },
    methods: {
      fetchStats() {
        // Fetch the data from your API
        // Example:
        // axios.get('/api/stats').then(response => {
        //   this.numberOfDoctors = response.data.doctors;
        //   this.numberOfPatients = response.data.patients;
        //   this.numberOfAppointments = response.data.appointments;
        // });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any additional styles for AdminHome if necessary */
  .card {
    margin-bottom: 20px;
  }
  h1{
    padding: inherit;
    margin: revert;
    text-align: center;
  }
  body{
    background:tan;
  }
  </style>