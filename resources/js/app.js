import { createApp } from 'vue';
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.min.css'; // Import Bootstrap CSS

// Import the router from the router.js file
import router from './router';
// Create the Vue app instance and register the router
createApp(App)
  .use(router).mount('#app'); 