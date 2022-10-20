<template>
   <div>
    <WaitingVue v-if="!data"/>
      <v-row v-if="quizs.length===0 && data===true">
          <v-col>
            <v-card>
                <v-card-title class="h-100 justify-content-center align-items-center">
                    <h6 class="mx-auto" >Aucun quiz de formation trouvé pour cette actvité </h6>
                </v-card-title>
            </v-card>
          </v-col>
      </v-row>
    <v-row v-if="data && quizs.length > 0">
        <v-col md="3" sm="3" lg="3" cols="3" v-for="(fi,index) in quizs" :key="index" >
            <v-card class="mx-auto" height="100%" max-width="400">
                <v-card-title class="text--primary">
                     <div><h6>{{fi.nom}}</h6></div>
                </v-card-title>
                <v-card-actions class="m-auto">
                    <div class="m-auto">
                       <v-btn color="primary" x-small text @click="$router.push({ name: 'quiz-details' ,params: { id: fi.id } })">
                        <v-icon>
                           {{mdiDetails}} 
                        </v-icon>
                        Consulter
                       </v-btn>
                       <v-btn color="error" x-small  text v-if="role!=='agent'" @click="deleteQuiz({id : fi.id })" >
                        <v-icon>
                            {{mdiDeleteEmpty}}
                        </v-icon>
                        Suprimer
                       </v-btn>
                   </div>
              </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
   </div>
</template>
<script>
import store from '../../store/index.js'
import Swal from 'sweetalert2'
import { mdiDeleteEmpty,mdiDetails } from '@mdi/js';
import WaitingVue from '../Reporting/Waiting.vue'
export default {

    data(){
        return {
            mdiDetails,
            mdiDeleteEmpty,
            quizs : [],
            role: '',
            data: false,
        }
    },
    mounted(){
          this.getQuizs()
         
       
    },
    methods : {
        deleteQuiz(id){  
        Swal.fire({
        title: 'Vous allez supprimer ce quiz de formation  ! cette opération est irréversible! (vous allez aussi supprimer les notes et les réponses des agents de ce quiz) ',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Ok',
        denyButtonText: `annuler`,
        })
        .then((result) => {
          if (result.isConfirmed) {
            store.dispatch('deleteQuizSimple',id)
            .then((response)=>{
              if(response.status ==200){
                  Swal.fire('supprimé!', '', 'success')
                  .then(()=>{
                     this.$router.go(0)
                  })
              }
            })    
          } 
        })
        },
    getQuizs(){
        const id =  this.$route.params.id
       store.dispatch('quizs3',id)
      .then((response)=>{
       this.quizs = response.data
       this.role = sessionStorage.getItem('role') 
      })
      .then(()=>{
          this.data = true
      })
      .catch(err=>{
          console.log(err)
        })
    },
  
    },
    components: {
        WaitingVue,
    }
}
</script>