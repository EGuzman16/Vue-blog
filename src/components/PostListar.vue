<template>
  <div>
    <h1>Listar Posts</h1>
    <div class="mb-3 d-flex justify-content-between">
      <router-link class="btn btn-primary" to="/admin/crear-post">Crear Post</router-link>
      <nav class="navbar navbar-light bg-light p-0">
        <form class="form-inline" @submit.prevent="searchPosts">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" v-model="searchQuery">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
      </nav>
    </div>
    <table class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Imagen</th>
          <th scope="col">Título</th>
          <th scope="col">Fecha</th>
          <th scope="col">Categoría</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="post in paginatedPosts" :key="post.ID">
          <td class="text-center">
            <img :src="`/server/${post.imagen}`" alt="Imagen del post" class="img-thumbnail" width="100">
          </td>
          <td class="align-middle">{{ post.titulo }}</td>
          <td class="align-middle">{{ formatDate(post.fecha) }}</td>
          <td class="align-middle">{{ post.categoria }}</td>
          <td class="text-center align-middle">
            <button class="btn btn-warning btn-sm" @click="editarPost(post.ID)">
              <i class="mdi mdi-pencil"></i> Editar
            </button>
            <button class="btn btn-danger btn-sm ml-2" @click="borrarPost(post.ID)">
              <i class="mdi mdi-delete"></i> Borrar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="d-flex justify-content-center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
          </li>
          <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
            <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      currentPage: 1,
      postsPerPage: 5,
      searchQuery: ''
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.filteredPosts.length / this.postsPerPage);
    },
    paginatedPosts() {
      const start = (this.currentPage - 1) * this.postsPerPage;
      const end = start + this.postsPerPage;
      return this.filteredPosts.slice(start, end);
    },
    filteredPosts() {
      if (this.searchQuery) {
        return this.posts.filter(post =>
          post.titulo.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          post.resumen.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          post.categoria.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
      return this.posts;
    }
  },
  created() {
    this.fetchPosts();
  },
  methods: {
    async fetchPosts() {
      try {
        const response = await fetch('/api/index.php?tabla=post');
        const data = await response.json();
        this.posts = data.filter(post => post.ID);  
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('es-ES', options);
    },
    editarPost(id) {
      this.$router.push({ name: 'EditarPost', params: { id } });
    },
    async borrarPost(id) {
      if (confirm('¿Estás seguro de que deseas borrar este post?')) {
        try {
          const response = await fetch(`/api/index.php?tabla=post&id=${id}`, {
            method: 'DELETE'
          });
          if (response.ok) {
            this.posts = this.posts.filter(post => post.ID !== id);
            alert('Post borrado exitosamente');
          } else {
            alert('Error al borrar el post');
          }
        } catch (error) {
          console.error('Error al borrar el post:', error);
        }
      }
    },
    changePage(page) {
      if (page > 0 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    searchPosts() {
      this.currentPage = 1;  
    }
  }
};
</script>

<style>
.table th, .table td {
  vertical-align: middle;
  text-align: center;
}
</style>