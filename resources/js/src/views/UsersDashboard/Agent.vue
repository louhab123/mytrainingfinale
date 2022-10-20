<template>
   <div>
      <v-navigation-drawer v-if="sideBarre" height="40vh" class="sideBarre" absolute permanent right>
        <template v-slot:prepend>
          <v-list-item two-line>
            <v-list-item-avatar><img :src="require('@/assets/images/avatars/1.png').default" ></v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>{{user}}</v-list-item-title>
              <v-list-item-subtitle>Connecté(e)</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </template>
        <v-divider></v-divider>
            <v-text-field
              label="Search"
              append-icon="mdi-magnify"
              style="width:85%;margin-left:5%; margin-top:3%"
              placeholder="Search" 
              filled 
              rounded 
              dense 
              single-line 
            ></v-text-field>
        <v-list dense>
          <v-list-item v-for="(formateur,index) in formateurListe" :key="index" link>
            <v-list-item-avatar>
              <v-img :src="require('@/assets/images/avatars/2.png').default" ></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
                <v-list-item-title link @click="openModal(formateur)">
                  {{formateur.nom}} {{formateur.prenom}}
                </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
       <v-row>
           <v-col md="4" sm="4" lg="4" cols="4">               
               <v-card  class="mx-auto" max-width="344">
                   <v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" height="200px"></v-img>
                     <v-card-title>Bienvenue</v-card-title>
                     <v-card-subtitle>  </v-card-subtitle>
                     <v-card-actions>
                          <v-avatar tile color="blue">
                                <v-icon dark>{{mdiClockOutline}}</v-icon>
                          </v-avatar>
                          <h3 class="ml-2">
                              {{clock}}
                          </h3>   
                    </v-card-actions>
                      <v-card-actions>
                          <v-avatar tile color="blue">
                                <v-icon dark>{{mdiCalendarRange}}</v-icon>
                          </v-avatar>
                          <h3 class="ml-2">
                              {{today}}
                          </h3>   
                    </v-card-actions>
                    <v-spacer></v-spacer>
                     <v-expand-transition>
                        <div>
                            <v-divider></v-divider>
                            <v-card-text>
                           La formation ne trahit jamais celui qui prend soin d'elle.
                            </v-card-text>
                        </div>
                    </v-expand-transition>
               </v-card>
           </v-col>
           <v-col cols="8" md="8" lg="8" sm="8">
               <v-card class="mx-auto" color="#26c6da" dark max-width="100%" max-height="100%">
                   <v-card-title>
                       <v-icon large left> </v-icon>
                       <span class="text-h6 font-weight-light">Mytraining</span>
                   </v-card-title>
                    <v-card-text class="text-h5 font-weight-bold">
                    "La formation en centre d’appels est essentielle à la réussite de la relation client." <br/>
                    </v-card-text>
                    <v-card-actions>
                        <v-list-item class="grow">
                          <v-list-item-avatar color="grey darken-3">
                            <v-img class="elevation-6" alt="" src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"></v-img>
                          </v-list-item-avatar>
                          <v-list-item-content>
                            <v-list-item-title>{{user}}</v-list-item-title>
                           </v-list-item-content>
                        </v-list-item>
                    </v-card-actions>
               </v-card>
           </v-col>
       </v-row>
        <fab 
          :actions="fabActions"
          bg-color="#2e5aff"
          main-icon ="email"
          main-tooltip ="De l'aide ?"
          @NewMessage = "NewMessage"
          @Messages = "Messages"
          ></fab>                
       <v-dialog v-model="dialogNewMessage">
          <v-card>
            <v-card-title primary-title class="justify-center">
              <h3 class="headline pink--text text--accent-2"> 
                Contacter vos formateurs pour vous aider
              </h3>
            </v-card-title>
            <v-card-subtitle class="text-center">
             Améliorer la qualité de vos formations
            </v-card-subtitle>
            <v-divider></v-divider>
            <v-card-text>
              <v-container fluid>
                <v-textarea auto-grow fluid v-model="messageToSend">
                </v-textarea>
              </v-container>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="warning" outlined x-small @click=" cancel()">
                <v-icon color="warning">{{mdiCloseBox}}</v-icon> Annuler
              </v-btn>
              <v-btn color="primary" outlined x-small @click="sendMessage">
                <v-icon color="primary" >{{mdiCheckOutline }}</v-icon> Envoyer
              </v-btn>
            </v-card-actions>
          </v-card>
       </v-dialog>
       <dialogNewMessage v-if="sending"/>
       <MessagesreceivedsVue v-if="showMessages"/>
   </div>
