import { createRouter, createWebHistory } from 'vue-router'

import Home from '../views/Home.vue'
import Login from '../components/Auth/Login.vue'

import Register from '../components/Auth/Register.vue'
import Contact from '../views/Contact.vue'
import AuthPage from '../views/AuthPage.vue'
import Dashboard from '../views/Dashboard.vue'


const routes = [
  {
    path: '/',
    name: 'Home',
    component:  Home
  },
  {
    path: '/Login',
    name: 'Login',
    component:  Login
  },
  {
    path: '/Register',
    name: 'Register',
    component:  Register
  },
  {
    path: '/Auth',
    name: 'Auth',
    component:  AuthPage
  },
  {
    path: '/Dashboard',
    name: 'Dashboard',
    component:  Dashboard
  },
  {
    path: '/Delete/:id',
    name: 'Delete',
    component:  () => import(/* webpackChunkName: "group-foo" */ '@/views/Delete.vue')
  },
  {
    path: '/Update/:id',
    name: 'Update',
    component:  () => import(/* webpackChunkName: "group-foo" */ '@/views/Update.vue')
  },
  {
    path: '/contact',
    name: 'Contact',
    component:  Contact
  }
  ,
  {
    path: '/Add',
    name: 'Add',
    component:  () => import(/* webpackChunkName: "group-foo" */ '@/views/Add.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
