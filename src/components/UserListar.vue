<template>
  <div>
    <h1>Listar Usuarios</h1>
    <div class="mb-3 d-flex justify-content-between">
      <router-link class="btn btn-primary" to="/admin/crear-usuario">Crear Usuario</router-link>
      <nav class="navbar navbar-light bg-light p-0">
        <form class="form-inline" @submit.prevent="searchUsers">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Buscar" v-model="searchQuery">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
      </nav>
    </div>
    <table class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Avatar</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in paginatedUsers" :key="user.ID">
          <td class="text-center">
            <img :src="`/server/${user.avatar}`" alt="Avatar del usuario" class="img-thumbnail" width="100">
          </td>
          <td class="align-middle">{{ user.nombre }}</td>
          <td class="align-middle">{{ user.mail }}</td>
          <td class="text-center align-middle">
            <button class="btn btn-warning btn-sm" @click="editarUsuario(user.ID)">
              <i class="mdi mdi-pencil"></i> Editar
            </button>
            <button class="btn btn-danger btn-sm ml-2" @click="borrarUsuario(user.ID)">
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
  name: 'UserListar',
  data() {
    return {
      users: [],
      currentPage: 1,
      usersPerPage: 5,
      searchQuery: ''
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.filteredUsers.length / this.usersPerPage);
    },
    paginatedUsers() {
      const start = (this.currentPage - 1) * this.usersPerPage;
      const end = start + this.usersPerPage;
      return this.filteredUsers.slice(start, end);
    },
    filteredUsers() {
      if (this.searchQuery) {
        return this.users.filter(user =>
          user.nombre.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          user.mail.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      }
      return this.users;
    }
  },
  created() {
    this.fetchUsers();
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await fetch('/api/index.php?tabla=user');
        const data = await response.json();
        this.users = data.filter(user => user.ID);  
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    },
    editarUsuario(id) {
      this.$router.push({ name: 'EditarUsuario', params: { id } });
    },
    async borrarUsuario(id) {
      if (confirm('¿Estás seguro de que deseas borrar este usuario?')) {
        try {
          const response = await fetch(`/api/index.php?tabla=user&id=${id}`, {
            method: 'DELETE'
          });
          if (response.ok) {
            this.users = this.users.filter(user => user.ID !== id);
            alert('Usuario borrado exitosamente');
          } else {
            alert('Error al borrar el usuario');
          }
        } catch (error) {
          console.error('Error al borrar el usuario:', error);
        }
      }
    },
    changePage(page) {
      if (page > 0 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    searchUsers() {
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