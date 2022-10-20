<template>
 <v-card flat class="pa-3 mt-2">
   <v-card-title>
     <h3>Ajouter un nouveau utilisateur :</h3>
   </v-card-title>
   <v-card-text>
     <v-row>
       <v-col cols="5" md="5" lg="5" sm="5"/>
       <v-col cols="3" md="3" lg="3" sm="3">
        <v-avatar rounded size="150" class="ml-4">
        <v-img :src="require('@/assets/images/avatars/1.png').default"></v-img>
        </v-avatar>
       </v-col>
       <v-col cols="4" md="4" lg="4" sm="4"/>
     </v-row>
   </v-card-text>
    <v-card-text>
      <v-form class="multi-col-validation mt-6">
        <v-row>
          <v-col md="6" sm="6" lg="6" cols="6">
            <v-text-field  v-model="user.nom" label="Nom : *" dense outlined class="mt-2" ></v-text-field>
          </v-col>
          <v-col md="6" sm="6" lg="6" cols="6">
            <v-text-field  v-model="user.prenom" label="Prenom : *" dense outlined class="mt-2" ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col md="6" sm="6" lg="6" cols="6">
            <v-text-field  v-model="user.email" label="Email : *" dense outlined class="mt-2" ></v-text-field>
          </v-col>
          <v-col md="6" sm="6" lg="6" cols="6">
            <v-text-field  v-model="user.password" label="Password : *" dense outlined class="mt-2" ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6" md="6" sm="6" lg="6">
            <v-select v-model="user.role" @change="roleandactvite()" item-text="nom" item-value="nom" dense outlined label="Profil  : * " :items="roles" class="mt-2" ></v-select>
          </v-col>
          <v-col v-if="addActvivite">
             <v-select item-text="nom" multiple item-value="id" v-model="user.actviteId" label="Activité :" :items="activitys"></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-alert color="warning" text class="mb-0">
              <div class="d-flex align-start">
                <v-icon color="warning">{{ icons.mdiAlertOutline }}</v-icon>
                <div class="ms-3">
                  <p class="text-base font-weight-medium mb-1">
                    Veuillez remplir tous les champs svp 
                  </p>
                </div>
              </div>
            </v-alert>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
    <v-card-actions>
     <v-row>
       <v-col col="10" md="10" sm="10" lg="10"/>
       <v-col col="2" md="2" sm="2" lg="2" >
          <v-btn color="warning" outlined @click="addUser()">Enregistrer</v-btn>
       </v-col>
     </v-row>
    </v-card-actions>
 </v-card>
</template>
<script>
import { mdiAlertOutline, mdiCloudUploadOutline } from '@mdi/js'
import Swal from 'sweetalert2'
import store from '../../store/index.js'
export default {
    data(){
        return {
            addActvivite : false,
            user: {
              nom :'',
              prenom : '',
              email : '',
              password : '',
              role : '',
              actviteId : '',
            },
            icons: {
              mdiAlertOutline,
              mdiCloudUploadOutline,
            },
            roles: [
              {
              id: 1,
              nom: 'formateur'
              },
              {
                id:2,
                nom : 'client',
              },
               {
                id:2,
                nom : 'admin',
              }
            ],
            activitys : [],
        }
    },
    methods :{
      roleandactvite(){
        if(this.user.role==='client'){
            this.addActvivite = true
        }
         if(this.user.role==='formateur'){
            this.addActvivite = false
        }
      },
      addUser(){
        if(!this.user.nom || !this.user.prenom || !this.user.email || !this.user.password || !this.user.role || (this.user.role==='client' && !this.user.actviteId)){
          if(!this.user.nom){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir le nom ",
                        showConfirmButton: false,
                        timer: 3000
              })
            }
         else if(!this.user.prenom){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir le prenom",
                        showConfirmButton: false,
                        timer: 3000
              })
            }
            else   if(!this.user.email ){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir l'email",
                        showConfirmButton: false,
                        timer: 3000
              })
            }
             else  if(!this.user.password){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir le mot de passe ",
                        showConfirmButton: false,
                        timer: 3000
              })
            }
             else  if(!this.user.role){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir le profil ",
                        showConfirmButton: false,
                        timer: 3000
              })
            }
            else if((this.user.role==='client' && !this.user.actviteId)){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir l'activite",
                        showConfirmButton: false,
                        timer: 3000
              })
            }
        }
        else {
          const User = this.user
          store.dispatch('AddNewUser',User)
          .then((response)=>{
            if(response.status==200){
          Swal.fire({
          icon: 'success',
          title: ' utitlisateur a éte bien ajouter ',
          showConfirmButton: true,
          timer: 3000
        }).then(()=>{
          this.$router.go(0)
        })
            }
         })
        }
      }
    },
    created(){
        store.dispatch('getActivities')
        .then((response)=>{
        this.activitys = response
        })
        .catch(err=>{
            console.log(err)
        })
    }
}
</script>
