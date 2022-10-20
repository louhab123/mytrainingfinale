<template>
    <v-row class="mt-4">
          <v-col
            cols="12"
            md="6"
             class="mt-4"
          >
            <v-text-field
              outlined
              dense
              
              v-model="nom"
              label="Nom de la vidéo *:"
              class="mt-9"
            ></v-text-field>
          </v-col>
          <v-col
            cols="12"
            md="6"
           
          >
    <v-tabs v-model="tab" show-arrows>
      <v-tab v-for="tab in tabs" :key="tab.icon">
        <v-icon size="20" class="me-3">
          {{ tab.icon }}
        </v-icon>
        <span>{{ tab.title }}</span>
      </v-tab>
    </v-tabs>
       <v-tabs-items v-model="tab">
      <v-tab-item>
           <v-file-input
                ref="file"
                type="file"
                @change="onFileChange"
                accept="mp4/*"
                label="Video *:"
            ></v-file-input>
      </v-tab-item>

      


    </v-tabs-items>
       
          </v-col>
             <v-row class="ml-4 mt-4 mb-4">
            <v-btn
            outlined
            color="primary"
            @click="SendRequestValidate"
            >
                Terminer
            </v-btn>
        </v-row>
        <v-dialog v-model="wating" max-width="400">
            <v-card>
                <v-card-text>
                    <wating-bar></wating-bar>
                </v-card-text>
            </v-card>
        </v-dialog>
        </v-row>
</template>
<script>
import {  mdiAccountMultiplePlusOutline, mdiAccountGroupOutline  } from '@mdi/js'
import Swal from 'sweetalert2'
import store from '../../store/index.js'
import WatingBar from './WaitingBar.vue'
export default {
    props:{
        actviteId: '',
        serviceId: '',
        
    },
    components: {
        WatingBar
    },
    data(){
    return {
    wating:false,
    url:'',
    nom : '',    
    tab: '',
    file : '',
    tabs : [
      { title: 'Depuis Votre ordinateur ', icon: mdiAccountGroupOutline  },
    ]
        }
    },
    methods:{
         onFileChange(file) {
             this.file = file
 
        },
        SendRequestValidate(){
            if(!this.nom  || !this.actviteId || !this.serviceId ){
                    if(!this.nom){
                    Swal.fire({
                    icon: 'error',
                    title: 'Vous devez attribuer un nom au module ',
                    showConfirmButton: false,
                    timer: 3000
                    })
              }
              if(!this.serviceId){
                   Swal.fire({
                    icon: 'error',
                    title: 'Vous devez attribuer un service au module',
                    showConfirmButton: false,
                    timer: 3000
                    })
              }
              if(!this.actviteId){
                    Swal.fire({
                    icon: 'error',
                    title: 'Vous devez attribuer une activité au module ',
                    showConfirmButton: false,
                    timer: 3000
                    })
              }
            //   if(this.file == '' ||  !this.url ){
            //          Swal.fire({
            //         icon: 'error',
            //         title: 'Vous devez injecter la video',
            //         showConfirmButton: false,
            //         timer: 3000
            //         })
            //   }
            }
            else {
                this.sendRequest()
            }
        },
        sendRequest(){
        this.wating = true
        var formData = new FormData()
        formData.append('nom', this.nom)
        formData.append('activiteId', this.actviteId)
        formData.append('serviceId',this.serviceId)
        formData.append('file', this.file)
        formData.append('ytp_url', this.url)
        store.dispatch('addVideo',formData)
        .then((response)=>{
                 if(response.status ==200){
                  Swal.fire({
                    icon: 'success',
                    title: 'Ressource ajoutée',
                    showConfirmButton: false,
                    timer: 3000
                    })
                    .then(()=>{
                        this.wating= false
                        this.$router.go(0)
                    })
            }
        })
        }
    
    }
}
</script>