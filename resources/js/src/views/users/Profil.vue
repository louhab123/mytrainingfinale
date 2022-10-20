<template>
 <v-card flat class="pa-3 mt-2">
   <v-card-title>
     <h3>{{user.nom}}  {{user.prenom}} </h3>
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
            <v-text-field  v-model="user.password" label="Password : *" type="password" dense outlined class="mt-2" ></v-text-field>
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
          <v-btn color="warning" outlined @click="handlUpdate" >Modifier</v-btn>
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
              id : '',  
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
        handlUpdate(){
          if(!this.user.nom || !this.user.prenom || !this.user.email || !this.user.password ){
                if(!this.user.nom){
                  Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir le nom ",
                        showConfirmButton: false,
                        timer: 3000
                          })
                }
                else if(!this.user.prenom ){
                      Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir le prenom ",
                        showConfirmButton: false,
                        timer: 3000
                          })
                }
                else if(!this.user.email){
                      Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir l'email ",
                        showConfirmButton: false,
                        timer: 3000
                          })
                }
                else if(!this.user.password){
                     Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir le mot de passe  ",
                        showConfirmButton: false,
                        timer: 3000
                          })
                }
          } 
          else {
              const user = this.user
              store.dispatch('updateUser',user)
              .then((response)=>{
                   if(response.status==200){
                    Swal.fire({
                    icon: 'success',
                    title: ' votre profil a éte bien modifié ',
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
        store.dispatch('getCurrentUser')
        .then((response)=>{
            this.user.id = response.data.user.id
            this.user.nom = response.data.user.nom
            this.user.prenom = response.data.user.prenom
            this.user.email = response.data.user.email
            this.user.role = response.data.user.role
            this.user.password = response.data.user.password
            this.user.actviteId = response.data.user.actviteId
        })
    }
}
</script>
