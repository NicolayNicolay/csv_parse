import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    name: 'HomePage',
    path: '/',
    meta: {
      requiresAuth: true,
    },
    redirect: '/admin',
  },
  {
    name: 'ObjectsPage',
    path: '/admin',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/ObjectsPage.vue')
  },
  {
    name: 'ObjectsUploadForm',
    path: '/admin/import',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/ObjectsUploadForm.vue')
  },
  {
    name: 'Login',
    path: '/login',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/Auth/LoginPage.vue')
  },
  {
    name: 'Registration',
    path: '/register',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/Auth/RegisterPage.vue')
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
