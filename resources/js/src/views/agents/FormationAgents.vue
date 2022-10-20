<template>
<div>
<v-row v-if="waiting">
    <v-col  cols="12" md="12" sm="12" lg="12" >
        <v-card>
            <waiting-vue />
        </v-card>
    </v-col>
</v-row>
<v-row v-else >
    <v-col  cols="12" md="12" sm="12" lg="12" >
        <v-card>
          <v-card-title><h3 class="mx-auto">Les missions affectés a l'agent  : </h3> 
            <v-chip pill>
            <v-avatar left> <v-img :src="require('@/assets/images/avatars/1.png').default"> </v-img></v-avatar>{{agent.agent}} 
            </v-chip> 
          </v-card-title>
        </v-card>
    </v-col>
</v-row>
</div>

</template>
  <script>
  import store from '../../store/index.js'
 import WaitingVue from './Waiting.vue'
  export default {
      data(){
          return {
          agent: '',
          waiting : false,  
          search : '',
          fis : [],
          fcs : [],
          }
      },
      components : {
        WaitingVue
      },
      methods: {
          getAgentdetails(){
            this.waiting = true
            const agent_id = this.$route.params.agent_id
            store.dispatch('getAgentdetails',agent_id)
            .then((response)=>{
               this.agent = response.data.agent
               this.fis = response.data.fis
               this.fcs = response.data.fcs
            })
            .then(()=>{
              this.waiting = false
            })
           .catch(err=>{
            console.log(err)
          })
          }
      },
       mounted(){
      this.getAgentdetails()
    },
  }
  </script>
  