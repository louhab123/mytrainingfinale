<template>
    <div>
        <v-row>
            <v-col cols="12" md="12" sm="12" lg="12" >
        <v-card >
           <v-card-title><h2 class="mx-auto text-primary">Historique des formations initiales </h2></v-card-title>
           <v-card-text>
               <v-toolbar   >
                     <v-toolbar-title class="black--text">Recherche : </v-toolbar-title>
                     <v-spacer></v-spacer>
                     <v-text-field v-model="search" :append-icon="mdiMagnify" label="Recherche: " single-line hide-details></v-text-field>
               </v-toolbar>
               <v-layout  column >
                <v-data-table :light="true" :headers="headers" :items="fis" :items-per-page="10" :search="search"></v-data-table>
               </v-layout>
           </v-card-text>
           <v-card-actions>
                
           </v-card-actions>
       </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script> 
import store from '../../store/index.js'
import { mdiMagnify } from '@mdi/js';
export default {
    data(){
        return {
            headers: [
               { text: 'SITE', value: 'SITE' , align:  'center' },
               { text: 'ACTIVITE', value: 'ACTIVITE', align:  'center'  },
               { text: 'VAGUE', value: 'N° VAGUE' , align:  'center' },
               { text: 'NOMBRE APPRENANT EN DEBUT DE FI	', value: 'NOMBRE APPRENANT EN DEBUT DE FI', align:  'center'  },
               { text: 'DATE DEBUT', value: 'DATE DEBUT FORMATION',align:  'center'  },
               { text: 'agent', value: 'NOM & PRENOM',align:  'center'  },
               { text: 'DATE FIN ', value: 'DATE FIN FORMATION' , align:  'center' },
               { text: 'NOMBRE APPRENANT MIS EN PRODUCTION', value: 'NOMBRE APPRENANT MIS EN PRODUCTION', align:  'center'  },
               { text: 'TAUX DE MISE EN PRODUCTION', value: 'TAUX DE MISE EN PRODUCTION' , align:  'center' },
            ],
            fis : [],
            search : '' ,
            mdiMagnify,
              
        }
    },
    created(){
        store.dispatch('getAncienFis')
        .then((response)=>{
             this.fis = response.data
           
        })
    }
}
</script>