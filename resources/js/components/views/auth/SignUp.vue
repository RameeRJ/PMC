<template>
  <div class="login-container">
    <div class="login-card">
      <h1>Let's Get Start</h1>
      <p>Enter your personal details here</p>

      <form @submit.prevent="handleSubmit">
        <!-- Name Field -->
        <div class="form-group">
          <label for="name">Name:</label>
          <input
            type="text"
            v-model="name"
            id="name"
            class="input-text"
            placeholder="Full Name"
      
          />
          <span class="text-danger" v-if="errors.name">{{ errors.name[0] }}</span>
        </div>

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

        <div class="form-group">
          <label for="phone">Phone:</label>
          <input
            type="phone"
            v-model="phone"
            id="phone"
            class="input-text"
            placeholder="Phone Number"
           
          />
          <span class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</span>
        </div>

        <!-- Password Field -->
        <div class="form-group">
          <label for="password">Password:</label>
          <input
            type="password"
            v-model="password"
            id="password"
            class="input-text"
            placeholder="Password"
      
          />
          <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group">
          <label for="confirmpassword">Confirm Password:</label>
          <input
            type="password"
            v-model="confirmpassword"
            id="confirmpassword"
            class="input-text"
            placeholder="Confirm Password"
          
          />
          <span class="text-danger" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</span>
        </div>

        <!-- Register Button -->
        <button class="login-btn">Register</button>

        <!-- Sign Up Link -->
        <p class="signup-link">
          Already have an account?
          <router-link to="/login" class="hover-link">Sign In</router-link>
        </p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      name: '',
      email: '',
      phone: '',
      password: '',
      confirmpassword: '',
      errors: {}, // Store validation errors
    };
  },
  methods: {
    async handleSubmit() {
      this.clearErrors(); // Clear previous errors


      const data = {
        name: this.name,
        email: this.email,
        phone: this.phone,
        password: this.password,
        password_confirmation: this.confirmpassword,
      };

      try {
        const response = await axios.post('/register', data);

        // Display a SweetAlert pop-up on success
        Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Registered successfully',
      showConfirmButton: false,
      timer: 2000,
      padding: '2em'
    });

    // Optionally redirect after a short delay
    setTimeout(() => {
      this.$router.push('/login');
    }, 2000);
  }  catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
          this.errors = error.response.data.errors; // Server-side validation errors
        } else {
          alert('Registration failed: ' + error.message);
        }
      }
    },
    clearErrors() {
      this.errors = {}; // Clear all errors before new submission
    },
  },
};
</script>

<style scoped>
@import "/public/assets/css/auth.css";
</style>
