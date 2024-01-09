import Login from './pages/Login.vue';
import Clients from './pages/Clients.vue';

const routes = [
  {
    path: '/',
    component: Login,
    name: 'login',
  },
  {
    path: '/clients',
    component: Clients,
    name: 'clients',
  },
];

export default routes;
