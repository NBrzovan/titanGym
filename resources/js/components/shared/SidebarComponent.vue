<template>
  <nav v-if="auth" class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
              <router-link to="" class="nav-link">
                <span class="icon-bg"><i class="mdi mdi-account-multiple"></i></span>
                <span class="menu-title">Admin panel</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/clients" class="nav-link">
                <span class="icon-bg"><i class="mdi mdi-account-multiple"></i></span>
                <span class="menu-title">Korisnici</span>
              </router-link>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="user-details">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="d-flex align-items-center">
                      <div class="sidebar-profile-img">
                        <!-- <img src="../../assets/images/faces/face28.png" alt="image"> -->
                      </div>
                      <div class="sidebar-profile-text">
                        <p class="mb-1">Henry Klein</p>
                      </div>
                    </div>
                  </div>
                  <div class="badge badge-danger">3</div>
                </div>
              </div>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a @click="logout" style="cursor: pointer" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
                  <span class="menu-title">Log Out</span></a>
              </div>
            </li>
          </ul>
        </nav>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      auth: localStorage.getItem('token') ? localStorage.getItem('token') : null
    };
  },
  methods: {
    async logout() {
      await axios.post('api/login')
              .then(() => {
                localStorage.removeItem('token');
                window.location.href = '/';    
            }).catch((error) => {
                console.log(error);
            });
    }
  },
  computed: {
    // Vaše computed svojstva idu ovde
  },
  created() {
    // Ovde možete postaviti logiku koja se izvršava pri kreiranju komponente
  }
};
</script>

<style scoped>
/* Ovde možete dodati stilove */
</style>