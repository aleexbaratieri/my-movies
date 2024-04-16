<template>
  <div class="d-flex align-center justify-center" style="height: 100vh">
    <v-card class="mx-auto pa-12 pb-8" elevation="8" min-width="480" rounded="lg">
      <v-form v-model="isFormValid" @submit.prevent="register">
        <div class="text-subtitle-1 text-medium-emphasis">Nome</div>
        <v-text-field density="compact" placeholder="Insira seu nome" prepend-inner-icon="mdi-account-outline"
          variant="outlined" v-model="user.name" :rules="nameRules" tabindex="1">
        </v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis">Sobrenome</div>
        <v-text-field density="compact" placeholder="Insira seu sobrenome" prepend-inner-icon="mdi-account-outline"
          variant="outlined" v-model="user.surname" :rules="surnameRules" tabindex="2">
        </v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis">Email</div>
        <v-text-field density="compact" placeholder="Insira seu e-mail" prepend-inner-icon="mdi-email-outline"
          variant="outlined" v-model="user.email" :rules="emailRules" tabindex="3">
        </v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis">Senha</div>
        <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
          density="compact" placeholder="Insira sua senha" prepend-inner-icon="mdi-lock-outline" variant="outlined"
          @click:append-inner="visible = !visible" v-model="user.password" :rules="passwordRules" tabindex="4">
        </v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis">Confirmar Senha</div>
        <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'" :type="visible ? 'text' : 'password'"
          density="compact" placeholder="Confirme a senha" prepend-inner-icon="mdi-lock-outline" variant="outlined"
          @click:append-inner="visible = !visible" v-model="user.password_confirmation" :rules="confirmPasswordRules"
          tabindex="5">
        </v-text-field>

        <v-btn block class="mb-8" color="blue" size="large" variant="tonal" type="submit" tabindex="6">Cadastrar</v-btn>

        <v-card-text class="text-center">
          <v-btn class="text-blue text-decoration-none" to="login" rel="noopener noreferrer" variant="plain"
            tabindex="7">
            <v-icon icon="mdi-chevron-left"></v-icon> Ir para Login
          </v-btn>
        </v-card-text>
      </v-form>
    </v-card>
  </div>

  <v-snackbar v-model="toast.status" vertical :color="toast.color">
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
        color: undefined,
      },
      user: {
        name: undefined,
        surname: undefined,
        email: undefined,
        password: undefined,
        password_confirmation: undefined,
      }
    };
  },
  methods: {
    async register() {
      if (this.isFormValid) {
        this.$store.dispatch('auth/register', this.user)
          .then(() => {
            this.user = {
              name: undefined,
              surname: undefined,
              email: undefined,
              password: undefined,
              password_confirmation: undefined,
            };
            this.toast = {
              title: 'Sucesso',
              message: 'Cadastro efetuado com sucesso!',
              status: true,
              color: 'success'
            }
          })
          .catch((err) => {
            this.toast = {
              title: 'Erro',
              message: err.response.data.message,
              status: true,
              color: 'error',
            }
          })
      }
    },
  },
  computed: {
    nameRules() {
      return [
        (v) => !!v || 'nome não informado',
      ];
    },
    surnameRules() {
      return [
        (v) => !!v || 'sobrenome não informado',
      ];
    },
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
    confirmPasswordRules() {
      return [
        (v) => !!v || 'Confirme a senha',
        (v) => (v === this.user.password) || 'Senhas diferentes!',
      ];
    },
  }
}
</script>