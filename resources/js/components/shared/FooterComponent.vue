<template>
  <footer v-if="auth" class="footer">
    <div class="footer-inner-wraper">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block"><span class="text-muted d-block text-center text-sm-left d-sm-inline-block">
            Copyright © {{ new Date().getFullYear() }}. All rights reserved by
            <span class="cursor-pointer"><a href="https://nikolabrzovan.onrender.com/" target="_blank">Nikola Brzovan</a></span>
        </span></span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> A little progress each day adds up to big results.</span>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  data() {
    return {
      auth: localStorage.getItem('token') ? localStorage.getItem('token') : null
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