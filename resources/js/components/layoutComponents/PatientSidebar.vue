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
            <div class="profile-container">
              <!-- Profile Image -->
              <div class="profile-image">
                <img :src="profileImage" alt="user" width="100px" height="100px">
              </div>
              <!-- Name and Email -->
              <div class="profile-info">
                <p class="profile-title">{{ user ? user.name : 'Guest' }}</p>
                <p class="profile-subtitle">{{ user ? user.email : 'Not logged in' }}</p>
              </div>
            </div>
          </td>
        </tr>
              <tr class="menu-spacer"><td></td></tr>
              <tr class="menu-row">
                  <td class="menu-btn menu-icon-doctor" :class="{ 'menu-active': isActive('/all-doctors') }">
                      <router-link to="/all-doctors" class="non-style-link-menu">
                          <div class="menu-item">
                              <i class="fas fa-user-md"></i>
                              <p class="menu-text">All Doctors</p>
                          </div>
                      </router-link>
                  </td>
              </tr>

              <tr class="menu-spacer"><td></td></tr>
              <tr class="menu-row">
                  <td class="menu-btn menu-icon-schedule" :class="{ 'menu-active': isActive('/ongoing-schedules') }">
                      <router-link to="/ongoing-schedules" class="non-style-link-menu">
                          <div class="menu-item">
                              <i class="fas fa-user-md"></i>
                              <p class="menu-text">Ongoing Schedules</p>
                          </div>
                      </router-link>
                  </td>
              </tr>

              <tr class="menu-spacer"><td></td></tr>
              <tr class="menu-row">
                  <td class="menu-btn menu-icon-appointment" :class="{ 'menu-active': isActive('/my-booking') }">
                      <router-link to="/my-booking" class="non-style-link-menu">
                          <div class="menu-item">
                              <i class="fas fa-calendar-alt"></i>
                              <p class="menu-text">My Booking</p>
                          </div>
                      </router-link>
                  </td>
              </tr>

              <tr class="menu-spacer"><td></td></tr>
              <tr class="menu-row">
                  <td class="menu-btn menu-icon-settings" :class="{ 'menu-active': isActive('/settings') }">
                      <router-link to="/settings" class="non-style-link-menu">
                          <div class="menu-item">
                              <i class="fas fa-cog"></i>
                              <p class="menu-text">Settings</p>
                          </div>
                      </router-link>
                  </td>
              </tr>
          </table>
      </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PatientSidebar',
  data() {
    return {
      defaultProfileImage: '/storage/assets/images/default.jpg', // Default profile image path
      isSidebarOpen: true,
      user: null, // Initial state of the sidebar
      profileImage: '', // Holds the profile image URL
    };
  },
  mounted() {
    this.fetchUserProfile(); // Fetch the user profile when the component is mounted
  },
  methods: {
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen; // Toggle the sidebar state
    },
    isActive(route) {
      return this.$route.path.startsWith(route);
    },
    async fetchUserProfile() {
      try {
        const response = await axios.post('/patient/user-details'); // API call to fetch user profile
        this.user = response.data; // Assign the user data to `user`
        // Set the profile image or use the default
        this.profileImage = this.user.profile_picture
          ? `/storage/${this.user.profile_picture}`
          : this.defaultProfileImage;
      } catch (error) {
        console.error('Error fetching user details:', error);
        this.profileImage = this.defaultProfileImage; // Fallback to default profile image
      }
    },
  },
};
</script>

<style scoped>
@import "/public/assets/css/admin.css";

img {
  width: 48px;
  height: 48px;
  border-radius: 21%;
  margin-left: -10px;
  margin-top: -26px;
  border: thick;
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
  cursor: auto;
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
