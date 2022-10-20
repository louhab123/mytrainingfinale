<template>
    <v-row>
 
        <v-col md="3" v-for="(fi,index) in quizs" :key="index">
                <v-card class="elevation-0" max-width="5000" height="100%">
 
      <v-card-title class="font-weight-semibold">{{fi.activite}} </v-card-title>
      <v-card-text>
     
      </v-card-text>

      <v-card-actions class="mt-4">
      <v-btn @click="$router.push({ name: 'quiz-finale-details' ,params: { id: fi.activite } })" class="d-flex align-center text-decoration-none me-2"
         color="primary"

        >
    Consulter
          
        </v-btn>
      </v-card-actions>
    </v-card>
        </v-col>
    </v-row>
</template>
<script>
import store from '../../store/index.js'
export default {
  created () {
      this.getQuizs()
  },
    data(){
        return {
            quizs : [],
        }
    },
    methods : {
    getQuizs(){
       store.dispatch('quizs2')
      .then((response)=>{
       this.quizs = response.data
      })
      .catch(err=>{
          console.log(err)
        })
    },
    mounted () {
        this.quizs()
    }
    }
}
</script>