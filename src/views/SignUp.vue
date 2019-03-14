<template>
  <div class="sign-up">
    <p>Let's create a new account!</p>

    <input type="text" placeholder="Email"><br>
    <input type="password" placeholder="Password"><br>
    <button>Sign up</button>
    <span><router-link to="/login">or go back to login</router-link></span>
  </div>
</template>

<script>
  export default {
    name: 'signUp',
    data() {
      return {};
    },
    methods: {}
  }
</script>

<style scoped>
</style>