
<template>
 <div>
   <div v-if="done">
    <v-tabs v-model="tab" show-arrows>
      <v-tab v-for="tab in tabs" :key="tab.icon">
        <v-icon size="20" class="me-3">{{ tab.icon }}</v-icon>
        <span>{{ tab.title }}</span>
      </v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <account-settings-account :WaveId="WaveId" :service_id="service_id" ></account-settings-account>
      </v-tab-item>
      <v-tab-item>
        <account-settings-security :WaveId="WaveId" ></account-settings-security>
      </v-tab-item>
    </v-tabs-items>
  </div>
<div v-else>
  <div v-if="Waiting">
    <waiting-vue/>
  </div>
   <div v-else >
     <v-row   >
 <v-col cols="12" md="12" sm="12" lg="12">
    <v-card flatclass="pa-3 mt-2">
         <v-card-title><h2 class="mx-auto">Etat de présence : </h2></v-card-title>
  <v-card-text>
    <v-row>
      <v-col cols="4" md="4" sm="4" lg="4">
         <v-menu ref="menuref" v-model="menu1" :close-on-content-click="false" transition="scale-transition" offset-y max-width="290px" min-width="auto">
              <template v-slot:activator="{ on, attrs }">
                <v-text-field v-model="dateFormatted" label="Date de l'état de présence :" persistent-hint :prepend-icon="icons.mdiCalendar" v-bind="attrs" max-width="29px" v-on="on" ></v-text-field>
              </template>
            <v-date-picker v-model="date" no-title color="primary" @input="menu1 = false" ></v-date-picker>
          </v-menu>
      </v-col>
      <v-col md="1" lg="1" sm="1" cols="1"/>
      <v-col md="2" lg="2" sm="2" cols="2" >
       <v-switch v-model="pauseDej" label=" pause déj ?  " color="primary" hide-details></v-switch>
      </v-col>
      <v-col md="1" lg="1" sm="1" cols="1"/>
      <v-col md="4" lg="4" sm="4" cols="4">
          <span>
            <v-select :prepend-icon="mdiGoogleMaps" :items="sites" v-model="site" label="Site :" style="width: 100%"></v-select>
          </span>
      </v-col>
     </v-row>
     <v-row>
        <v-col cols="4" md="4" sm="4" lg="4">
          <v-dialog v-model="modal1" :return-value.sync="startTime" ref="dialog1" persistent width="290px">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field v-model="startTime" readonly label="heure de début formation* : " :prepend-icon="icons.mdiClockTimeFourOutline"  v-bind="attrs" v-on="on"></v-text-field>
            </template>
            <v-time-picker v-if="modal1"   v-model="startTime" color="primary" full-width>
              <v-spacer></v-spacer>
              <v-btn text color="warning" @click="modal1 = false">annuler </v-btn>
              <v-btn text color="primary" @click="$refs.dialog1.save(startTime)"   >Enregistrer</v-btn>
            </v-time-picker>
          </v-dialog>
        </v-col>
        <v-col cols="4" lg="4" md="4" sm="4">
          <v-dialog ref="dialog2" v-model="modal2" :return-value.sync="endTime" persistent width="290px">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field  v-model="endTime" readonly label="heure de fin formation* : " :prepend-icon="icons.mdiClockTimeFourOutline"  v-bind="attrs" v-on="on"></v-text-field>
            </template>
            <v-time-picker v-if="modal2" v-model="endTime" color="primary" full-width>
              <v-spacer></v-spacer>
               <v-btn text color="warning" @click="modal2 = false">annuler </v-btn>
              <v-btn text color="primary" @click="$refs.dialog2.save(endTime)" >Enregistrer</v-btn>
            </v-time-picker>
          </v-dialog>
        </v-col>
     </v-row>
  </v-card-text>
  <v-card-actions>
    <v-row>
      <v-col cols="2">
        <v-btn color="info" outlined  small @click="addNewAgent()" >Ajouter un nouveau agent a cette formation  </v-btn>
      </v-col>
      <v-col cols="7" md="7" sm="7" lg="7"></v-col>
      <v-col cols="3" sm="3" md="3" lg="3">
         <v-btn color="warning" outlined  small @click="handlDelete()" >effacer</v-btn>
         <v-btn color="primary" outlined  small @click="handlRequest()"> valider </v-btn>
      </v-col>
    </v-row>
  </v-card-actions>
</v-card>
 </v-col>
