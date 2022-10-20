<template>
  <v-card>
    <v-toolbar
      color="cyan" info flat>
      <v-toolbar-title style="border-bottom : 1px solid #9155fd">Ajouter un support de formation : </v-toolbar-title>
      <v-spacer></v-spacer>
      <template v-slot:extension>
        <v-tabs v-model="tab" align-with-title>
          <v-tabs-slider color="yellow"></v-tabs-slider>
          <v-tab v-for="item in items" :key="item">
            {{ item }}
          </v-tab>
        </v-tabs>
      </template>
    </v-toolbar>

    <v-tabs-items v-model="tab">
        <!--module-->
      <v-tab-item>
        <v-card class="mt-4" >
          <v-card-text class="mt-4">
            <v-row class="mt-4">
                <v-col cols="6" class="mt-4" lg="6" sm="6" md="6">
                    <v-text-field outlined dense v-model="nom" label="Nom du module *:"></v-text-field>
                </v-col>
                <v-col cols="6" lg="6" sm="6" md="6">
                    <v-select item-text="nom" item-value="id" v-model="actviteId" label="Activité *:" :items="activitys"></v-select>
                </v-col>
             </v-row>
             <v-row> 
                <v-col cols="6" md="6" lg="6" sm="6">
                  <v-select item-text="nom" v-model="serviceId" item-value="id" label="Service *:" :items="servicesOption"></v-select>
                </v-col>
                <v-col cols="6" md="6" lg="6" sm="6">
                  <v-file-input ref="file" type="file" @change="onFileChange" accept="pdf/*" label="Support de formation *:"></v-file-input>
                </v-col>
             </v-row>
          <v-row class="ml-4 mt-4 mb-4">
              <v-btn outlined color="primary" @click="SendRequestValidate">Terminer</v-btn>
          </v-row>
          </v-card-text>
        </v-card>
      </v-tab-item>     
      <!--Quiz-->
      <v-tab-item>
        <add-quiz></add-quiz>
      </v-tab-item>
      <!--Video-->
      <v-tab-item>
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="6">
                  <v-select item-text="nom" item-value="id" v-model="actviteId" label="Activité *:" :items="activitys"></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-select item-text="nom" v-model="serviceId" item-value="id" label="Service *:" :items="servicesOption"></v-select>
              </v-col>

              </v-row>
              <add-video :actviteId="actviteId" :serviceId="serviceId" ></add-video>
          <v-row>
           
          </v-row>
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
       <v-dialog v-model="wating" max-width="400">
            <v-card>
                <v-card-text>
                    <wating-bar></wating-bar>
                </v-card-text>
            </v-card>
        </v-dialog>
  </v-card>
</template>
<script>
import store from '../../store/index.js'
import Swal from 'sweetalert2'
import AddVideo from './AddVideo.vue'
import WatingBar from './WaitingBar.vue'
import AddQuiz from './AddQuiz.vue'
  export default {
    data () {
      return { 
        types : [
          {
            id :1,
            value: 'fi'
          },
          {
            id:2,
            value : 'fc'
          }
        ],
        type : '',
        myformations : [],
        myformation : '',
        wating: false,
        file : '',
        activitys : [],
        serviceId : '',
        actviteId : '',
        nom : '',
        tab: null,
        items: [
          'Module', 'Quiz', 'Vidéos', 
        ],
      }
    },
    components: {
        AddVideo,
        WatingBar,
        AddQuiz
    },
    methods : {
    getActivities(){
       store.dispatch('getActivities')
      .then((response)=>{
       this.activitys = response
      })
      .catch(err=>{
          console.log(err)
        })
    },
    getServices(){
        store.dispatch('getServices')
      .then((response)=>{
       this.services = response
      })
      .catch(err=>{
          console.log(err)
        })
      
    },
    getmyformations(){
      store.dispatch('getmyformationsAll')
      .then((response)=>{
        this.myformations = response.data
      })
    },
    onFileChange(file) {
    this.file = file
 
        },
    SendRequestValidate(){
        if(!this.nom || !this.serviceId  || !this.actviteId || this.file == '' ) {
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
              if(this.file == ''){
                    Swal.fire({
                    icon: 'error',
                    title: 'Vous devez choisir un module de formation',
                    showConfirmButton: false,
                    timer: 3000
                    })
              }
        }
        else {
            this.sendRequest()
        }
        

    },
    sendRequest(){
        this.wating= true
        var formData = new FormData()
        formData.append('nom', this.nom)
        formData.append('activiteId', this.actviteId)
        formData.append('serviceId',this.serviceId)
        formData.append('file', this.file)
    
        store.dispatch('addResource',formData)
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
    },
    mounted(){
     this.getActivities()
     this.getServices()
    },
    computed : {
    servicesOption(){if(this.actviteId){
        const serv =this.services.filter(x=>
          x.activite_id === this.actviteId
        )
         return serv
    }
    },
    }
  }
</script>