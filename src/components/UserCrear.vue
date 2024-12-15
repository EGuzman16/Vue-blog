<template>
    <div class="container">
      <h1>Crear Usuario</h1>
      <form @submit.prevent="crearUsuario">
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
            <input type="file" class="form-control-file" id="avatar" @change="onFileChange" required>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6 offset-sm-2">
            <button type="submit" class="btn btn-primary">Crear Usuario</button>
          </div>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'UserCrear',
    data() {
      return {
        nombre: '',
        mail: '',
        password: '',
        avatar: null
      };
    },
    methods: {
      onFileChange(event) {
        this.avatar = event.target.files[0];
      },
      async crearUsuario() {
        const formData = new FormData();
        formData.append('nombre', this.nombre);
        formData.append('mail', this.mail);
        formData.append('password', this.password);
        formData.append('avatar', this.avatar);
  
        try {
          const response = await fetch('/api/index.php?tabla=user&crear', {
            method: 'POST',
            body: formData
          });
          const result = await response.json();
          if (result.success) {
            alert('Usuario creado exitosamente');
            this.$router.push('/admin/user-listar');
          } else {
            alert('Error al crear el usuario: ' + result.message);
          }
        } catch (error) {
          console.error('Error al crear el usuario:', error);
        }
      }
    }
  };
  </script>
  
