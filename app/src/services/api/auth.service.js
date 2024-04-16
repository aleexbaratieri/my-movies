import axios from "axios";
import authHeader from "./auth-header";

class AuthService {
  constructor() {
    this.http = axios.create({
      baseURL: `${import.meta.env.VITE_API_URL}`,
      headers: {
        "Content-Type": "application/json",
      },
    });
  }

  async login(credentials) {
    return this.http.post(`auth/login`, credentials)
    .then(response => {
      if (response.data.access_token) {
          localStorage.setItem('user', JSON.stringify(response.data));
        }

        return response.data;
    })
  }

  async logout() {
    this.http.post('auth/logout', null, {
      headers: authHeader(),
    })
    localStorage.removeItem('user');
  }

  async refresh() {
    this.http.post('auth/refresh', null, {
      headers: authHeader(),
    })
    .then(response => {
      if (response.data.access_token) {
          localStorage.setItem('user', JSON.stringify(response.data));
        }

        return response.data;
    })
    .catch(() => {
      localStorage.removeItem('user');
      this.$router.push('/login');
    })
  }

  async register(user) {
    return this.http.post(`register`, user)
  }
}

export default new AuthService();
