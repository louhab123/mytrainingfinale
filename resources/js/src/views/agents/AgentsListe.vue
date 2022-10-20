<template>
  <v-card >
  <v-card-title><h3 class="mx-auto">Liste des agents :</h3> </v-card-title>
    <v-card-text>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    <v-data-table :headers="headers" :items="agentList" :items-per-page="7" :search="search" :loading="loading" loading-text="veuillez attendre pour  le chargement des agents ...  ">
     <template v-slot:item.nom="{ item }">
          <v-icon>
                {{mdiAccount}}
          </v-icon>
          {{item.nom}}
      </template>
      <template v-slot:item.action="{ item }">
            <v-menu >
              <template v-slot:activator="{ on, attrs }" >
                <v-icon dark v-bind="attrs" color="black"  v-on="on">{{mdiDotsHorizontal}}</v-icon>
              </template>
                <v-list>
                  <v-list-item-group color="primary" >
                  <v-list-item @click="agentGetDetails(item.id)" >
                      <v-icon class="mr-2">
                        {{mdiCardAccountDetails}}
                      </v-icon>
                      <v-list-item-content  >
                        <v-list-item-title outlined >
                          Plus de détails  
                        </v-list-item-title>
                      </v-list-item-content>
                  </v-list-item>
               </v-list-item-group>
                </v-list>
            </v-menu>
          </template>
   </v-data-table>
    </v-card-text>
 
  </v-card>
</template>
<script>
import store from '../../store/index.js'
import { mdiAccount , mdiCardAccountDetails ,mdiDotsHorizontal} from '@mdi/js'
export default {
    data(){
        return {
        agentList: [],
        mdiAccount,
        mdiCardAccountDetails,
        mdiDotsHorizontal,
        headers: [
        { text: 'nom', value: 'nom' },
        { text: 'email', value: 'email' },
        { text: 'action', value: 'action' },

          ],
        loading : false,  
        search : '',
        }
    },
    methods: {
      agentGetDetails(id){
        this.$router.push({name: 'detail-agent', params: { agent_id: id } }) 
        },
        getAgents(){
          this.loading = true
          store.dispatch('getAgents')
          .then((response)=>{
          this.agentList = response
          })
          .then(()=>{
            this.loading = false
          })
         .catch(err=>{
          console.log(err)
        })
        }
    },
     mounted(){
    this.getAgents()
  },
}
</script>
