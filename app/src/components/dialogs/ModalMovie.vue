<template>
  <v-dialog width="50vh">
    <v-card class="pa-12 pb-8" elevation="8" height="90vh" rounded="lg">
      <v-img :src="`https://image.tmdb.org/t/p/original${movie.poster_path}`" height="200" class="align-end"
        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" cover>
        <v-card-title class="text-white" v-text="movie.title"></v-card-title>
      </v-img>
      <v-card-subtitle class="pt-4">
        <v-chip class="mr-4" color="red-darken-1" variant="elevated" title="Direção">{{ movie.director }}</v-chip>
        <v-chip class="mr-4" color="indigo-darken-1" variant="elevated" title="Duração">{{ movie.runtime }} min</v-chip>
        <v-chip color="deep-orange-darken-2" variant="elevated" title="Ano de lançamento">{{ movie.release_date
          }}</v-chip>
      </v-card-subtitle>
      <v-card-text>
        {{ movie.overview }}
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    movie: { required: true, type: Object },
  },
};
</script>