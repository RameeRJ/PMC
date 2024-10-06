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
          <h3>Status Overview</h3>
          <div class="row">
            <div class="col-md-3">
              <div class="status-card">
                <img src="https://via.placeholder.com/100" alt="Doctor Icon" />
                <p class="card-count">5</p>
                <span class="card-label">Doctors Available</span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="status-card">
                <img src="https://via.placeholder.com/100" alt="Patient Icon" />
                <p class="card-count">20</p>
                <span class="card-label">Patients Registered</span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="status-card">
                <img src="https://via.placeholder.com/100" alt="Booking Icon" />
                <p class="card-count">3</p>
                <span class="card-label">New Bookings</span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="status-card">
                <img src="https://via.placeholder.com/100" alt="Session Icon" />
                <p class="card-count">2</p>
                <span class="card-label">Today’s Sessions</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Upcoming Bookings Section -->
        <div class="upcoming-bookings-section">
          <h3>Your Upcoming Bookings</h3>
          <table class="table booking-table">
            <thead>
              <tr>
                <th>#</th>
                <th>Session Title</th>
                <th>Doctor</th>
                <th>Scheduled Date & Time</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>General Check-up</td>
                <td>Dr. John Doe</td>
                <td>2024-10-15 10:00 AM</td>
              </tr>
              <tr>
                <td>2</td>
                <td>Cardiology Consultation</td>
                <td>Dr. Sarah Lee</td>
                <td>2024-10-20 12:00 PM</td>
              </tr>
              <!-- Add more bookings as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from '../../layoutComponents/NavBar.vue';
import PatientSidebar from '../../layoutComponents/PatientSidebar.vue';

export default {
  name: "PatientDashboard",
  components: {
    PatientSidebar,
    NavBar,
  },
  data() {
    return {
      user: {}
  };
},
  mounted() {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
      }

  },  
}
</script>

<style scoped>
/* Main container layout */
.container-fluid {
  padding: 0;
}

.row {
  margin: 0;
}

/* Dashboard header */
.dashboard-header {
  background-image: url("/public/assets/images/patient_dashboard.jpg");
  background-repeat: no-repeat;
  background-size:  cover;
  color: #000000;
  padding: 30px;
  border-radius: 8px;
  margin-bottom: 20px;
  background-position: center;
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

/* Search Section */
.search-section {
  display: flex;
  justify-content: space-between;
}

.search-box {
  display: flex;
}

.search-box input {
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
}

.search-btn {
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
}

/* Status Cards */
.status-section h3 {
  margin-bottom: 20px;
}

.status-card {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.status-card img {
  width: 50px;
  height: 50px;
  margin-bottom: 10px;
}

.status-card .card-count {
  font-size: 24px;
  font-weight: bold;
}

.status-card .card-label {
  font-size: 14px;
  color: #666;
}

/* Upcoming Bookings Section */
.upcoming-bookings-section h3 {
  margin-bottom: 20px;
}

.booking-table {
  width: 100%;
  border-collapse: collapse;
}

.booking-table th,
.booking-table td {
  padding: 15px;
  border: 1px solid #ddd;
  text-align: left;
}

.booking-table th {
  background-color: #007bff;
  color: white;
}

.booking-table tr:nth-child(even) {
  background-color: #f2f2f2;
}
.user-name {
    color: #df536b; /* Example: tomato red color */
    font-weight: bold;
    font-size: 28px;
    text-transform: uppercase;
  }

</style>
