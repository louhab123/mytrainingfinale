<template>
   <v-row>
       <v-col cols="12" md="12" sm="12" lg="12" >
             <v-card>
        <v-card-title class="font-weight-semibold m-auto" > 
            <h2 class="mx-auto font-weight-semibold m-auto">
                {{video.nom}}
            </h2>
        </v-card-title>
        <v-card-text>
             <awesome-video
             style="max-width: 100%"
             class="mb-4 mt-4" :properties="properties">
             </awesome-video>
        </v-card-text>
    </v-card>
       </v-col>
   </v-row>
</template>
<script>
import store from '../../store/index.js'
import AwesomeVideo from "awesome-video-player"

export default {
    components: {
    AwesomeVideo
  },
    data(){
        return {
            video : {

            },
            videos : [],
        
    properties: {
        src: '',
        preload: "auto",
     
      },
        }
    },
    created () {
        this.getvideo()
    },
    methods : {
        getvideo(){
            const id =  this.$route.params.id
            store.dispatch('ShowVdeo2', id)
            .then(response=>{
             this.properties.src = response.data.url
             this.video = response.data.video
            })
        }
    }

}
</script>