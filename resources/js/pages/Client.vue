<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3>Podaci o korisniku</h3>
                        <p class=""> Wrap content inside<code>&lt;blockquote class="blockquote"&gt;</code></p>
                        <div v-if="client.length>0">
                          <h3>Ime i prezime: {{ client[0].firstName }} {{ client[0].lastName }}</h3>
                          <h3>Email: {{ client[0].email }}</h3>
                          <h3>Datum rođenja: {{ client[0].dateOfBirth }}</h3>
                          <h3>Pol: {{ client[0].gender }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Evidencija plaćanja članarine</h4>
                    <p class="card-description"> Use <code>&lt;address&gt;</code> tag </p>
                    <div class="row">
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
                  <div class="card-body">
                    <h4 class="card-title">Lead</h4>
                    <p class="card-description"> Use class <code>.lead</code>
                    </p>
                    <p class="lead"> Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. </p>
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