<template>
    <div>
        <v-col cols="8" md="8" sm="8" lg="8" >
              <v-card shaped   >
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
            <v-card shaped class="mt-4">
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
            <v-card shaped class="mt-4">
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
    </div>
</template>
<script>
import { mdiClockOutline,mdiCalendarRange, mdiBriefcaseVariantOutline,mdiAccountOutline,mdiBookOpenPageVariantOutline,mdiBookOpenVariant, } from '@mdi/js'
export default {
    data(){
        return {
          mdiClockOutline,
          mdiCalendarRange,
          mdiBriefcaseVariantOutline,
          mdiAccountOutline, 
          mdiBookOpenPageVariantOutline,
          mdiBookOpenVariant,
          countVague,
          effective,
          countFc,
          
          
        }
    }
}
</script>