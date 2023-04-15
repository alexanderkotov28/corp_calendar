<template>
  <v-layout align-center justify-center>
    <v-flex xs12 sm8 md4>
      <v-card class="elevation-12">
        <v-toolbar dark color="primary">
          <v-toolbar-title>Login form</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-form ref="form" @submit.prevent="login()">
            <v-text-field
              v-model="email"
              :error-messages="errors.email"
              :disabled="loading"
              @change="errors.email = []"
              :rules="rules.email"
              name="email"
              label="E-mail"
              type="text"
              placeholder="E-mail"
              required
            ></v-text-field>

            <v-text-field
              v-model="password"
              :disabled="loading"
              :rules="rules.password"
              name="password"
              label="Password"
              type="password"
              placeholder="password"
              required
            ></v-text-field>

            <v-btn type="submit" class="mt-4" color="primary" value="log in" :loading="loading">Login</v-btn>
          </v-form>
        </v-card-text>
      </v-card>

    </v-flex>
    <v-snackbar
      v-model="snackbar"
    >
      {{ errorMessage }}
    </v-snackbar>
  </v-layout>
</template>

<script>
export default {
  name: "login",
  auth: 'guest',
  layout: 'noauth',
  data: () => ({
    email: null,
    password: null,
    errorMessage: null,
    errors: {
      email: []
    },
    rules: {
      email: [
        v =>!!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail is invalid'
      ],
      password: [
        v =>!!v || 'Password is required'
      ]
    },
    snackbar: false,
    loading: false
  }),
  methods: {
    login() {
      if (this.$refs.form.validate()){
        this.loading = true;
        this.$auth.loginWith('laravelSanctum', {
          data: {
            email: this.email,
            password: this.password
          }
        }).catch(error => {
          this.errorMessage = error.response.data.message;
          this.errors = error.response.data.errors;
          this.snackbar = true;
        }).finally(() => {
          this.loading = false;
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
