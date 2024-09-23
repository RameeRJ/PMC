<template>
  <div class="login-container">
    <div class="login-card">
      <h1>Welcome Back!</h1>
      <p>Login with your details to continue</p>

      <!-- Email Field -->
      <div class="form-group">
        <label for="email">Email:</label>
        <input
          type="email"
          v-model="email"
          id="email"
          class="input-text"
          placeholder="Email Address"
          required
        />
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
          required
        />
      </div>

      <!-- Error Message -->
      <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>

      <!-- Login Button -->
      <button @click="submitForm" class="login-btn">Login</button>

      <!-- Sign Up Link -->
      <p class="signup-link">
        Don't have an account?
        <router-link to="/signup" class="hover-link">Sign Up</router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
      errorMessage: ''
    };
  },
  methods: {
    async submitForm() {
      // Simulate a login API call
      if (this.email === '' || this.password === '') {
        this.errorMessage = 'Email and Password are required.';
        return;
      }

      try {
        // Assuming you have an API call like this
        const response = await fetch('/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        });

        if (!response.ok) {
          throw new Error('Login failed');
        }

        const data = await response.json();
        // Handle successful login, e.g., saving token, redirecting
        this.$router.push('/dashboard');g
      } catch (error) {
        this.errorMessage = 'Invalid email or password.';
      }
    },
  },
};
</script>

<style scoped>
@import "/public/assets/css/auth.css";
</style>
