<template>
<div>
    <v-row  v-if="!data">
        <v-col cols="12" md="12" sm="12" lg="12">
                <v-card class="text-center">
                    <v-card-text>
                        <WaitingBarVue/>
                    </v-card-text>
                </v-card>
        </v-col>
    </v-row>
  <v-row v-else>
      <v-col cols="12" md="12" sm="12" lg="12">
        <v-card class="mx-auto my-12" max-width="100%">
            <v-card-title>
                    <h3 class="mx-auto">
                        Liste des activitées :
                    </h3>
            </v-card-title>
            <v-card-text>
                    <v-row class="mb-auto">
                        <v-col md="2" sm="2" lg="2" cols="2">
                            <v-btn color="primary" outlined @click="add">
                                Ajouter une nouvelle activité 
                            </v-btn>
                        </v-col>
                    </v-row>
                <v-data-table :headers="headers" :items="activites" >
                    <template v-slot:item.statut="{ item }">
                        <v-chip outlined color="success" v-if="item.statut==='1'">
                        Active
                        </v-chip>
                        <v-chip color="error" outlined v-if="item.statut==='0'">
                        Inactive
                        </v-chip>
                    </template>
                <template v-slot:item.action="{ item }">
                    <v-menu>
                       <template v-slot:activator="{ on, attrs }" >
                          <v-icon  color="black" dark v-bind="attrs" v-on="on">
                            {{mdiDotsHorizontal}}
                          </v-icon>
                       </template>
                       <v-list>
                            <v-list-item>
                            <v-list-item-title>
                                <p outlined color="info" style="cursor:pointer" @click="handleClick(item)">
                                Modifier
                                </p>
                            </v-list-item-title>
                            </v-list-item>
                            <v-list-item >
                            <v-list-item-title>
                                <p @click="handlItem(item)" style="cursor:pointer" outlined color="success" v-if="item.statut==='0'">
                                Activer
                                </p>
                                <p color="error" style="cursor:pointer"  @click="handlItem(item)" outlined v-if="item.statut==='1'">
                                Desactiver 
                                </p>
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                       </v-menu>
                </template>
                </v-data-table>
            </v-card-text>
        </v-card>
      </v-col>
  </v-row>
</div>
</template>
<script>
import store from '../../store/index.js'
import { mdiDotsHorizontal } from '@mdi/js';
import WaitingBarVue  from './WaitingBar';
import Swal from 'sweetalert2';
export default {
    data(){
        return {
            mdiDotsHorizontal,
            headers: [
                 { text: 'activite', value: 'nom',  class: 'text-center' },
                 { text: 'statut', value: 'statut',  class: 'text-center'},
                 { text: 'Action', value: 'action',  class: 'text-center'},

            ],
            activites : [],
            data: false,
        }
    }, 
    created(){
    store.dispatch('getActivities')
      .then((response)=>{
       this.activites = response
      })
      .then(()=>{
          this.data = true
      })
      .catch(err=>{
          console.log(err)
        })
    },
    methods: {
        add(){
            this.$router.push({name:'add-activite'})
        },
        handlItem(item){
            const data = {
                id: item.id,
                statut : item.statut
            }
            store.dispatch('handlActivite',data)
            .then((response)=>{
                if(response.status===200){
                    Swal.fire({
                        icon: 'Sucess',
                        title: "Activité a été bien chnagé",
                        showConfirmButton: false,
                        timer: 3000
                    }).then(()=>{
                         this.$router.go(0)
                    })
                }
            })
        },
        handleClick(item){
            this.$router.push({
                name: 'service',params: { id: item.id }
            })
        }
    },
    components : {
        WaitingBarVue,
    }
}
</script>