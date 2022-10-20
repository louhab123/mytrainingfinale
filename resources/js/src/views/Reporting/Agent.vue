<template>
  <div>
    <v-row>
      <v-col md="12" sm="12" lg="12">
        <v-card>
        <v-toolbar color="indigo" sucess>
          <v-toolbar-title>
              Agent :
          </v-toolbar-title>
        </v-toolbar>
        <v-card-title class="h-100 justify-content-center align-items-center">
          <h3 class="mx-auto" >
            Reporting par agent :
          </h3>
        </v-card-title>
        <v-card-text>
            <v-row>
              <v-col md="6" sm="6" lg="6" class="mt-2">
                <span>
                  <v-icon>
                    {{ mdiCalendar  }}
                  </v-icon>
                   Période (la date de début et de fin de formation):
                  <flatPickr
                  v-model="date"
                  :config="config"
                  class="form-control mt-4"
                  placeholder="Choisissez une période ..."
                  style="  border: 2px solid whitesmoke;
                  border-radius: 10px;
                  padding: 12px 10px;
                  text-align: center;
                  width: 100%;"
                  >
                    
                  </flatPickr>
                </span>
              </v-col>
              <v-col md="6" lg="6" sm="6" class="mt-6">
                <span>
                  <v-select
                  :prepend-icon="mdiGoogleMaps"
                  :items="sites"
                  v-model="site"
                  label="Site :"
                  class="mt-6"
                   style="width: 100%"
                  >

                  </v-select>
                </span>
              </v-col>
            </v-row>
            <v-row>
                <v-col md="6" sm="6" lg="6">
                    <v-select
                    item-text="nom"
                    item-value="id"
                    v-model="actviteId"
                    label="Activité :"
                    :items="activitys"
                    ></v-select>
                </v-col>
                <v-col md="6" sm="6" lg="6">
                      <v-select
                        item-text="nom"
                        v-model="serviceId"
                        item-value="id"
                        label="Service :"
                        
                        :items="servicesOption"
                        ></v-select>
                </v-col>
               
            </v-row>
            <v-row>
                 <v-col md="6" sm="6" lg="6">
                     <v-select
                        item-text="vague"
                        v-model="vagueId"
                        item-value="id"
                        label="Vague :"
                        
                        :items="vaguesOption"
                        ></v-select>
                </v-col>
                 <v-col md="6" sm="6" lg="6">
                     <v-select
                        item-text="agent"
                        v-model="agentId"
                        item-value="id"
                        label="Agent :"
                        
                        :items="agentsOption"
                        ></v-select>
                </v-col>
            </v-row>
            <v-row class="d-flex">
              <v-col md="8" sm="8" lg="8"/>
               <v-col  md="4" sm="4" lg="4" class=" float-right">
                  <v-btn
                  class="ma-2 float-right"
                  outlined
                  color="warning"
                  @click="deleteItems()"
                   >
                  Effacer
                </v-btn>
                 <v-btn
                   class="ma-2 float-right"
                   outlined
                   color="primary"
                   @click="handlItems()"
                   >
                  Valider
                </v-btn>
              </v-col>
            </v-row>
        </v-card-text>
      </v-card>
      </v-col>
    </v-row>
    <v-row v-if="data && !waiting">
     <v-col md="2" lg="2" sm="2"/>
     <v-col md="8" lg="8" sm="8">
        <v-card>
        <v-card-title class="h-100 justify-content-center align-items-center">
          <h6 class="mx-auto" >
                      Veuillez choisir la période ou l'année, l'activité , le service , l'agent et  le site  
                            puis valider .
          </h6>
        </v-card-title>
      </v-card>
     </v-col>
     <v-col md="2" lg="2" sm="2"/>
    </v-row>
      <v-row v-if="waiting">
    <Waiting ></Waiting>
  </v-row>
  <v-row v-if="!data">
  <v-col cols="2" md="2" sm="2" lg="2"/>
    <v-col cols="8" md="8" sm="8" lg="8">
        <v-card>
            <v-card-title>
                     Liste des Vagues/Activités :
            </v-card-title>
            <v-card-text>
                  <v-data-table
                    :headers="headers"
                    :items="agentVagues"
                    :items-per-page="5"
                    class="elevation-1"
                ></v-data-table>
            </v-card-text>
        </v-card>
    </v-col>
    <v-col cols="2" md="2" sm="2" lg="2"/>
  </v-row>
  <v-row v-if="!data">
      <v-col cols="2" md="2" sm="2" lg="2"/>
      <v-col cols="8" md="8" sm="8" lg="8">
          <v-card>
              <v-card-title>
                     Liste des Quiz/Notes :
              </v-card-title>
              <v-card-text>
                   <v-data-table
                    :headers="headersNotes"
                    :items="agentNotes"
                    :items-per-page="5"
                    class="elevation-1"
                    >
                        <template v-slot:item="i">
                            <tr>
                             
                                <td>{{i.item.quiz}}</td>
                                <td>{{i.item.service}}</td>
                                <td>{{i.item.activite}}</td>
                                 <td :class="{
                                        'error lighten-2': i.item.note < 5, 
                                        'success lighten-4': i.item.note > 5
                                        }">{{i.item.note}}
                                 </td>
                            </tr>
                       </template>
                </v-data-table>
              </v-card-text>
          </v-card>
      </v-col>
      <v-col cols="2" md="2" sm="2" lg="2"/>
  </v-row>
  <v-row v-if="!data">
        <v-col cols="6" md="6" sm="6" lg="6">
                <v-card>
                    <v-card-title>
                        Les quiz passés par actvité :
                    </v-card-title>
                    <v-card-text>
                        <QuizAgentActiviteChartVue  :series="charts.activite.series" :categories="charts.activiteCategories"/>
                    </v-card-text>
                </v-card>
        </v-col>
        <v-col cols="6" md="6" sm="6" lg="6">
                <v-card>
                    <v-card-title>
                        Moyen des notes par actvité :
                    </v-card-title>
                    <v-card-text>
                        <MoyenNotesActvite :series="charts.Moyenactivite.series" :categories="charts.MoyenactiviteCategories" />
                    </v-card-text>
                </v-card>
        </v-col>
  </v-row>
  <v-row v-if="!data">
        <v-col cols="6" md="6" sm="6" lg="6">
                <v-card>
                    <v-card-title>
                        Les quiz passés par service :
                    </v-card-title>
                    <v-card-text>
                        <QuizAgentServiceChartVue :series="charts.service.series" :categories="charts.serviceCategories"/>
                    </v-card-text>
                </v-card>
        </v-col>
        <v-col cols="6" md="6" sm="6" lg="6">
                <v-card>
                    <v-card-title>
                        Moyen des notes par service : 
                    </v-card-title>
                    <v-card-text>
                        <MoyenNotesService  :series="charts.Moyenservice.series" :categories="charts.MoyenserviceCategories" />
                    </v-card-text>
                </v-card>
        </v-col>
  </v-row>
  </div>
