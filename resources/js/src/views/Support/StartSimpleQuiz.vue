<template>
  <v-card
    flat
    class="pa-3 mt-2"
  >

   <v-card-title>
      <h1 class="mx-auto">Quiz de la formation :</h1>
   </v-card-title>
  


    <v-card-text>
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
                    href="javascript:void(0)"
                    class="text-decoration-none warning--text"
                  >
                    <span class="text-sm">Veuillez Renseigner les question et choisir les bonnes reponses !! </span>
                  </a>
                </div>
              </div>
            </v-alert>
          </v-col>
 <v-card-text>
        <v-form class="multi-col-validation mt-6 mb-4" v-for="question in questions" :key="question.id">
          <v-row>
            <p class="mt-2 mb-2">question : {{question.id}} </p>
          </v-row>
        <v-row >
          <v-col
            md="12"
            cols="12"
          >
            <v-text-field
              v-model="question.title"
              label="question*:"
              dense
              outlined
            ></v-text-field>
          </v-col>
            <!--- ezhsdn -->
</v-row>
     

   
      

   

             <v-row class="d-flex align-items-center">
            <v-col md="1">
        
            </v-col>
            <v-col md="10">
      <v-row align="center" v-for="(response,index) in question.responses " :key="index"> 
        <v-checkbox
         v-model="response.value"
          hide-details
          class="shrink mr-2 mt-0"
        ></v-checkbox>
        <v-text-field 
        v-model="response.response" 
        label="Ajoutez une réponse. [ cochez la réponse si elle est bonne ]"></v-text-field>
   
            <v-icon color="error"  @click.prevent="deleteresponse(question.id,response.id)" class="ml-4" style="cursor:pointer">
                  {{ icons.mdiDeleteEmpty }}
          </v-icon>
     
        
      </v-row>
  
          
            </v-col>

        </v-row>
      
            <v-btn
        
              class="me-3 mt-4"
              @click.prevent="addreponse(question.id)"
            >
              Ajouter une reponse
            </v-btn>
      
    
    
      </v-form>
 </v-card-text>
    <v-card-text>
           <v-file-input
          ref="file"
          type="file"
               @change="onFileChange"
                accept="image/png, image/jpeg, image/bmp"
                label="Capture d'ecran *:"
            ></v-file-input>
    </v-card-text>
    

    </v-card-text>

     <v-card-actions>
          <v-row class="d-flex float-right mb-4">
              <v-col cols="12">
            <v-btn
              color="primary"
              class="me-3 mt-4"
              @click.prevent="addAgent"
            >
              Ajouter une question
            </v-btn>
            <v-btn
              color="secondary"
              outlined
              class="mt-4"
              type="reset"
              @click.prevent="Enregistrer"
            >
              Enregistrer 
            </v-btn>
          </v-col>
      </v-row>
     </v-card-actions>
 
     
       

  </v-card>
</template>

<script>
import { mdiAlertOutline, mdiCloudUploadOutline,mdiDeleteEmpty } from '@mdi/js'
import store from '../../store/index.js'
import Swal from 'sweetalert2'

export default {
  props: {

  },
  data(){
    return {
      file : '',
      activitys : [],
      services : [],
    questions :[ {
        id:1,
        title : '',
        responses :[
           {
             id: 1,
        response : '',
        value : '',
      },
            {
              id : 2,
        response : '',
        value : '',
      },
      
      ],
      }],
      
    }
  },
  methods:{
     onFileChange(file) {
    this.file = file
 
        },
    created(){
     
    },
    Enregistrer(){
      var novalue = 0
     this.questions[0].responses.forEach(element => {
       if(element.value === null){
          novalue = novalue + 1
       }
     });
    //  if(novalue > 1) {
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Vous devez choisir une réponse juste au moins pour toutes les questions',
    //                 showConfirmButton: false,
    //                 timer: 3000
    //                 })
    //  }
     // else {
       const questions = {
            serviceId : this.$route.params.id,
            nom : this.$route.params.nom,
            questions : this.questions,
            site : this.$route.params.site,

      }
    
        store.dispatch('addSimpleQuiz',questions)
        .then(response=>{
             if(response.status ==200){
      var formData = new FormData()
      formData.append('file',this.file)
        formData.append('id',response.data.id)
        formData.append('nom',response.data.nom)
      store.dispatch('addSimpleQuizInstructions',formData).then(response=>{
         if(response.status ==200){
         Swal.fire({
                    icon: 'success',
                    title: 'Quiz ajouté',
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
                    icon: 'error',
                    title: "une erreur s'est produite " ,
                    showConfirmButton: false,
                    timer: 3000
                    })
                    .then(()=>{
                        this.wating= false
                         this.$router.go(-1)
                    })
            }
      })
               
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: "une erreur s'est produite " ,
                    showConfirmButton: false,
                    timer: 3000
                    })
                    .then(()=>{
                        this.wating= false
                        this.$router.go(-1)
                    })
            }
        })
    // }

    },
    addAgent(){
        this.questions.push({
            id:this.questions[this.questions.length -1].id + 1,
            title : '',
            responses :[
           {
              id: 1,
              response : '',
              value : '',
            },
            {
              id:2,
              response : '',
              value : '',
            },
            
            ],
          }

         )
    },
    addreponse(id){
       const question = this.questions.find(x=>x.id === id)
       question.responses.push({
                id:question.responses.length +1,
                response : '',
                value : '',
       })
    },
    deleteresponse(question_id,response_id){
      const question = this.questions.find(x=>x.id === question_id)
     question.responses =  question.responses.filter(x=>x.id != response_id )
     
     
    },
    getActivities(){
       store.dispatch('getActivities')
      .then((response)=>{
       this.activitys = response
      })
      .catch(err=>{
          erroMessage.value = err.response.data.message
        })
    },
    getServices(){
        store.dispatch('getServices')
      .then((response)=>{
       this.services = response
      })
      .catch(err=>{
          erroMessage.value = err.response.data.message
        })
    }
  },
  mounted(){
     this.getActivities()
     this.getServices()
  },
  setup() {
    const status = ['Active', 'Inactive']

    return {
      icons: {
        mdiAlertOutline,
        mdiCloudUploadOutline,
        mdiDeleteEmpty,
      },
      status
    }
  },
}
</script>
