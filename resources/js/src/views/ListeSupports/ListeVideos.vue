<template>
    <v-row>
  <WaitingVue v-if="data" />
    <v-row v-if="nodatafound">
          <v-col>
            <v-card>
                    <v-card-title class="h-100 justify-content-center align-items-center">
                    <h6 class="mx-auto" >
                               
                                Aucun  video  trouvée 
                    </h6>
                    </v-card-title>
            </v-card>
          </v-col>
      </v-row>
    <v-col md="3" v-for="(fi,index) in fi_s" :key="index" v-if="!data && !nodatafound">
      <v-card>
            <v-img class="white--text align-end" height="200px"  :src="imageResource(fi.image_url)">
                <v-card-title>
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <h3 v-bind="attrs" v-on="on" style="cursor: pointer; color: white;" @click="$router.push({ name: 'show-video' ,params: { id: fi.id } })"  >{{fi.activite}}</h3>
                        </template>
                        <span>Cliquer pour consulter lee video  de l'actvité : {{fi.activite}}</span>
                    </v-tooltip>
                </v-card-title>
            </v-img>
        </v-card>
    </v-col>
    </v-row>
</template>
<script>
import store from '../../store/index.js'
import WaitingVue from './Waiting.vue'
export default {
       components: {
        WaitingVue,
    },
  created () {
      this.getVideos()
  },
    data(){
        return {
            fi_s : [],
            nodatafound: false,
            data : true,
        }
    },
    methods : {
            imageResource(image){
                if(image==="") return  "https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                else {
                    return image
                }
            },
    getVideos(){
       store.dispatch('getVideos')
      .then((response)=>{
       if(response.data === 'nodatafound'){
           this.nodatafound = true
           this.data=false
       }
       else {
           
        this.fi_s = response.data
        this.data=false
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