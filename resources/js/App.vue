<template>
    <div id="app">
     <NavBar />
     <Router-View />
    </div>
    <!-- <HomeMsg /> -->
    
    <!-- <SignUp /> -->
  </template>
  
  <script>
  
  import NavBar from './components/layoutComponents/NavBar.vue'
  // import HomeMsg from './components/Home.vue'
  // import LoginPage from './components/Login.vue'
  // import SignUp from './components/SignUp.vue'
  
  
  export default {
    name: 'App',
    components: {
      // NavBar,
      // HomeMsg,
      // LoginPage,
      // SignUp,
    },
  
   
  };
  </script>
  
  <style>
  /* Color of the links BEFORE scroll */
  .navbar-scroll .nav-link,
  .navbar-scroll .navbar-toggler-icon,
  .navbar-scroll .navbar-brand {
    color: #262626;
  }
  
  /* Color of the navbar BEFORE scroll */
  .navbar-scroll {
    background-color: #FFC017;
  }
  
  /* Color of the links AFTER scroll */
  .navbar-scrolled .nav-link,
  .navbar-scrolled .navbar-toggler-icon,
  .navbar-scroll .navbar-brand {
    color: #262626;
  }
  
  /* Color of the navbar AFTER scroll */
  .navbar-scrolled {
    background-color: #fff;
  }
  
  /* An optional height of the navbar AFTER scroll */
  .navbar.navbar-scroll.navbar-scrolled {
    padding-top: auto;
    padding-bottom: auto;
  }
  .navbar-brand {
    font-size: unset;
    height: 4.5rem;
  }
  
  </style>
  