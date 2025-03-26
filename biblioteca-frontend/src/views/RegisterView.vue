<template>
  <v-container class="auth-page fill-height d-flex align-center justify-center" fluid>
    <v-card class="register-card pa-6" max-width="700" min-height="580" elevation="14">
      <v-card-title class="text-h4 font-weight-bold text-center mb-6 text-indigo-darken-3">
        <v-icon color="indigo-darken-3" size="34" class="mr-2">mdi-account-plus</v-icon>
        Crear cuenta
      </v-card-title>

      <v-form @submit.prevent="register">
        <v-text-field
          v-model="nombre"
          label="Nombre completo"
          prepend-inner-icon="mdi-account"
          color="indigo"
          variant="outlined"
          dense
          required
        />

        <v-text-field
          v-model="correo"
          label="Correo electrónico"
          type="email"
          prepend-inner-icon="mdi-email"
          color="indigo"
          variant="outlined"
          dense
          required
        />

        <v-select
          v-model="tipo_usuario"
          :items="['estudiante', 'profesor']"
          label="Tipo de usuario"
          prepend-inner-icon="mdi-account-group"
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

        <v-btn type="submit" color="indigo" class="mt-4" block size="large">
          <v-icon left>mdi-account-check</v-icon> Registrarse
        </v-btn>

        <v-alert v-if="error" type="error" class="mt-4" dense>{{ error }}</v-alert>
        <v-alert v-if="success" type="success" class="mt-4" dense>{{ success }}</v-alert>

        <div class="text-center mt-4">
          <span class="text-caption">
            ¿Ya tienes cuenta?
            <router-link to="/login" class="text-indigo text-decoration-none font-weight-medium">
              Inicia sesión aquí
            </router-link>
          </span>
        </div>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import api from '@/axios'

export default {
  name: 'RegisterView',
  data() {
    return {
      nombre: '',
      correo: '',
      password: '',
      tipo_usuario: '',
      error: null,
      success: null,
    }
  },
  methods: {
    async register() {
      this.error = null
      this.success = null
      try {
        await api.post('/register', {
          nombre: this.nombre,
          correo: this.correo,
          password: this.password,
          tipo_usuario: this.tipo_usuario,
        })

        this.success = 'Registro exitoso. Redirigiendo al inicio de sesión...'
        setTimeout(() => this.$router.push('/login'), 2000)
      } catch (err) {
        if (err.response && err.response.data.message) {
          this.error = err.response.data.message
        } else {
          this.error = 'Error al registrar. Verificá los campos.'
        }
      }
    },
  },
}
</script>

<style scoped>
.auth-page {
  background: linear-gradient(to bottom right, #1e1e2f, #2c2c3e);
  padding: 2px;
}

.register-card {
  background-color: white;
  border-radius: 18px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.text-decoration-none {
  text-decoration: none;
}
</style>