<template>
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <router-link class="navbar-brand" to="/">
        <img src="/img/logo.png" alt="Vue logo" width="30" height="30" class="d-inline-block align-top">
        VueBlog
      </router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/">Inicio</router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Categorías
            </a>
            <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdown">
              <router-link class="dropdown-item text-white" :to="{ name: 'Home', query: { categoria: 'Entretenimiento' } }">Entretenimiento</router-link>
              <router-link class="dropdown-item text-white" :to="{ name: 'Home', query: { categoria: 'Cultura' } }">Cultura</router-link>
              <router-link class="dropdown-item text-white" :to="{ name: 'Home', query: { categoria: 'Viajes' } }">Viajes</router-link>
              <router-link class="dropdown-item text-white" :to="{ name: 'Home', query: { categoria: 'Tecnología' } }">Tecnología</router-link>
            </div>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/about">Sobre Nosotros</router-link>
          </li>
          <li class="nav-item" v-if="isAuthenticated">
            <router-link class="nav-link" to="/admin">Admin</router-link>
          </li>
          <li class="nav-item" v-if="isAuthenticated">
            <button class="nav-link btn btn-link" @click="logout">Cerrar Sesión</button>
          </li>
          <li class="nav-item" v-else>
            <router-link class="nav-link" to="/login">Iniciar Sesión</router-link>
          </li>
        </ul>
      </div>
    </nav>
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      isAuthenticated: localStorage.getItem('auth') === 'true'
    };
  },
  methods: {
    logout() {
      localStorage.removeItem('auth');
      this.isAuthenticated = false;
      this.$router.push('/login');
    }
  },
  watch: {
    '$route'() {
      this.isAuthenticated = localStorage.getItem('auth') === 'true';
    }
  }
};
</script>

