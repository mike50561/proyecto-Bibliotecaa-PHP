<template>
  <v-container class="devoluciones-page fill-height">
    <v-row class="justify-center">
      <v-col cols="12" md="11">
        <v-card class="pa-6 devoluciones-card" elevation="12">
          <v-card-title class="text-h5 text-center text-indigo-darken-3 font-weight-bold mb-4">
            <v-icon class="mr-2" color="indigo-darken-3">mdi-book-arrow-return</v-icon>
            Préstamos Pendientes
          </v-card-title>

          <!-- Alertas -->
          <v-alert v-if="mensaje" type="success" class="mb-4" dense>{{ mensaje }}</v-alert>
          <v-alert v-if="error" type="error" class="mb-4" dense>{{ error }}</v-alert>

          <!-- Tabla -->
          <v-simple-table>
            <thead>
              <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Libro</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(prestamo, index) in prestamos" :key="prestamo.id">
                <td>{{ index + 1 }}</td>
                <td>{{ prestamo.usuario?.nombre }}</td>
                <td>{{ prestamo.libro?.titulo }}</td>
                <td>{{ prestamo.fecha_prestamo }}</td>
                <td>{{ prestamo.fecha_devolucion }}</td>
                <td>
                  <v-btn color="green" @click="registrarDevolucion(prestamo.id)" small>
                    <v-icon left small>mdi-check</v-icon> Devuelto
                  </v-btn>
                </td>
              </tr>
              <tr v-if="prestamos.length === 0">
                <td colspan="6" class="text-center text-grey">
                  No hay préstamos pendientes
                </td>
              </tr>
            </tbody>
          </v-simple-table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      prestamos: [],
      mensaje: '',
      error: ''
    }
  },
  mounted() {
    const token = localStorage.getItem('token')
    const usuario = localStorage.getItem('usuario')
    if (!token || !usuario || JSON.parse(usuario).tipo_usuario !== 'admin') {
      this.$router.push('/login')
      return
    }
    this.obtenerPrestamos()
  },
  methods: {
    async obtenerPrestamos() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.get('http://localhost:8000/api/prestamos', {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.prestamos = res.data.filter(p => p.estado === 'pendiente')
      } catch (err) {
        this.error = 'Error al cargar préstamos'
      }
    },
    async registrarDevolucion(prestamoId) {
      const token = localStorage.getItem('token')
      try {
        await axios.post('http://localhost:8000/api/devoluciones', {
          prestamo_id: prestamoId
        }, {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.mensaje = 'Devolución registrada correctamente'
        this.obtenerPrestamos()
      } catch (err) {
        this.error = 'Error al registrar la devolución'
      }
    }
  }
}
</script>

<style scoped>
.devoluciones-page {
  background: linear-gradient(to bottom, #1e1e2f, #2c2c3e);
  padding-top: 30px;
  min-height: 100vh;
}

.devoluciones-card {
  background-color: white;
  border-radius: 16px;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.25);
}
</style>
