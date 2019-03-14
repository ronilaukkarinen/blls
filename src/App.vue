<template>
  <div id="app">
    <div id="nav" style="display: none;">
      <router-link to="/">Home</router-link> |
      <router-link to="/login">Login</router-link>
    </div>
    <router-view/>
  </div>
</template>
