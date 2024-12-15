import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Admin from '../views/Admin.vue'
import PostListar from '../components/PostListar.vue'
import UserListar from '../components/UserListar.vue'
import CrearPost from '../components/PostCrear.vue'
import CrearUsuario from '../components/UserCrear.vue'
import EditarPost from '../components/PostEditar.vue'
import EditarUsuario from '../components/UserEditar.vue'
import PostVista from '../components/PostVista.vue'
import About from '../views/About.vue'
import Login from '../views/Login.vue'
import auth from '../../middleware/auth'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
    beforeEnter: auth
  },
  {
    path: '/admin/post-listar',
    name: 'PostListar',
    component: PostListar,
    beforeEnter: auth
  },
  {
    path: '/admin/user-listar',
    name: 'UserListar',
    component: UserListar,
    beforeEnter: auth
  },
  {
    path: '/admin/crear-post',
    name: 'CrearPost',
    component: CrearPost,
    beforeEnter: auth
  },
  {
    path: '/admin/crear-usuario',
    name: 'CrearUsuario',
    component: CrearUsuario,
    beforeEnter: auth
  },
  {
    path: '/admin/editar-post/:id',
    name: 'EditarPost',
    component: EditarPost,
    props: true,
    beforeEnter: auth
  },
  {
    path: '/admin/editar-usuario/:id',
    name: 'EditarUsuario',
    component: EditarUsuario,
    props: true,
    beforeEnter: auth
  },
  {
    path: '/post/:id',
    name: 'PostVista',
    component: PostVista,
    props: true
  },
  {
    path: '/about',
    name: 'About',
    component: About
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router