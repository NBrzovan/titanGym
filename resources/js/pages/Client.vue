<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Podaci o korisniku</h4>
                        <p class=""> Wrap content inside<code>&lt;blockquote class="blockquote"&gt;</code></p>
                    </div>
                    <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ime i Prezime : </h5>
                        <p class="card-text">Email: </p>
                        <!-- Dodajte ostale informacije koje želite prikazati -->
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Evidencija plaćanja</h4>
                    <p class="card-description"> Use <code>&lt;address&gt;</code> tag </p>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <p class="font-weight-bold">Connect Plus imc</p>
                          <p> 695 lsom Ave, </p>
                          <p> Suite 00 </p>
                          <p> San Francisco, CA 94107 </p>
                        </address>
                      </div>
                      <div class="col-md-6">
                        <address class="text-primary">
                          <p class="font-weight-bold"> E-mail </p>
                          <p class="mb-2"> johndoe@examplemeail.com </p>
                          <p class="font-weight-bold"> Web Address </p>
                          <p> www.Connect Plus.com </p>
                        </address>
                      </div>
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
export default {
  data() {
    return {
      // Vaši podaci idu ovde
    };
  },
  methods: {
    // Vaše metode idu ovde
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