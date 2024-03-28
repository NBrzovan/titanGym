<template>
  <nav v-if="auth" class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-category">MENU</li>
            <li class="nav-item">
              <router-link to="/admin" class="nav-link" exact-active-class="active">
                  <span class="icon-bg"><i class="mdi mdi-account-multiple"></i></span>
                  <span class="menu-title">Admin panel</span>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/clients" class="nav-link" exact-active-class="active">
                  <span class="icon-bg"><i class="mdi mdi-account-multiple"></i></span>
                  <span class="menu-title">Klijenti</span>
              </router-link>
            </li>
            <li class="nav-item nav-category">ADMIN</li>
            <li class="nav-item sidebar-user-actions">
              <div class="user-details">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <div class="d-flex align-items-center">
                      <div class="sidebar-profile-img">
                        <img class="rounded-circle" :src="userImage" alt="adminImage">
                      </div>
                      <div class="sidebar-profile-text">
                        <p class="pt-3">{{ adminFirstname ? adminFirstname : null }} {{ adminLastname ? adminLastname : null}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item sidebar-user-actions">
              <div class="sidebar-user-menu">
                <a @click="logout" style="cursor: pointer" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
                  <span class="menu-title">Log Out</span>
                </a>
              </div>
            </li>
          </ul>
  </nav>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    adminUpdated: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      auth: localStorage.getItem('token') ? localStorage.getItem('token') : null,
      adminFirstname: "",
      adminLastname: "",
      id : localStorage.getItem('id') ? localStorage.getItem('id') : null,
      adminUpdated: false,
    };
  },
  mounted() {
    this.getCurentAdmin();
    // this.$root.$on('updateSuccess', this.handleUpdateSuccess);
  },
  methods: {
    async logout() {
      await axios.get('api/logout')
        .then(() => {
          localStorage.removeItem('token');
          localStorage.removeItem('userName');
          localStorage.removeItem('firstName');
          localStorage.removeItem('id');
          window.location.href = '/';    
        }).catch((error) => {
            
        });
    },

    getCurentAdmin(){
      var id = localStorage.getItem('id');
      axios.get('/api/admin/'+id)
        .then(response => {
          this.adminFirstname = response.data.firstName;
          this.adminLastname = response.data.lastName
        })
        .catch(error => {
          console.log(error);
        });
    },

     handleAdminUpdated(updated) {
      alert(1);
      this.adminUpdated = updated;
    },
    
  },
  computed: {
    userImage() {
        if (this.id == 1) {
            return '/assets/images/faces/adminVlada.png';
        } else if(this.id == 2) {
            return '/assets/images/faces/adminAna.jpg'; 
        }
    }
  },
  created() {
    // Ovde možete postaviti logiku koja se izvršava pri kreiranju komponente
  }
};
</script>

<style scoped>
  .active {
      color: #ffed00 !important; 
      font-weight: bold; 
      font-family: "nunito-medium", sans-serif;
  }
</style>