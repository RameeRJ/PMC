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
        <div class="dashboard-header">
          <h2>Welcome <span class="user-name">{{ user.name }}</span></h2>
        </div>
        <div class="status-section mb-4">
          <h3 class="center">Status Overview</h3>
          <div class="row">
          <div class="col-md-4">
            <div class="status-card">
              
                <router-link to="/view-doctor" class="no-underline">
                <h5 class="card-label">Number of Doctors</h5>
                <p class="card-count">{{ numberOfDoctors }}</p>
              </router-link>
            
            </div>
          </div>
          <div class="col-md-4">
            <div class="status-card">
             
                <router-link to="/view-patients" class="no-underline">
                <h5 class="card-label">Number of Patients</h5>
                <p class="card-count">{{ numberOfPatients }}</p>
                </router-link>
              
            </div>
          </div>
          <div class="col-md-4">
            <div class="status-card">
             
                <router-link to="/view-department" class="no-underline">
                <h5 class="card-label">Number of Departments</h5>
                <p class="card-count">{{ numberOfDepartments }}</p>
                </router-link>
             
            </div>
          </div>
        </div>
        <!-- Add more admin content here -->
      </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import AdminSidebar from "../../layoutComponents/AdminSidebar.vue";
import Navbar from "../../layoutComponents/NavBar.vue";

export default {
  name: 'AdminHome',
  components: {
    AdminSidebar,
    Navbar
  },
  data() {
    return {
      numberOfDoctors: 0, // Array to hold the list of doctors
      numberOfPatients: 0, // Number of patients (initialize as needed)
      numberOfDepartments: 0, // Number of appointments (initialize as needed)
      user: {}
    };
  },
  mounted() {
    this.fetchStats();
    this.fetchdepartment(); // Fetch statistics when component is mounted
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
      }
  },
  methods: {
    fetchStats() {
      // Fetch the list of doctors from your API
      axios.post('/doctors') // Replace with your actual endpoint
        .then(response => {
          this.numberOfDoctors = response.data.length; // Assume response contains an array of doctors
        })
        .catch(error => {
          console.error('Error fetching doctors:', error);
        });   
    },

    fetchdepartment() {
      axios.post('/departments')
      .then(response => {
        this.numberOfDepartments = response.data.length;
      })
      .catch(error => {
        console.error('Error fetching departments:', error);
      });
    }
  },
};
</script>

<style scoped>
/* Add any additional styles for AdminHome if necessary */
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
  background-image: url("/public/assets/images/admin_dashboard.jpg");
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
  display: grid;
    align-content: stretch;
    justify-content: space-evenly;
    align-items: stretch;
    justify-items: center
  
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
