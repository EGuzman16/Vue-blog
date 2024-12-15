<template>
  <div>
    <div class="jumbotron custom-jumbotron">
      <div class="overlay"></div>
      <h1 class="display-4">¡Bienvenido!</h1>
      <p class="lead">Descubre las últimas actualizaciones y artículos destacados en nuestro blog de noticias.</p>
      <hr class="my-4">
      <p>Aquí encontrarás información importante y recursos que podrían interesarte.</p>
      <p class="lead">
        <router-link class="btn btn-primary btn-lg" to="/about" role="button">Sobre Nosotros</router-link>
      </p>
    </div>

    <nav class="navbar navbar-light bg-light mb-3">
      <form class="form-inline ml-auto search-form" @submit.prevent="searchPosts">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="searchQuery">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
      </form>
    </nav>

    <div class="row mb-2 mr-5 ml-5">
      <div class="col-md-6" v-for="post in paginatedPosts" :key="post.ID">
        <div class="card flex-md-row mb-4 box-shadow h-md-250 post-card">
          <img class="card-img-top d-md-none img-thumbnail" :src="`/server/${post.imagen}`" alt="Card image cap">
          <div class="card-body d-flex flex-column align-items-start">
            <strong class="d-inline-block mb-2 text-primary">{{ post.categoria }}</strong>
            <h2 class="mb-0">
              <router-link :to="{ name: 'PostVista', params: { id: post.ID } }" class="text-dark">{{ post.titulo }}</router-link>
            </h2>
            <p class="card-text mb-auto text-secondary">{{ formatDate(post.fecha) }}</p>
            <p class="card-text mb-auto">{{ post.resumen }}</p>
          </div>
          <img class="card-img-right flex-auto d-none d-md-block img-thumbnail" :src="`/server/${post.imagen}`" alt="Card image cap" width="300" height="250">
        </div>
      </div>
    </div>


    <div class="d-flex justify-content-center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Anterior</a>
          </li>
          <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
            <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Siguiente</a>
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
      postsPerPage: 4,
      searchQuery: '',
      categoria: this.$route.query.categoria || ''
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
      let filtered = this.posts;
      if (this.categoria) {
        filtered = filtered.filter(post => post.categoria === this.categoria);
      }
      if (this.searchQuery) {
        filtered = filtered.filter(post =>
          post.titulo.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          post.resumen.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          post.categoria.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
      return filtered;
    }
  },
  watch: {
    '$route.query.categoria': function(newCategoria) {
      this.categoria = newCategoria;
      this.currentPage = 1; 
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
    changePage(page) {
      if (page > 0 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    searchPosts() {
      this.currentPage = 1;  
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('es-ES', options);
    }
  }
};
</script>

<style>
h2 {
  font-size: 1.2rem;
}
.custom-jumbotron {
  position: relative;
  background: url('/img/hero.png') no-repeat center center;
  background-size: cover;
  color: white;
}
.custom-jumbotron .overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.761);  
}
.custom-jumbotron h1,
.custom-jumbotron p {
  position: relative;
  z-index: 1;
}
.post-card {
  display: flex;
  flex-direction: column;
}
@media (min-width: 768px) {
  .post-card {
    flex-direction: row;
  }
  .post-card .card-img-top {
    display: none;
  }
}
@media (max-width: 767.98px) {
  .search-form {
    justify-content: center;
    width: 100%;
  }
}
</style>