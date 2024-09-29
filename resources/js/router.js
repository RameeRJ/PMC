import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    name: 'index',
    component: () =>
      import(
        /* webpackChunkName: "login" */ './components/views/index.vue'
      ),
      
  },
  {
    path: '/login',
    name: 'login-page',
    component: () =>
      import(
        /* webpackChunkName: "login" */ './components/views/auth/Login.vue'
      ),
  },
  {
    path: '/SignUp',
    name: 'signup',
    component: () =>
      import(
        /* webpackChunkName: "signup" */ './components/views/auth/SignUp.vue'
      ),
  },
  {
    path: '/admin',
    name: 'admin',
    component: () =>
      import(
        /* webpackChunkName: "signup" */ './components/views/admin/admin_dashboard.vue'
      ),
  },
  {
    path: '/doctor',
    name: 'doctor',
    component: () =>
      import(
        /* webpackChunkName: "signup" */ './components/views/doctor/doctor_dashboard.vue'
      ),
  },
  {
    path: '/patient',
    name: 'patient',
    component: () =>
      import(
        /* webpackChunkName: "signup" */ './components/views/patient/patient_dashboard.vue'
      ),
  },

  {
    path: '/home',
    name: 'home',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/index.vue'
      ),
  },
  {
    path: '/about',
    name: 'about',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/about.vue'
      ),
  },
  {
    path: '/contact',
    name: 'contact',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/contact.vue'
      ),
  },
  {
    path: '/view-doctor',
    name: 'view-doctor',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/admin/view-doctor.vue'
      ),
  },
];

// Create the router instance
const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
