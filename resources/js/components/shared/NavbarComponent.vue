<template>
  <nav v-if="auth" class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="#"><img src="/assets/images/auth/logoV-removebg-preview.png" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center pt-4 text-secondary"> You don’t have to be extreme. Just consistent.</span>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item  dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="reportDropdown" href="#" data-toggle="dropdown" aria-expanded="false"> Reports </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="reportDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-pdf mr-2"></i>PDF </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-excel mr-2"></i>Excel </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-file-word mr-2"></i>doc </a>
              </div>
            </li>
            <li class="nav-item nav-language dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-language-icon">
                  <i class="flag-icon flag-icon-rs" title="RS" id="rs"></i>
                </div>
                <div class="nav-language-text">
                  <p class="mb-1 text-black">Serbian</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <div class="nav-language-icon mr-2">
                    <i class="flag-icon flag-icon-rs" title="RS" id="rs"></i>
                  </div>
                  <div class="nav-language-text">
                    <p class="mb-1 text-black">Serbian</p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                   <img class="rounded-circle" :src="userImage" alt="adminImage">
                </div>
                <div class="nav-profile-text">
                  <p class="pt-3">{{adminFirstName ? adminFirstName : null}}</p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                <div class="p-3 text-center bg-primary">
                   <img class="rounded-circle" :src="userImage" alt="adminImage">
                </div>
                <div class="p-2">
                  <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                  <router-link to="/admin" class="dropdown-item py-1 d-flex align-items-center justify-content-between">
                    <span>Profile</span>
                    <span class="p-0">
                      <!-- <span class="badge badge-success">1</span> -->
                      <i class="mdi mdi-account-outline ml-1"></i>
                    </span>
                  </router-link>
                  <div role="separator" class="dropdown-divider"></div>
                  <h5 class="dropdown-header text-uppercase  pl-2 text-dark mt-2">Actions</h5>
                  <a @click="logout"  style="cursor: pointer" class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                      <span class="menu-title">Log Out</span>
                    <i class="mdi mdi-logout ml-1"></i>
                  </a>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-email-outline"></i>
                <span class="count-symbol bg-success"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                <h6 class="p-3 mb-0 bg-primary text-white py-4">Messages</h6>
                <div class="dropdown-divider"></div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-bell-outline"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0 bg-primary text-white py-4">Notifications</h6>
                <div class="dropdown-divider"></div>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
</template>

<script>

import axios from 'axios';

export default {
  data() {
    return {
      auth: localStorage.getItem('token') ? localStorage.getItem('token') : null,
      adminFirstName: "",
      id : localStorage.getItem('id') ? localStorage.getItem('id') : null,
    };
  },
  mounted() {
    this.getCurentAdmin();
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
          this.adminFirstName = response.data.firstName
        })
        .catch(error => {
          console.log(error);
        });
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
/* Ovde možete dodati stilove */
</style>