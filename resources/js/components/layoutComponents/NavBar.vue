<template>
  <div>
    <!-- Navigation -->
    <nav class="navbar navbar-light" style="background-color: #c863733d;">
      <div class="container-fluid">
        <!-- Navbar content -->
        <span class="navbar-brand">PMC.| PATHAMBAD MEDICAL CENTER</span>

        <!-- Logout Button -->
        <button @click="logout" class="btn btn-danger logout-btn">Logout</button>
      </div>
    </nav>

    <!-- Rest of the dashboard content -->
    <div class="dashboard-content">
      <!-- Your dashboard content here -->
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
  methods: {
    async logout() {
  try {
    const result = await Swal.fire({
      title: 'Are you sure?',
      text: 'You will be logged out!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, log me out!',
      cancelButtonText: 'Cancel',
      padding: '1em',
    });

    // Check if the user confirmed the logout action
    if (result.isConfirmed) {
      // Proceed with logout
      await axios.post('/logout');

      // Clear all relevant local storage data
      localStorage.removeItem('isAuthenticated');
      localStorage.removeItem('userType');
      localStorage.removeItem('user');
      localStorage.removeItem('doctor_id');
      localStorage.removeItem('authToken'); // If you have a token stored
      localStorage.removeItem('patient_name');
      localStorage.removeItem('profileImage');

      // Redirect the user to the login page
      this.$router.push({ name: 'index' });

      // Show success message
      Swal.fire({
        icon: 'success',
        title: 'Logged out successfully',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        padding: '1em',
      });
    }
  } catch (error) {
    // Handle any potential errors during the logout process
    Swal.fire({
      icon: 'error',
      title: 'Logout Failed',
      text: 'There was an error logging you out. Please try again.',
      padding: '1em',
    });
  }
}
}}
</script>

<style scoped>
.logout-btn {
  padding: 8px 16px;
  background-color: #c86373;
  color: whitesmoke;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  letter-spacing: 0.5px;
  transition: all 0.3s;
  font-size: 16px;
  

}

.logout-btn:hover {
  background-color: #e35c73;
  color:white
}
.navbar{
  padding: 0%;

}
.navbar-brand{
  font-size: 16px;
  padding-top: 19px;
  font-weight: 500;
  color: #c86373;
  height: 62px;
}
</style>
