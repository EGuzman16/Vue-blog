<template>
    <div class="container">
      <h1>Editar Usuario</h1>
      <form @submit.prevent="editarUsuario">
        <div class="form-group row">
          <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="nombre" v-model="nombre" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="mail" class="col-sm-2 col-form-label">Correo</label>
          <div class="col-sm-6">
            <input type="email" class="form-control" id="mail" v-model="mail" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
          <div class="col-sm-6">
            <input type="password" class="form-control" id="password" v-model="password" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
          <div class="col-sm-6">
            <input type="file" class="form-control-file" id="avatar" @change="onFileChange">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6 offset-sm-2">
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
          </div>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'UserEditar',
    data() {
      return {
        id: this.$route.params.id,
        nombre: '',
        mail: '',
        password: '',
        avatar: null
      };
    },
    created() {
      this.fetchUser();
    },
    methods: {
      async fetchUser() {
        try {
          const response = await fetch(`/api/index.php?tabla=user&id=${this.id}`);
          const data = await response.json();
          if (data.success === 0) {
            alert(data.message);
          } else {
            this.nombre = data.nombre;
            this.mail = data.mail;
            this.password = data.password;
          }
        } catch (error) {
          console.error('Error al obtener los datos del usuario:', error);
        }
      },
      onFileChange(event) {
        this.avatar = event.target.files[0];
      },
      async editarUsuario() {
        const formData = new FormData();
        formData.append('id', this.id);
        formData.append('nombre', this.nombre);
        formData.append('mail', this.mail);
        formData.append('password', this.password);
        if (this.avatar) {
          formData.append('avatar', this.avatar);
        }
  
        try {
          const response = await fetch('/api/index.php?tabla=user&actualizar', {
            method: 'POST',
            body: formData
          });
          const result = await response.json();
          if (result.success) {
            alert('Usuario actualizado exitosamente');
            this.$router.push('/admin/user-listar');
          } else {
            alert('Error al actualizar el usuario: ' + result.message);
          }
        } catch (error) {
          console.error('Error al actualizar el usuario:', error);
        }
      }
    }
  };
  </script>
  
