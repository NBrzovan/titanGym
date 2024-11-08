<template>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper p-0">
        <div class="content-wrapper d-flex align-items-center auth min-vh-100" 
             style="background: url('/assets/images/auth/titanBaner.jpg') no-repeat center center fixed; background-size: cover;">
            <div class="row flex-grow w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img src="/assets/images/auth/titanLogo.png" alt="Logo">
                        </div>
                        <h2 class="text-center">Titan Gym</h2>
                        <h4 class="font-weight-light text-center">Prijavite se na vaš nalog</h4>
                        <form class="pt-3" @submit="login">
                            <div class="form-group">
                                <input type="email" v-model="email" class="form-control form-control-lg" placeholder="Unesite Vaš email">
                            </div>
                            <div class="form-group">
                                <input type="password" v-model="password" class="form-control form-control-lg" placeholder="Unesite Vašu lozinka">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Prijava</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login(e) {
      e.preventDefault();
      
      await axios.post('api/login', {
          email: this.email,
          password: this.password,
      }).then((response) => {
          if(response.data.error){    
              Swal.fire({
                  icon: 'error',
                  text: response.data.error,
              });
          }
          else {                                                                      
              localStorage.setItem('token', response.data.token);
              localStorage.setItem('id', response.data.id);
              window.location.href = '/clients';
          }
          
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