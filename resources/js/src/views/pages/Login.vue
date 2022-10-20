<template>
 <div>
   <v-row>
      <v-col  cols="7" md="7" sm="7" lg="7">
        <div class="auth-wrapper auth-v1">
         <div class="auth-inner">
            <v-img :src="require('@/assets/images/misc/login-page.jpg').default" 
            height="100%" width="100%"  class="me-3">
            </v-img>
         </div>
        </div>
      </v-col>
      <v-col cols="5" md="5" sm="5" lg="5">
        <div class="auth-wrapper auth-v1">
         <div class="auth-inner">
            <v-card  class="auth-card">
              <v-card-title class="d-flex align-center justify-center py-7">
                  <v-img :src="require('@/assets/images/logos/logo.png').default"
                  max-height="300px"
                  max-width="300px"
                  alt="logo"
                  contain
                  class="me-3"
                ></v-img>
              </v-card-title>
              <v-card-text>
                <p class="text-2xl font-weight-semibold text--primary mb-2">Bienvenue sur My'Training! 👋🏻</p>
                <p class="mb-2">Veuillez vous connecter à votre compte</p>
              </v-card-text>
              <v-card-text v-if="errorMessge">
                <v-alert color="primary" dark text>
                  Email ou le mot de passe que vous avez renseigner est incorrecte(s)
                </v-alert>
              </v-card-text>
              <v-card-text>
                <v-form @submit.prevent="login">
                  <v-text-field v-model="email" outlined label="Email" placeholder="john@example.com" hide-details class="mb-3">
                  </v-text-field>
                  <v-text-field v-model="password" outlined :type="isPasswordVisible ? 'text' : 'password'" label="Password"
                  placeholder="············"
                  :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                  hide-details
                  @click:append="isPasswordVisible = !isPasswordVisible"
                ></v-text-field>
                <v-btn type="submit" block color="primary" class="mt-6" outlined > Connexion </v-btn>
                </v-form>
              </v-card-text>
            </v-card>
         </div>
        </div>
      </v-col>
  </v-row>
  <v-dialog v-model="dialog" width="250">
      <v-card class="text-center">
        <v-card-text>  
            <v-progress-circular indeterminate color="primary"></v-progress-circular>
            <v-progress-circular indeterminate color="warning" ></v-progress-circular>
            <v-progress-circular indeterminate color="info"></v-progress-circular>
            <v-progress-circular indeterminate color="error"></v-progress-circular>
            <v-progress-circular indeterminate color="primary"></v-progress-circular>
          </v-card-text>
        </v-card>
  </v-dialog>
 </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {  mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import store from '../../store/index.js'


export default {
  data(){
    return {
      errorMessge : false,
      isPasswordVisible :false,
      dialog :false,
      email : '',
      password : '',
      icons: {
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
    }
  },
  components : {
  
  },
  methods: {
        login() {
          this.dialog = true
          const user = {
            email:this.email,
            password: this.password
          }
          store.dispatch('login',user)
          .then((response)=>{
            if(response.message !== 'incorrect') {
              this.$router.push( {name: 'dashboard' })
            }
          else {
            this.errorMessge = true
          }
          })
          .then(()=>{
             this.dialog = false
          })
      
    }
  }
}
</script>

<style lang="scss">
@import '~@resources/sass/preset/pages/auth.scss';
</style>
