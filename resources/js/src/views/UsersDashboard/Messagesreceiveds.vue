<template>
    <div>
        <v-dialog v-model="dialog">
            <v-card >
                <v-card-title  class="justify-center">
                    <h3 class="headline pink--text text--accent-2"> 
                        Liste des messages reçus :
                    </h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <WaitingBarVue v-if="waiting"/>
                    <v-list v-else>
                        <v-list-group  no-action   v-for="(message,index) in messagesReciveds" :key="index">
                                
                               <template #activator>
                                   <v-list-item-avatar>
                                        <v-img :src="require('@/assets/images/avatars/2.png').default" ></v-img>
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                    <v-list-item-title v-text="message[0].agent"></v-list-item-title>
                                    </v-list-item-content>
                                </template>
                                <v-divider></v-divider>
                                 <v-list-item>
                                    <v-list-item-content>
                                        <v-card>
                                            <v-card-text style="border:1px solid red">
                                                <div class="agent" v-for="(agentMessages,index) in message" :key="index">
                                                  <v-list-item-avatar>
                                                    <v-img :src="require('@/assets/images/avatars/2.png').default" ></v-img>
                                                   </v-list-item-avatar>
                                                   <strong>
                                                    {{agentMessages.agent_fullName}} :
                                                   </strong>   
                                                      {{agentMessages.message}}
                                                </div>
                                            </v-card-text>
                                            <v-card-text>
                                            <v-form v-if="role==='formateur'">
                                                <v-container>
                                                    <v-text-field
                                                    v-model="messageToSend"
                                                    clearable
                                                    label="Votre réponse....."
                                                    :clear-icon="mdiCloseCircle"
                                                    filled
                                                    @click:clear="clearMessage"
                                                    :append-outer-icon="mdiSend"
                                                    @click:append-outer="answer(message[0].agent_id)"
                                                    >

                                                    </v-text-field>
                                                </v-container>
                                            </v-form>
                                            </v-card-text>
                                        </v-card> 
                                    </v-list-item-content>
                                </v-list-item>
                        </v-list-group>   
                    </v-list>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions class="justify-end">
                    <v-btn  text color="orange" outlined x-small @click="handleModal">
                        <v-icon  color="secondary" >{{mdiCheckOutline }}</v-icon> Ok
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <dialogNewMessage v-if="sending"/>
    </div>
</template>
<script>
import { 
 mdiStarOutline,
 mdiStar,
 mdiSilverwareForkKnife,
 mdiSchoolOutline,
 mdiCloseBox,
 mdiCheckOutline,
 mdiCloseCircle,
 mdiSend,
 } from '@mdi/js'
import store  from '../../store/index.js'
import WaitingBarVue from './components/Waiting.vue'
import dialogNewMessage from './components/DialogLoading.vue'
import Swal from 'sweetalert2'
export default {
    props: {
    },
    components: {
        WaitingBarVue,
        dialogNewMessage
    },
    data(){
        return {
            dialog:true,
            mdiStarOutline,
            mdiCheckOutline,
            mdiSilverwareForkKnife,
            mdiSchoolOutline,
            mdiStar,
            mdiCloseCircle,
            messagesReciveds : [],
            agentIdToAnswer : 0,
            mdiCloseBox,
            mdiSend ,
            dialogNewMessage : false,
            messageToSend : '',
            waiting : false,
            sending : false,
            role : '',
        }
    },
    methods: {
        handleModal(){
            this.dialog = false
        },
        getAllMessage(){
            this.waiting = true
            store.dispatch('getAllMessages')
            .then((response)=>{
                this.messagesReciveds = response.data
            })
            .then(()=>{
                this.waiting = false
            })
            .catch((error)=>{
                console.log(error)
            })
        },
        answer(agent_id){
            this.dialog = false 
            this.sending = true
            const data = {
                message : this.messageToSend,
                agent_id : agent_id,
            }
            store.dispatch('answerToAgentMessage',data)
            .then((response)=>{
                if(response.data === 'message_has_send'){
                    this.sending = false
                    this.messageToSend = ''
                    Swal.fire({
                    icon: 'success',
                    title: 'Le message a été bien envoyé ! ',
                    showConfirmButton: false,
                    timer: 3000
                    }) 
                }
            })
        },
        sendMessage(){

        },
        cancel(){
            this.messageToSend = ''
        },
        clearMessage () {
         this.cancel()
        },
        },
    mounted(){
        this.getAllMessage()  
        this.role = sessionStorage.getItem('role')
    }
}
</script>