</template>
<script>
import { mdiClockOutline,mdiCalendarRange,mdiAccount,mdiCheckOutline,mdiCloseBox, MdiMagnify } from '@mdi/js';
import fab from 'vue-fab'
import store  from '../../store/index.js'
import dialogNewMessage from './components/DialogLoading.vue'
import MessagesreceivedsVue from './Messagesreceiveds.vue'
import Swal from 'sweetalert2'
export default {
      components : {
        fab,
        dialogNewMessage,
        MessagesreceivedsVue,
        
      },
    data(){
        return {
            user : '',
            clock : null,
            today : null,
            userId : 0,
            mdiClockOutline,
            mdiCalendarRange,
            mdiAccount ,
            mdiCloseBox,
            mdiCheckOutline,
            MdiMagnify,
            fabActions : [
                     {
                      name: 'NewMessage',
                      icon: 'send',
                      tooltip: "Vous voulez d'aide ? contacter vos formateurs ",
                    },
                    {
                      name: 'Messages',
                      icon: 'drafts',
                      tooltip: "Vos messages ",
                    },
            ],
            formateurListe: [],
            sideBarre : false,
            dialogNewMessage :false,
            formateur: {},
            messageToSend: '',
            sending:false,
            showMessages : false,
            messages : 0,
            search : '',
        }
    },
    created(){
            this.userId=parseInt(sessionStorage.getItem('userId'))
            this.user=sessionStorage.getItem('user')
            const today = new Date()
            const dd = String(today.getDate()).padStart(2, '0')
            const mm = String(today.getMonth() + 1).padStart(2, '0') // January is 0!
            const yyyy = today.getFullYear()
            this.today = `${dd}/${mm}/${yyyy}`
            store.dispatch('getFormateurs')
            .then(response=>{
              this.formateurListe = response.data
            })
    },
    methods: {

    showTime() {
      const date = new Date()
      let h = date.getHours() // 0 - 23
      let m = date.getMinutes() // 0 - 59
      let s = date.getSeconds()
      let session = 'AM'
      if (h === 0) {
        h = 12
      }
      if (h > 12) {
        h -= 12
        session = 'PM'
      }
      h = h < 10 ? `0${h}` : h
      m = m < 10 ? `0${m}` : m
      s = s < 10 ? `0${s}` : s

      const time = `${h}:${m}:${s} ${session}`
      this.clock = time
    },
    NewMessage(){
    this.sideBarre = true
    },
    openModal:function(formateur){
      this.formateur = formateur
      this.dialogNewMessage = true
      this.sideBarre = false
    },
    Messages(){
        this.showMessages = true
         this.dialogNewMessage = false
    },
    sendMessage(){
      this.sending = true
      this.dialogNewMessage = false
      const data = {
            userId :  this.userId,
            formateurId : this.formateur.id,
            message : this.messageToSend
          }
      store.dispatch('sendMessage',data)
      .then((response)=>{
        if(response.data === 'message_has_send'){
          this.sending = false
             Swal.fire({
                    icon: 'success',
                    title: 'Le message a été bien envoyé ! ',
                    showConfirmButton: false,
                    timer: 3000
                    })    
        }
      })
      .then(()=>{
        this.messageToSend = '' 
      })
      .catch((err)=>{
        console.log(err)
      })    
    },
    cancel(){
      this.dialogNewMessage = false
      this.messageToSend = ''
    }
    },
    mounted() {
        this.$nextTick(() => {
          window.setInterval(() => {
            this.showTime()
          }, 1000)
        })
      },
      computed:{
      search2(){
        var newFormateur = []
        if(this.search.length > 0){
        newFormateur =    this.formateur.filter(x=>{
              x.nom.theString.match(this.search) || x.prenom.theString.match(this.search)
            })
        }
        this.formateur = newFormateur
      }
      }
}
</script>
<style>
.sideBarre{
  margin-top: 25%;
}

</style>