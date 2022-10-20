<template>
  <div>
    <waiting-vue v-if="waiting"/>
    <v-card v-else >
     <v-card-title>
      <v-row>
        <v-col cols="4" md="4" sm="4" lg="4">
          <v-chip pill>
            <v-avatar left> <v-img :src="require('@/assets/images/avatars/1.png').default"> </v-img></v-avatar>{{agent}}
          </v-chip>
        </v-col>
        <v-col cols="4" md="4" sm="4" lg="4"></v-col> 
        <v-col cols="2" md="2" sm="2" lg="2">
           <v-btn color="info" plain> {{note}} / {{totale}}</v-btn>
        </v-col>
        <v-col>
            <v-btn color="warning" @click="createPdf()">Imprimer en PDF</v-btn>
        </v-col>
      </v-row>
     </v-card-title>
     <v-card-text>
       <v-col cols="12" md="12" sm="12" lg="12">
          <span v-for="(response,index) in quiz " :key="index">
            <v-card-title> <h6>{{index}} </h6></v-card-title>
            <div align="center" v-for="(resp,index2) in response['agentResponse']" :key="index2">
              <div align="center" v-for="(resp2,index2) in response['trueResponse']" :key="index2">
                <div class="mt-2 mb-2" v-if="resp2.id===resp.simple_response_id">
                    <v-row>
                      <v-checkbox v-model="resp.value" v-bind:color="resp2.value===1  ? 'success' : 'error' "  :value="resp.value"  hide-details class="shrink mr-2 mt-0" ></v-checkbox>
                      <p class="text-white" >{{resp2.response}}</p>
                      <v-chip outlined color="success" class="ml-4" v-if="resp2.value===1"> La bonne réponse </v-chip>
                    </v-row>
                </div>
              </div>
            </div>
          </span>
       </v-col>
     </v-card-text>
   </v-card>
   <vue-html2pdf ref="html2Pdf"   :show-layout="false"
        :float-layout="true"
        :enable-download="true"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        filename="hee hee"
        :pdf-quality="2"
        :manual-pagination="false"
        pdf-format="a4"
        pdf-orientation="landscape"
        pdf-content-width="800px" >
    <section slot="pdf-content">
     <v-card>
     <v-card-title>
      <v-row>
        <v-col cols="4" md="4" sm="4" lg="4">
          <v-chip pill>
            <v-avatar left> <v-img :src="require('@/assets/images/avatars/1.png').default"> </v-img></v-avatar>{{agent}}
          </v-chip>
        </v-col>
        <v-col cols="4" md="4" sm="4" lg="4"></v-col> 
        <v-col cols="2" md="2" sm="2" lg="2">
           <v-btn color="info" plain> {{note}} / {{totale}}</v-btn>
        </v-col>
      </v-row>
     </v-card-title>
     <v-card-text>
       <v-col cols="12" md="12" sm="12" lg="12">
          <span v-for="(response,index) in quiz " :key="index">
            <v-card-title> <h6>{{index}} </h6></v-card-title>
            <div align="center" v-for="(resp,index2) in response['agentResponse']" :key="index2">
              <div align="center" v-for="(resp2,index2) in response['trueResponse']" :key="index2">
                <div class="mt-2 mb-2" v-if="resp2.id===resp.simple_response_id">
                    <v-row>
                      <v-checkbox v-model="resp.value" v-bind:color="resp2.value===1  ? 'success' : 'error' "  :value="resp.value"  hide-details class="shrink mr-2 mt-0" ></v-checkbox>
                      <p class="text-white" >{{resp2.response}}</p>
                      <v-chip outlined color="success" class="ml-4" v-if="resp2.value===1"> La bonne réponse </v-chip>
                    </v-row>
                </div>
              </div>
            </div>
          </span>
       </v-col>
     </v-card-text>
    </v-card>
    </section>
   </vue-html2pdf>
  </div>
</template>
<script>
import { mdiAlertOutline, mdiCloudUploadOutline } from '@mdi/js'
import store from '../../store/index'
import WaitingVue from './Waiting.vue'
import VueHtml2pdf from 'vue-html2pdf'
export default {
   components: {
     WaitingVue,
     VueHtml2pdf,
      },
    data(){
        return {
            waiting : false ,
            totale: '',
            quiz : {},
            group: {},
            note:'',
            agent: '',
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
          this.waiting = true
            const detail ={
                agent_id : this.$route.params.agent_id,
                group_quiz_id : this.$route.params.group_quiz_id
            } 
            store.dispatch('getResponseAgentDetail',detail)
            .then(response=>{
                this.quiz= response.data.responses
                this.agent= response.data.agent
                this.note = response.data.note
                 this.totale = Object.keys(response.data.responses).length * 2  
            })
            .then(()=>{
              this.waiting = false
            })
        },
        createPdf(){
          this.waiting = true
          this.$refs.html2Pdf.generatePdf()
          this.waiting = false 

        }
       

    }
}
</script>