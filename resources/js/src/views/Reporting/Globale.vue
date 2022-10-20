<template>
  <div>
    <v-row>
      <v-col md="12" sm="12" lg="12">
        <v-card>
        <v-toolbar color="indigo" sucess><v-toolbar-title>Global :</v-toolbar-title></v-toolbar>
        <v-card-title class="h-100 justify-content-center align-items-center">
          <h3 class="mx-auto" >Reporting global des formations</h3>
        </v-card-title>
        <v-card-text>
            <v-row>
              <v-col md="6" sm="6" lg="6" class="mt-4">
                <span><v-icon>{{ mdiCalendar  }}</v-icon>
                  Période (la date de début et de fin de formation):
                  <flatPickr v-model="date" :config="config" class="form-control mt-4" placeholder="Choisissez une période ..." style="  border: 2px solid whitesmoke; border-radius: 10px; padding: 12px 10px; text-align: center; width: 70%;" ></flatPickr>
                </span>
              </v-col>
              <v-col md="6" lg="6" sm="6" class="mt-6">
                <span>
                  <v-select :prepend-icon="mdiGoogleMaps" :items="sites"  multiple  v-model="site" label="Site :" class="mt-6" style="width: 100%"></v-select>
                </span>
              </v-col>
            </v-row>
            <v-row class="d-flex">
              <v-col md="8" sm="8" lg="8"/>
              <v-col  md="4" sm="4" lg="4" class=" float-right">
                  <v-btn class="ma-2 float-right" outlined color="warning" @click="deleteItems()">Effacer</v-btn>
                  <v-btn class="ma-2 float-right" outlined color="primary" @click="handlItems()"> Valider</v-btn>
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
            <h6 class="mx-auto" > Veuillez choisir la période ou l'année, le site puis valider .</h6>
          </v-card-title>
        </v-card>
     </v-col>
     <v-col md="2" lg="2" sm="2"/>
    </v-row>
  <v-row v-if="waiting">
    <Waiting ></Waiting>
  </v-row>
  <v-row v-if="!data">
      <v-col md="6" sm="6" lg="6">
          <v-card>
            <v-card-title><h6  class="mx-auto">Total des formations initiales :</h6></v-card-title>
            <v-card-text><Moyen :seriesM="seriesMI"></Moyen></v-card-text>
          </v-card>
      </v-col>
      <v-col md="6" lg="6" sm="6">
         <v-card height="100%">
            <v-card-title> <h6 class="mx-auto">Total des formations continues  :</h6></v-card-title>
            <v-card-text> <Moyen2 :seriesM="seriesMC"></Moyen2> </v-card-text>
          </v-card>
      </v-col>  
  </v-row>
    <v-row v-if="!data">
        <v-col md="6" sm="6" lg="6">
            <v-card>
              <v-card-title><h6 class="mx-auto">Les formations initiales par formateur : </h6></v-card-title>
              <v-card-text><FormateurIChart :series="charts.formateurI.series" :categories="charts.formateurIcategories" ></FormateurIChart></v-card-text>
            </v-card>
        </v-col>
        <v-col md="6" sm="6" lg="6">
            <v-card>
              <v-card-title> <h6 class="mx-auto ">Les formations continues par formateur : </h6></v-card-title>
              <v-card-text><FormateurCChart :series="charts.formateurC.series" :categories="charts.formateurCcategories" ></FormateurCChart></v-card-text>
            </v-card>
        </v-col>
    </v-row>
    <v-row v-if="!data">
        <v-col md="6" sm="6" lg="6">
            <v-card>
              <v-card-title><h6 class="mx-auto">  Les formations initiales par activité : </h6></v-card-title>
              <v-card-text><ActvitieIChartVue :series="charts.actviteI.series" :categories="charts.actviteIcategories" ></ActvitieIChartVue></v-card-text>
            </v-card>
        </v-col>
        <v-col md="6" sm="6" lg="6">
            <v-card>
              <v-card-title><h6 class="mx-auto"> Les formations continues par activité : </h6></v-card-title>
              <v-card-text><ActviteCChartVue :series="charts.actviteC.series" :categories="charts.actviteCcategories" ></ActviteCChartVue></v-card-text>
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
import { mdiCalendar,mdiGoogleMaps  } from '@mdi/js'
import Moyen from './Charts/Moyen.vue'
import Moyen2 from './Charts/Moyen2.vue'
import FormateurIChart from './Charts/FormateurIChart.vue'
import FormateurCChart from './Charts/FormateurIChart.vue'
import ActviteCChartVue from './Charts/ActviteCChart.vue'
import ActvitieIChartVue from './Charts/ActvitieIChart.vue'
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
              actviteC: {
                series: [
                  {
                    data: [],
                  },
                ],
                actviteCcategories: [],
              },
              actviteI: {
                series: [
                  {
                    data: [],
                  },
                ],
                actviteIcategories: [],
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
            sites: ['TA', 'TE', 'HO', 'BDX','NSL'],
            site: [],
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

     }
   },
   components: {
    flatPickr,
    Moyen,
    Moyen,
    Moyen2,
    FormateurIChart,
    FormateurCChart,
    ActviteCChartVue,
    ActvitieIChartVue,
    Waiting,
    },
    created(){
      this.thisMonthDateRange();
      this.sites.map(el=>{this.site.push(el)})
      this.sendData();
    },
    methods: {
      thisMonthDateRange() {
      const today = new Date()
      const dd = String(today.getDate()).padStart(2, '0')
      const mm = String(today.getMonth() + 1).padStart(2, '0') // January is 0!
      const yyyy = today.getFullYear()
      this.date[1] = `${dd}/${mm}/${yyyy}` // `${yyyy}/${mm}/${dd}`
      const firstDay = new Date(today.getFullYear(), today.getMonth(), 1)
      const fdd = String(firstDay.getDate()).padStart(2, '0')
      const fmm = String(firstDay.getMonth() + 1).padStart(2, '0')
      const fyyyy = firstDay.getFullYear()
      this.date[0] = `${fdd}/${fmm}/${fyyyy}`
       },
     deleteItems(){
       this.date = []
       this.site = ''
     },
     handlItems(){
       
       if(this.date.length ===0 || !this.site) {
         if(this.date.length ===0){
             Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir la période",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
         else if(this.site.length == 0){
            Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir le site",
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
         }
         else {
        var startDay  = this.date[0]
         var endDay  = this.date[1]
         }
         const data = {
           startDay : startDay,
           endDay   : endDay,
           site     : this.site
         }
         store.dispatch('getGlobaleReporting',data)
         .then(response=>{
           console.log(response.data)
           this.seriesMI.formationsI = response.data.formationsI
           this.seriesMI.formationsEI = response.data.formationsEI
           this.seriesMI.formationsRI = response.data.formationsRI
           this.seriesMI.abandons = response.data.abandons
           this.seriesMC.formationsC = response.data.formationsC
           this.seriesMC.formationsEC = response.data.formationsEC
           this.seriesMC.formationsRC = response.data.formationsRC
           this.charts.formateurI.series[0].data = Object.values(response.data.formationIUser)
           this.charts.formateurIcategories = Object.keys(response.data.formationIUser)
           this.charts.formateurC.series[0].data = Object.values(response.data.formationCUser)
           this.charts.formateurCcategories = Object.keys(response.data.formationCUser)
           this.charts.actviteI.series[0].data = Object.values(response.data.actviteI)
           this.charts.actviteIcategories = Object.keys(response.data.actviteI)
           this.charts.actviteC.series[0].data = Object.values(response.data.actviteC)
           this.charts.actviteCcategories = Object.keys(response.data.actviteC)
           this.waiting = false 
           this.data = false
         })     
     
     }
   },

}
</script>