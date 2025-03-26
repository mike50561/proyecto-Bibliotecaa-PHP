<template>
  <v-container class="login-bg fill-height d-flex align-center justify-center">
    <v-card class="login-card pa-6" max-width="600" min-height="480" elevation="14">
      <v-card-title class="text-h5 text-center text-indigo-darken-2">
        <v-icon size="32" color="indigo-darken-2" class="mr-2">mdi-account-circle</v-icon>
        Bienvenido
      </v-card-title>

      <v-card-subtitle class="text-center mb-4">Inicia sesión para continuar</v-card-subtitle>

      <v-form @submit.prevent="login">
        <v-text-field
          v-model="correo"
          label="Correo electrónico"
          prepend-inner-icon="mdi-email"
          color="indigo"
          variant="outlined"
          dense
          required
        />

        <v-text-field
          v-model="password"
          label="Contraseña"
          type="password"
          prepend-inner-icon="mdi-lock"
          color="indigo"
          variant="outlined"
          dense
          required
        />

        <v-btn
          :loading="loading"
          type="submit"
          color="indigo"
          block
          class="mt-4"
          size="large"
        >
          <v-icon left>mdi-login</v-icon> Ingresar
        </v-btn>

        <v-btn variant="text" color="grey darken-1" block class="mt-2 text-caption">
          <v-icon left size="18">mdi-help-circle</v-icon>
          ¿Olvidaste tu contraseña?
        </v-btn>

        <v-alert v-if="error" type="error" class="mt-4" dense>
          {{ error }}
        </v-alert>

        <div class="text-center mt-4">
          <span class="text-caption">
            ¿No tienes cuenta?
            <router-link to="/register" class="text-indigo text-decoration-none font-weight-medium">
              Regístrate aquí
            </router-link>
          </span>
        </div>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import api from '@/axios' // ✅ importamos el archivo central axios.js

export default {
  name: 'LoginView',
  data() {
    return {
      correo: '',
      password: '',
      error: null,
      loading: false,
    }
  },
  methods: {
    async login() {
      this.error = null
      this.loading = true
      try {
        const response = await api.post('/login', {
          correo: this.correo,
          password: this.password,
        })

        const token = response.data.token
        const usuario = response.data.usuario

        localStorage.setItem('token', token)
        localStorage.setItem('usuario', JSON.stringify(usuario))

        this.$router.push('/')
      } catch (err) {
        this.error = err.response?.data?.message || 'Credenciales incorrectas'
      } finally {
        this.loading = false
      }
    },
  },
}
</script>

<style scoped>
.login-bg {
  background: linear-gradient(to bottom, #1e1e2f, #2c2c3e);
  padding: 20px;
}

.login-card {
  max-width: 380px;
  width: 100%;
  background-color: white;
  border-radius: 16px;
}

.text-decoration-none {
  text-decoration: none;
}
</style>
