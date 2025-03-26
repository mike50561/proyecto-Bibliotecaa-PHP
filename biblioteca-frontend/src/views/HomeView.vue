<template>
  <v-container class="home-page" fluid>
    <!-- Bienvenida -->
    <v-row justify="center" class="mt-10">
      <v-col cols="12" md="10">
        <v-card class="pa-5 home-card" elevation="10">
          <v-img
            src="@/assets/biblioteca.jpg"
            height="350"
            class="mb-4 rounded-lg"
            cover
          ></v-img>

          <v-card-title class="text-h4 text-white text-center">
            Bienvenido al Sistema de Biblioteca Virtual
          </v-card-title>

          <v-card-text class="text-white text-center mb-4">
            Gestioná libros, préstamos y devoluciones de manera eficiente con nuestra plataforma.
          </v-card-text>

          <div class="text-center">
            <v-btn color="cyan lighten-1" dark rounded @click="$router.push('/libros')">
              Explorar Libros
            </v-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>

    <!-- Sección de funcionalidades -->
    <v-row justify="center" class="mt-12 mb-10">
      <v-col cols="12" md="3" v-for="item in funcionalidades" :key="item.titulo">
        <v-card class="pa-4 text-center" elevation="4" color="#3c2c3e" dark>
          <v-icon size="50" class="mb-2" color="cyan lighten-5">{{ item.icono }}</v-icon>
          <h3 class="text-h6 font-weight-bold">{{ item.titulo }}</h3>
          <p>{{ item.descripcion }}</p>
        </v-card>
      </v-col>
    </v-row>

    <!-- Nueva sección: Sobre nosotros -->
    <v-row justify="center" class="mb-12">
      <v-col cols="12" md="10">
        <v-card elevation="6" class="d-flex flex-column flex-md-row">
          <v-img
            src="@/assets/galeria4.jpg"
            height="100%"
            width="50%"
            cover
            class="rounded-lg"
          ></v-img>
          <v-card-text class="pa-5">
            <h3 class="text-h5 font-weight-bold mb-2">¿Quiénes somos?</h3>
            <p>
              Somos una iniciativa educativa que busca digitalizar el acceso a los recursos bibliográficos
              de instituciones educativas. Nuestra misión es brindar herramientas modernas para mejorar el
              acceso a la lectura.
            </p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Galería con descripciones -->
    <v-row justify="center" class="mb-12">
      <v-col cols="12" md="4" v-for="(img, index) in imagenes" :key="index">
        <v-card elevation="6" class="rounded-lg gallery-card">
  <v-img :src="img.url" height="200" cover class="rounded-t-lg zoomable"></v-img>
  <v-card-title class="text-subtitle-1 font-weight-bold cyan--text text--darken-1">
    {{ img.titulo }}
  </v-card-title>
  <v-card-text class="text-grey lighten-4">
    {{ img.descripcion }}
  </v-card-text>
</v-card>

      </v-col>
    </v-row>

    
  </v-container>
</template>

<script>
export default {
  name: 'HomeView',
  data() {
    return {
      funcionalidades: [
        {
          titulo: 'Gestión de Libros',
          descripcion: 'Registro, edición y control de inventario de libros.',
          icono: 'mdi-book-open-page-variant',
        },
        {
          titulo: 'Préstamos',
          descripcion: 'Registrar y consultar préstamos de libros.',
          icono: 'mdi-library',
        },
        {
          titulo: 'Devoluciones',
          descripcion: 'Controlar devoluciones y verificar atrasos.',
          icono: 'mdi-book-check',
        },
        {
          titulo: 'Historial',
          descripcion: 'Revisar historial completo por usuario.',
          icono: 'mdi-history',
        },
      ],
      imagenes: [
        {
          url: require('@/assets/galeria1.jpg'),
          titulo: 'Zona de lectura moderna',
          descripcion: 'Ambientes cómodos y tecnológicos para fomentar la lectura.',
        },
        {
          url: require('@/assets/galeria2.jpg'),
          titulo: 'Biblioteca Central',
          descripcion: 'Infraestructura moderna y accesible para todos.',
        },
        {
          url: require('@/assets/galeria3.jpg'),
          titulo: 'Eventos educativos',
          descripcion: 'Actividades de aprendizaje, cultura y tecnología.',
        },
      ],
    }
  },
}
</script>

<style scoped>
.home-page {
  background: linear-gradient(to bottom, #1e1e2f, #232338);
  padding-top: 50px;
  padding-bottom: 80px;
  color: white;
}

.home-card {
  background-color: #2c2c3e;
  border-radius: 16px;
  transition: transform 0.3s ease;
}

.home-card:hover {
  transform: scale(1.01);
}

.v-card-title {
  font-size: 28px;
  font-weight: bold;
  color: #00bcd4;
}

.v-card-text {
  font-size: 16px;
  line-height: 1.6;
  color: #e0e0e0;
}

.v-img {
  border-radius: 8px;
}

/* Galería con efecto */
.v-card:hover {
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
}

.v-img.zoomable {
  transition: transform 0.4s ease;
}

.v-img.zoomable:hover {
  transform: scale(1.05);
  z-index: 2;
}
.v-card {
  background-color: #2c2c3e !important;
  color: white;
}
.gallery-card {
  transition: transform 0.3s ease;
  background-color: #212121;
}

.gallery-card:hover {
  transform: scale(1.03);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
}

.zoomable {
  transition: transform 0.4s ease;
}

.zoomable:hover {
  transform: scale(1.05);
}


</style>

