export default function refreshToken(error) {
  if (error.response.status === 401) {
    this.$store.dispatch('auth/refresh')
  }
}