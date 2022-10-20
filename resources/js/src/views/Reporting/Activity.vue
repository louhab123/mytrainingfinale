<template>
  <div>
    <v-row>
      <v-col md="12" sm="12" lg="12">
        <v-card>
        <v-toolbar color="indigo" sucess>
          <v-toolbar-title>
              Activité :
          </v-toolbar-title>
        </v-toolbar>
        <v-card-title class="h-100 justify-content-center align-items-center">
          <h3 class="mx-auto" >
            Reporting par activité :
          </h3>
        </v-card-title>
        <v-card-text>
            <v-row>
              <v-col md="4" sm="4" lg="4" class="mt-2">
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
              <v-col  md="4" lg="4" sm="4" class="mt-6">
                    <v-select
                    item-text="nom"
                    item-value="id"
                    v-model="actviteId"
                    label="Activité :"
                    :items="activitys"
                    class="mt-6"
                    ></v-select>
              </v-col>
              <v-col md="4" lg="4" sm="4" class="mt-6">
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
                      Veuillez choisir la période ou l'année, l'activité et  le site  
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
        <v-col cols="3" md="3" sm="3" lg="3">
          <v-card  
            shaped>
               <v-card-text color="teal accent-4" class="d-flex align-center">
                 <v-avatar
                        color="primary"
                        size="44"
                        rounded
                        class="elevation-1"
                      >
                        <v-icon
                          dark
                          color="white"
                          size="30"
                        >
                          {{ mdiAbTesting   }}
                        </v-icon>
                  </v-avatar>
                  <div class="ms-3">
                    <p class="text-xs mb-0">
                          Les quiz passés : 
                    </p>
                    <h3 class="text-xl font-weight-semibold">
                        {{countQuizP}}
                    </h3>
                  </div>
               </v-card-text>
          </v-card>
          <v-card 
            class="mt-2" 
            shaped>
             <v-card-text color="teal accent-4" class="d-flex align-center">
                 <v-avatar
                        color="primary"
                        size="44"
                        rounded
                        class="elevation-1"
                      >
                        <v-icon
                          dark
                          color="white"
                          size="30"
                        >
                          {{ mdiArmFlexOutline   }}
                        </v-icon>
                  </v-avatar>
                  <div class="ms-3">
                    <p class="text-xs mb-0">
                          Les quiz injectés : 
                    </p>
                    <h3 class="text-xl font-weight-semibold">
                        {{countQuiz}}
                    </h3>
                  </div>
               </v-card-text>
          </v-card>
        </v-col>  
       <v-col cols="9" md="9" sm="9" lg="9" >
           <v-card shaped height="100%"  >
             <span class="font-weight-semibold"></span>
              <v-spacer></v-spacer>
              <v-spacer></v-spacer>
              <v-spacer></v-spacer>
              <v-card-title>
                Reporting par activité :
              </v-card-title>
               <v-card-text>
                  <v-row  >
                    <v-col cols="3" md="3" sm="3" lg="3" class="d-flex align-center" >
                      <v-avatar
                        color="primary"
                        size="44"
                        rounded
                        class="elevation-1"
                      >
                        <v-icon
                          dark
                          color="white"
                          size="30"
                        >
                          {{ mdiBriefcaseVariantOutline  }}
                        </v-icon>
                      </v-avatar>
                      <div class="ms-3">
                        <p class="text-xs mb-0">
                          Vague : 
                        </p>
                        <h3 class="text-xl font-weight-semibold">
                          {{ countVague }}
                        </h3>
                      </div>
                    </v-col>
                    <v-col md="3" sm="3" lg="3" class="d-flex align-center" >
                      <v-avatar
                        color="success"
                        size="44"
                        rounded
                        class="elevation-1"
                      >
                        <v-icon
                          dark
                          color="white"
                          size="30"
                        >
                          {{ mdiAccountOutline  }}
                        </v-icon>
                      </v-avatar>
                      <div class="ms-3">
                        <p class="text-xs mb-0">
                          Effectif formé :
                        </p>
                        <h3 class="text-xl font-weight-semibold">
                          {{ effective }}
                        </h3>
                      </div>
                    </v-col>
                    <v-col md="3" sm="3" lg="3" class="d-flex align-center" >
                      <v-avatar
                        color="info"
                        size="44"
                        rounded
                        class="elevation-1"
                      >
                        <v-icon
                          dark
                          color="white"
                          size="30"
                        >
                          {{ mdiBookOpenPageVariantOutline  }}
                        </v-icon>
                      </v-avatar>
                      <div class="ms-3">
                        <p class="text-xs mb-0">
                          Formations Continues :
                        </p>
                        <h3 class="text-xl font-weight-semibold">
                          {{ countFc }}
                        </h3>
                      </div>
                    </v-col>
                    <v-col md="3"  sm="3" lg="3" class="d-flex align-center" >
                      <v-avatar
                        color="warning"
                        size="44"
                        rounded
                        class="elevation-1"
                      >
                        <v-icon
                          dark
                          color="white"
                          size="30"
                        >
                          {{ mdiBookOpenVariant  }}
                        </v-icon>
                      </v-avatar>
                      <div class="ms-3">
                        <p class="text-xs mb-0">
                          Formations Initiales :
                        </p>
                        <h3 class="text-xl font-weight-semibold">
                          {{ countFi }}
                        </h3>
                      </div>
                    </v-col>
                  </v-row>
                 </v-card-text>
           </v-card>
       </v-col>
  </v-row>
  <v-row v-if="!data">
    <v-col md="6" sm="6" lg="6" cols="6">
        <v-card>
        <v-card-title>
           <h3 class="mx-auto">
              Les formations initiales par service : 
           </h3>
        </v-card-title>
        <v-card-text>
            <ServiceFiChart :series="charts.SeriviceI.series" :categories="charts.SeriviceIcategories" ></ServiceFiChart>
        </v-card-text>
      </v-card>
    </v-col>
     <v-col md="6" sm="6" lg="6" cols="6">
        <v-card>
        <v-card-title>
            <h3 class="mx-auto">
              Les formations continues par service :
            </h3> 
        </v-card-title>
        <v-card-text>
            <ServiceFcChart :series="charts.SeriviceC.series" :categories="charts.SeriviceCcategories" ></ServiceFcChart>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
  <v-row v-if="!data">
    <v-col md="6" sm="6" lg="6" cols="6" >
        <v-card>
          <v-card-title>
           <h3 class="mx-auto">
              Les formations initiales par formateur : 
           </h3>
          </v-card-title>
          <v-card-text>
            <FormateurIChart :series="charts.formateurI.series" :categories="charts.formateurIcategories"></FormateurIChart>
          </v-card-text>
        </v-card>
    </v-col>
      <v-col md="6" sm="6" lg="6" cols="6" >
        <v-card>
          <v-card-title>
           <h3 class="mx-auto">
              Les formations continues par formateur : 
           </h3>
          </v-card-title>
          <v-card-text>
            <FormateurCChart :series="charts.formateurC.series" :categories="charts.formateurCcategories"></FormateurCChart>
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
import Moyen from './Charts/Moyen.vue'
import Moyen2 from './Charts/Moyen2.vue'
import FormateurIChart from './Charts/FormateurIChart.vue'
import FormateurCChart from './Charts/FormateurIChart.vue'
import ServiceFcChart from './Charts/ServiceFcChart.vue'
import ServiceFiChart from './Charts/ServiceFiChart.vue'
import Waiting from './Waiting.vue'

