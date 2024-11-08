<template>
    <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Admin panel</h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Podaci</li>
              <li class="breadcrumb-item"><a href="#">Admin podaci</a></li>
            </ol>
          </nav>
        </div>
        <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card bg-light">
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adminName"><i class="fa fa-user icon colorText pr-2"></i> Admin ime</label>
                                    <input type="text" class="form-control" id="adminName" name="adminName" v-model="this.adminName">
                                    <small class="text-danger" v-if="validationErrors.adminName">{{ validationErrors.adminName }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adminLastName"><i class="fa fa-user icon colorText pr-2"></i> Admin prezime</label>
                                    <input type="text" class="form-control" id="adminLastName" name="adminLastName" v-model="this.adminLastName">
                                    <small class="text-danger" v-if="validationErrors.adminLastName">{{ validationErrors.adminLastName }}</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adminEmail"><i class="fa fa-envelope icon colorText pr-2"></i> Email</label>
                                    <input type="email" class="form-control" id="adminEmail" name="adminEmail" v-model="this.adminEmail">
                                    <small class="text-danger" v-if="validationErrors.adminEmail">{{ validationErrors.adminEmail }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                          <button type="button" class="btn btn-success btn-fw" @click="confirmUpdateAdmin">Sačuvaj izmene</button>
                        </div>
                    </form>
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
      adminName: "",
      adminLastName: "",
      adminEmail: "",
      showPass: false,
      validationErrors: {
        adminName: null,
        adminLastName: null,
        adminEmail: null,
      }
    };
  },
  mounted() {
    this.getCurentAdmin();
  },
  methods: {
    getCurentAdmin(){
      var id = localStorage.getItem('id');
      axios.get('/api/admin/'+id)
        .then(response => {
          this.adminName = response.data.firstName
          this.adminEmail = response.data.email
          this.adminLastName = response.data.lastName
        })
        .catch(error => {
          console.log(error);
        });
    },

    showPassword(event) {
        this.showPass = event.target.checked;
        const passField = document.getElementById('adminPass');
        passField.type = this.showPass ? 'text' : 'password';
    },

    async confirmUpdateAdmin(){
      var adminID = localStorage.getItem('id');

       if (this.validateAdminData()) {
          var updatedAdminData = {
              adminName: this.adminName,
              adminLastName: this.adminLastName,
              adminEmail : this.adminEmail
          };
        // var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;  
        axios.put('/api/admin/'+adminID, updatedAdminData)
          .then(response => {
            this.getCurentAdmin();
            this.$emit('admin-updated', true);
            this.showSuccessAlert("Uspešno ažurirano" ,"Uspešno ste izmenili klijenta!");
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          })
          .catch(error => {
            this.showErrorAlert("Došlo je do greške. Molimo Vas, pokušajte kasnije.");
          });
        }  
    },

    validateAdminData(){
      let isValid = true;

      if (!this.adminName || this.adminName.trim() === "") {
        this.validationErrors.adminName = "Polje Admin ime  ne sme biti prazno.";
        isValid = false;
      } else {
          this.validationErrors.adminName = null;
      }

      if (!this.adminLastName || this.adminLastName.trim() === "") {
        this.validationErrors.adminLastName = "Polje Admin prezime ne sme biti prazno.";
        isValid = false;
      } else {
          this.validationErrors.adminLastName = null;
      }
     
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!this.adminEmail || this.adminEmail.trim() === "") {
        this.validationErrors.adminEmail = "Polje Email ne sme biti prazno.";
      } else if (!emailRegex.test(this.adminEmail)) {
        this.validationErrors.adminEmail = "Neispravan format Email adrese.";
      } else {
        this.validationErrors.adminEmail = null;
      }

      return isValid;
    },

    showSuccessAlert(title, text) {
      Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonText: 'OK'
      })
    },

    showErrorAlert(text) {
      Swal.fire({
        title: 'Greška!',
        text: text,
        icon: 'error',
        confirmButtonText: 'OK'
      })
    },

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