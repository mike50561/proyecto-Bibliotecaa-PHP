<template>
  <v-container fluid class="libros-page">
    <!-- Título principal -->
    <v-row justify="center">
      <v-col cols="12" class="text-center">
        <h2 class="text-h4 font-weight-bold text-white mb-6">📚 Listado de Libros</h2>
      </v-col>
    </v-row>

    <!-- Botón Agregar libro (solo admin) -->
    <v-row justify="end" v-if="usuario?.tipo_usuario === 'admin'">
      <v-col cols="12" md="3" class="text-end mb-4">
        <v-btn color="cyan darken-2" dark @click="mostrarFormulario = true">
          <v-icon left>mdi-plus</v-icon> Agregar Libro
        </v-btn>
      </v-col>
    </v-row>

    <!-- Tarjetas de libros -->
    <v-row>
      <v-col cols="12" md="6" lg="4" v-for="libro in libros" :key="libro.id">
        <v-card class="libro-card" elevation="6">
          <v-card-title class="text-h6 font-weight-bold">{{ libro.titulo }}</v-card-title>
          <v-card-subtitle class="text-grey-darken-1">{{ libro.autor }} - {{ libro.editorial }}</v-card-subtitle>
          <v-card-text>
            <v-chip class="ma-1" color="blue-grey" text-color="white" label>📅 {{ libro.anio }}</v-chip>
            <v-chip class="ma-1" color="deep-purple" text-color="white" label>🏷️ {{ libro.categoria }}</v-chip>
            <v-chip class="ma-1" color="green" text-color="white" label>📦 {{ libro.cantidad }} en stock</v-chip>
          </v-card-text>

          <!-- Acciones para admin -->
          <v-card-actions v-if="usuario?.tipo_usuario === 'admin'">
            <v-btn color="primary" @click="abrirEditar(libro)">Editar</v-btn>
            <v-btn color="red darken-1" @click="eliminarLibro(libro.id)">Eliminar</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <!-- Formulario agregar libro -->
    <v-dialog v-model="mostrarFormulario" max-width="500">
      <v-card>
        <v-card-title>Nuevo Libro</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="agregarLibro">
            <v-text-field v-model="nuevoLibro.titulo" label="Título" required />
            <v-text-field v-model="nuevoLibro.autor" label="Autor" required />
            <v-text-field v-model="nuevoLibro.editorial" label="Editorial" />
            <v-text-field v-model="nuevoLibro.anio" label="Año" type="number" />
            <v-text-field v-model="nuevoLibro.isbn" label="ISBN" />
            <v-text-field v-model="nuevoLibro.categoria" label="Categoría" />
            <v-text-field v-model="nuevoLibro.cantidad" label="Cantidad" type="number" required />
            <v-btn type="submit" color="indigo" block class="mt-4">Guardar</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Formulario editar libro -->
    <v-dialog v-model="editarLibroDialog" max-width="500">
      <v-card>
        <v-card-title>Editar Libro</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="guardarEdicion">
            <v-text-field v-model="libroEditando.titulo" label="Título" required />
            <v-text-field v-model="libroEditando.autor" label="Autor" required />
            <v-text-field v-model="libroEditando.editorial" label="Editorial" />
            <v-text-field v-model="libroEditando.anio" label="Año" type="number" />
            <v-text-field v-model="libroEditando.isbn" label="ISBN" />
            <v-text-field v-model="libroEditando.categoria" label="Categoría" />
            <v-text-field v-model="libroEditando.cantidad" label="Cantidad" type="number" required />
            <v-btn type="submit" color="indigo" block class="mt-4">Guardar cambios</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      libros: [],
      mostrarFormulario: false,
      editarLibroDialog: false,
      libroEditando: {},
      nuevoLibro: {
        titulo: '',
        autor: '',
        editorial: '',
        anio: '',
        isbn: '',
        categoria: '',
        cantidad: 1,
      },
      usuario: null,
    }
  },
  methods: {
    async obtenerLibros() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.get('http://localhost:8000/api/libros', {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.libros = res.data
      } catch (error) {
        this.$router.push('/login')
      }
    },
    async eliminarLibro(id) {
      const confirmar = confirm('¿Estás seguro de eliminar este libro?')
      if (!confirmar) return
      const token = localStorage.getItem('token')
      try {
        await axios.delete(`http://localhost:8000/api/libros/${id}`, {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.libros = this.libros.filter(l => l.id !== id)
      } catch (error) {
        alert('Error al eliminar el libro')
      }
    },
    async agregarLibro() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.post('http://localhost:8000/api/libros', this.nuevoLibro, {
          headers: { Authorization: `Bearer ${token}` }
        })
        this.libros.push(res.data)
        this.mostrarFormulario = false
        this.nuevoLibro = {
          titulo: '', autor: '', editorial: '', anio: '', isbn: '', categoria: '', cantidad: 1
        }
      } catch (error) {
        alert('Error al guardar el libro')
      }
    },
    abrirEditar(libro) {
      this.libroEditando = { ...libro }
      this.editarLibroDialog = true
    },
    async guardarEdicion() {
      const token = localStorage.getItem('token')
      try {
        const res = await axios.put(`http://localhost:8000/api/libros/${this.libroEditando.id}`, this.libroEditando, {
          headers: { Authorization: `Bearer ${token}` }
        })
        const index = this.libros.findIndex(l => l.id === this.libroEditando.id)
        if (index !== -1) this.libros.splice(index, 1, res.data)
        this.editarLibroDialog = false
      } catch (error) {
        alert('Error al editar el libro')
      }
    }
  },
  mounted() {
    const token = localStorage.getItem('token')
    const usuario = localStorage.getItem('usuario')
    if (!token || !usuario) {
      this.$router.push('/login')
      return
    }
    this.usuario = JSON.parse(usuario)
    this.obtenerLibros()
  }
}
</script>

<style scoped>
.libros-page {
  background: linear-gradient(to right, #1e1e2f, #2c2c3e);
  min-height: 100vh;
  padding-top: 40px;
  padding-bottom: 40px;
}

.libro-card {
  background-color: #ffffff;
  border-radius: 14px;
}
</style>
