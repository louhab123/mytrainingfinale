<template>
 <div>
   <v-menu offset-y left nudge-bottom="14" min-width="230" content-class="user-profile-menu-content">
    <template v-slot:activator="{ on, attrs }">
      <v-badge bottom color="success" overlap offset-x="12" offset-y="12" class="ms-4" dot>
        <v-avatar size="40px" v-bind="attrs" v-on="on">
          <v-img :src="require('@/assets/images/avatars/1.png').default"></v-img>
        </v-avatar>
      </v-badge>
    </template>
    <v-list>
      <div class="pb-3 pt-2">
        <v-badge bottom color="success" overlap offset-x="12" offset-y="12" class="ms-4" dot>
          <v-avatar size="40px">
            <v-img :src="require('@/assets/images/avatars/1.png').default"></v-img>
          </v-avatar>
        </v-badge>
        <div class="d-inline-flex flex-column justify-center ms-3" style="vertical-align: middle">
          <span class="text--primary font-weight-semibold mb-n1"> {{this.user.name}} </span>
          <small class="text--disabled text-capitalize">{{this.user.role}}</small>
        </div>
      </div>

      <v-divider></v-divider>

      <!-- Profile -->
      <v-list-item link>
        <v-list-item-icon class="me-2">
          <v-icon size="22">
            {{ icons.mdiAccountOutline }}
          </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title @click="profil()">Profile</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-list-item link @click="logout()">
        <v-list-item-icon class="me-2">
          <v-icon size="22">
            {{ icons.mdiLogoutVariant }}
          </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title >Déconnexion</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-menu>
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
import store from '../../store/index.js'
import {mdiLogoutVariant,mdiAccountOutline} from '@mdi/js'
export default {
    data(){
    return{
      user : {
        name: '',
        role: '',
      },
      icons: {
        mdiLogoutVariant, 
        mdiAccountOutline       
      },
      dialog:false,
    }
     },
    methods: {
        logout(){
          this.dialog = true
          store.dispatch('logout')
          .then(()=>{
          sessionStorage.removeItem('TOKEN')
          sessionStorage.removeItem('user')
          sessionStorage.removeItem('role')
          sessionStorage.removeItem('userId')
          sessionStorage.removeItem('ability')
          this.dialog = false
          this.$router.push({name: 'pages-login'})
          })
         },
        profil(){
            this.$router.push({name: 'profil'})
        }
    },
    
  created(){
    this.user.name = sessionStorage.getItem('user')
    this.user.role = sessionStorage.getItem('role')
    
  },
}
</script>

<style lang="scss">
.user-profile-menu-content {
  .v-list-item {
    min-height: 2.5rem !important;
  }
}
</style>
