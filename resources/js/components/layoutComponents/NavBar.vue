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
export default {
  methods: {
    logout() {
      // Trigger the logout process by calling API or clearing local storage
      axios.post('/logout').then(response => {
        // Clear local storage or authentication token
        localStorage.removeItem('authtoken');
        // Redirect to login page
        this.$router.push('/login');
      }).catch(error => {
        console.error('Logout error:', error);
      });
    }
  }
};
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
