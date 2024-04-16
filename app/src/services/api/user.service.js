import axios from 'axios';
import authHeader from './auth-header';

class UserService {
  constructor() {
    this.http = axios.create({
      baseURL: `${import.meta.env.VITE_API_URL}`,
      headers: {
        "Content-Type": "application/json",
      },
    });
  }
  
  async me() {
    return await this.http.get('auth/me', { headers: authHeader() });
  }

	async getMovies(search) {
		const params = {};

		if (search.filter) {
			params.filter = search.filter;
		}

		if(search.page) {
			params.page = search.page;
		}

		return await this.http.get(`movies`, { headers: authHeader(), params });
	}

	async getMovieById(movieId) {
		return await this.http.get(`movies/${movieId}`, { headers: authHeader() });
	}

	async markAsFavorite(movie) {
		if (!movie.favorite) {
			return await this.http.post('movies/favorite', movie, { headers: authHeader() });
		}

		return await this.http.delete(`movies/${movie.id}/favorite`, { headers: authHeader() });
  }
  
	async markAsWatched(movie) {
		if (!movie.watched) {
			return await this.http.post('movies/watched', movie, { headers: authHeader() });
		}

		return await this.http.delete(`movies/${movie.id}/watched`, { headers: authHeader() });
  }
  
	async markAsWatchLater(movie) {
		if (!movie.watch_later) {
			return await this.http.post('movies/watch-later', movie, { headers: authHeader() });
		}

		return await this.http.delete(`movies/${movie.id}/watch-later`, { headers: authHeader() });
  }
}

export default new UserService();