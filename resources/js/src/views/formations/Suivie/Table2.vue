
<template>
<div>
   <WaitingVue v-if="!data"/>
     <v-row v-if="nodata && data">
          <v-col>
            <v-card>
                    <v-card-title class="h-100 justify-content-center align-items-center">
                    <h6 class="mx-auto" >
                               
                                Aucune  formation trouvée 
                    </h6>
                    </v-card-title>
            </v-card>
          </v-col>
      </v-row>
<v-row v-if="data && !nodata">
  <v-col cols="12" md="12" sm="12" lg="12" >
    <v-card>
      <v-card-title>
       <h2 class="mx-auto">
          filtrer par date de début et de fin de formation :
       </h2>
      </v-card-title>
      <v-card-text>
      <v-row>
        <v-col md="12" sm="12" lg="12" class="mt-4">
            <v-row>
                <v-col cols="4" class="mt-6">
                  <v-icon>
                    {{ mdiCalendar  }}
                </v-icon>
                  Période (la date de début et de fin de formation):
                </v-col>
                <v-col cols="2"/>
                <v-col cols="6">
                  <flatPickr
                  v-model="date"
                  :config="config"
                  class="form-control mt-4"
                  placeholder="Choisissez une période ..."
                  style="  border: 2px solid whitesmoke;
                  border-radius: 10px;
                  padding: 12px 10px;
                  text-align: center;
                  margin-left 20%;
                  width: 100%;"
                  >
                 </flatPickr>
                </v-col>
            </v-row>
        </v-col>
      </v-row>
      </v-card-text>
          <v-card-actions>
          <v-row class="d-flex">
              <v-col md="8" sm="8" lg="8"/>
               <v-col  md="4" sm="4" lg="4" class=" float-right">
                  <v-btn
                  class="ma-2 float-right"
                  outlined
                  color="warning"
                
                   >
                  Effacer
                </v-btn>
                 <v-btn
                   class="ma-2 float-right"
                   outlined
                   color="primary"
                   >
                  Valider
                </v-btn>
              </v-col>
            </v-row>
      </v-card-actions>
    </v-card>
  </v-col>
</v-row>
<v-row class="mt-6" v-if="data">
 <v-col cols="12" md="12" sm="12" lg="12" >
     <v-card flat class="pa-3 mt-2">
        <v-card-title>
          <h2 class="mx-auto"> Tableau de suivi des formations</h2>
        </v-card-title>
        <v-card-text class="mt-6">
            <v-data-table :headers="headers" :items="formationsList" :items-per-page="10">
                <template v-slot:item.statut="{ item }">
            <v-chip outlined color="success" v-if="item.statut==='non cloturé'">Non cloturé</v-chip>
            <v-chip color="error" outlined v-if="item.statut==='cloturé'">Cloturé</v-chip>
          </template>
          <template v-slot:item.action="{ item }">
            <v-menu >
              <template v-slot:activator="{ on, attrs }" >
                <v-icon dark v-bind="attrs"  color="black"  v-on="on">{{mdiDotsHorizontal}}</v-icon>
              </template>
                <v-list>
                  <v-list-item>
                    <v-list-item-title style="cursor:pointer" @click="push(item.vague.id)">
                    <v-icon>
                      {{mdiTransitTransfer}}
                    </v-icon>
                     Déclaration de l'état de présence
                    </v-list-item-title>
                  </v-list-item>
                  <v-list-item >
                    <v-list-item-title @click="push2(item.vague)" style="cursor:pointer" >
                      <v-icon>
                        {{mdiCardAccountDetails}}
                      </v-icon>
                      Détail de l'état de présence 
                    </v-list-item-title>
                  </v-list-item>
                   <v-list-item >
                    <v-list-item-title @click="push3(item.vague)" style="cursor:pointer" >
                      <v-icon>
                        {{mdiTextBoxMultipleOutline}}
                      </v-icon>
                    Cumul des heures de formation
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
import store from '../../../store/index.js'
import WaitingVue from './Waiting.vue'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import { mdiCalendar,mdiGoogleMaps,mdiDotsHorizontal,mdiTransitTransfer, mdiCardAccountDetails,mdiTextBoxMultipleOutline } from '@mdi/js'

export default {
  components : {
      WaitingVue,
      flatPickr
  },
    data(){
            return {
              config: {
                mode: 'range',
                maxDate: "today",
                dateFormat: 'd/m/Y',
                 },
              date : [],
              mdiCalendar,
              mdiGoogleMaps, 
              mdiDotsHorizontal,
              mdiCardAccountDetails,
              mdiTransitTransfer,
              mdiTextBoxMultipleOutline,
              formationsList: [], 
              headers: [
                  { text: 'nom de la formation', value: 'nom' , class: 'text-center' },
                  { text: 'activité', value: 'activite',  class: 'text-center' },
                  { text: 'service', value: 'service',  class: 'text-center'},
                  { text: 'formateur', value: 'user' ,  class: 'text-center'},
                  { text: 'type de formation', value: 'type',  class: 'text-center' },
                  { text: 'Date début', value: 'startDate' ,  class: 'text-center' },
                  { text: 'Site', value: 'site' ,  class: 'text-center' },
                  { text: 'Date fin', value: 'endDate' ,  class: 'text-center'},
                   { text: 'Action', value: 'action' ,  class: 'text-center' },
              ],
              
              expanded : [],
              data : false,
              nodata : false
            }
    },
     mounted(){
     this.getFormations()
  },
  methods: {
  getFormations(){
    store.dispatch('getFormationsgetAll')
    .then(response=>{
      if(response.data ==='nodatafound')
      {
        this.nodata = true
      }
      else {
        this.formationsList = response.data
      }
        
    })
  .then(()=>{
    this.data = true
    this.nodata = false
  })
},
  push(id){
    this.$router.push({
      name:'detail-formation', params: { id }
    })
  },
  push2(formation){
   
    this.$router.push({ name: 'getDetailsStateOfPrsence', params: { formation_type: formation.formation_type,formation_id:formation.formation_id } })
  },
  push3(formation){
  
     this.$router.push({ name: 'getComuleStateOfPresence', params: { formation_type: formation.formation_type,formation_id:formation.formation_id } })
  }
  },
  setup() {

  },
}
</script>