export default {
   data(){
     return {
          charts: {
              formateurI: {
                series: [
                  {
                    data: [],
                  },
                ],
              },
              formateurIcategories :[],
              formateurC: {
                series: [
                  {
                    data: [],
                  },
                ],
                formateurCcategories: [],
              },
              SeriviceI: {
                series: [
                  {
                    data: [],
                  },
                ],
                SeriviceIcategories: [],
              },
              SeriviceC: {
                series: [
                  {
                    data: [],
                  },
                ],
                SeriviceCcategories: [],
              },
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
            sites : ['TA', 'TE', 'HO', 'BDX','NSL'],
            site: '',
            data: true,
            waiting: false,
            seriesMI : {
              formationsI : 0,
              formationsEI : 0,
              formationsRI : 0,
              abandons : 0
            },
             seriesMC : {
              formationsC : 0,
              formationsEC : 0,
              formationsRC : 0,
            },
            actviteId : '',
            activitys : [],
            countVague: '',
            countFc   : '',
            countFi   : '',
            effective : '',
            countQuiz : '',
            countQuizP: '',

     }
   },
   components: {
    flatPickr,
    Moyen,
    Moyen,
    Moyen2,
    FormateurIChart,
    FormateurCChart,
    ServiceFcChart,
    ServiceFiChart,
    Waiting,
},
   methods: {
     deleteItems(){
       this.date = []
       this.site = ''
     },
     handlItems(){
       if(this.date.length ===0 || !this.site || !this.actviteId) {
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
           actviteId: this.actviteId
         }
         store.dispatch('getReportingActvity',data)
         .then(response=>{
           this.countVague = response.data.countVague  
           this.countFc = response.data.countFc
           this.countFi = response.data.countFi
           this.effective = response.data.effective
           this.charts.formateurI.series[0].data = Object.values(response.data.formationIUser)
           this.charts.formateurIcategories = Object.keys(response.data.formationIUser)
           this.charts.formateurC.series[0].data = Object.values(response.data.formationCUser)
           this.charts.formateurCcategories = Object.keys(response.data.formationCUser)
           this.charts.SeriviceI.series[0].data = Object.values(response.data.SeriviceI)
           this.charts.SeriviceIcategories = Object.keys(response.data.SeriviceI)
           this.charts.SeriviceC.series[0].data = Object.values(response.data.SeriviceC)
           this.charts.SeriviceCcategories = Object.keys(response.data.SeriviceC)
           this.countQuiz = response.data.countQuiz
           this.countQuizP = response.data.countQuizP
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
   }

}
</script>