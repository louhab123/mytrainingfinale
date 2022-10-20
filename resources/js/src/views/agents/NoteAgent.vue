<template>
 <div>
   <waiting-vue v-if="waiting"/>
   <div v-if="nodatafound">
      <v-row >
          <v-col>
            <v-card>
                    <v-card-title class="h-100 justify-content-center align-items-center">
                    <h6 class="mx-auto" >
                               
                                Aucun  agent a  passé un quiz encore   
                    </h6>
                    </v-card-title>
            </v-card>
          </v-col>
      </v-row>
   </div>
   <div v-if="!waiting && !nodatafound">
    <v-row>
      <v-col cols="12" md="12" sm="12" lg="12">
      <v-card class="m-4">
       <v-card-title><h2 class="mx-auto text--primary">Filtrer le tableau avec activité et service désirés : </h2></v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="6" lg="6" sm="6" md="6">
            <v-select item-text="nom" item-value="id" v-model="actviteId" label="Activité" :items="activitys"></v-select>
          </v-col>
          <v-col cols="6" lg="6" sm="6" md="6">
               <v-select item-text="nom" v-model="serviceId" item-value="id" label="Service" :items="servicesOption" ></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="8" sm="8" lg="8" md="8" />
          <v-col cols="2" md="2" lg="2" sm="2">
            <v-btn color="warning" outlined @click="deleteItems()" >Effacer</v-btn>
          </v-col>
           <v-col cols="2" md="2" lg="2" sm="2">
            <v-btn color="primary" outlined  @click="handlItems()"  >Valider </v-btn>
          </v-col>
        </v-row>
      </v-card-text>
     </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="12" sm="12" lg="12">
      <v-card class="m-4">
      <v-card-title ><h3 class="mx-auto">Les notes des agents : </h3></v-card-title>
      <v-card-text>
        <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
        <v-data-table :headers="headers" :items="agentList" :items-per-page="7" :search="search" >
          <template  #[`item.note`]="{item}">
              <v-btn v-bind:color="item.note < 5 ? 'warning' : 'primary' " outlined  >{{item.note}}</v-btn>               
          </template>
          <template #[`item.actions`]="{item}">
            <v-menu>
              <template  v-slot:activator="{ on, attrs }" ><v-icon dark v-bind="attrs" color="black"  v-on="on">{{mdiDotsHorizontal}}</v-icon></template>
              <v-list>
                  <v-list-item>
                    <v-list-item-title @click="consulter(item)" style="cursor:pointer">
                      <v-icon>{{mdiCardAccountDetails}}</v-icon> consulter le détail
                    </v-list-item-title>
                  </v-list-item>
                    <v-list-item>
                    <v-list-item-title @click="deleteItem(item)" style="cursor:pointer">
                      <v-icon>{{mdiDeleteEmpty}}</v-icon> Suprimer 
                    </v-list-item-title>
                  </v-list-item>
                </v-list>
            </v-menu>
          </template>
        </v-data-table>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="exportExcel()" outlined color="success">
        <v-icon>
          {{mdiSizeXs}}
        </v-icon>
          Exporter en Excel
        </v-btn>
      </v-card-actions>
      </v-card>
      </v-col>
    </v-row>
   </div>
 </div>
</template>
<script>
import store from '../../store/index.js'
import WaitingVue from './Waiting.vue'
import Swal from 'sweetalert2'
import { mdiPencilOutline,mdiSizeXs, mdiDeleteOutline, mdiDotsHorizontal,mdiDeleteEmpty,mdiCardAccountDetails} from '@mdi/js'
export default {
    data(){
        return {
          mdiDotsHorizontal,
          mdiCardAccountDetails,
          mdiPencilOutline,
          mdiDeleteOutline,
          mdiDeleteEmpty,
          mdiSizeXs,
          agentList: [],
          activitys : [],
          actviteId : '',
          services: [],
          serviceId : '',
          headers: [
                  { text: 'note', value: 'note', class: 'text-center' },
                  { text: 'agent', value: 'agent', class: 'text-center' },
                  { text: 'formation', value: 'formation', class: 'text-center' },
                  { text: 'activité', value: 'activite',class: 'text-center' },
                  { text: 'service', value: 'service', class: 'text-center' },
                  { text: 'Actions', value: 'actions', class: 'text-center' },  
                   ],
          search : '',
          waiting : false ,
          nodatafound : false ,
        }
          },
    components: {
      WaitingVue
    },
    computed : {
      servicesOption(){
        if(this.actviteId){
        const serv =this.services.filter(x=>x.activite_id === this.actviteId)
        return serv
                }
      }
    },
    methods: {
    deleteItem(item) {
        Swal.fire({
        title: 'Vous allez supprimer ce module de formation  ! cette opération est irréversible.',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Ok',
        denyButtonText: `annuler`,
        }).then((result) => {
          if (result.isConfirmed) {
            store.dispatch('deleteNoteAgent',item.id)
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
    exportExcel(){
      this.waiting = true 
      store.dispatch('ExtractNotes')
      .then((response)=>{
      if(response.status === 200){ 
        let blob = new Blob([response.data], { type: 'application/vnd.ms-excel' });
        let url = window['URL'].createObjectURL(blob);
        let a = document.createElement('a');
        a.href = url;
        a.download = 'Liste_des_notes_des_agents.xlsx';
        a.click();
        window['URL'].revokeObjectURL(url);
      }
      })
      .then(()=>{
        this.waiting  = false
      })

    },
       handlItems(){
       if(this.actviteId === '' || this.serviceId === '') {
         if(this.actviteId === ''){
             Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir l'activité ",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
         else if(this.serviceId  === '' ){
            Swal.fire({
                        icon: 'error',
                        title: "Vous devez choisir le service",
                        showConfirmButton: false,
                        timer: 3000
              })
         }
       }
       else {
         this.sendData()
       }
     },
      sendData(){
          this.waiting = true
          const details = {
            actviteId : this.actviteId,
            serviceId : this.serviceId
          }
          store.dispatch('getAgentNotesFilter',details)
          .then((response)=>{
            if(response.data === 'nodatafound') {
              alert('aucune note trouvée pour ce service')
              this.getAgents()
            }
            else {
              this.agentList = response.data
            }
            
          })
          .then(()=>{
            this.waiting = false 
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
        },
      deleteItems(){
        this.actviteId = ''
        this.serviceId = ''
      },
      consulter(item){
          this.$router.push({name: 'detail-response', params: { agent_id: item.agent_id , group_quiz_id: item.quiz_simple_groups_id } })
      },
      getAgents(){
         this.waiting = true  
         store.dispatch('getAgentNotes')
         .then((response)=>{
           if(response.data == 'nodatafound'){
             this.nodatafound = true
           }
           else {
          this.agentList = response.data
           }
          })
          .then(()=>{
            this.waiting = false 
          })
         .catch(err=>{
          console.log(err)
          })
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
    },
     mounted(){
      this.getAgents()
      this.getActivities()
      this.getServices()
      },
}
</script>
