<template>
<div>
     <v-row  v-if="!data">
        <v-col cols="12" md="12" sm="12" lg="12">
                <v-card class="text-center">
                    <v-card-text>
                        <WaitingBarVue/>
                    </v-card-text>
                </v-card>
        </v-col>
    </v-row>
  <v-row v-else>
     
      <v-col cols="12" md="12" sm="12" lg="12">
        <v-card class="mx-auto my-12" max-width="100%">
          <v-card-title>
            <v-row>
               <v-dialog v-model="dialog" width="500">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" outlined  dark v-bind="attrs" v-on="on">Ajouter un service </v-btn>
                </template>
                <v-card>
                    <v-card-title class="text-h5 grey lighten-2">Ajouter un service </v-card-title>
                    <v-card-text>
                        <v-text-field
                        v-model="nom"
                        label="Nom*: "
                        dense
                        outlined
                        ></v-text-field>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="addService">
                        Enregistrer 
                    </v-btn>
                    </v-card-actions>
                </v-card>
               </v-dialog>
            </v-row>
          </v-card-title>
            <v-card-title><h3 class="mx-auto">Liste des Services  :</h3>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="12" lg="12" sm="12">
                        <v-card>
                            <v-card-title><h3  class="mx-auto">{{activitie.nom}}</h3></v-card-title>
                            <v-card-text class="d-flex">
                                <v-avatar rounded size="120" class="me-6">
                                <v-img class="white--text align-end" height="200px" :src="src" >
                                <section v-loading="loading">azeqsdsqsfsdqsss</section>
                                </v-img>
                                </v-avatar>
                                <div>
                                    <v-btn @click="$refs.file.click()" color="info" outlined  class="me-3 mt-5"><v-icon class="d-sm-none">{{ mdiCloudUploadOutline }}</v-icon><span class="d-none d-sm-block">Changer l'image de l'activitée </span></v-btn>
                                    <input  @change="onFileChange"  ref="file" type="file"  :hidden="true"/>
                                    <p class="text-sm mt-5">Accept JPG, GIF or PNG. </p>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-text>
                <v-data-table :headers="headers" :items="services">
                 <template v-slot:item.statut="{ item }">
                    <v-chip  color="success"  outlined v-if="item.statut==='1'">
                       Active
                    </v-chip>
                    <v-chip color="error" outlined v-if="item.statut==='0'">
                       Inactive
                    </v-chip>
                    </template>
                          <template v-slot:item.action="{ item }">
                    <v-menu>
                       <template v-slot:activator="{ on, attrs }" >
                          <v-icon  color="black" dark v-bind="attrs" v-on="on">
                            {{mdiDotsHorizontal}}
                          </v-icon>
                       </template>
                       <v-list>
                            <v-list-item>
                            <v-list-item-title>
                                <p outlined color="info" style="cursor:pointer" @click="handleClick(item)">
                                Modifier
                                </p>
                            </v-list-item-title>
                            </v-list-item>
                            <v-list-item >
                            <v-list-item-title>
                                <p @click="handlItem(item)" style="cursor:pointer" outlined color="success" v-if="item.statut==='0'">
                                Activer
                                </p>
                                <p color="error" style="cursor:pointer"  @click="handlItem(item)" outlined v-if="item.statut==='1'">
                                Desactiver 
                                </p>
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                       </v-menu>
                </template>
                </v-data-table>
            </v-card-text>
        </v-card>
      </v-col>
  </v-row>
</div>
</template>
<script>
import store from '../../store/index.js'
import WaitingBarVue  from './WaitingBar'
import Swal from 'sweetalert2'
import { mdiCloudUploadOutline,mdiDotsHorizontal } from '@mdi/js'
export default {
    data(){
        return {
            headers: [
                 { text: 'Service', value: 'nom',  class: 'text-center' },
                 { text: 'statut', value: 'statut',  class: 'text-center'},
                 {text : 'Action', value : 'action'}
            ],
            mdiCloudUploadOutline,
            mdiDotsHorizontal,
            services : [],
            data: false,
            dialog: false,
            nom : '',
            src : null,
            loading : false,
            file : '',
            activitie : {},

        }
    }, 
    created(){
        this.getServices()
    },
    methods: {
        handlItem(item){
           
           const service_id  = {
            id : this.$route.params.id
           } 
            store.dispatch('handlService',service_id)
            .then((response)=>{
                if(response.status===200){
                    Swal.fire({
                        icon: 'Sucess',
                        title: "Service a été bien chnagé",
                        showConfirmButton: false,
                        timer: 3000
                    }).then(()=>{
                     this.$router.go(0)
                    })
                }
            })
        },
        handleClick(item){
      
         this.$router.push({name:'edit-service' , params : { id : item.id}})  
        },
        onFileChange(e) {
           this.loading = true
            this.file = e.target.files[0];
            this.changeImage()
        },
        changeImage(){
           var formData = new FormData()
           formData.append('activitie_id', this.$route.params.id)
           formData.append('file', this.file)
           store.dispatch('changeActivitieImage', formData)
           .then((response)=>{
               console.log(response.data)
               this.src = response.data.image_url
           })
           .then(()=>{
               this.loading = false
           })
        },
        getServices(){
            const id = this.$route.params.id
            store.dispatch('getServices2',id).
            then((response)=>{
                this.services = response.data.services
                this.activitie = response.data.activitie
                if(response.data.image_url === ""){
                    this.src = 'https://cdn.vuetifyjs.com/images/cards/docks.jpg'
                }
                else {
                    this.src = response.data.image_url
                }
            })
            .then(()=>{
                this.data= true
            })
            .catch((err)=>{
                console.log(err)
            })
        },
        addService(){
            if(!this.nom){
                 Swal.fire({
                    icon: 'error',
                    title: 'Vous devez renseigner le nom du service ',
                    showConfirmButton: false,
                    timer: 1500
                    })
            }
            else {
            const actvite = this.$route.params.id;
            const nom = this.nom;
            const data = {
                nom : nom,
                activite_id : actvite
            }
            store.dispatch('addService',data)
            .then((response)=>{
                if(response.status===200){
                    Swal.fire({
                    icon: 'success',
                    title: 'le service a été ajouté avec Succès ',
                    showConfirmButton: false,
                    timer: 1500
                    }).then(()=>{
                        this.$router.go(0)
                    })
                }
            })
            }
          
        }
    },
    components: {
        WaitingBarVue,
    }
}
</script>