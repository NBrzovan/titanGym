<template>
  <div class="container-fluid content-wrapper">
    <div class="page-header">
      <h3 class="page-title">Tabela Klijenata</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Tabela</a></li>
          <li class="breadcrumb-item active" aria-current="page">Tabela Klijenata</li>
        </ol>
      </nav>
    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Klijenti</h4>
            <div class="d-flex justify-content-between mb-3">
              <div class="search-field d-xl-block">
                <form class="d-flex align-items-center">
                  <div class="input-group">
                    <div class="input-group bg-transparent">
                      <i class="input-group-text border-0 mdi mdi-magnify"></i>
                      <input v-model="searchClientQuery" 
                             @keyup="onSearchInput"
                             type="text" 
                             class="form-control bg-transparent border-0" 
                             id="searchClient" 
                             name="searchClient" 
                             placeholder="Pretraži klijenta">
                    </div>
                  </div>
                </form>
              </div>
              <button @click="openCreateModal()" class="btn colorBackground text-dark btn-sm">
                <i class="mdi mdi-account-plus mt-2"></i> Dodaj klijenta
              </button>
            </div>
            <p>Broj klijenata : {{clientCount}}</p>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th> Klijent </th>
                    <th> Ime i prezime </th>
                    <th> Plaćeni period </th>
                    <th> Iznos članarine (RSD) </th>
                    <th> Status </th>
                    <th> Akcije </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="client in clients" :key="client.id">
                    <td>
                      <img :src="getGenderImage(client.gender, client.id)" alt="Gender Image" class="img-fluid" />
                    </td>
                    <td class="pt-4">
                      <router-link class="text-decoration-none rlFullName" :to="'/client/' + client.id">
                        {{ client.firstName }} {{ client.lastName }}
                      </router-link>
                    </td>
                    <td class="pt-4">{{ paidPeriod(client.dateOfPayment) }} - {{ paidPeriod(client.dateExpiry) }}</td>
                    <td class="pt-4">{{ client.membershipFee }}</td>
                    <td class="pt-4" :class="{'text-success': new Date() <= new Date(client.dateExpiry), 'text-danger': new Date() > new Date(client.dateExpiry)}">
                      {{ new Date() > new Date(client.dateExpiry) ? 'Neaktivan' : 'Aktivan' }}
                    </td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle colorText" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="mdi mdi-account"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a @click="openMembershipFeeModal(client.id)" class="dropdown-item actionH" href="#"><i class="mdi mdi-coin"></i> Članarina</a>
                          <a @click="openEditModal(client.id)" class="dropdown-item actionH" href="#"><i class="mdi mdi-tooltip-edit"></i> Izmeni</a>
                          <a @click="openDeleteModal(client.id)" class="dropdown-item actionH" href="#"><i class="mdi mdi-delete"></i> Obriši</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal ADD Client -->
  <div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createClientModalLabel">Dodavanje klijenta</h5>
          <a href="#" @click="closeModal('createClientModal')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></a>
        </div>
        <div class="modal-body">
          <form class="forms-sample">
              <div class="form-group row">
                <label for="firstName" class="col-sm-3 col-form-label">Ime klijenta</label>
                <div class="col-sm-9">
                  <input type="text" v-model="createFirstName" class="form-control" id="createFirstName" name="createFirstName" placeholder="Ime">
                  <small class="text-danger" v-if="validationErrors.createFirstName">{{ validationErrors.createFirstName }}</small>
                </div>
              </div>
                <div class="form-group row">
                <label for="lastName" class="col-sm-3 col-form-label">Prezime klijenta</label>
                <div class="col-sm-9">
                  <input type="text" v-model="createLastName" class="form-control" id="createLastName" name="createLastName" placeholder="Prezime">
                  <small class="text-danger" v-if="validationErrors.createLastName">{{ validationErrors.createLastName }}</small>
                </div>
              </div>
              <!-- <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" v-model="createEmail" class="form-control" id="createEmail" name ="createEmail" placeholder="Email">
                  <small class="text-danger" v-if="validationErrors.createEmail">{{ validationErrors.createEmail }}</small>
                </div>
              </div> -->
              <div class="form-group row">
                  <label for="gender" class="col-12 col-sm-3 col-form-label pt-4">Izaberite pol</label>
                  <div class="col-12 col-sm-9">
                      <div class="form-check form-check-inline">
                          <input v-model="createGender" class="form-check-input" type="radio" id="createGenderM" name="createGender" value="Muški">
                          <label class="pt-2" for="createGenderM"> Muški</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input v-model="createGender" class="form-check-input" type="radio" id="createGenderZ" name="createGender" value="Ženski">
                          <label class="pt-2" for="createGenderZ"> Ženski</label>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Broj telefona</label>
                <div class="col-sm-9">
                  <input  v-model="createPhone" type="text" class="form-control" id="createPhone" name="createPhone" placeholder="Broj telefona">
                  <small class="text-danger" v-if="validationErrors.createPhone">{{ validationErrors.createPhone }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="createDateOfPayment" class="col-sm-3 col-form-label">Datum članarine od :</label>
                <div class="col-sm-9">
                  <input type="text" v-model="createDateOfPayment" class="form-control" id="createDateOfPayment" name="createdateOfPayment" placeholder="Datum članarine od">
                  <small class="text-danger" v-if="validationErrors.createDateOfPayment">{{ validationErrors.createDateOfPayment }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="createDateExpiry" class="col-sm-3 col-form-label">Datum članarine do :</label>
                <div class="col-sm-9">
                  <input type="text" v-model="createDateExpiry" class="form-control" id="createDateExpiry" name="createDateExpiry" placeholder="Datum članarine do">
                  <small class="text-danger" v-if="validationErrors.createDateExpiry">{{ validationErrors.createDateExpiry }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="membershipFee" class="col-sm-3 col-form-label">Članarina (RSD)</label>
                <div class="col-sm-9">
                  <input type="text" v-model="createmembershipFee" class="form-control" id="createmembershipFee" name="createmembershipFee" placeholder="Iznos članarine">
                  <small class="text-danger" v-if="validationErrors.createmembershipFee">{{ validationErrors.createmembershipFee }}</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" @click="closeModal('createClientModal')" class="btn btn-danger" data-bs-dismiss="modal">Otkaži</button>
                <button type="button" class="btn btn-success btn-fw" @click="confirmCreate">Sačuvaj</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit Client -->
  <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editClientModalLabel">Izmena klijenta</h5>
          <a href="#" @click="closeModal('editClientModal')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></a>
        </div>
        <div class="modal-body">
          <form class="forms-sample">
              <div class="form-group row">
                <label for="firstName" class="col-sm-3 col-form-label">Ime klijenta</label>
                <div class="col-sm-9">
                  <input type="text" v-model="firstName" class="form-control" id="firstName" name="firstName" placeholder="Ime">
                  <small class="text-danger" v-if="validationErrorsEdit.firstName">{{ validationErrorsEdit.firstName }}</small>
                </div>
              </div>
                <div class="form-group row">
                <label for="lastName" class="col-sm-3 col-form-label">Prezime klijenta</label>
                <div class="col-sm-9">
                  <input type="text" v-model="lastName" class="form-control" id="lastName" name="lastName" placeholder="Prezime">
                  <small class="text-danger" v-if="validationErrorsEdit.lastName">{{ validationErrorsEdit.lastName }}</small>
                </div>
              </div>
              <!-- <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" v-model="email" class="form-control" id="email" name ="email" placeholder="Email">
                  <small class="text-danger" v-if="validationErrorsEdit.email">{{ validationErrorsEdit.email }}</small>
                </div>
              </div> -->
              <div class="form-group row">
                  <label for="gender" class="col-12 col-sm-3 col-form-label pt-4">Izaberite pol</label>
                  <div class="col-12 col-sm-9">
                      <div class="form-check form-check-inline">
                          <input v-model="gender" class="form-check-input" type="radio" id="genderM" name="genderM" value="Muški">
                          <label class="pt-2" for="genderM"> Muški</label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input v-model="gender" class="form-check-input" type="radio" id="genderZ" name="genderZ" value="Ženski">
                          <label class="pt-2" for="genderZ"> Ženski</label>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                <label for="phone" class="col-sm-3 col-form-label">Broj telefona</label>
                <div class="col-sm-9">
                  <input  v-model="phone" type="text" class="form-control" id="phone" name="phone" placeholder="Broj telefona">
                  <small class="text-danger" v-if="validationErrorsEdit.phone">{{ validationErrorsEdit.phone }}</small>
                </div>
              </div>
              <!-- <div class="form-group row">
                <label for="dateOfBirth" class="col-sm-3 col-form-label">Datum rođenja</label>
                <div class="col-sm-9">
                  <input type="text" v-model="dateOfBirth" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Datum rođenja">
                  <small class="text-danger" v-if="validationErrorsEdit.dateOfBirth">{{ validationErrorsEdit.dateOfBirth }}</small>
                </div>
              </div> -->
              <div class="form-group row">
                <label for="editDateOfPayment" class="col-sm-3 col-form-label">Datum članarine od :</label>
                <div class="col-sm-9">
                  <input type="text" v-model="editDateOfPayment" class="form-control" id="editDateOfPayment" name="editDateOfPayment" placeholder="Datum članarine od">
                  <small class="text-danger" v-if="validationErrorsEdit.editDateOfPayment">{{ validationErrorsEdit.editDateOfPayment }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="editDateExpiry" class="col-sm-3 col-form-label">Datum članarine do :</label>
                <div class="col-sm-9">
                  <input type="text" v-model="editDateExpiry" class="form-control" id="editDateExpiry" name="editDateExpiry" placeholder="Datum članarine do">
                  <small class="text-danger" v-if="validationErrorsEdit.editDateExpiry">{{ validationErrorsEdit.editDateExpiry }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="membershipFee" class="col-sm-3 col-form-label">Članarina (RSD)</label>
                <div class="col-sm-9">
                  <input type="text" v-model="membershipFee" class="form-control" id="membershipFee" name="membershipFee" placeholder="Iznos članarine">
                  <small class="text-danger" v-if="validationErrorsEdit.membershipFee">{{ validationErrorsEdit.membershipFee }}</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" @click="closeModal('editClientModal')" class="btn btn-danger" data-bs-dismiss="modal">Otkaži</button>
                <button type="button" class="btn btn-success btn-fw" @click="confirmUpdate">Sačuvaj izmene</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Delete Client -->
  <div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteClientModalLabel">Potvrda brisanja</h5>
          <a href="#" @click="closeModal('deleteClientModal')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></a>
        </div>
        <div class="modal-body">
          Da li ste sigurni da želite da obrišete klijenta : {{this.firstNameDelete}} {{this.lastNameDelete}} ?
        </div>
        <div class="modal-footer">
          <button type="button" @click="closeModal('deleteClientModal')" class="btn btn-secondary" data-bs-dismiss="modal">Otkaži</button>
          <button type="button" class="btn btn-danger" @click="confirmDelete">Obriši</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal MembershipFee Client -->
  <div class="modal fade" id="membershipFeeModal" tabindex="-1" aria-labelledby="membershipFeeModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="membershipFeeModal">Evidentiraj članarinu za tekući mesec (RSD)</h5>
          <a href="#" @click="closeModal('membershipFeeModal')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close"></i></a>
        </div>
        <div class="modal-body">
          <form class="forms-sample">
              <div class="form-group row">
                <label for="membershipFee" class="col-sm-3 col-form-label">Članarina (RSD)</label>
                <div class="col-sm-9">
                  <input type="text" v-model="membershipFeeRecord" class="form-control" id="membershipFeeRecord" name="membershipFeeRecord" placeholder="Iznos članarine">
                  <small class="text-danger" v-if="membershipFeeRecordErr">{{ membershipFeeRecordErr }}</small>
                </div>
              </div>
              <div class="form-group row">
                <label for="membershipFeeDateOfPayment" class="col-sm-3 col-form-label">Datum članarine od :</label>
                <div class="col-sm-9">
                  <input type="text" v-model="membershipFeeDateOfPayment" class="form-control" id="membershipFeeDateOfPayment" name="membershipFeeDateOfPayment" placeholder="Datum članarine od">
                  <small class="text-danger" v-if="membershipFeeDateOfPaymentErr">{{ membershipFeeDateOfPaymentErr }}</small>
                </div>
              </div><div class="form-group row">
                <label for="membershipFeeDateExpiry" class="col-sm-3 col-form-label">Datum članarine do :</label>
                <div class="col-sm-9">
                  <input type="text" v-model="membershipFeeDateExpiry" class="form-control" id="membershipFeeDateExpiry" name="membershipFeeDateExpiry" placeholder="Datum članarine do">
                  <small class="text-danger" v-if="membershipFeeDateExpiryErr">{{ membershipFeeDateExpiryErr }}</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" @click="closeModal('membershipFeeModal')" class="btn btn-danger" data-bs-dismiss="modal">Otkaži</button>
                <button type="button" class="btn btn-success btn-fw" @click="addMembershipFeeRecord">Evidentiraj članarinu</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
          
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2';
import moment from "moment";

export default {
  data() {
    return {
      clients: [],
      clientCount: 0,
      maleImages: ['face1.jpg', 'face4.jpg', 'face4.jpg', 'face7.jpg', 'face8.jpg', 'face9.jpg', 'face12.jpg', 'face13.jpg', 'face15.jpg', 'face16.jpg', 'face19.jpg','face21.jpg'],
      femaleImages: ['face2.jpg', 'face6.jpg', 'face10.jpg', 'face11.jpg', 'face20.jpg', 'face23.jpg', 'face26.jpg'],
      clientIdToEdit: null,
      clientIdToDelete: null,
      createFirstName: '',
      createLastName: '',
      createEmail: '',
      createGender: 'Muški',
      createPhone: '',
      createDateOfBirth: '',
      createmembershipFee: '',
      createDateOfPayment: '',
      createDateExpiry: '',
      membershipFeeDateOfPayment: '',
      membershipFeeDateExpiry: '',
      firstName: '',
      lastName: '',
      email: '',
      gender: '',
      phone: '',
      dateOfBirth: '',
      membershipFee: '',
      editDateOfPayment: '',
      editDateExpiry: '',
      firstNameDelete: '',
      lastNameDelete: '',
      searchClientQuery: '',
      membershipFeeClientId: '',
      membershipFeeRecord: '',
      membershipFeeRecordErr: '',
      membershipFeeDateOfPaymentErr: '',
      membershipFeeDateExpiryErr: '',
      validationErrors: {
        createFirstName: null,
        createLastName: null,
        createEmail: null,
        createGender: null,
        createPhone: null,
        createmembershipFee: null,
        createDateOfBirth: null,
        createDateOfPayment: null,
        createDateExpiry: null,
      },
      validationErrorsEdit: {
        firstName: null,
        lastName: null,
        email: null,
        gender: null,
        phone: null,
        membershipFee: null,
        dateOfBirth: null,
        editDateOfPayment: null,
        editDateExpiry: null
      }
    };
  },
  mounted() {
    this.fetchClients();
  },
  methods: {

    async fetchClients() {

      axios.get('/api/clients', {
          params: {
              search: this.searchClientQuery
          }
      })
      .then(response => {
        this.clients = response.data;
        this.clientCount = this.clients.length;
      })
      .catch(error => {
        console.error('Error fetching clients:', error);
      });
    },

    onSearchInput() {
        if (this.searchClientQuery.length >= 3) {
            this.fetchClients();
        }
    },

    getGenderImage(gender, clientId) {
        const imageArray = gender === 'Muški' ? this.maleImages : this.femaleImages;
        let randomIndex = clientId % imageArray.length;
        return `/assets/images/faces/${imageArray[randomIndex]}`;
    },

    openEditModal(clientId) {
      this.clientIdToEdit = clientId;
      this.editAction(this.clientIdToEdit);
      $('#editClientModal').modal('show');
    },

    openMembershipFeeModal(clientId){
      this.membershipFeeClientId = clientId;
      $('#membershipFeeModal').modal('show');
    },

    openDeleteModal(clientId){
      this.clientIdToDelete = clientId;
      this.deleteAction(this.clientIdToDelete);
      $('#deleteClientModal').modal('show');
    },

    openCreateModal(){
      $('#createClientModal').modal('show');
    },

    editAction(clientId) {
        axios.get('/api/clients/'+clientId)
        .then(response => {
          
          this.firstName = response.data.firstName;
          this.lastName = response.data.lastName;
          this.email = response.data.email;
          this.gender = response.data.gender;
          this.phone = response.data.phone;

          if(response.data.dateOfBirth != null){
            this.dateOfBirth = moment(response.data.dateOfBirth).format('DD.MM.YYYY.');
          }else{
            this.dateOfBirth == "";
          }

          if(response.data.dateOfPayment != null || response.data.dateOfPayment != ''){
            this.editDateOfPayment = moment(response.data.dateOfPayment).format('DD.MM.YYYY.');
          }else{
            this.editDateOfPayment == "";
          }

           if(response.data.dateExpiry != null || response.data.dateExpiry != ''){
            this.editDateExpiry = moment(response.data.dateExpiry).format('DD.MM.YYYY.');
          }else{
            this.editDateExpiry == "";
          }

          this.membershipFee = response.data.membershipFee;
        })
        .catch(error => {
          console.error('Error fetching clients:', error);
          if (error.response) {
              console.error('Status Code:', error.response.status);
          }
        });
    },

    addMembershipFeeRecord(){
      const membershipFeeRecord = parseFloat(this.membershipFeeRecord);
      const datePattern = /^\d{2}\.\d{2}\.\d{4}\.$/;

      this.membershipFeeRecordErr = '';
      this.membershipFeeDateOfPaymentErr =  '';
      this.membershipFeeDateExpiryErr = '';

      if (isNaN(membershipFeeRecord) || membershipFeeRecord < 0 || membershipFeeRecord > 100000) {
        this.membershipFeeRecordErr = "Unesite validan iznos od 0 do 100000";
        return;
      }
      
      if (!datePattern.test(this.membershipFeeDateOfPayment)) {
            this.membershipFeeDateOfPaymentErr = "Datum mora biti u formatu DD.MM.YYYY.";
            return;
      }

      if (!datePattern.test(this.membershipFeeDateExpiry)) {
            this.membershipFeeDateExpiryErr = "Datum mora biti u formatu DD.MM.YYYY.";
            return;
      }

      axios.post('/api/membershipFee/clients/' + this.membershipFeeClientId,
        {
          membershipFeeRecord : this.membershipFeeRecord,
          dateOfPayment : this.membershipFeeDateOfPayment,
          dateExpiry : this.membershipFeeDateExpiry
        })
        .then(response => {
          this.showSuccessAlert("Uspešno evidentirano" ,"Uspešno ste evidentirali članarinu!");
        })
        .catch(error => {
          console.error('Error fetching clients:', error);
          if (error.response) {
              console.error('Status Code:', error.response.status);
          }
        });
        this.fetchClients();
        $('#membershipFeeModal').modal('hide');
        this.clearModal();
    },

    confirmCreate(){
      if (this.validateForm()) {
        const addClientData = {
            firstName: this.createFirstName,
            lastName: this.createLastName,
            email: this.createEmail,
            gender: this.createGender,
            phone: this.createPhone,
            dateOfBirth: this.createDateOfBirth,
            membershipFee: this.createmembershipFee,
            dateOfPayment: this.createDateOfPayment,
            dateExpiry: this.createDateExpiry
        };

        axios.post('/api/clients/add', addClientData)
          .then(response => {
              this.showSuccessAlert("Uspešno kreirano" ,"Uspešno ste kreirali novog klijenta!");
              this.fetchClients();
              $('#createClientModal').modal('hide');
              this.clearModal();
          })
          .catch(error => {
            if (error.response && error.response.status === 422) {
                this.showErrorAlert("E-mail već postoji.");
            }else{
              this.showErrorAlert("Došlo je do greške. Molimo Vas, pokušajte kasnije.");
                $('#createClientModal').modal('hide');
                this.clearModal();
            }
          });
      }
    },

    confirmUpdate(){
      const clientId = this.clientIdToEdit;
      if (this.validateFormEdit()) {
        const updatedClientData = {
            firstName: this.firstName,
            lastName: this.lastName,
            email: this.email,
            gender: this.gender,
            phone: this.phone,
            dateOfBirth: this.dateOfBirth,
            membershipFee : this.membershipFee,
            dateOfPayment : this.editDateOfPayment,
            dateExpiry : this.editDateExpiry
        };

        axios.put('/api/clients/'+clientId, updatedClientData)
          .then(response => {
            this.showSuccessAlert("Uspešno ažurirano" ,"Uspešno ste izmenili klijenta!");
            this.fetchClients();
            $('#editClientModal').modal('hide');
            this.clearModal();
          })
          .catch(error => {
            if (error.response && error.response.status === 422) {
                this.showErrorAlert("E-mail već postoji.");
            }else{
              this.showErrorAlert("Došlo je do greške. Molimo Vas, pokušajte kasnije.");
              $('#editClientModal').modal('hide');
              this.clearModal();
            }
          });
      }  
    },

    deleteAction(clientId) {
      axios.get('/api/clients/'+clientId)
        .then(response => {
          this.firstNameDelete = response.data.firstName;
          this.lastNameDelete = response.data.lastName;
        })
        .catch(error => {
          console.error('Error fetching clients:', error);
          if (error.response) {
              console.error('Status Code:', error.response.status);
          }
        });
    },

    confirmDelete() {
      const clientId = this.clientIdToDelete;
      axios.delete('/api/clients/'+clientId)
        .then(response => {
          this.showSuccessAlert("Uspešno obrisano" ,"Uspešno ste obrisali klijenta!");
        })
        .catch(error => {
          this.showErrorAlert();
        });
        this.fetchClients();
        $('#deleteClientModal').modal('hide');
        this.clearModal();
    },

    validateForm() {
      let isValid = true;
      const datePattern = /^\d{2}\.\d{2}\.\d{4}\.$/;

      if (!this.createFirstName || this.createFirstName.trim() === "") {
        this.validationErrors.createFirstName = "Polje Ime ne sme biti prazno.";
        isValid = false;
      } else {
          this.validationErrors.createFirstName = null;
      }

      if (!this.createLastName || this.createLastName.trim() === "") {
        this.validationErrors.createLastName = "Polje Prezime ne sme biti prazno.";
        isValid = false;
      } else {
          this.validationErrors.createLastName = null;
      }

      if (!datePattern.test(this.createDateOfPayment)) {
            this.validationErrors.createDateOfPayment = "Datum mora biti u formatu DD.MM.YYYY.";
            isValid = false;
      } else {
          this.validationErrors.createDateOfPayment = null;
      }

      if (!datePattern.test(this.createDateExpiry)) {
            this.validationErrors.createDateExpiry = "Datum mora biti u formatu DD.MM.YYYY.";
            isValid = false;
      } else {
          this.validationErrors.createDateExpiry = null;
      }

      // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      // if (!this.createEmail || this.createEmail.trim() === "") {
      //   this.validationErrors.createEmail = "Polje Email ne sme biti prazno.";
      // } else if (!emailRegex.test(this.createEmail)) {
      //   this.validationErrors.createEmail = "Neispravan format Email adrese.";
      // } else {
      //   this.validationErrors.createEmail = null;
      // }

      // if (!this.createPhone || this.createPhone.trim() === "") {
      //   this.validationErrors.createPhone = "Polje Broj Telefona ne sme biti prazno.";
      //   isValid = false;
      // } else {
      //     this.validationErrors.createPhone = null;
      // }

      if (!this.createmembershipFee || this.createmembershipFee.trim() === "") {
          this.validationErrors.createmembershipFee = "Polje Članarina (RSD) ne sme biti prazno.";
          isValid = false;
      }else if(isNaN(this.createmembershipFee) || this.createmembershipFee < 0 || this.createmembershipFee > 100000){
          this.validationErrors.createmembershipFee = "Unesite validan iznos od 0 do 100000";
          isValid = false;
      }else {
          this.validationErrors.createmembershipFee = null;
      }
      
      // const regex = /^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[0-2])\.\d{4}\.$/;

      // if(!regex.test(this.createDateOfBirth)){
      //   this.validationErrors.createDateOfBirth = "Polje Datum rođenja mora biti u formatu dd.mm.yyyy.";
      //   isValid = false;
      // } else {
      //     this.validationErrors.createDateOfBirth = null;
      // }
      

      return isValid;
    },

    validateFormEdit(){
      let isValid = true;
      const datePattern = /^\d{2}\.\d{2}\.\d{4}\.$/;

      if (!this.firstName || this.firstName.trim() === "") {
        this.validationErrorsEdit.firstName = "Polje Ime ne sme biti prazno.";
        isValid = false;
      } else {
          this.validationErrorsEdit.firstName = null;
      }

      if (!this.lastName || this.lastName.trim() === "") {
        this.validationErrorsEdit.lastName = "Polje Prezime ne sme biti prazno.";
        isValid = false;
      } else {
          this.validationErrorsEdit.lastName = null;
      }

      // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      // if (!this.email || this.email.trim() === "") {
      //   this.validationErrorsEdit.email = "Polje Email ne sme biti prazno.";
      // } else if (!emailRegex.test(this.email)) {
      //   this.validationErrorsEdit.email = "Neispravan format Email adrese.";
      // } else {
      //   this.validationErrorsEdit.email = null;
      // }

      // if (!this.phone || this.phone.trim() === "") {
      //   this.validationErrorsEdit.phone = "Polje Broj Telefona ne sme biti prazno.";
      //   isValid = false;
      // } else {
      //     this.validationErrorsEdit.phone = null;
      // }

      if (!this.membershipFee || this.membershipFee.trim() === "") {
        this.validationErrorsEdit.membershipFee = "Polje Članarina (RSD) ne sme biti prazno.";
        isValid = false;
      }else if(isNaN(this.membershipFee) || this.membershipFee < 0 || this.membershipFee > 100000){
        this.validationErrorsEdit.membershipFee = "Unesite validan iznos od 0 do 100000";
        isValid = false;
      } else {
          this.validationErrorsEdit.membershipFee = null;
      }

      if (!datePattern.test(this.editDateOfPayment)) {
            this.validationErrorsEdit.editDateOfPayment = "Datum mora biti u formatu DD.MM.YYYY.";
            isValid = false;
      } else {
          this.validationErrorsEdit.editDateOfPayment = null;
      }

      if (!datePattern.test(this.editDateExpiry)) {
            this.validationErrorsEdit.editDateExpiry = "Datum mora biti u formatu DD.MM.YYYY.";
            isValid = false;
      } else {
          this.validationErrorsEdit.editDateExpiry = null;
      }

      //const regex = /^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[0-2])\.\d{4}\.$/;

      // if(!regex.test(this.dateOfBirth)){
      //   this.validationErrorsEdit.dateOfBirth = "Polje Datum rođenja mora biti u formatu dd.mm.yyyy.";
      //   isValid = false;
      // } else {
      //     this.validationErrorsEdit.dateOfBirth = null;
      // }
      
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

    clearModal(){
      this.createFirstName = '',
      this.createLastName = '',
      this.createEmail = '',
      this.createGender = 'Muški',
      this.createPhone = '',
      this.createDateOfBirth = '',
      this.createmembershipFee = '',
      this.firstName = '',
      this.lastName = '',
      this.email = '',
      this.gender = '',
      this.phone = '',
      this.dateOfBirth = '',
      this.firstNameDelete = '',
      this.lastNameDelete = '',
      this.membershipFee = '',
      this.membershipFeeClientId = '',
      this.membershipFeeRecord = '',
      this.createDateOfPayment = '',
      this.createDateExpiry = '',
      this.membershipFeeDateOfPayment = '',
      this.membershipFeeDateExpiry = '',
      this.editDateOfPayment = '',
      this.editDateExpiry = ''
    },

    paidPeriod(period) {
      if (!period) return ''; 

      const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
      const formatter = new Intl.DateTimeFormat('sr-Latn', options);

      const formattedDate = formatter.format(new Date(period));
      return formattedDate;
    },

    closeModal(modalName){
      $(`#${modalName}`).modal('hide');
      this.clearModal();
    }
  },
  computed: {
    
  },
  created() {

  },
  watch: {
    searchClientQuery: function (newQuery, oldQuery) {
        this.fetchClients();
    },
  }
};
</script>

<style scoped>
    .rlFullName:hover{
      color: #ffed00 !important;
    }

    .actionH:hover {
      background-color: #ffed00 !important;
    }
    .colorBackground {
      background-color: #ffed00 !important;
    }

    .colorText {
      color: #ffed00 !important;
    }
</style>