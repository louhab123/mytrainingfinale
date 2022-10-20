<template>
  <v-card flat class="pa-3 mt-2">
    <v-card-text class="d-flex">
      <v-col cols="6"  offset="3" sm="4" md="6" class="d-none d-sm-flex justify-center position-relative">
        <v-img contain max-width="170" :src="require('@/assets/images/3d-characters/pose-m-1.png').default" class="security-character"></v-img>
      </v-col>
    </v-card-text>
    <v-card-text>
    <v-col cols="12" md="12" sm="12" lg="12" >
      <v-alert color="warning" text class="mb-0" >
        <div class="d-flex align-start">
          <v-icon color="warning">{{ icons.mdiAlertOutline }}</v-icon>
            <div class="ms-3">
              <a href="javascript:void(0)" class="text-decoration-none warning--text">
                <span class="text-sm">Veuillez Choisir les agents  !! </span>
              </a>
            </div>
        </div>
      </v-alert>
    </v-col>
     <v-spacer></v-spacer>
      <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
      <v-data-table  :loading="loading" loading-text="veuillez attendre pour  le chargement des agents ... " :headers="headers" :items="agentList" :search="search" :class="{ 'primary': isSelected }" :items-per-page="10">  
        <template v-slot:item.nom="{ item }">
          <v-icon>
                {{mdiAccount}}
          </v-icon>
          {{item.nom}}
        </template>
         <template v-slot:item.glutenfree="{ item }">
            <v-simple-checkbox v-model="item.glutenfree" @click="handleClick(item)" disabled></v-simple-checkbox>
          </template>
      </v-data-table>
    </v-card-text>
    <v-card-actions>
       <v-row>
          <v-col cols="12" md="12" sm="12"  >
            <v-btn color="primary" class="me-3 mt-4" @click.prevent="addAgent">Enregistrer</v-btn>
          </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mdiAlertOutline, mdiCloudUploadOutline, mdiAccount } from '@mdi/js'
import store from '../../store/index.js'
import Swal from 'sweetalert2'

export default {
  props: {
    WaveId: {
      type: Number,
      default: () => 0,
    },
  },
  data(){
    return {
       search: '',
      agentList : [],
      item: {},
      isSelected: false,
      loading : false ,
      mdiAccount,
    }
  },
  methods:{
    handleClick(row){
      this.agentList.map((item) => {
       if( item.id === row.id) {
       item.glutenfree =true
         }
  })
    },
    addAgent(){
      const selectedAgent = []
      this.agentList.map(x=>{
     if(x.glutenfree === true){
       selectedAgent.push(x)
     }
   }
   
   )
 const agents = {
   agents : selectedAgent,
   waveId : this.WaveId
 }
   store.dispatch('selectedAgent',agents)
     .then((response)=>{
            if(response.status==200){
          Swal.fire({
          icon: 'success',
          title: ' les agents ont été affectés a cette formation ',
          showConfirmButton: true,
          timer: 3000
        }).then(()=>{
          this.$router.go(0)
        })
            }
         })
    },
    getAgents() {
      this.loading = true 
      store.dispatch('getAgents')
      .then((response)=>{
      this.agentList = response
       })
       .then(()=>{
        this.loading = false 
        })
        .catch(err=>{
          console.log(err)
          Swal.fire({
          icon: 'error',
          title: ' une erreur a été produite , veuillez réessayer ultérieurement ',
          showConfirmButton: true,
          timer: 3000
        })
        })
    }
  },
  mounted(){
     this.getAgents()
  },
  setup() {
       const statusColor = {
      /* eslint-disable key-spacing */
      Current: 'primary',
      Professional: 'success',
      Rejected: 'error',
      Resigned: 'warning',
      Applied: 'info',
      /* eslint-enable key-spacing */
    }

    return {
      headers: [
        { text: 'nom', sortable: true, value: 'nom' },
        { text: 'email', sortable: true, value: 'email' },
        { text: 'activite', sortable: true, value: 'activite' },
        { text: 'service', sortable: true, value: 'service' },
        { text: '', value: 'glutenfree' },

      ],
      status: {
        1: 'Current',
        2: 'Professional',
        3: 'Rejected',
        4: 'Resigned',
        5: 'Applied',
      },
      statusColor,

      // icons
      icons: {
  mdiCloudUploadOutline,
  mdiAlertOutline,
      },
      
    }
  },
}
</script>
<style >
.primary,
.primary:hover {
  /** avoid using !important, added just for example**/
  background-color: red !important;
}
</style>
