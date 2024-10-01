<template>
    <div class="dashboard-container">
      <div class="sidebar">
        <!-- Patient Sidebar -->
        <div class="profile-section">
          <p class="patient-name">Test Patient..</p>
          <p class="patient-email">patient@edoc.com</p>
          <button class="logout-btn">Log out</button>
        </div>
  
        <nav>
          <router-link to="/home" class="nav-item">Home</router-link>
          <router-link to="/all-doctors" class="nav-item">All Doctors</router-link>
          <router-link to="/scheduled-sessions" class="nav-item">Scheduled Sessions</router-link>
          <router-link to="/my-bookings" class="nav-item">My Bookings</router-link>
          <router-link to="/settings" class="nav-item">Settings</router-link>
        </nav>
      </div>
  
      <div class="content">
        <!-- Dashboard Content -->
        <div class="header">
          <h2>Welcome!</h2>
          <h3>Test Patient.</h3>
          <p>
            Haven't any idea about doctors? No problem, let's jump to "All Doctors" section or "Sessions"
            Track your past and future appointments history. Also find out the expected arrival time of your doctor or medical consultant.
          </p>
  
          <div class="search-section">
            <input type="text" placeholder="Test Doctor" />
            <button class="search-btn">Search</button>
          </div>
        </div>
  
        <div class="status">
          <h3>Status</h3>
          <div class="status-cards">
            <div class="card">
              <p>1</p>
              <span>All Doctors</span>
            </div>
            <div class="card">
              <p>3</p>
              <span>All Patients</span>
            </div>
            <div class="card">
              <p>0</p>
              <span>New Bookings</span>
            </div>
            <div class="card">
              <p>0</p>
              <span>Today Sessions</span>
            </div>
          </div>
        </div>
  
        <div class="upcoming-bookings">
          <h3>Your Upcoming Booking</h3>
          <table class="booking-table">
            <thead>
              <tr>
                <th>Appoint. Number</th>
                <th>Session Title</th>
                <th>Doctor</th>
                <th>Scheduled Date & Time</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Test Session</td>
                <td>Test Doctor</td>
                <td>2050-01-01 18:00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "PatientDashboard",
  };
  </script>
  
  <style scoped>
  .dashboard-container {
    display: flex;
  }
  
  .sidebar {
    width: 20%;
    background-color: #f8f9fa;
    padding: 20px;
  }
  
  .profile-section {
    text-align: center;
  }
  
  .avatar {
    border-radius: 50%;
    width: 80px;
    height: 80px;
  }
  
  .patient-name {
    font-weight: bold;
  }
  
  .logout-btn {
    background-color: #e74c3c;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
  }
  
  .nav-item {
    display: block;
    margin: 20px 0;
    text-decoration: none;
    color: #333;
  }
  
  .content {
    width: 80%;
    padding: 20px;
  }
  
  .header {
    background-color: #eaf4fc;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
  }
  
  .search-section {
    display: flex;
    margin-top: 20px;
  }
  
  .search-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-left: 10px;
  }
  
  .status {
    margin-top: 20px;
  }
  
  .status-cards {
    display: flex;
    justify-content: space-around;
  }
  
  .card {
    background-color: #f5f5f5;
    padding: 20px;
    text-align: center;
    width: 20%;
    border-radius: 8px;
  }
  
  .upcoming-bookings {
    margin-top: 20px;
  }
  
  .booking-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .booking-table th,
  .booking-table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
  }
  </style>
  