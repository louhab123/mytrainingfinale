<template>

    <div>

      <v-card-text>
      <v-row align="center">
        <v-col cols="4"/>
        <v-col
          class="text-h1"
          cols="4"
        >
          {{seriesM.formationsC}}
        </v-col>
        <v-col cols="4"/>
      </v-row>
    </v-card-text>
     <v-row class="text-center py-1 ">
      <v-col
       md="6" sm="6" lg="6"
        class="border-top border-right d-flex align-items-between flex-column py-1"
      >
        <v-card-text class="text-muted mb-0" style="color:#56ca00" >
          Les formations réalisées :
        </v-card-text>
        <h3 class="font-weight-bolder mb-0" style="color:#56ca00" >
         {{seriesM.formationsRC}} %
        </h3>
      </v-col>

      <v-col
         md="6" sm="6" lg="6"
        class="border-top d-flex align-items-between flex-column py-1"
      >
        <v-card-text class="text-muted mb-0" style="color:#2e5aff">
         Les formations en cours :
        </v-card-text>
        <h3 class="font-weight-bolder mb-0" style="color:#2e5aff" >
          {{seriesM.formationsEC }}   %
        </h3>
      </v-col>
    </v-row>
    </div>
</template>
<script>
export default {
  components: {
   
  },
  props: {
    seriesM :{
      type:Object,
      Default : {}
    }
  },
  data() {
    return {
    }
  },
  created() {

    
    
  },
}
</script>
