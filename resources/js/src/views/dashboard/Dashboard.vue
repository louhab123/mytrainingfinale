<template>
<div>
  <v-row>
     <v-col md="4" sm="4" lg="4" cols="4">               
          <v-card  shaped class="mx-auto" >
                   <v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" height="200px"></v-img>
                     <v-card-title>Bienvenue {{user}}</v-card-title>
                     <v-card-subtitle> Sur My'Training  </v-card-subtitle>
                     <v-card-actions>
                          <v-avatar tile color="blue">
                                <v-icon dark>{{mdiClockOutline}}</v-icon>
                          </v-avatar>
                          <h3 class="ml-2">
                              {{clock}}
                          </h3>   
                    </v-card-actions>
                      <v-card-actions>
                          <v-avatar tile color="blue">
                                <v-icon dark>{{mdiCalendarRange}}</v-icon>
                          </v-avatar>
                          <h3 class="ml-2">
                              {{today}}
                          </h3>   
                    </v-card-actions>
                    <v-spacer></v-spacer>
                     <v-expand-transition>
                        <div>
                            <v-divider></v-divider>
                            <v-card-text>
                           La formation ne trahit jamais celui qui prend soin d'elle.
                            </v-card-text>
                        </div>
                    </v-expand-transition>
          </v-card>
    </v-col>
      <v-col cols="8" md="8" sm="8" lg="8" >
         <v-card shaped v-if="!data"  height="25%">
              <v-card-text class="text-center">
              <div class="text-center">
                  <v-progress-circular
                    indeterminate
                    color="primary"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="red"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="purple"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="green"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="amber"
                  ></v-progress-circular>
                </div>
              </v-card-text>
           </v-card>
          <v-card shaped  v-else >
             <span class="font-weight-semibold"></span>
              <v-spacer></v-spacer>
              <v-spacer></v-spacer>
              <v-spacer></v-spacer>
              <v-card-title>
                Reporting Global du semaine  :
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
          
         <v-row>
           <v-col cols="6" md="6" sm="6" lg="6">
          <v-card class="mt-4" shaped v-if="!data" height="360%">
            <v-card-text class="text-center">
              <div class="text-center">
                <v-progress-circular
                  indeterminate
                  color="primary"
                ></v-progress-circular>

                <v-progress-circular
                  indeterminate
                  color="red"
                ></v-progress-circular>

                <v-progress-circular
                  indeterminate
                  color="purple"
                ></v-progress-circular>

                <v-progress-circular
                  indeterminate
                  color="green"
                ></v-progress-circular>

                <v-progress-circular
                  indeterminate
                  color="amber"
                ></v-progress-circular>
              </div>
            </v-card-text>
          </v-card>   
          <v-card shaped class="mt-4" v-else >
            <v-card-title>
             Les formations initiales   :
            </v-card-title>
               <v-card-text>
                <v-row align="center">
                  <v-col cols="4"/>
                  <v-col
                    class="text-h1"
                    cols="4"
                  >
                    {{countFi}}
                  </v-col>
                  <v-col cols="4"/>
                </v-row>
               </v-card-text>
                <v-row class="text-center py-1 ">
                  <v-col
                  md="4" sm="4" lg="4"
                    class="border-top border-right d-flex align-items-between flex-column py-1"
                  >
                    <v-card-text class="text-muted mb-0" style="color:#56ca00">
                      Les formations réalisées :
                    </v-card-text>
                    <h3 class="font-weight-bolder mb-0" style="color:#56ca00">
                    {{countFiR}} %
                    </h3>
                  </v-col>
                  <v-col
                    md="4" sm="4" lg="4"
                    class="border-top d-flex align-items-between flex-column py-1"
                  >
                    <v-card-text class="text-muted mb-0" style="color:#2e5aff">
                    Les formations en cours :
                    </v-card-text>
                    <h3 class="font-weight-bolder mb-0" style="color:#2e5aff">
                      {{countFiE }}   %
                    </h3>
                  </v-col>
                  <v-col
                    md="4" sm="4" lg="4"
                    class="border-top d-flex align-items-between flex-column py-1"
                  >
                    <v-card-text class="text-muted mb-2 " style="color:#ff928a">
                    Les abandons : 
                    </v-card-text>
                    <h3 class="font-weight-bolder mb-0 mt-4" style="color:#ff928a">
                      {{abondonsFi}}  %
                    </h3>
                  </v-col>
                </v-row>
          </v-card>
           </v-col>
            <v-col cols="6" md="6" sm="6" lg="6">
              <v-card v-if="!data" shaped height="360%" class="mt-4">
                  <v-card-text class="text-center">
                      <div class="text-center">
                      <v-progress-circular
                        indeterminate
                        color="primary"
                      ></v-progress-circular>

                      <v-progress-circular
                        indeterminate
                        color="red"
                      ></v-progress-circular>

                      <v-progress-circular
                        indeterminate
                        color="purple"
                      ></v-progress-circular>

                      <v-progress-circular
                        indeterminate
                        color="green"
                      ></v-progress-circular>

                      <v-progress-circular
                        indeterminate
                        color="amber"
                      ></v-progress-circular>
                    </div>
                  </v-card-text>
              </v-card>
          <v-card shaped class="mt-4" v-else>
            <v-card-title>
             Les formations continues   :
            </v-card-title>
               <v-card-text>
                <v-row align="center">
                  <v-col cols="4"/>
                  <v-col
                    class="text-h1"
                    cols="4"
                  >
                    {{countFc}}
                  </v-col>
                  <v-col cols="4"/>
                </v-row>
               </v-card-text>
                <v-row class="text-center py-1 mt-3 ">
                  <v-col
                  md="6" sm="6" lg="6"
                    class="border-top border-right d-flex align-items-between flex-column py-1"
                  >
                    <v-card-text class="text-muted mb-0" style="color:#56ca00" >
                      Les formations réalisées :
                    </v-card-text>
                    <h3 class="font-weight-bolder mb-0" style="color:#56ca00">
                    {{countFcR}} %
                    </h3>
                  </v-col>
                  <v-col
                    md="6" sm="6" lg="6"
                    class="border-top d-flex align-items-between flex-column py-1"
                  >
                    <v-card-text class="text-muted mb-0" style="color:#2e5aff">
                    Les formations en cours :
                    </v-card-text>
                    <h3 class="font-weight-bolder mb-0">
                      {{countFcE }}   %
                    </h3>
                  </v-col>
                </v-row>
          </v-card>
           </v-col>
         </v-row>
      </v-col>
  </v-row>
  <!-- <v-row>
    <v-col cols="6" md="6" sm="6" lg="6">
      <v-card shaped>
        <v-card-title>
           <h3 class="mx-auto">
            Nombre des formations initiales par activité 
           </h3>
        </v-card-title>
        <v-card-text>
            <ActvitieIChartVue :data="actviteI" ></ActvitieIChartVue>
        </v-card-text>
        <v-card-actions>
          <v-btn color="info" outlined width="100%">
            Détail
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
      <v-col cols="6" md="6" sm="6" lg="6">
      <v-card shaped>
        <v-card-title>
           <h3 class="mx-auto">
            Nombre des formations continues par activité 
           </h3>
        </v-card-title>
        <v-card-text>
          <ActviteCChartVue :data="actviteC"  ></ActviteCChartVue>
        </v-card-text>
        <v-card-actions>
          <v-btn color="info" outlined width="100%">
            Détail
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row> -->
</div>

