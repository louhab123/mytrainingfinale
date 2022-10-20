<template>
  <v-card  >
    <v-card-title>
    <h3 class="mx-auto">
      liste des formateurs   :
    </h3>  
    </v-card-title>
    <v-card-text>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    <v-data-table
    :headers="headers"
    :items="formateurs"
    :items-per-page="7"
    :search="search"
  ></v-data-table>
    </v-card-text>
 
  </v-card>
</template>
<script>
import store  from '../../store/index.js'
export default {
    data(){
        return {
            formateurs : [],
            headers: [
                    { text: 'nom', value: 'nom' },
                    {text : 'prenom', value: 'prenom'},
                    { text: 'email', value: 'email' },
                    ],
            search : '',
        }
    },
    created(){
        store.dispatch('getFormateurs')
        .then((response)=>{
            this.formateurs = response.data
        })
    }
}
</script>