<template>
   <v-card>
      <v-card-title>
          {{group.nom}}
      </v-card-title>
         <v-card-text>
            <v-img
      :src="instructions"
      eager>
  
      </v-img>
        <v-col cols="12">
            <v-alert
              color="warning"
              text
              class="mb-0"
            >
              <div class="d-flex align-start">
                    <v-icon color="warning">
                  {{ icons.mdiAlertOutline }}
                </v-icon>

                <div class="ms-3">
                  <a
                  
                    class="text-decoration-none warning--text"
                  >
                    <span class="text-sm">Veuillez cocher les bonnes  reponses !! </span>
                  </a>
                </div>
              </div>
            </v-alert>
          </v-col>
     <v-col md="8" offset="2">

      <div v-for="(response,index) in quiz " :key="index">
       
       
        <v-card-title>
          {{response.question}} 
       </v-card-title>
<v-row align="center" v-for="(response1,index) in response.responses" :key="index">
  

            <v-checkbox
      
          hide-details
          class="shrink mr-2 mt-0"
        ></v-checkbox>
        <p class="mt-3">{{response1.response}}</p>
     
        
       </v-row>
      </div>
     
       
      
     </v-col>
    </v-card-text>
        <v-card-actions>
               <v-btn  @click="sendData">
                   Terminer 
               </v-btn>
        </v-card-actions>
   </v-card>
</template>
<script>
import { mdiAlertOutline, mdiCloudUploadOutline } from '@mdi/js'
import store from '../../store/index'
import Swal from 'sweetalert2'
export default {
    data(){
        return {
          instructions : '',
            quiz : {},
            group: {},
            responses : [],
            responsesWillSend : {},
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
      sendData(){
        const response = {
          responseAgent : this.quiz,
          user_id :  sessionStorage.getItem('userId'),
          quiz_id : this.$route.params.id,
          type : "finale"
        }
         store.dispatch('sendDataAgent',response)
         .then(response=>{
           if(response.statut ===200){
                 Swal.fire({
                        icon: 'success',
                        title: "",
                        showConfirmButton: false,
                        timer: 3000
                        }).then(()=>{
                          this.route.go(0)
                        })
           }
         })
      },
        getQuizDetails(){
            const id = this.$route.params.id
            store.dispatch('getQuizDetails2',id)
            .then(response=>{
              this.instructions = response.data.Instruction
              this.quiz = response.data.responses,
              this.group = response.data.group
                

            })
        }
    }
}
</script>