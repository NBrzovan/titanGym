<template>
  <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
          <div class="content-wrapper d-flex align-items-center auth">
              <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                      <div class="brand-logo">
                          <!-- <img src="../../assets/images/logo-dark.svg"> -->
                      </div>
                      <h3 style="text-align: center;">Titan Gym</h3>
                      <h6 class="font-weight-light" style="text-align: center;">Prijavite se na vaš nalog</h6>
                      <form class="pt-3" @submit="login">
                          <div class="form-group">
                            <input type="email" v-model="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Vaš email...">
                          </div>
                          <div class="form-group">
                            <input type="password" v-model="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Vaša lozinka...">
                          </div>
                          <div class="mt-3">
                            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Prijava</button>
                          </div>
                          <div class="my-2 d-flex justify-content-between align-items-center">
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