<template>
   <div>
       <WaitingVue v-if="!data"/>
         <v-row v-if="nodata">
          <v-col>
            <v-card>
                    <v-card-title class="h-100 justify-content-center align-items-center">
                    <h6 class="mx-auto" >
                               
                               Aucun quiz de formation trouvé pour votre service 
                    </h6>
                    </v-card-title>
            </v-card>
          </v-col>
      </v-row>
        <v-row v-if="data">
        <v-col cols="4" md="4" sm="4" lg="4" v-for="(fi,index) in quizs" :key="index">
        <v-card>
            <v-img class="white--text align-end" height="200px" :src="imageResource(fi.image_url)"></v-img>
                <v-card-title>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <h3 v-bind="attrs" v-on="on" style="cursor: pointer; color: white;" @click="$router.push({ name: 'quiz-details3' ,params: { id: fi.id } })"  >{{fi.activite}}</h3>
                        </template>
                        <span>Cliquer pour consulter les quiz de l'actvité : {{fi.activite}}</span>
                    </v-tooltip>
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
  created () {
      this.getQuizs()
  },
    data(){
        return {
            quizs : [],
            data : false,
            nodata : false ,
        }
    },
    methods : {
            imageResource(image){
                if(image==="") return  "https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                else {
                    return image
                }
            },
    getQuizs(){
    store.dispatch('quizs')
      .then((response)=>{
          if(response.data === 'nodatafound'){
              this.nodata = true
          }
          else {
              this.quizs = response.data
          }
       
      })
      .then(()=>{
          this.data = true
      })
      .catch(err=>{
          console.log(err)
        })
    },
    mounted () {
        this.quizs()
    }
    },
    components: {
        WaitingVue,
    }
}
</script>
<style>
h3:hover{
    color: white;
}
</style>