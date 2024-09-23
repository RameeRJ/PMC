<template>
  <div class="login-container">
    <div class="login-card">
      <h1>Let's Get Start</h1>
      <p>Enter Your Personal Details Here</p>

     <!--name field-->
      <div class="form-group">
        <label for="name">Name:</label>
        <input
          type="name"
          v-model="name"
          id="name"
          class="input-text"
          placeholder="Full Name"
          required
        />
      </div>
      
      <!--place-->
      

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

      <div class="form-group">
        <label for="password">Confirm Password:</label>
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