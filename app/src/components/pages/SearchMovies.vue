<template>
  <v-container>

    <v-overlay :model-value="overlay" class="align-center justify-center">
      <v-progress-circular color="primary" size="64" indeterminate></v-progress-circular>
    </v-overlay>

    <v-card class="mx-auto" color="grey-lighten-3">
      <v-card-text>
        <v-text-field :loading="loading" append-inner-icon="mdi-magnify" density="comfortable"
          label="Digite o nome do filme" variant="solo" hide-details single-line clearable
          @click:append-inner="searchMovies" @keyup.enter="searchMovies" v-model="search.filter">
        </v-text-field>
      </v-card-text>
    </v-card>

    <v-card class="mx-auto mt-8" v-if="movies.length">
      <v-container fluid>
        <v-row dense>
          <v-col v-for="movie in movies" :key="movie.id" cols="3">
            <v-card>
              <v-img :src="`https://image.tmdb.org/t/p/original${movie.poster_path}`" class="align-end"
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

    <div class="text-center" v-if="movies.length">
      <v-container>
        <v-row justify="center">
          <v-col cols="8">
            <v-container class="max-width">
              <v-pagination v-model="pagination.current" :length="pagination.total_pages" class="my-4"></v-pagination>
            </v-container>
          </v-col>
        </v-row>
      </v-container>
    </div>

    <ModalMovie v-model="modalMovie" :movie="activeMovie"></ModalMovie>

  </v-container>
</template>

<script>
import refreshToken from "@/services/api/refresh-token";
import UserService from "@/services/api/user.service";
import { format } from "date-fns";

export default {
  data: () => ({
    loaded: false,
    loading: false,
    overlay: false,
    modalMovie: false,
    user: {},
    search: {
      filter: undefined,
      page: undefined,
    },
    movies: [],
    pagination: {
      current: 1,
      total_pages: undefined
    },
  }),
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    }
  },
  methods: {
    async searchMovies() {
      this.loading = true
      await UserService.getMovies(this.search).then(
        (response) => {
          this.movies = response.data.data.results;
          this.updateCards();
          this.pagination = {
            current: response.data.data.page,
            total_pages: response.data.data.total_pages,
          }
          this.loading = false
          this.loaded = true
        },
        (error) => {
          refreshToken(error)
        }
      );
    },
    async markAsFavorite(movie) {
      await UserService.markAsFavorite(movie)
        .then(() => {
          this.movies = this.movies.map(mv => {
            if (mv.id === movie.id) {
              mv.favorite = !movie.favorite;
              return mv;
            }
            return mv;
          });

          UserService.me().then(response => this.user = response.data)
        })
        .catch(() => refreshToken(error))
    },
    async markAsWatched(movie) {
      await UserService.markAsWatched(movie)
        .then(async () => {
          this.movies = this.movies.map(mv => {
            if (mv.id === movie.id) {
              mv.watched = !movie.watched;
              return mv;
            }
            return mv;
          });

          await UserService.me().then(response => this.user = response.data)
          await this.updateCards();
        })
        .catch(() => refreshToken(error))
    },
    async markAsWatchLater(movie) {
      await UserService.markAsWatchLater(movie)
        .then(async () => {
          this.movies = this.movies.map(mv => {
            if (mv.id === movie.id) {
              mv.watch_later = !movie.watch_later;
              return mv;
            }
            return mv;
          });

          await UserService.me().then(response => this.user = response.data)
          await this.updateCards();
        })
        .catch(() => refreshToken(error))
    },
    async updateCards() {
      this.movies = this.movies.map((movie) => {

        movie.favorite = this.user.movies.some((mv) => mv.movie_id === movie.id && mv.favorite);
        movie.watched = this.user.movies.some((mv) => mv.movie_id === movie.id && mv.watched);
        movie.watch_later = this.user.movies.some((mv) => mv.movie_id === movie.id && mv.watch_later);

        return movie;
      });
    },
    async showMovie(movie) {
      this.overlay = true;
      await UserService.getMovieById(movie.id)
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
          this.overlay = false;
        })
        .catch()
    }
  },
  async mounted() {
    if (!this.currentUser) {
      this.$router.push('/login');
    }
    await UserService.me()
      .then(response => this.user = response.data)
      .catch(error => {
        refreshToken(error)
      });
  },
  watch: {
    'pagination.current': async function (page) {
      this.search.page = page;
      await UserService.getMovies(this.search).then(
        (response) => {
          this.movies = response.data.data.results;
          this.pagination = {
            current: response.data.data.page,
            total_pages: response.data.data.total_pages,
          }
          this.loading = false
          this.loaded = true
        },
        (error) => {
          refreshToken(error)
        }
      );
    },
  },
}
</script>