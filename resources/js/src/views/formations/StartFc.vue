<template>
    <div >
  <v-card v-if="!done" flat class="pa-3 mt-2">
      <v-card-title><h2 class="mx-auto">Créer une nouvelle formation continue  :</h2>
      </v-card-title>
<v-alert v-if="alert" color="error" dark class="mb-0">
     Vous devez remplir tous les champs svp . vous n'avez pas Renseigner le champ : {{shamp}}
</v-alert>
    <v-form class="multi-col-validation">
      <v-card-text class="pt-5">
        <v-row>
          <v-col cols="6" lg="6" sm="6" md="6">
            <v-select :items="items" item-text="value" item-value="value" label="Site :" hide-details v-model="site"></v-select>
          </v-col>
          <v-col cols="6" lg="6" sm="6" md="6">
            <v-select item-text="nom" item-value="id" v-model="actviteId" label="Activité" :items="activitys"></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6" lg="6" sm="6" md="6">
            <v-select item-text="nom" v-model="serviceId" item-value="id" label="Service" :items="servicesOption" ></v-select>
          </v-col>
          <v-col>
            <v-text-field label="Nom  de formation " persistent-hint v-model="nom"></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-text>
        <v-row>
    <v-col cols="6" lg="6" sm="6" md="6">
      <v-menu
        ref="menuref"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        max-width="290px"
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            label="Date de Début * "
            persistent-hint
            v-bind="attrs"
            v-model="dateDebut"
            :prepend-icon="icons.mdiCalendar"
            v-on="on"
          ></v-text-field>
        </template>

        <v-date-picker
          v-model="dateDebut"
          no-title
          color="primary"
          @input="menu1 = false"
        ></v-date-picker>
      </v-menu>
    </v-col>
    <v-col
      cols="12"
      lg="6"
    >
      <v-menu
        ref="menuref"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        max-width="290px"
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            label="Date de fin *"
            persistent-hint
             v-model="dateFin"
            :prepend-icon="icons.mdiCalendar"
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>

        <v-date-picker
          v-model="dateFin"
          no-title
          color="primary"
          @input="menu1 = false"
        ></v-date-picker>
      </v-menu>
    </v-col>
  </v-row>
      </v-card-text>
      <v-card-actions>
         <v-col md="10" sm="10" lg="10" cols="10"/> 
     <v-col md="2" sm="2" lg="2" cols="2">
          <v-btn
          color="primary"
          class="me-3 mt-3"
          @click="startFormation"
          outlined
        >
          Enregistrer
        </v-btn>
     </v-col>
      </v-card-actions>
    </v-form>

  </v-card>
<div  v-if="done">
<account-settings-security :WaveId="WaveId" ></account-settings-security>

</div>
</div>
   
</template>
<script>
import { mdiAccountOutline, mdiLockOpenOutline, mdiInformationOutline, mdiAccountMultiplePlusOutline, mdiAccountGroupOutline,mdiCalendar  } from '@mdi/js'
import { ref } from '@vue/composition-api'

// demos
import AccountSettingsAccount from './AccountSettingsAccount.vue'
import AccountSettingsSecurity from './AccountSettingsSecurity.vue'
import AccountSettingsInfo from './AccountSettingsInfo.vue'
import store from '../../store/index.js'
import Swal from 'sweetalert2'

export default {
  components: {
    AccountSettingsAccount,
    AccountSettingsSecurity,
    AccountSettingsInfo,
  },
  data(){
    return {
      userId : sessionStorage.getItem('userId'),
      done: false,
      activitys: [],
      services: [],
      shamp : '',
      alert: false,
      nom: '',
      statusC : '',
      statusN: '',
      status: '',
      WaveId : '',
      items :   ['TA','TE','HO','BDX','NSL'],
      site : '',
    }
  },
  methods: {
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
    },
    startFormationPost(){
     const detail = {
       actviteId :this.actviteId,
       serviceId : this.serviceId,
       site : this.site,
       dateDebut : this.dateDebut,
       dateFin : this.dateFin,
       userId : this.userId,
       nom : this.nom
     }
      store.dispatch('startFormationFCPost',detail)
      .then((response)=>{
       if(response.status===200){
         this.WaveId = response.data.wave_id
          this.done = true
           Swal.fire({
          icon: 'success',
          title: 'La formation a été ajoutée avec succés ! vous pouvez ajouter ou affecter des agents à cette formation ',
          showConfirmButton: true,
          timer: 3000
        }).then((response)=>{
          this.done = true
          
        })
       }
      })
   
    }
  },
  mounted(){
     this.getActivities()
     this.getServices()
  },
  computed:{
      servicesOption(){
        if(this.actviteId){
        const serv =this.services.filter(x=>
          x.activite_id === this.actviteId
        )
         return serv
  }
 
  } },
  setup() {
   
    const date = new Date().toISOString().substr(0, 10)
    const menu = ref(false)
    const modal = ref(false)
    const menu1 = ref(false)
    const menuref = ref(null)
    const dateFormatted = ref(null)
    const actviteId = ref(null)
    const serviceId = ref(null)
    const dateDebut = ref(null)
    const dateFin = ref(null)

    const tab = ref('')
    const picker = new Date().toISOString().substr(0, 10)
    // tabs
    const tabs = [
      { title: 'Nouveaux Agents ', icon: mdiAccountMultiplePlusOutline  },
      { title: 'Anciens Agents ', icon: mdiAccountGroupOutline  },
    ]
     function startFormation(ev) {
      ev.preventDefault();
       if(  !this.actviteId  || !this.serviceId  || !this.dateDebut || !this.dateFin ){
       if(!this.nom){
         this.alert= true
         this.shamp = 'nom'
       }
        if(!this.actviteId){
         this.alert= true
         this.shamp = 'actvite'
       }
          if(!this.serviceId){
         this.alert= true
         this.shamp = 'service'
       }
         if(!this.dateDebut){
         this.alert= true
         this.shamp = 'Date debut du formation'
       }
         if(!this.dateFin){
         this.alert= true
         this.shamp = 'Date fin du formation'
       }
       }
       else {
         this.alert =false
         this.startFormationPost()
       }

     }

    // account settings data

    return {
      startFormation,
      date,
      menu,
      modal,
      menu1,
      menuref,
      dateFormatted,
      tab,
      tabs,
      actviteId,
      serviceId,
      dateFin,
      dateDebut,
      picker,
      icons: {
        mdiCalendar,
        mdiAccountOutline,
        mdiLockOpenOutline,
        mdiInformationOutline,
        mdiAccountGroupOutline ,
        mdiAccountMultiplePlusOutline,
      },
    }
  },
}
</script>