</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiClockOutline,mdiCalendarRange, mdiBriefcaseVariantOutline,mdiAccountOutline,mdiBookOpenPageVariantOutline,mdiBookOpenVariant, } from '@mdi/js'
import store from '../../store/index.js'
import VueApexCharts from 'vue-apexcharts'
import ActvitieIChartVue from './ActvitieIChart.vue'
import ActviteCChartVue from './ActviteCChart.vue'
export default {
  data(){
    return{
      today : null,
      clock : null,
      mdiCalendarRange,
      mdiClockOutline,
      mdiBriefcaseVariantOutline,
      mdiAccountOutline,
      mdiBookOpenPageVariantOutline,
      mdiBookOpenVariant,
      countVague : 0,
      effective : 0,
      countFc : 0,
      countFcR : 0,
      countFcE : 0,
      countFi : 0,
      countFiE : 0,
      countFiR : 0,
      user: '',
      abondonsFi : 0,
      actviteI: {
          series: [{ name: '', data: [] }],
          data: [],
        },
      actviteC: {
          series: [{ name: '', data: [] }],
          data: [],
        },  

        data :false,
    }
  },
  components: {
    VueApexCharts,
    ActvitieIChartVue,
    ActviteCChartVue,
  },
  methods: {
    showTime() {
      const date = new Date()
      let h = date.getHours() // 0 - 23
      let m = date.getMinutes() // 0 - 59
      let s = date.getSeconds()
      let session = 'AM'
      if (h === 0) {
        h = 12
      }
      if (h > 12) {
        h -= 12
        session = 'PM'
      }
      h = h < 10 ? `0${h}` : h
      m = m < 10 ? `0${m}` : m
      s = s < 10 ? `0${s}` : s

      const time = `${h}:${m}:${s} ${session}`
      this.clock = time
    },
   },
  mounted() {
    this.$nextTick(() => {
      window.setInterval(() => {
        this.showTime()
      }, 1000)
    })
      store.dispatch('getformationByactiviteDashboeardAdmin')
      .then((response)=>{
           this.actviteI.series[0].data = Object.values(response.data.groupByActviteFI_nbr)
           this.actviteI.data = Object.keys(response.data.groupByActviteFI_nbr)
           this.actviteC.series[0].data = Object.values(response.data.groupByActviteFC_nbr)
           this.actviteC.data = Object.keys(response.data.groupByActviteFC_nbr)
      })
  },
  created(){
    this.user = sessionStorage.getItem('user')
    const today = new Date()
    const dd = String(today.getDate()).padStart(2, '0')
    const mm = String(today.getMonth() + 1).padStart(2, '0') // January is 0!
    const yyyy = today.getFullYear()
    this.today = `${dd}/${mm}/${yyyy}`
    store.dispatch('effectiveByWeeek')
    .then(response=>{
      this.effective = response.data.effective
      this.countVague = response.data.countVague
      this.countFc = response.data.countFc
      this.countFi = response.data.countFi
      this.countFiR = response.data.countFiR
      this.countFiE = response.data.countFiE
      this.countFcR = response.data.countFcR
      this.countFcE = response.data.countFcE
      this.abondonsFi = response.data.abondonsFi
    })
    .then(()=>{
      this.data= true
    }) 
  }
}
</script>
