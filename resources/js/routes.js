import Login from './pages/Login.vue';
import Clients from './pages/Clients.vue';
import Client from './pages/Client.vue';

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
  {
    path: '/client/:id',
    component: Client,
    name: 'client',
  },
];

export default routes;
