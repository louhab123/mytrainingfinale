<template>
 <div>
     <WaitingVue v-if="!data && !nodatafound"/>
          <v-row v-if="!data && nodatafound===true">
          <v-col>
            <v-card>
                    <v-card-title class="h-100 justify-content-center align-items-center">
                    <h6 class="mx-auto" >
                               
                               Aucun module de formation a été injecté 
                    </h6>
                    </v-card-title>
            </v-card>
          </v-col>
      </v-row>
        <v-row v-if="data">
            <v-col  cols="4" md="4" sm="4" lg="4" v-for="(fi,index) in fi_s" :key="index">
            <v-card>
                <v-img class="white--text align-end" height="200px"  :src="imageResource(fi.image_url)">
                </v-img>
                <v-card-text>
                    <v-card-title>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <h3 v-bind="attrs" v-on="on" style="cursor: pointer; color: white;" @click="$router.push({ name: 'show-resource' ,params: { id: fi.id } })"   >{{fi.activite}}</h3>
                            </template>
                            <span>Cliquer pour consulter les quiz de l'actvité : {{fi.activite}}</span>
                        </v-tooltip>
                    </v-card-title>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
 </div>
</template>
<script>
import WaitingVue from './Waiting.vue'
import store from '../../store/index.js'
export default {
     components: {
        WaitingVue,
    },
  created () {
      this.getfis()
  },
    data(){
        return {
            fi_s : [],
            data: false,
            nodatafound : false,
        }
    },
    computed: {
            
    },
    methods : {
        imageResource(image){
                if(image==="") return  "https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                else {
                    return image
                }
            },
    getfis(){
       store.dispatch('getfis')
      .then((response)=>{
          if(response.data=='nodatafound'){
           this.nodatafound= true
          }
          else {
       this.fi_s = response.data
       this.data = true
          }
     
      })
      .catch(err=>{
          console.log(err)
        })
    },
    mounted () {
        this.getfis()
    },
  
    }
}
</script>