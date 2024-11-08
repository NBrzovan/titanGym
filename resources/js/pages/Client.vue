<template>
    <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title"> Pregled klijenta i evidencije </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Tabela</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tabela evidencije</li>
            </ol>
          </nav>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card bg-light">
                  <div class="card-body">
                      <h1 class="card-title">Podaci o klijentu</h1>
                      <div v-if="client.length > 0">
                          <div class="row">
                              <div class="col-md-6">
                                  <h3><i class="fa fa-user icon-sm colorText"></i> Ime i prezime</h3>
                                  <p class="font-weight-bold ml-4 pFont">{{ client[0].firstName }} {{ client[0].lastName }}</p>
                              </div>
                              <div class="col-md-6">
                                  <h3><i class="fa fa-envelope icon-sm colorText"></i> Email</h3>
                                  <p class="font-weight-bold ml-4 pFont">{{ client[0].email }}</p>
                              </div>
                          </div>
                          <div class="row mt-4">
                              <div class="col-md-6">
                                  <h3><i class="mdi mdi-cellphone-iphone icon-sm colorText"></i> Broj telefona</h3>
                                  <p class="font-weight-bold ml-4 pFont">{{  client[0].phone }}</p>
                              </div>
                          </div>
                          <div class="row mt-4">
                              <div class="col-md-6">
                                  <h3><i class="fa fa-birthday-cake icon-sm colorText"></i> Datum rođenja</h3>
                                  <p class="font-weight-bold ml-4 pFont">{{ paidPeriod(client[0].dateOfBirth) }}</p>
                              </div>
                              <div class="col-md-6">
                                  <h3><i class="fa fa-venus-mars icon-sm colorText"></i> Pol</h3>
                                  <p class="font-weight-bold ml-4 pFont">{{ client[0].gender }}</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Evidencija plaćanja članarine</h4>
                    <div class="row">
                      <div class="table-responsive">
                        <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Dan uplate članarine</th>
                            <th>Dan isteka članarine</th>
                            <th>Iznos članarine (RSD)</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="record in client" :key="record.id">
                            <td class="text-center">{{ paidPeriod(record.dateOfPayment) }}</td>
                            <td class="text-center">{{ paidPeriod(record.dateExpiry) }}</td>
                            <td class="text-center">{{ record.membershipFee }}</td>
                          </tr>
                        </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      clientID : this.$route.params.id,
      client : []

    };
  },
  methods: {
    getClientReview(){
       axios.get('/api/getClientReview/' + this.clientID)
      .then(response => {
        this.client = response.data;
      })
      .catch(error => {
        console.error('Error fetching clients:', error);
      });
    },

    paidPeriod(period) {
      if (!period) return ''; 

      const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
      const formatter = new Intl.DateTimeFormat('sr-Latn', options);

      const formattedDate = formatter.format(new Date(period));
      return formattedDate;
    }
  },
  mounted() {
    this.getClientReview();
  },
  computed: {
    
  },
  created() {
    
  }
};
</script>

<style scoped>
  .colorBackground {
    background-color: #ffed00;
  }

  .colorText {
    color: #ffed00;
  }

  .pFont{
    font-size: 20px;
  }
</style>