<template>
  <div class="login-container">
    <div class="login-card">
      <h1>Welcome</h1>
      <p>Login with your details to continue</p>

      <form @submit.prevent="login">
        <!-- Email Field -->
        <div class="form-group">
          <label for="email">Email:</label>
          <input
            type="email"
            v-model="email"
            id="email"
            class="input-text"
            placeholder="Email Address"
          />
          <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
        </div>

        <!-- Password Field -->
        <div class="form-group">
          <label for="password">Password:</label>
          <input
            type="password"
            v-model="password"
            id="password"
            class="input-text"
          />
          <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
        </div>

        <!-- Login Button -->
        <button class="login-btn">Login</button>

        <!-- Sign Up Link -->
        <p class="signup-link">
          Don't have an account?
          <router-link to="/signup" class="hover-link">Sign Up</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: '',
      remember: false,
      errors: {},
    };
  },
  methods: {
  async login() {
    this.errors = {};

    try {
      // Step 1: Check if the user is a doctor and get doctor ID
      let doctorId = null;
      try {
        const doctorResponse = await axios.post('/get-doctor-id', { email: this.email });
        doctorId = doctorResponse.data.doctor_id;
        localStorage.setItem('doctor_id', doctorId); // Store doctor_id if found
      } catch (err) {
        // If the doctor isn't found, it's okay to proceed
        if (err.response.status !== 404) {
          throw err;
        }
      }

      // Step 2: Proceed with the login
      const response = await axios.post('/login', {
        email: this.email,
        password: this.password,
        remember: this.remember,
      });

      const user = response.data.user;

      // Store user data in localStorage for use across the application
      localStorage.setItem('user', JSON.stringify(user));

      // Step 3: Show success message
      Swal.fire({
        icon: 'success',
        title: 'Login Successful!',
        showConfirmButton: false,
        timer: 1000,
        toast: true,
        position: 'top-end',
      });

      // Step 4: Redirect based on user type
      const userType = user.user_type;
      if (userType === 'admin') {
        this.$router.push('/admin');
      } else if (userType === 'patient') {
        this.$router.push('/patient');
      } else if (userType === 'doctor') {
        this.$router.push('/doctor');
      }
    } catch (error) {
      if (error.response && error.response.data.errors) {
        // Handle validation errors
        this.errors = error.response.data.errors;
      } else {
        alert('Login failed. Please try again.');
      }
    }
  },
},

  mounted() {
    // Clear any existing user data on load
    localStorage.removeItem('user');
    localStorage.removeItem('doctor_id')
  },
};
</script>

<style scoped>
@import "/public/assets/css/auth.css";
</style>
