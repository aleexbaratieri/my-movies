<template>
  <v-app-bar flat class="border-b">
    <v-btn variant="plain" to="/"><v-icon>mdi-home</v-icon>
      <v-app-bar-title class="ml-2">Meus Filmes Favoritos</v-app-bar-title>
    </v-btn>

    <template #append>
      <v-menu>
        <template #activator="{ props }">

          <v-btn prepend-icon="mdi-movie-search" to="search">
            Procurar
          </v-btn>
          <v-btn prepend-icon="mdi-logout" @click="logout()">
            Sair
          </v-btn>
        </template>
      </v-menu>
    </template>
  </v-app-bar>
</template>

<script>
export default {
  methods: {
    async logout() {
      this.$store.dispatch('auth/logout')
        .then(() => {
          this.$router.push('/login');
        })
    }
  }
}

</script>
