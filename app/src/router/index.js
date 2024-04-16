import { createRouter, createWebHistory } from 'vue-router'

import Login from '@/components/pages/Login.vue';
import Register from '@/components/pages/Register.vue';
import Home from '@/components/pages/Home.vue';
import SearchMovies from '@/components/pages/SearchMovies.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/search',
    name: 'Pesquisar',
    component: SearchMovies
  },
  {
    path: '/login',
    name: 'Acessar Sistema',
    component: Login
  },
  {
    path: '/register',
    name: 'Cadastre-se',
    component: Register
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
