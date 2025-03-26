<template>
  <v-container class="mi-historial-page fill-height d-flex justify-center align-center">
    <v-card class="pa-6 historial-card" max-width="1000" elevation="12">
      <v-card-title class="text-h5 text-center text-indigo-darken-3 font-weight-bold mb-4">
        <v-icon class="mr-2" color="indigo-darken-3">mdi-book-open-page-variant</v-icon>
        Mi Historial de Préstamos
      </v-card-title>

      <!-- Alertas -->
      <v-alert v-if="error" type="error" dense class="mb-4">{{ error }}</v-alert>

      <!-- Tabla -->
      <v-simple-table v-if="historial.length">
        <thead>
          <tr>
            <th>#</th>
            <th>Libro</th>
            <th>Fecha Préstamo</th>
            <th>Fecha Devolución</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in historial" :key="item.id">
            <td>{{ index + 1 }}</td>
            <td>{{ item.libro?.titulo }}</td>
            <td>{{ item.fecha_prestamo }}</td>
            <td>{{ item.fecha_devolucion }}</td>
            <td>
              <v-chip
                :color="item.estado === 'devuelto' ? 'green' : 'orange'"
                text-color="white"
                small
              >
                {{ item.estado }}
              </v-chip>
            </td>
          </tr>
        </tbody>
      </v-simple-table>

      <v-alert v-else type="info" dense class="mt-4">
        Aún no tenés préstamos registrados.
      </v-alert>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      historial: [],
      error: ''
    }
  },
  mounted() {
    const token = localStorage.getItem('token')
    const usuario = JSON.parse(localStorage.getItem('usuario'))

    if (!token || !usuario || usuario.tipo_usuario === 'admin') {
      this.$router.push('/login')
      return
    }

    this.obtenerMiHistorial(usuario.id)
  },
  methods: {
    async obtenerMiHistorial(id) {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.get(`http://localhost:8000/api/usuarios/${id}/historial`, {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.historial = res.data
      } catch (err) {
        this.error = 'Error al cargar tu historial'
      }
    }
  }
}
</script>

<style scoped>
.mi-historial-page {
  background: linear-gradient(to bottom right, #1e1e2f, #2c2c3e);
  padding: 20px;
  min-height: 100vh;
}

.historial-card {
  background-color: white;
  border-radius: 16px;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
}
</style>
