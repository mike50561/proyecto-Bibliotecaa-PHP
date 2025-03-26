import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import LibrosView from '../views/LibrosView.vue'
import PrestamosView from '../views/PrestamosView.vue'
import DevolucionesView from '../views/DevolucionesView.vue'
import HistorialView from '../views/HistorialView.vue'
import EstudianteView from '../views/EstudianteView.vue'

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/login', name: 'Login', component: LoginView },
  { path: '/register', name: 'Register', component: RegisterView },
  { path: '/libros', name: 'Libros', component: LibrosView },
  { path: '/prestamos', name: 'Prestamos', component: PrestamosView },
  { path: '/devoluciones', name: 'Devoluciones', component: DevolucionesView },
  { path: '/historial', name: 'Historial', component: HistorialView },
  { path: '/mi-historial', name: 'MiHistorial', component: EstudianteView }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
