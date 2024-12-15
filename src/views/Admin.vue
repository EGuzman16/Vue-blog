<template>
  <div>
    <div class="jumbotron">
      <h1 class="display-4">Panel de Administración</h1>
      <p class="lead">Administra el contenido de tu blog de manera eficiente y sencilla desde este panel centralizado.</p>
      <hr class="my-4">
      <p>Accede a las herramientas necesarias para gestionar publicaciones y usuarios, manteniendo el control total de tu plataforma.</p>
      <p class="lead">
        <router-link class="btn btn-primary btn-lg" to="/admin/post-listar" role="button">Gestionar Publicaciones</router-link>
        <router-link class="btn btn-secondary btn-lg ml-2" to="/admin/user-listar" role="button">Gestionar Usuarios</router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Admin'
}
</script>
