<template>
    <div class="container">
      <!-- Bootstrap Toggle Button -->
      <button
        class="navbar-toggler"
        type="button"
        @click="toggleSidebar"
        aria-controls="navbarResponsive"
       :aria-expanded="isSidebarOpen"
        aria-label="Toggle navigation"
        v-if="!isSidebarOpen" 
      >
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="menu" :class="{ 'menu-closed': !isSidebarOpen }">
        <table class="menu-container" border="0">
          <tr>
            <td style="padding:10px" colspan="2">
              <table border="0" class="profile-container">
                <tr>
                  <td width="30%" style="padding-left:20px">
                    <!-- <img src="@/assets/images/logo.svg"" alt="user" width="100%" style="border-radius:50%"> -->
                  </td>
                  <td style="padding:0px;margin:0px;">
                    <p class="profile-title">Administrator</p>
                    <p class="profile-subtitle">admin@edoc.com</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active">
              <router-link to="/admin" class="non-style-link-menu non-style-link-menu-active">
                <div class="menu-item">
                  <i class="fas fa-tachometer-alt"></i>
                  <p class="menu-text">Dashboard</p>
                </div>
              </router-link>
            </td>
          </tr>
          <tr class="menu-spacer"><td></td></tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor">
              <router-link to="/doctor-view" class="non-style-link-menu">
                <div class="menu-item">
                  <i class="fas fa-user-md"></i>
                  <p class="menu-text">Doctors</p>
                </div>
              </router-link>
            </td>
          </tr>
          <tr class="menu-spacer"><td></td></tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-schedule">
              <router-link to="/schedule" class="non-style-link-menu">
                <div class="menu-item">
                  <i class="fas fa-calendar-alt"></i>
                  <p class="menu-text">Schedule</p>
                </div>
              </router-link>
            </td>
          </tr>
          <tr class="menu-spacer"><td></td></tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-appointment">
              <router-link to="/appointment" class="non-style-link-menu">
                <div class="menu-item">
                  <i class="fas fa-calendar-check"></i>
                  <p class="menu-text">Appointment</p>
                </div>
              </router-link>
            </td>
          </tr>
          <tr class="menu-spacer"><td></td></tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-patient">
              <router-link to="/patients" class="non-style-link-menu">
                <div class="menu-item">
                  <i class="fas fa-procedures"></i>
                  <p class="menu-text">Patients</p>
                </div>
              </router-link>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AdminSidebar',
    data() {
      return {
        isSidebarOpen: true, // Initial state of the sidebar
      };
    },
    methods: {
      toggleSidebar() {
        this.isSidebarOpen = !this.isSidebarOpen; // Toggle the sidebar state
      },
    },
  }
  </script>
  
  <style scoped>
  @import "/public/assets/css/admin.css";
  
  
  .menu {
  width: 250px; /* Default sidebar width */
  transition: width 0.3s, transform 0.3s;
  box-shadow: 6px 0 10px rgba(50, 0, 0, 0.2); /* Add shadow effect */
  z-index: 1000; /* Ensure the sidebar is above other content */
  margin-top: 8px;
  
}
  
  .menu-closed {
    transform: translateX(-100%); /* Hide the sidebar */
  }
  
  .menu-container {
    width: 100%;
  }
  
  .menu-item {
    display: flex;
    align-items: center; /* Align items vertically centered */
    height: 45px;
  }
  
  .menu-item i {
    margin-right: 8px; /* Space between icon and text */
    font-size: 1.2em; /* Adjust icon size */
  }
  
  .menu-text {
    margin: 0; /* Remove default margin from paragraph */
  }
  
  /* Responsive Styles */
  @media (max-width: 768px) {
    .menu {
      width: 250px; /* Set width for the menu */
    }
  
    .menu-closed {
      transform: translateX(-100%); /* Hide the sidebar when closed */
    }
  
    .menu-text {
      display: inline; /* Show text on smaller screens */
    }
  
    .menu-spacer {
      display: none; /* Hide spacer on smaller screens */
    }
  }
  
  /* Button Style */
  .navbar-toggler {
    display: block; /* Show button */
    margin: 10px; /* Adjust margin as needed */
    background-color: #007bff; /* Button color */
    border: none;
    padding: 10px;
    color: white; /* Icon color */
  }
  </style>