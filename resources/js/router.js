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
      meta: { requiresAuth: true, userType: 'admin'},
  },
  {
    path: '/doctor',
    name: 'doctor',
    component: () =>
      import(
        /* webpackChunkName: "signup" */ './components/views/doctor/doctor_dashboard.vue'
      ),
      meta: { requiresAuth: true, userType: 'doctor'},
  },
  {
    path: '/patient',
    name: 'patient',
    component: () =>
      import(
        /* webpackChunkName: "signup" */ './components/views/patient/patient_dashboard.vue'
      ),
      meta: { requiresAuth: true, userType: 'patient'},
      
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
      meta: { requiresAuth: true, userType: 'admin'},
  },
  {
    path: '/view-schedule',
    name: 'view-schedule',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/admin/view-schedule.vue'
      ),
      meta: { requiresAuth: true, userType: 'admin'},
  },
  {
    path: '/view-appointment',
    name: 'view-appointment',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/admin/view-appointment.vue'
      ),
      meta: { requiresAuth: true, userType: 'admin'},
  },
  {
    path: '/view-patients',
    name: 'view-patients',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/admin/view-patients.vue'
      ),
      meta: { requiresAuth: true, userType: 'admin'},
  },
  {
    path: '/view-department',
    name: 'view-department',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/admin/view-department.vue'
      ),
      meta: { requiresAuth: true, userType: 'admin'},
  },
  {
    path: '/my-schedules',
    name: 'my-schedules',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/doctor/my-schedules.vue'
      ),
      meta: { requiresAuth: true, userType: 'doctor'},
  },
  {
    path: '/my-appointments',
    name: 'my-appointments',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/doctor/my-appointments.vue'
      ),
      meta: { requiresAuth: true, userType: 'doctor'},
  },
  {
    path: '/my-patients',
    name: 'my-patients',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/doctor/my-patients.vue'
      ),
      meta: { requiresAuth: true, userType: 'doctor'},
  },
  {
    path: '/analytics',
    name: 'analytics',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/doctor/doctor-analytics.vue'
      ),
      meta: { requiresAuth: true, userType: 'doctor'},
  },
  {
    path: '/all-doctors',
    name: 'all-doctors',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/patient/all-doctors.vue'
      ),
      meta: { requiresAuth: true, userType: 'patient'},
  },
  {
    path: '/ongoing-schedules',
    name: 'ongoing-schedules',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/patient/ongoing-schedules.vue'
      ),
      meta: { requiresAuth: true, userType: 'patient'},
  },
  {
    path: '/my-booking',
    name: 'my-booking',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/patient/my-booking.vue'
      ),
      meta: { requiresAuth: true, userType: 'patient'},
  },
  {
    path: '/settings',
    name: 'settings',
    component: () =>
      import(
        /* webpackChunkName: "home" */ './components/views/patient/settings.vue'
      ),
      meta: { requiresAuth: true, userType: 'patient'},
  },
];

// Create the router instance
const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('isAuthenticated'); 
  const userType = localStorage.getItem('userType'); 

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      next({ name: 'index' }); 
    } else if (to.meta.userType && to.meta.userType !== userType) {
      next({ name: 'index' }); 
    } else {
      next(); 
    }
  } else {
    next();
  }
});

export default router;
