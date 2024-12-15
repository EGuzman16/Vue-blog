<template>
  <div class="container mt-5 d-flex justify-content-center">
    <div class="card p-4" style="max-width: 500px; width: 100%;">
      <h1 class="card-title text-center">Iniciar Sesión</h1>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" class="form-control" id="password" v-model="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await fetch('/api/index.php?tabla=auth', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            mail: this.email,
            password: this.password
          })
        });
        const data = await response.json();
        if (data.success) {
          localStorage.setItem('auth', true);
          this.$router.push('/admin');
        } else {
          alert(data.message);
        }
      } catch (error) {
        console.error('Error al iniciar sesión:', error);
      }
    }
  }
};
</script>
