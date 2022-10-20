<template>
    <v-row>
 
        <v-col md="3" v-for="(fi,index) in quizs" :key="index">
                <v-card class="elevation-0" max-width="5000" height="100%">
 
      <v-card-title class="font-weight-semibold">{{fi.nom}} </v-card-title>
  
      <v-card-actions class="mt-4">
      <v-btn @click="$router.push({ name: 'quiz-details2' ,params: { id: fi.id } })" class="d-flex align-center text-decoration-none me-2"
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
        const id =  this.$route.params.id
       store.dispatch('quizs4',id)
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