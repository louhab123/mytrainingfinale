
<template>
<div>
  <div v-if="waiting">
      <waiting-vue/>
  </div>
 <v-card v-else flat class="pa-3 mt-2">
  <v-card-title> <h2 class="mx-auto"> Le cumul des heures  :</h2> </v-card-title>
   <v-card-text>
       <v-btn outlined color="info" @click="routeur"> <v-icon v-text="icons.mdiArrowLeftBold"> </v-icon></v-btn>
          <v-text-field v-model="search" label="Search" single-line :append-icon="icons.mdiAccountGroupOutline " hide-details ></v-text-field>
          <v-data-table :headers="headers" :items="formationsList" :items-per-page="10" :search="search">
              <template #[`item.cumule`]="{item}">
                <div class="d-flex align-center">
                  <div class="d-flex flex-column ms-3">
                    <span class="d-block font-weight-semibold text--primary text-truncate">{{ item.cumule }} Heures </span> 
                  </div>
                </div>
              </template>
          </v-data-table>
   </v-card-text>
 </v-card>
</div>
</template>

<script>
import store from '../../../store/index.js'
import WaitingVue  from './Waiting.vue'
import { mdiArrowLeftBold,mdiAccountGroupOutline  } from '@mdi/js';

export default {
  components : {
       WaitingVue,
  },
    data(){
            return {
              waiting : false ,
                  icons : {
                    mdiArrowLeftBold,
                    mdiAccountGroupOutline 
                },
                search: '',
               formationsList: [], 
                   headers: [
                  { text: 'agent', value: 'agent',  class: 'text-center' },
                  { text: 'Cumul des heures', value: 'cumule' ,  class: 'text-center' },
      ],
      expanded : [],
            }
    },
     mounted(){
     this.getComuleStateOfPresence()
  },
  methods: {
        routeur() {
           this.$router.go(-1)
          },
        getComuleStateOfPresence(){
            this.waiting = true
            const details={
                formation_type:  this.$route.params.formation_type,
                formation_id :this.$route.params.formation_id
                }
                store.dispatch('getComuleStateOfPresence',details)
                .then(response=>{
                this.formationsList = response.data
                })
                .then(()=>{
                  this.waiting = false 
                })
              }
              },

}
</script>
