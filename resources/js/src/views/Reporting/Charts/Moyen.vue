<template>

    <div>

      <v-card-text>
      <v-row align="center">
        <v-col cols="4"/>
        <v-col
          class="text-h1"
          cols="4"
        >
          {{seriesM.formationsI}}
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
         {{seriesM.formationsRI}} %
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
          {{seriesM.formationsEI }}   %
        </h3>
      </v-col>
       <v-col
         md="4" sm="4" lg="4"
        class="border-top d-flex align-items-between flex-column py-1"
      > 
        <v-card-text class="text-muted mb-2 " style="color:#ff928a">
         Les abandons : 
        </v-card-text>
        <h3 class="font-weight-bolder mb-0 mt-4" style="color:#ff928a" >
          {{seriesM.abandons}}  %
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
