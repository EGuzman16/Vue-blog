<template>
    <div class="container">
      <h1>Crear Post</h1>
      <form @submit.prevent="crearPost">
        <div class="form-group row">
          <label for="titulo" class="col-sm-2 col-form-label">Título</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="titulo" v-model="titulo" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="resumen" class="col-sm-2 col-form-label">Resumen</label>
          <div class="col-sm-6">
            <textarea class="form-control" id="resumen" v-model="resumen" required></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
          <div class="col-sm-6">
            <textarea class="form-control" id="descripcion" v-model="descripcion" required></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label for="categoria" class="col-sm-2 col-form-label">Categoría</label>
          <div class="col-sm-6">
            <select class="form-control" id="categoria" v-model="categoria" required>
              <option value="" disabled>Selecciona una categoría</option>
              <option value="Entretenimiento">Entretenimiento</option>
              <option value="Cultura">Cultura</option>
              <option value="Viajes">Viajes</option>
              <option value="Tecnología">Tecnología</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
          <div class="col-sm-6">
            <input type="date" class="form-control" id="fecha" v-model="fecha" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
          <div class="col-sm-6">
            <input type="file" class="form-control-file" id="imagen" @change="onFileChange" required>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6 offset-sm-2">
            <button type="submit" class="btn btn-primary">Crear Post</button>
          </div>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'PostCrear',
    data() {
      return {
        titulo: '',
        resumen: '',
        descripcion: '',
        categoria: '',
        fecha: new Date().toISOString().substr(0, 10), 
        imagen: null
      };
    },
    methods: {
      onFileChange(event) {
        this.imagen = event.target.files[0];
      },
      async crearPost() {
        const formData = new FormData();
        formData.append('titulo', this.titulo);
        formData.append('resumen', this.resumen);
        formData.append('descripcion', this.descripcion);
        formData.append('categoria', this.categoria);
        formData.append('fecha', this.fecha);
        formData.append('imagen', this.imagen);
  
        try {
          const response = await fetch('/api/index.php?tabla=post&crear', {
            method: 'POST',
            body: formData
          });
          const result = await response.json();
          if (result.success) {
            alert('Post creado exitosamente');
            this.$router.push('/admin/post-listar');
          } else {
            alert('Error al crear el post: ' + result.message);
          }
        } catch (error) {
          console.error('Error al crear el post:', error);
        }
      }
    }
  };
  </script>
  
