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
        /* webpackChunkName: "login" */ './components/Auth/Login.vue'
      ),
  },
  {
    path: '/SignUp',
    name: 'signup',
    component: () =>
      import(
        /* webpackChunkName: "signup" */ './components/Auth/SignUp.vue'
      ),
  },
  {
    path: '/home',
    name: 'home',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/index.vue'
      ),
  }
];

// Create the router instance
const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
