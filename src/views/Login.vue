<template>
  <div class="login">
    <h3>Sign in</h3>
    <input type="text" placeholder="Email"><br>
    <input type="password" placeholder="Password"><br>
    <button @click="login">Connection</button>
    <p>Ei tunnareita? <router-link to="/sign-up">Rekisteröidy tästä!</router-link></p>
  </div>
</template>

<script>
  export default {
    name: 'login',
    data() {
      return {};
    },
    methods: {
      login: function() {
        this.$router.replace('dashboard')
      }
    }
  }
</script>

<style scoped> /* "scoped" attribute limit the CSS to this component only */
</style>