<template>
  <div class="d-flex align-center justify-center" style="height: 100vh">
    <v-card class="mx-auto pa-12 pb-8" elevation="8" min-width="480" rounded="lg">
      <v-form v-model="isFormValid" @submit.prevent="login">
        <div class="text-subtitle-1 text-medium-emphasis">Email</div>
        <v-text-field density="compact" placeholder="Insira seu e-mail" prepend-inner-icon="mdi-email-outline"
          variant="outlined" v-model="user.email" :rules="emailRules" tabindex="1">
        </v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis">Senha</div>
        <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
          density="compact" placeholder="Insira seu senha" prepend-inner-icon="mdi-lock-outline" variant="outlined"
          @click:append-inner="visible = !visible" v-model="user.password" :rules="passwordRules" tabindex="2">
        </v-text-field>

        <v-btn block class="my-8" color="blue" size="large" variant="tonal" type="submit" tabindex="3">Log In</v-btn>

        <v-card-text class="text-center">
          <v-btn class="text-blue text-decoration-none" to="register" rel="noopener noreferrer" variant="plain"
            tabindex="4">
            Cadastre-se <v-icon icon="mdi-chevron-right"></v-icon>
          </v-btn>
        </v-card-text>
      </v-form>
    </v-card>
  </div>

  <v-snackbar v-model="toast.status" vertical color="error">
    <div class="text-subtitle-1 pb-2">{{ toast.title }}</div>

    <p>{{ toast.message }}</p>

    <template v-slot:actions>
      <v-btn variant="text" @click="toast.status = false">
        Fechar
      </v-btn>
    </template>
  </v-snackbar>

</template>
<script>

export default {
  data() {
    return {
      visible: false,
      isFormValid: false,
      toast: {
        status: false,
        title: undefined,
        message: undefined,
      },
      user: {
        email: undefined,
        password: undefined,
      },
    };
  },
  methods: {
    async login() {
      if (this.isFormValid) {
        this.$store.dispatch('auth/login', this.user)
          .then(() => {
            this.$router.push('/');
          })
          .catch((err) => {
            this.toast.title = 'Erro';
            this.toast.message = err.response.data.message;
            this.toast.status = true;
          })
      }
    },
  },
  computed: {
    emailRules() {
      return [
        (v) => !!v || 'e-mail não informado',
        (v) => !!(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v)) || 'e-mail inválido',
      ];
    },
    passwordRules() {
      return [
        (v) => !!v || 'Senha não informada',
      ];
    },
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
  },
  created() {
    if (this.loggedIn) {
      this.$router.push("/");
    }
  },
}
</script>