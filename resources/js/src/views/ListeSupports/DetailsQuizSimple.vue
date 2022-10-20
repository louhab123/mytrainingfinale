<template>
   <div>
     <WaitingVue v-if="!data"/>
     <v-card v-if="data">
      <v-card-title><h2 class="mx-auto">{{group.nom}}</h2></v-card-title>
      <v-card-text> <v-img :src="instructions" eager> </v-img>
      </v-card-text>
      <v-card-text>
        <v-col cols="12">
            <v-alert color="warning" text class="mb-0">
              <div class="d-flex align-start">
                <v-icon color="warning"> {{ icons.mdiAlertOutline }}</v-icon>
                <div class="ms-3">
                  <a class="text-decoration-none warning--text">
                    <span class="text-sm">Veuillez cocher les bonnes  reponses !! </span>
                  </a>
                </div>
              </div>
            </v-alert>
        </v-col>
     <v-col md="12"  sm="12" lg="12">
      <div v-for="(response,index) in quiz " :key="index">
      <v-card-title>
          {{response.question}}  
          <!-- <v-chip  color="info" outlined  class="ml-4" v-if="response.trueResponse > 1 "> Plusieurs réponses sont corrects</v-chip> -->
      </v-card-title>
       <v-row align="center" v-for="(response,index2) in response.responses" :key="index2">
          <v-checkbox v-model="response.value" :value="response.value" input-value="response.value" hide-details class="shrink mr-2 mt-0"></v-checkbox>
          <p class="mt-3">{{response.response}}  </p>
       </v-row>
      </div>
     </v-col>
    </v-card-text>
        <v-card-actions>
              <v-col md="4" lg="4" sm="4" />
               <v-col>
                  <v-btn width="100%" color="primary" outlined  @click="sendData"> Terminer </v-btn>
               </v-col>
              <v-col md="4" lg="4" sm="4" />               
        </v-card-actions>
   </v-card>
   </div>
</template>
<script>
import { mdiAlertOutline, mdiCloudUploadOutline } from '@mdi/js'
import store from '../../store/index'
import Swal from 'sweetalert2'
import WaitingVue from './Waiting.vue'
export default {
    data(){
        return {
            data: false,
            quiz : {},
            group: {},
            instructions: '',
            responses : {},
              icons: {
                mdiAlertOutline,
                mdiCloudUploadOutline,
            },
        }
    },
    created () {
        this.getQuizDetails()
    },
    methods : {
        getQuizDetails(){
            const id = this.$route.params.id
            store.dispatch('getQuizDetails',id)
            .then(response=>{
                this.quiz = response.data.responses,
                this.group = response.data.group,
                this.instructions = response.data.Instruction
            }).then(()=>{
              this.data = true
            })
        },
        sendData(){
          let note = 0
         this.quiz.forEach(element => {
           let var1 = false
           // count true responses element.trueResponse
           let counttrueAnswers = 0
           let countRightAnswers= 0
           element.responses.forEach(el=>{
             let var2 = false 
             if(el.value===true){
               counttrueAnswers+=1
             }
             if(el.value_response===1 && el.value===true){
               countRightAnswers+=1
             }
             if(counttrueAnswers===element.trueResponse && countRightAnswers===counttrueAnswers) {
             var1 = true
             }
             else {
               var1 = false
             }
           })
           if(var1===true){
             note+=2
           }
         });
        const response = {
          activite_id : this.group.activite_id,
          service_id : this.group.service_id,
          responseAgent : this.quiz,
          user_id :  sessionStorage.getItem('userId'),
          quiz_id : this.$route.params.id,
          type : "simple",
          responseAgent : this.quiz,
          note:note
        }
        store.dispatch('sendDataAgent',response)
        .then((response)=>{
        if(response.status ==200 ) {
              if(response.data==='exist')
                {
               Swal.fire({
                    icon: 'error',
                    title: 'Vous avez deja passé le quiz',
                    showConfirmButton: false,
                    timer: 3000
                    })
                    .then(()=>{
                        this.wating= false
                        this.$router.go(-1)
                    })
                 }
              else {
               Swal.fire({
                    icon: 'success',
                    title: 'félicitation vous avez terminé le quiz ',
                    showConfirmButton: false,
                    timer: 3000
                    })
                    .then(()=>{
                        this.wating= false
                        this.$router.go(-1)
                    })
              }             

        }
        })

        }
    },
    components: {
      WaitingVue,
    }
}
</script>