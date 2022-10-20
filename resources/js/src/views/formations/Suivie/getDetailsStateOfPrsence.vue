
<template>
<div>
      <v-row>
          <v-col
      cols="12"
      md="12"
    >
      <dashboard-statistics-card></dashboard-statistics-card>
    </v-col>
    </v-row>
 <v-card
   flat
    class="pa-3 mt-2"
 >

 <h2 class="mb-4 d-flex justify-center">
     Détail de l'état de présence par agent :
 </h2>
 <v-btn
 outlined
        color="info"
        @click="routeur"
 >
    <v-icon v-text="icons.mdiArrowLeftBold"> </v-icon>
 </v-btn>
        <v-text-field
        v-model="search"
        :append-icon="icons.mdiAccountGroupOutline "
        label="Search "
        single-line
        hide-details
      ></v-text-field>
      <v-data-table
    :headers="headers"
     :search="search"
    :items="formationsList"
    :items-per-page="10"
  >
   <template #[`item.etat`]="{item}">
      <div class="d-flex align-center">
     
        <div class="d-flex flex-column ms-3">
          <span class="d-block font-weight-semibold text--primary text-truncate"> 
             
                <v-btn
      text
      v-if="item.etat==='Présent'"
      color="success"
    >
       {{ item.etat }} </v-btn>
         <v-btn
      text
      v-if="item.etat==='Retard'"
      color="warning"
    >
       {{ item.etat }} </v-btn>
         <v-btn
      text
      v-if="item.etat==='Absent'"
      color="info"
    >
       {{ item.etat }} </v-btn>
        <v-btn
      text
      v-if="item.etat==='Abandon'"
      color="error"
    >
       {{ item.etat }} </v-btn>

     </span> 
        </div>
      </div>
    </template>

  </v-data-table>
 </v-card>
</div>
</template>

<script>
import store from '../../../store/index.js'
import { mdiArrowLeftBold,mdiAccountGroupOutline  } from '@mdi/js';

export default {
  components : {
      
  },
    data(){
            return {
                icons : {
                    mdiArrowLeftBold,
                    mdiAccountGroupOutline 
                },
                search: '',
               formationsList: [], 
                   headers: [
                  { text: 'agent', value: 'agent' , class: 'text-center' },
                  { text: 'état', value: 'etat',  class: 'text-center' },
                  { text: 'date', value: 'date',  class: 'text-center'},
                  { text: 'startTime', value: 'startTime' ,  class: 'text-center'},
                  { text: 'endTime', value: 'endTime',  class: 'text-center' },
        
      ],
      expanded : [],
            }
    },
     mounted(){
     this.getDetailsStateOfPrsence()
  },
  methods: {
      routeur() {
this.$router.push({path: '/suivi-fi-fc'})
      },
  getDetailsStateOfPrsence(){

    const details={
    formation_type:  this.$route.params.formation_type,
    formation_id :this.$route.params.formation_id
    }
   store.dispatch('getDetailsStateOfPrsence',details)
   .then((response)=>{
      this.formationsList = response.data
   })
   
  }
  },
  setup() {

  },
}
</script>