</v-row>
<v-row >
  <v-col cols="12" md="12" sm="12" lg="12">
    <v-card>
  <v-card-text>
      <v-list rounded class="mt-4">
      <v-list-item-group color="primary">
        <v-list-item v-for="(item, index) in formationsList" :key="index">
          <v-list-item-icon><v-icon v-text="icons.mdiAccountConvert"> </v-icon></v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title  >{{item.agent}} 
              <div class="d-flex float-right">
                <v-select :items="items" item-text="value" item-value="value" label="Etat de présence :" hide-details v-model="item.etat" @change="SelectTime(item)"></v-select>
              </div>
            </v-list-item-title> 
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-card-text>
  <v-card-actions>
  <v-row class="mb-5 d-flex justify-content-center">
      <v-col lg="12" md="12" sm="12Z" cols="12">
        <v-btn outlined color="primary" style="width:50%; margin-left:20%; margin-right:20%" class="  mt-4" @click="sendRequest">Terminer</v-btn>
      </v-col>
    </v-row>
  </v-card-actions>
</v-card>
  </v-col>
</v-row>
</div>
  <div class="dialog-retad-agent">
   <v-row justify="space-around">
    <v-col cols="auto">
       <v-dialog v-model="Retard" persistent transition="dialog-bottom-transition" max-width="600px">
        <v-card>
          <v-card-text>
              <v-dialog v-model="retard1" :return-value.sync="startTimeRetard" ref="retard1" persistent width="290px" height="300px">
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field v-model="startTimeRetard" readonly label="heure de début formation*: " :prepend-icon="icons.mdiClockTimeFourOutline"  v-bind="attrs" v-on="on"></v-text-field>
                    </template>
                    <v-time-picker v-if="retard1"   v-model="startTimeRetard" color="primary" full-width>
                      <v-spacer></v-spacer>
                      <v-btn text color="warning" @click="retard1 = false">annuler </v-btn>
                      <v-btn text color="primary" @click="$refs.retard1.save(startTimeRetard)"   >Enregistrer</v-btn>
                    </v-time-picker>
              </v-dialog>
              <v-dialog v-model="retard2" :return-value.sync="endTimeRetard" ref="retard2" persistent width="290px" height="300px">
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field v-model="endTimeRetard" readonly label="heure de fin formation*: " :prepend-icon="icons.mdiClockTimeFourOutline"  v-bind="attrs" v-on="on"></v-text-field>
                    </template>
                    <v-time-picker v-if="retard2"   v-model="endTimeRetard" color="primary" full-width>
                      <v-spacer></v-spacer>
                      <v-btn text color="warning" @click="retard2 = false">annuler </v-btn>
                      <v-btn text color="primary" @click="$refs.retard2.save(endTimeRetard)"   >Enregistrer</v-btn>
                    </v-time-picker>
              </v-dialog>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary"  @click="handle" outlined width="100%">
                Enregistrer
            </v-btn>
          </v-card-actions>
        </v-card>
    </v-dialog>
    </v-col>
   </v-row>
  </div>
</div>
 </div>
</template>

<script>
import store from '../../../store/index.js'
import TimePicker from './Timepicker.vue'
import { mdiAccountConvert,mdiCalendar,mdiGoogleMaps,mdiClockTimeFourOutline,mdiAccountMultiplePlusOutline,mdiAccountGroupOutline } from '@mdi/js';
import Swal from 'sweetalert2'
import WaitingVue from  './Waiting.vue'
import AccountSettingsAccount from '../AccountSettingsAccount.vue'
import AccountSettingsSecurity from '../AccountSettingsSecurity.vue'


