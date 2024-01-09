import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';
import Sidebar from './components/shared/SidebarComponent.vue';
import Navbar from './components/shared/NavbarComponent.vue';
import Footer from './components/shared/FooterComponent.vue';

const router = createRouter({
  history: createWebHistory(),
  routes
});


const app = createApp({});

app.component('sidebar-component', Sidebar);
app.component('navbar-component', Navbar);
app.component('footer-component', Footer);

app.use(router);

app.mount('#app');
