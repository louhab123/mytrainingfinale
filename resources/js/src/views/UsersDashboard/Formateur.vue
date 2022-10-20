<template>
   <div>
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
       <div class="fab">
          <fab 
          :actions="fabActions"
          bg-color="#2e5aff"
          main-icon ="email"
          main-tooltip ="Contacter vos agents !"
          @Messages = "displayRecivedMessages"
          ></fab>
       </div>
       <MessagesreceivedsVue v-if="showMessages"/>
   </div>
</template>
<script>
import { mdiClockOutline,mdiCalendarRange  } from '@mdi/js';
import fab from 'vue-fab'
import MessagesreceivedsVue from './Messagesreceiveds.vue';
export default {
    components: {
      fab,
      MessagesreceivedsVue,
    },
    data(){
        return {
            clock : null,
            today : null,
            user : '',
            userId : 0,
            mdiClockOutline,
            mdiCalendarRange ,
            fabActions: [
                    {
                      name: 'Messages',
                      icon: 'drafts',
                      tooltip: "Vos messages reçus",
                    },
            ],
            showMessages : false,
        }
    },
    created(){
            this.user=sessionStorage.getItem('user')
            this.userId = parseInt(sessionStorage.getItem('userId'))
            const today = new Date()
            const dd = String(today.getDate()).padStart(2, '0')
            const mm = String(today.getMonth() + 1).padStart(2, '0') // January is 0!
            const yyyy = today.getFullYear()
            this.today = `${dd}/${mm}/${yyyy}`
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
    displayRecivedMessages(){
      this.showMessages = true
    }
    },
      mounted() {
          this.$nextTick(() => {
            window.setInterval(() => {
              this.showTime()
            }, 1000)
          })
        },
}
</script>