</template>
<script>
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'
import Swal from 'sweetalert2'
import store from '../../store/index.js'
import { mdiCalendar,mdiGoogleMaps,mdiAccountOutline, mdiArmFlexOutline ,mdiApplicationVariableOutline ,mdiAbTesting ,mdiCurrencyUsd, mdiTrendingUp, mdiDotsVertical, mdiLabelOutline, mdiBriefcaseVariantOutline,mdiBookOpenVariant , mdiBookOpenPageVariantOutline } from '@mdi/js'
import Waiting from './Waiting.vue'
import QuizAgentActiviteChartVue from './Charts/QuizAgentActiviteChart.vue'
import QuizAgentServiceChartVue from './Charts/QuizAgentServiceChart.vue'
import MoyenNotesService from './Charts/MoyenNotesService.vue'
import MoyenNotesActvite from './Charts/MoyenNotesActvite.vue'

export default {
   data(){
     return {
           charts: {
              service: {
                series: [
                  {
                    data: [],
                  },
                ],
              },
              Moyenservice: {
                series: [
                  {
                    data: [],
                  },
                ],
              },
              serviceCategories :[],
              MoyenserviceCategories :[],
              activite: {
                series: [
                  {
                    data: [],
                  },
                ],
                  },
            Moyenactivite: {
                series: [
                  {
                    data: [],
                  },
                ],
                },  
            activiteCategories: [],
            MoyenactiviteCategories: [],
                 },
            config: {
                mode: 'range',
                maxDate: "today",
                dateFormat: 'd/m/Y',
            },
            date : [],
            mdiCalendar,
            mdiGoogleMaps ,
            mdiAccountOutline,
            mdiCurrencyUsd, 
            mdiTrendingUp,
            mdiDotsVertical,
            mdiLabelOutline,
            mdiBriefcaseVariantOutline,
            mdiBookOpenVariant , 
            mdiAbTesting ,
            mdiArmFlexOutline ,
            mdiApplicationVariableOutline ,
            mdiBookOpenPageVariantOutline,
            sites: ['TA', 'TE', 'HO', 'BDX','NSL'],
            site: '',
            data: true,
            waiting: false,
            actviteId : '',
            activitys : [],
            services: [],
            agents: [],
            agentId : '',
            serviceId : '',
            vagues  : [],
            vagueId : '',
            headers: [
            {
                text: 'Vague',
                align: 'center',
                sortable: true,
                value: 'vague',
            },
            { text: 'activite', value: 'activite',align: 'center', },
            { text: 'service', value: 'service',align: 'center', },
            ],
            agentVagues : [],
            headersNotes: [
            {
                text: 'quiz',
                align: 'center',
                sortable: true,
                value: 'quiz',
            },
            { text: 'service', value: 'service',align: 'center', },
            { text: 'activite', value: 'activite' ,align: 'center',},
            { text: 'note', value: 'note',align: 'center', },
            ],
            agentNotes : [],

     }
   },
   components: {
    flatPickr,
    Waiting,
    QuizAgentActiviteChartVue,
    QuizAgentServiceChartVue,
    MoyenNotesService,
    MoyenNotesActvite,
},
  computed: {
    servicesOption(){
        if(this.actviteId){
        const serv =this.services.filter(x=>
          x.activite_id === this.actviteId
        )
         return serv
        }
        },
  agentsOption(){
         if(this.vagueId){
        const vag =this.agents.filter(x=>
          x.vague_id   === this.vagueId
        )
         return vag
        }
        },
  vaguesOption(){
        if(this.serviceId){
        const ag =this.vagues.filter(x=>
        x.service  === this.serviceId
        )
        return ag
         }
        },
  },
   methods: {
     deleteItems(){
       this.date = []
       this.site = ''
     },
     handlItems(){
       if(this.date.length ===0 || !this.site || !this.actviteId || !this.serviceId || !this.agentId) {
         if(this.date.length ===0){
             Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir la période",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
         else if(!this.site){
            Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir le site",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
         else if(!this.actviteId){
              Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir l'activité",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
         else if(!this.serviceId){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir le service",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
         else if(!this.agentId){
               Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir l'agent",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
       }
       else {
         this.sendData()
       }
     },
     sendData(){
       this.data = true 
       this.waiting  =true
       var rangetosend = this.date
         if (typeof this.date === 'string') {
         rangetosend = rangetosend.split(' ').filter(e => e !== 'au')
         var startDay  = rangetosend[0]
         var endDay  = rangetosend[2]
         const data = {
           startDay : startDay,
           endDay   : endDay,
           site     : this.site,
           agentId: this.agentId
         }
         store.dispatch('getReportingbyAgent',data)
         .then(response=>{
           this.agentVagues  = response.data.agentVagues
           this.agentNotes = response.data.agentNotes
           this.charts.service.series[0].data = Object.values(response.data.groupNotesByService_nbr)
           this.charts.serviceCategories = Object.keys(response.data.groupNotesByService_nbr)
           this.charts.Moyenservice.series[0].data = Object.values(response.data.moyenneNoteService)
           this.charts.MoyenserviceCategories = Object.keys(response.data.moyenneNoteService)
           this.charts.activite.series[0].data = Object.values(response.data.groupNotesByActivite_nbr)
           this.charts.activiteCategories = Object.keys(response.data.groupNotesByActivite_nbr)
           this.charts.Moyenactivite.series[0].data = Object.values(response.data.moyenneNoteActivite)
           this.charts.MoyenactiviteCategories = Object.keys(response.data.moyenneNoteActivite)
           this.waiting = false 
           this.data = false
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
    store.dispatch('getServices')
        .then((response)=>{
       this.services = response
        })
        .catch(err=>{
          console.log(err)
        })
    store.dispatch('getAgents2')
        .then(response=>{
            this.agents= response.data
        })
        .catch(err=>{
          console.log(err)
        })
    store.dispatch('getVagues')
        .then(response=>{
            this.vagues = response.data
        })  
        .catch(err=>{
            console.log(err)
        })
   }

}
</script>