<template>
  <v-container>

    <v-overlay :model-value="overlay" class="align-center justify-center">
      <v-progress-circular color="primary" size="64" indeterminate></v-progress-circular>
    </v-overlay>

    <v-card class="mx-auto mt-8">
      <v-container fluid>
        <v-row dense>
          <v-col v-for="movie in user.movies" :key="movie.id" cols="3">
            <v-card>
              <v-img :src="`https://image.tmdb.org/t/p/original${movie.poster_path}`" class="align-end row-pointer"
                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)" height="200px" cover @click="showMovie(movie)">
                <v-card-title class="text-white" v-text="movie.title"></v-card-title>
              </v-img>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :color="movie.favorite ? 'error' : 'medium-emphasis'" icon="mdi-heart" size="small"
                  title="Favorito" @click="markAsFavorite(movie)">
                </v-btn>
                <v-btn :color="movie.watched ? 'primary' : 'medium-emphasis'" icon="mdi-movie-check" size="small"
                  title="Assistido" @click="markAsWatched(movie)">
                </v-btn>
                <v-btn :color="movie.watch_later ? 'primary' : 'medium-emphasis'" icon="mdi-movie-play" size="small"
                  title="Assistir Depois" @click="markAsWatchLater(movie)">
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-card>
  </v-container>

  <ModalMovie v-model="modalMovie" :movie="activeMovie"></ModalMovie>

</template>

<style scoped>
.row-pointer {
  cursor: pointer;
}
</style>

<script>
import refreshToken from "@/services/api/refresh-token";
import UserService from "@/services/api/user.service";
import { format } from "date-fns";

export default {
  data() {
    return {
      user: {},
      modalMovie: false,
      activeMovie: {},
      loading: false,
    }
  },
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    }
  },
  async mounted() {
    if (!this.currentUser) {
      this.$router.push('/login');
    }
    await UserService.me()
      .then(response => this.user = response.data)
      .catch(error => refreshToken(error));
  },
  methods: {
    async markAsFavorite(movie) {
      const payload = await this.mapMovieToTMDB(movie)
      await UserService.markAsFavorite(payload)
        .then(() => {
          this.user.movies = this.user.movies.map(mv => {
            if (mv.id === movie.id) {
              mv.favorite = !movie.favorite;
              return mv;
            }
            return mv;
          });

          UserService.me().then(response => this.user = response.data)
        })
        .catch(error => refreshToken(error));
    },
    async markAsWatched(movie) {
      const payload = await this.mapMovieToTMDB(movie)
      await UserService.markAsWatched(payload)
        .then(async () => {
          this.user.movies = this.user.movies.map(mv => {
            if (mv.id === movie.id) {
              mv.watched = !movie.watched;
              return mv;
            }
            return mv;
          });

          await UserService.me().then(response => this.user = response.data)
          await this.updateCards();
        })
        .catch(error => refreshToken(error));
    },
    async markAsWatchLater(movie) {
      const payload = await this.mapMovieToTMDB(movie)
      await UserService.markAsWatchLater(payload)
        .then(async () => {
          this.user.movies = this.user.movies.map(mv => {
            if (mv.id === movie.id) {
              mv.watch_later = !movie.watch_later;
              return mv;
            }
            return mv;
          });

          await UserService.me().then(response => this.user = response.data)
          await this.updateCards();
        })
        .catch(error => refreshToken(error));
    },
    async updateCards() {
      this.movies = this.movies.map((movie) => {

        movie.favorite = this.user.movies.some((mv) => mv.movie_id === movie.id && mv.favorite);
        movie.watched = this.user.movies.some((mv) => mv.movie_id === movie.id && mv.watched);
        movie.watch_later = this.user.movies.some((mv) => mv.movie_id === movie.id && mv.watch_later);

        return movie;
      });
    },
    async mapMovieToTMDB(movie) {
      return {
        id: movie.movie_id,
        original_title: movie.original_title,
        title: movie.title,
        poster_path: movie.poster_path,
        favorite: movie.favorite,
        watched: movie.watched,
        watch_later: movie.watch_later
      }
    },
    async showMovie(movie) {
      this.loading = true;
      await UserService.getMovieById(movie.movie_id)
        .then(response => {
          this.activeMovie = {
            poster_path: response.data.data.poster_path,
            title: response.data.data.title,
            overview: response.data.data.overview,
            release_date: format(response.data.data.release_date, 'yyyy'),
            runtime: response.data.data.runtime,
            director: response.data.data.credits.crew.filter(({ job }) => job === 'Director')[0].name
          }

          this.modalMovie = true
          this.loading = false;
        })
        .catch()
    }
  },
};
</script>