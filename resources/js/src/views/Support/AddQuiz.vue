<template>
  <v-card>
        <v-row  class=" mt-4">



          <v-col
           
            md="6"
            class="ml-4"
          >
            <v-select
              item-text="nom"
              item-value="id"
              v-model="actviteId"
              label="Activité *:"
              :items="activitys"
        
            ></v-select>
          </v-col>

          <v-col
       
            md="5"
            class="ml-4"
          >
            <v-select
             item-text="nom"
             v-model="serviceId"
              item-value="id"
              label="Service *:"
              
              :items="servicesOption"
            ></v-select>
          </v-col>
        </v-row>
        <v-row>
            <v-col
            cols="6"
            md="6"
            sm="6"
            lg="6"
          >
            <v-text-field
              outlined
              dense
               class="ml-4 mt-4" 
              v-model="nom"
              label="Nom du quiz *:"
            ></v-text-field>
          </v-col>
          <v-col cols="6" md="6"  sm="6" lg="6">
            <v-select
             item-text="nom"
             v-model="site"
              item-value="nom"
              label="Site *:"
              
              :items="sites"
            ></v-select>
          </v-col>
        </v-row>

   <v-row class=" mb-4 mt-4 d-flex float-right">
       <v-col  cols="6"
            md="6"
            
           >
            <v-col md="4" >
            <v-btn
            outlined
            color="success"
             small
             @click="simpleQuizPush"
            >
                Quiz 
            </v-btn>
         
            </v-col>
        
       </v-col>
         <v-col  cols="6"
            md="6"
           >
            <v-col md="4">
            <!-- <v-btn
            outlined
            color="info"
             small
              @click="finaleQuizPush"
            >
                Quiz final
            </v-btn> -->
         
            </v-col>
        
       </v-col>
        
       
            
        </v-row>
  </v-card>
</template>
<script>
import store from '../../store/index.js'
import Swal from 'sweetalert2'
import AddVideo from './AddVideo.vue'
import WatingBar from './WaitingBar.vue'
  export default {
    data () {
      return { 
        types : [{
          id:1,
          value :'fi'
        },
        {
                id:2,
          value :'fc'
        }],
        sites : [
          {
            id: 1,
            nom : 'TA'
          },
          {
            id : 2,
            nom : 'TE'
          },
          {
            id:3,
            nom : 'HO',

          },
          {
            id : 4,
            nom : 'BDX'
          },
          {
            id : 5,
            nom : 'NSL'
          }
        ],
        type : '',
        myformations : [],
        myformation : '',
        nom : '',
        wating: false,
        file : '',
        activitys : [],
        serviceId : '',
        actviteId : '',
        nom : '',
        tab: null,
        site : '',
        items: [
          'Simple quiz', 'finale Quiz', , 
        ],
      }
    },
    components: {
        AddVideo,
        WatingBar
    },
    methods : {
       getmyformations(){
      store.dispatch('getmyformationsAll')
      .then((response)=>{
        this.myformations = response.data
      })
    },
        finaleQuizPush(){
        if( !this.serviceId ){
        Swal.fire({
            icon: 'error',
            title: "Vous devez choisir l'activité et le service du quiz",
            showConfirmButton: false,
            timer: 3000
            })
            }
            else {
            this.$router.push({ name: 'start-finale-quiz' ,params: { id: this.serviceId , nom : this.nom } })
            }
           
          
        },
        simpleQuizPush(){
           if(!this.serviceId){
                  Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir l'activité et le service du quiz",
                        showConfirmButton: false,
                        timer: 3000
                        })
           }
           else {
               this.$router.push({ name: 'start-simple-quiz' ,params: { id: this.serviceId ,nom : this.nom, site: this.site} })
           }
           
        },
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

  
    },
    mounted(){
     this.getActivities()
     this.getServices()
      this.getmyformations()
    },
    computed : {
    servicesOption(){if(this.actviteId){
        const serv =this.services.filter(x=>
          x.activite_id === this.actviteId
        )
         return serv
    }
    },
    myformationsOption(){
    if(this.actviteId){
            const serv =this.myformations.filter(x=>
              x.activite === this.actviteId
            )
            return serv
    }
    }
    }
  }
</script>