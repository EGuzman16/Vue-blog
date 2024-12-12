<template>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-8">
          <div v-if="post" class="text-center">
            <img :src="`/server/${post.imagen}`" alt="Imagen del post" class="img-fluid mb-3">
            <h1 class="text-left">{{ post.titulo }}</h1>
            <p class="text-left"><strong>Categoría:</strong> {{ post.categoria }}</p>
            <p class="text-left"><strong>Fecha:</strong> {{ formatDate(post.fecha) }}</p>
            <p class="text-left">{{ post.descripcion }}</p>
          </div>
          <div v-else>
            <p>Cargando...</p>
          </div>
        </div>
        <div class="col-md-4">
          <h3>Últimos Posts</h3>
          <div class="card p-3">
            <div v-for="ultimoPost in ultimosPosts" :key="ultimoPost.ID" class="d-flex mb-3">
              <img :src="`/server/${ultimoPost.imagen}`" alt="Imagen del post" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
              <div class="ml-3">
                <h5 class="mb-1 text-left">
                  <router-link :to="{ name: 'PostVista', params: { id: ultimoPost.ID } }">{{ ultimoPost.titulo }}</router-link>
                </h5>
                <p class="mb-0 text-left"><small class="text-muted">{{ ultimoPost.categoria }}</small></p>
                <p class="mb-0 text-left"><small class="text-muted">{{ formatDate(ultimoPost.fecha) }}</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'PostVista',
    data() {
      return {
        post: null,
        ultimosPosts: []
      };
    },
    created() {
      this.fetchPost();
      this.fetchUltimosPosts();
    },
    watch: {
      '$route.params.id': 'fetchPost'
    },
    methods: {
      async fetchPost() {
        const id = this.$route.params.id;
        try {
          const response = await fetch(`/api/index.php?tabla=post&id=${id}`);
          const data = await response.json();
          if (data.success === 0) {
            alert(data.message);
          } else {
            this.post = data;
          }
        } catch (error) {
          console.error('Error al obtener los datos del post:', error);
        }
      },
      async fetchUltimosPosts() {
        try {
          const response = await fetch('/api/index.php?tabla=post');
          const data = await response.json();
          this.ultimosPosts = data.slice(0, 3);  
        } catch (error) {
          console.error('Error al obtener los últimos posts:', error);
        }
      },
      formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('es-ES', options);
      }
    }
  };
  </script>
  
  <style>
  .card {
    border: 1px solid #ddd;
    border-radius: 5px;
  }
  </style>