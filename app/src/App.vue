<template>
  <v-app>
    <v-main>
      <TopBar v-if="$store.state.auth.status.loggedIn" />
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>

</script>
