export default function auth(to, from, next) {
  if (!localStorage.getItem('auth')) {
    next('/login');
  } else {
    next();
  }
}