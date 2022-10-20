<template>
<v-row>
    <v-col md="3" v-for="(fi,index) in videos" :key="index">
        <v-card class="elevation-0" max-width="5000" height="100%">
            <v-card-subtitle class="pb-0">
                <v-icon size="29">{{mdiPlayBox}}</v-icon>
            </v-card-subtitle>
             <v-card-title>
                 <h6>
                     {{fi.nom}}
                 </h6>
             </v-card-title>
            <v-card-actions>
                <v-btn color="primary" x-small text @click="$router.push({ name: 'show-video-detail' ,params: { id: fi.id } })" >Consulter</v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
</v-row>
</template>
<script>
import store from '../../store/index.js'
import AwesomeVideo from "awesome-video-player"
import { mdiPlayBox } from '@mdi/js';

export default {
    components: {
    AwesomeVideo
  },
    data(){
        return {
            mdiPlayBox,
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
            store.dispatch('ShowVdeo', id)
            .then(response=>{
             this.videos = response.data
            })
        }
    }

}
</script>