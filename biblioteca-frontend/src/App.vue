<template>
  <v-app>
    <v-app-bar app color="indigo" dark>
      <router-link to="/" class="toolbar-title-link"> <v-toolbar-title>Sistema de Biblioteca</v-toolbar-title></router-link>
      <v-spacer></v-spacer>

      <!-- Enlaces visibles si hay sesión -->
      <template v-if="usuario">
        <router-link to="/" class="nav-link">Inicio</router-link>
        <router-link to="/libros" class="nav-link">Libros</router-link>
        <router-link v-if="usuario.tipo_usuario === 'admin'" to="/prestamos" class="nav-link">Préstamos</router-link>
        <span class="nav-link" @click="cerrarSesion" style="cursor: pointer;">Cerrar sesión</span> </template>
        <router-link  v-if="usuario?.tipo_usuario === 'admin'"  to="/devoluciones"  class="nav-link">  Devoluciones</router-link>
        <router-link  v-if="usuario?.tipo_usuario === 'admin'"  to="/historial"  class="nav-link">  Historial</router-link>
        <router-link  v-if="usuario && usuario.tipo_usuario !== 'admin'"  to="/mi-historial"  class="nav-link">  Mi Historial</router-link>

      <!-- Enlaces públicos si NO hay sesión -->
      <template v-else>
        <router-link to="/login" class="nav-link">Login</router-link>
        <router-link to="/register" class="nav-link">Registro</router-link>
      </template>
    </v-app-bar>

    <v-main>
      <v-container class="py-5">
        <router-view />
      </v-container>
    </v-main>

    <v-footer color="#1e1e2f" dark class="footer-compact">
  <v-container class="py-2">
    <v-row justify="space-between" align="center">
      <v-col cols="12" md="6" class="text-center text-md-left white--text text-caption">
        &copy; {{ new Date().getFullYear() }} Biblioteca Virtual
      </v-col>
      <v-col cols="12" md="6" class="text-center text-md-right">
        <v-icon small color="#3b5998" class="mr-2">mdi-facebook</v-icon>
        <v-icon small color="#1da1f2" class="mr-2">mdi-twitter</v-icon>
        <v-icon small color="#e1306c" class="mr-2">mdi-instagram</v-icon>
        <v-icon small color="#ffffff">mdi-email</v-icon>
      </v-col>
    </v-row>
  </v-container>
</v-footer>


  </v-app>
</template>

<script>
export default {
  data() {
    return {
      usuario: null,
    }
  },
  mounted() {
    const usuario = localStorage.getItem('usuario')
    if (usuario) {
      this.usuario = JSON.parse(usuario)
    }
  },
  methods: {
    cerrarSesion() {
      localStorage.removeItem('token')
      localStorage.removeItem('usuario')
      this.usuario = null
      this.$router.push('/login')
    }
  }
}
</script>



<style scoped>
.nav-link {
  margin-left: 20px;
  color: white;
  text-decoration: none;
  font-weight: bold;
}

.nav-link.router-link-exact-active {
  color: #90caf9;
}
</style>
