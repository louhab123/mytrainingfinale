<template>
  <v-card
    flat
    class="pa-3 mt-2"
  >
    <v-card-text class="d-flex">
  

      <!-- upload photo -->
        <v-col cols="6"  offset="3" sm="4" md="6" class="d-none d-sm-flex justify-center position-relative">
              <v-img
                contain
                max-width="170"
                :src="require('@/assets/images/3d-characters/pose-m-1.png').default"
                class="security-character"
              ></v-img>
            </v-col>
    </v-card-text>

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
                    <span class="text-sm">Veuillez Renseigner tous les shamps svp !! </span>
                  </a>
                </div>
              </div>
            </v-alert>
          </v-col>
      <v-form class="multi-col-validation mt-6" v-for="agent in agents" :key="agent.id">
          <v-row>
            <p class="mt-2 mb-2">Agent : {{agent.id}} </p>
            <v-icon @click="deleteAgent(agent.id)" color="error" style="cursor:pointer" class="ml-4">
              {{mdiDeleteEmpty}}
            </v-icon>
          </v-row>
        <v-row >
          <v-col
            md="6"
            cols="12"
          >
            <v-text-field
              v-model="agent.nom"
              label="nom*:"
              dense
              outlined
            ></v-text-field>
          </v-col>

          <v-col
            md="6"
            cols="12"
          >
            <v-text-field
              v-model="agent.prenom"
              label="Prenom*: "
              dense
              outlined
            ></v-text-field>
          </v-col>

          <v-col
            cols="12"
            md="6"
          >
            <v-text-field
              v-model="agent.email"
              label="Email*: "
              dense
              outlined
            ></v-text-field>
          </v-col>

      

          <v-col
            cols="12"
            md="6"
          >
            <v-select
              v-model="agent.statu"
              label="Statu du compte*:"
              :items="status"
            ></v-select>
          </v-col>

        </v-row>
      </v-form>
      <v-row>
              <v-col cols="12">
            <v-btn
              color="primary"
              class="me-3 mt-4"
              @click.prevent="addAgent"
            >
              Ajouter un autre agent
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
    </v-card-text>
  </v-card>
</template>

<script>
import { mdiAlertOutline, mdiCloudUploadOutline,mdiDeleteEmpty } from '@mdi/js'
import { ref } from '@vue/composition-api'
import store from '../../store/index.js'
import Swal from 'sweetalert2'

export default {
  props: {
    WaveId: {
      type: Number,
      default: () => 0,
    },
    service_id: {
      type: Number,
      default : ()=>0
    }
  },
  data(){
    return {
      mdiDeleteEmpty,
      activitys : [],
      services : [],
      agents:[ {
          id:1,
          nom : '',
          prenom : '',
          email : '',
        }],
    }
  },
  methods:{
    created(){
     
    },
    Enregistrer(){
      
      const agents ={
        agents : this.agents,
        waveId : this.WaveId,
        service_id : this.service_id
        
      }
         store.dispatch('addNewAgent', agents)
         .then((response)=>{
          if(response.data==='exit'){
          Swal.fire({
          icon: 'error',
          title: ' un des agents que vous avez résigné est déjà existé ! merci de vérifier sur la liste des aciens  agents et le supprimer ',
          showConfirmButton: true,
          timer: 3000
        })
          }
           else  if(response.data==='added'){
          Swal.fire({
          icon: 'success',
          title: ' les agents ont été affecté a cette formations ',
          showConfirmButton: true,
          timer: 3000
        }).then(()=>{
          this.$router.go(0)
        })
            }
         })
    },
    addAgent(){
            this.agents.push({
            id:this.agents[this.agents.length -1].id + 1,
            nom : '',
            prenom : '',
            email : '',
            statu: '',
          })
    },
    deleteAgent(id){
       this.agents =  this.agents.filter(x=>x.id != id )
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
      },
      status
    }
  },
}
</script>
