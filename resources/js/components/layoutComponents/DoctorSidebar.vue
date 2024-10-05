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
                    <img :src="defaultProfileImage" alt="user" width="100%">
                  </td>
                  <td style="padding:0px;margin:0px;">
                    <p class="profile-title">{{ user ? user.name : 'Guest' }}</p>
                  <p class="profile-subtitle">{{ user ? user.email : 'Not logged in' }}</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr class="menu-row">
          <td class="menu-btn menu-icon-dashbord" :class="{ 'menu-active': isActive('/doctor') }">
            <router-link to="/doctor" class="non-style-link-menu">
              <div class="menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <p class="menu-text">Dashboard</p>
              </div>
            </router-link>
          </td>
        </tr>
          <tr class="menu-spacer"><td></td></tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-schedule" :class="{ 'menu-active': isActive('/my-schedules') }">
              <router-link to="/my-schedules" class="non-style-link-menu">
                <div class="menu-item">
                  <i class="fas fa-user-md"></i>
                  <p class="menu-text">My Schedules</p>
                </div>
              </router-link>
            </td>
          </tr>

          <tr class="menu-spacer"><td></td></tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-appointment" :class="{ 'menu-active': isActive('/my-appointments') }">
              <router-link to="/my-appointments" class="non-style-link-menu">
                <div class="menu-item">
                  <i class="fas fa-user-md"></i>
                  <p class="menu-text">My Appointments</p>
                </div>
              </router-link>
            </td>
          </tr>


          <tr class="menu-spacer"><td></td></tr>
          <tr class="menu-row">
            <td class="menu-btn menu-icon-patient" :class="{ 'menu-active': isActive('/my-patients') }">
              <router-link to="/my-patients" class="non-style-link-menu">
                <div class="menu-item">
                  <i class="fas fa-calendar-alt"></i>
                  <p class="menu-text">My Patients</p>
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
    name: 'DoctorSidebar',
    data() {
      return {
        defaultProfileImage: '/storage/assets/images/default.jpg',
        isSidebarOpen: true,
        user: null, // Initial state of the sidebar
      };
    },
    mounted() {
    // Retrieve the user from localStorage if logged in
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
    }
  },

    methods: {
      toggleSidebar() {
        this.isSidebarOpen = !this.isSidebarOpen; // Toggle the sidebar state
      },
      isActive(route) {
      return this.$route.path.startsWith(route);
    },
    },
  }
  </script>
  
  <style scoped>
  @import "/public/assets/css/admin.css";
  
  img{
    width: 48px;
    height: 48px;
    border-radius: 50%;
    margin-left:-10px;
    margin-top:-26px;
    border:thick;
    border-color: turquoise;

  }
  
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
  .menu-btn {
    cursor:auto;
   }
  
  /* Responsive Styles */
  @media (max-width: 768px) {
    .menu {
      width: 170px; /* Set width for the menu */
    }
  
    .menu-closed {
      transform: translateX(-100%); /* Hide the sidebar when closed */
    }
  

  
    .menu-spacer {
      display: none; /* Hide spacer on smaller screens */
    }
    .menu-active {
    width: 172px;
  }
  .profile-subtitle {
    font-size: 11px;
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