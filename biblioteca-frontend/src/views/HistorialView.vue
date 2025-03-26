<template>
  <v-container class="historial-page fill-height d-flex justify-center align-center">
    <v-card class="pa-6 historial-card" max-width="1000" elevation="12">
      <v-card-title class="text-h5 text-center text-indigo-darken-3 font-weight-bold mb-4">
        <v-icon class="mr-2" color="indigo-darken-3">mdi-history</v-icon>
        Historial de Préstamos por Usuario
      </v-card-title>

      <v-row dense class="mb-4">
        <v-col cols="12" md="6">
          <v-select
            v-model="usuarioSeleccionado"
            :items="usuarios"
            item-text="nombre"
            item-value="id"
            label="Seleccionar Usuario"
            prepend-inner-icon="mdi-account"
            color="indigo"
            variant="outlined"
            dense
            @change="obtenerHistorial"
          />
        </v-col>

        <v-col cols="12" md="6" class="d-flex align-end justify-end">
          <v-btn
            v-if="usuarioSeleccionado && historial.length"
            color="indigo"
            class="mt-md-0 mt-4"
            @click="descargarPdf"
          >
            <v-icon left>mdi-file-pdf-box</v-icon> Descargar PDF
          </v-btn>
        </v-col>
      </v-row>

      <!-- Tabla -->
      <v-alert v-if="error" type="error" dense class="mb-4">{{ error }}</v-alert>

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

      <v-alert
        v-else-if="usuarioSeleccionado && historial.length === 0"
        type="info"
        dense
        class="mt-4"
      >
        Este usuario no tiene préstamos registrados.
      </v-alert>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      usuarios: [],
      usuarioSeleccionado: null,
      historial: [],
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
    this.obtenerUsuarios()
  },
  methods: {
    async obtenerUsuarios() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.get('http://localhost:8000/api/usuarios', {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.usuarios = res.data.filter(u => u.tipo_usuario !== 'admin')
      } catch (err) {
        this.error = 'Error al cargar usuarios'
      }
    },

    async obtenerHistorial() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.get(`http://localhost:8000/api/usuarios/${this.usuarioSeleccionado}/historial`, {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.historial = res.data
      } catch (err) {
        this.error = 'Error al cargar historial'
      }
    },

    async descargarPdf() {
      const token = localStorage.getItem('token')
      try {
        const response = await axios.get(
          `http://localhost:8000/api/usuarios/${this.usuarioSeleccionado}/historial/pdf`,
          {
            headers: { Authorization: `Bearer ${token}` },
            responseType: 'blob'
          }
        )

        const blob = new Blob([response.data], { type: 'application/pdf' })
        const url = window.URL.createObjectURL(blob)
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', 'historial.pdf')
        document.body.appendChild(link)
        link.click()
      } catch (err) {
        this.error = 'No se pudo descargar el PDF.'
      }
    }
  }
}
</script>

<style scoped>
.historial-page {
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