export default {
  components : {
       TimePicker,
       WaitingVue,
       AccountSettingsAccount,
       AccountSettingsSecurity,
  },
    data(){
      return {
              menu2 : false,
              pauseDej : false ,
              rules :[ v=>v.length > 0 || 'ce champs est obligatoire'],
              startTime: '',
              endTime: '',
              end: '',
              datapicker: {
                    startTime : '',
                    endTime: '',
              },
              selected: '',
              isDialogVisible: false,
              items : [
                { label: 'Présent', value: 'Présent' },
                {label : 'Retard' ,value: 'Retard'},
                { label: 'Absent', value: 'Absent' },
                { label: 'Abandon', value: 'Abandon' },
                ],
              date : '',
              menu1: '',
              icons: {
                    mdiAccountConvert,
                    mdiCalendar,
                    mdiClockTimeFourOutline
                },
              mdiGoogleMaps,
              etatPresence : null,
              isDialogVisible: '',
              choosedCountry : '',
              countryList : [
                { label: 'Présent', value: 'Présent' },
                {label : 'Retard' ,value: 'Retard'},
                { label: 'Absent', value: 'Absent' },
                { label: 'Abandon', value: 'Abandon' },
                ],
              Retard :false,
              endTimeRetard : '',
              startTimeRetard : '',
              itemRetard : '',
              toggleCheckboxOne : 'présent',
              formationsList: [], 
              headers: [
                  { text: 'Agent', value: 'agent' ,  align: 'center', },
                  { text: 'Etat de présence' , value:'etatpre', align: 'center'  },
                  { text: "Heure d'arrivé " , value:'heurA', align: 'center' },
                  { text: "Heure départ" , value:'heurD', align: 'center'  },
               ],
              agents : {},
              agentsWithTime : [],
              check : true,
              notremplied : false,
              sites: ['TA', 'TE', 'HO', 'BDX','NSL'],
              site: '',
              Waiting : false,
              modal1 : false,
              modal2 : false ,
              retard1 : false,
              retard2 : false,
              done : false,
              tab : '',
              WaveId : '',
              service_id : '',
              tabs : [
                { title: 'Nouveaux Agents ', icon: mdiAccountMultiplePlusOutline  },
                { title: 'Anciens Agents ', icon: mdiAccountGroupOutline  },
              ]
            }
    },
     mounted(){
     this.getFormations()
        },
  computed: {
  dateFormatted(){
        if (!this.date) return null
        return this.date
  }
  },
  methods: {
      handlDelete(){
          this.site = ''
          this.date = ''
          this.pauseDej = false
          this.startTime = ''
          this.endTime = ''
      },
      handlRequest(){
              if(this.date === '' || this.site === '' || this.startTime === '' || this.endTime=== ''){
                 if(this.date === ''){
                  Swal.fire({
                  icon: 'error',
                  title: "vous n'avez pas selectionner la date " ,
                  showConfirmButton: true,
                  timer: 30000
                  })
                }
                else if(this.site === '' ) {
                  Swal.fire({
                  icon: 'error',
                  title: "vous n'avez pas selectionner le site" ,
                  showConfirmButton: true,
                  timer: 30000
                  })
                }
                else if(this.startTime === ''){
                  Swal.fire({
                  icon: 'error',
                  title: "vous n'avez pas insérer l'heure  de debut de formation " ,
                  showConfirmButton: true,
                  timer: 30000
                  })
                }
                else if(this.endTime=== ''){
                  Swal.fire({
                  icon: 'error',
                  title: "vous n'avez pas insérer l'heure  de debut de formation " ,
                  showConfirmButton: true,
                  timer: 30000
                  })
                }
              }
              else {
                this.formationsList.forEach(element=>{
                    element.etat = 'Présent'
                    element.startTime =  this.startTime
                    element.endTime = this.endTime
                })
              }
      },
      sendRequest2(){
         this.Waiting = true 
          const details = {
              date : this.date,
              agentsList : this.formationsList,
              site: this.site,
              pauseDej : this.pauseDej
          }
          store.dispatch('statofpresence',details)
          .then((response)=>{
              if(response.status===200) {
                Swal.fire({
                icon: 'success',
                title: `Félicitations ! l'état de présence a été injectée avec succès` ,
                showConfirmButton: true,
                timer: 300000
                })
                .then(()=>{
                   this.Waiting = false
                })
                .then(()=>{
                    this.$router.go(0)
                })
              
              }
      })
      },
      sendRequest(){
  if(this.check){
        this.formationsList.forEach(x=>{
        if(x.etat== "" ){
            Swal.fire({
            icon: 'error',
            title: `vous n'avez  selectionner l'état de présence du l'agent :  ${x.agent}` ,
            showConfirmButton: true,
            timer: 30000
            })
            }
        })
        if(this.date === ''){
        Swal.fire({
            icon: 'error',
            title: "vous n'avez pas selectionner la date " ,
            showConfirmButton: true,
            timer: 30000
            })
            }
            else {
                this.check = false
            }
            }
            if(!this.check) {
                this.sendRequest2()
            }
         
          
      },
    SelectTime(item){
        this.formationsList.map(element=>{
         if(element.agent_id== item.agent_id){
             if( item.etat === 'Absent'  || item.etat === 'Abandon') {
              if(item.etat === 'Abandon'){
               item.startTime = ''
                item.endTime = ''
                item.etat === 'Abandon'
              }
               if(item.etat === 'Absent'){
                 item.startTime = ''
                 item.endTime = ''
                 item.etat === 'Absent'
              }    
             } 
             if( item.etat === 'Retard' ) {
                  this.Retard = true
                  this.itemRetard = item    
             }

             }
          })
      },
      handle(){
        this.formationsList.map(x =>{
         if( x.agent_id === this.itemRetard.agent_id){
            x.startTime = this.startTimeRetard
            x.end = this.endTimeRetard
            this.Retard = false 
         }
        })
      
      },
  getFormations(){
    this.Waiting = true
    this.WaveId = parseInt(this.$route.params.id)
    store.dispatch('getFormationsDetail', this.$route.params.id)
    .then(response=>{
        this.formationsList = response.data.agents
        this.service_id = response.data.service_id
    })
    .then(()=>{
      this.Waiting = false
    })
  },
  push(id){
    this.$router.push({
      name:'detail-formation', params: { id }
    })
  },
  addNewAgent(){
    this.done = true
  }
  },
}
</script>
