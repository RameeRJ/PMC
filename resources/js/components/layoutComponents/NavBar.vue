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
        await axios.post('/logout');
        
        // Clear local storage or session data if required
        localStorage.removeItem('authToken');

        // Redirect the user to the login page
        this.$router.push({ name: 'index' });

        // Optionally, show a success message (if using a toast system)
        Swal.fire({
      icon: 'success',
      title: 'Logged out successfully',
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000,
      padding: '1em',
    });
  } catch (error) {
    console.error('Error logging out:', error);
    Swal.fire({
      icon: 'error',
      title: 'Error logging out',
      text: 'Please try again later.',
    });
  }
}}}
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
