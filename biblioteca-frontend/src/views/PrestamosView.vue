<template>
  <v-container fluid class="prestamo-page fill-height d-flex align-center justify-center">
    <v-card class="pa-6 prestamo-card" max-width="700" elevation="14">
      <v-card-title class="text-h5 text-center text-indigo-darken-2">
        <v-icon color="indigo-darken-2" class="mr-2">mdi-book-plus</v-icon>
        Registrar Préstamo
      </v-card-title>

      <v-form @submit.prevent="registrarPrestamo">
        <v-row dense>
          <v-col cols="12" md="6">
            <v-select
              v-model="prestamo.usuario_id"
              :items="usuarios"
              item-text="nombre"
              item-value="id"
              label="Seleccionar Usuario"
              prepend-inner-icon="mdi-account"
              color="indigo"
              variant="outlined"
              dense
              required
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-select
              v-model="prestamo.libro_id"
              :items="libros"
              item-text="titulo"
              item-value="id"
              label="Seleccionar Libro"
              prepend-inner-icon="mdi-book"
              color="indigo"
              variant="outlined"
              dense
              required
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
              v-model="prestamo.fecha_prestamo"
              label="Fecha de Préstamo"
              type="date"
              prepend-inner-icon="mdi-calendar"
              color="indigo"
              variant="outlined"
              dense
              required
            />
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
              v-model="prestamo.fecha_devolucion"
              label="Fecha de Devolución"
              type="date"
              prepend-inner-icon="mdi-calendar-check"
              color="indigo"
              variant="outlined"
              dense
              required
            />
          </v-col>
        </v-row>

        <v-btn type="submit" color="indigo" block class="mt-4" size="large">
          <v-icon left>mdi-check</v-icon> Registrar Préstamo
        </v-btn>

        <v-alert v-if="mensaje" type="success" class="mt-4" dense>{{ mensaje }}</v-alert>
        <v-alert v-if="error" type="error" class="mt-4" dense>{{ error }}</v-alert>
      </v-form>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      prestamo: {
        usuario_id: '',
        libro_id: '',
        fecha_prestamo: '',
        fecha_devolucion: '',
      },
      usuarios: [],
      libros: [],
      mensaje: '',
      error: '',
    }
  },
  mounted() {
    const token = localStorage.getItem('token')
    const usuario = localStorage.getItem('usuario')
    if (!token || !usuario || JSON.parse(usuario).tipo_usuario !== 'admin') {
      this.$router.push('/login')
      return
    }
    this.obtenerUsuarios()
    this.obtenerLibros()
  },
  methods: {
    async obtenerUsuarios() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.get('http://localhost:8000/api/usuarios', {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.usuarios = res.data.filter(u => u.tipo_usuario !== 'admin')
      } catch (error) {
        this.error = 'Error al cargar usuarios'
      }
    },
    async obtenerLibros() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.get('http://localhost:8000/api/libros', {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.libros = res.data
      } catch (error) {
        this.error = 'Error al cargar libros'
      }
    },
    async registrarPrestamo() {
      const token = localStorage.getItem('token')
      this.mensaje = ''
      this.error = ''
      try {
        await axios.post('http://localhost:8000/api/prestamos', this.prestamo, {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.mensaje = '✅ Préstamo registrado exitosamente.'
        this.prestamo = {
          usuario_id: '',
          libro_id: '',
          fecha_prestamo: '',
          fecha_devolucion: '',
        }
      } catch (error) {
        this.error = '❌ Error al registrar el préstamo.'
      }
    }
  }
}
</script>

<style scoped>
.prestamo-page {
  background: linear-gradient(to bottom right, #1e1e2f, #2c2c3e);
  padding: 20px;
  min-height: 100vh;
}

.prestamo-card {
  background-color: white;
  border-radius: 16px;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
}
</style>
