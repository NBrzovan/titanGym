import Login from './pages/Login.vue';
import Clients from './pages/Clients.vue';
import Client from './pages/Client.vue';
import AdminComponent from './admin/AdminComponent.vue';
import { checkIsAuth, checkIsGuest } from './protection.js';


const routes = [
  {
    path: '/',
    component: Login,
    name: 'login',
    beforeEnter: checkIsGuest
  },
  {
    path: '/clients',
    component: Clients,
    name: 'clients',
    beforeEnter: checkIsAuth
  },
  {
    path: '/client/:id',
    component: Client,
    name: 'client',
    beforeEnter: checkIsAuth
  },
  {
    path: '/admin',
    component: AdminComponent,
    name: 'admin',
    beforeEnter: checkIsAuth
  }
];

export default routes;
