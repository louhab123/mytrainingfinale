<template>
  <v-row>
    <v-card  class="mx-auto" style="width:100%; margin-top :1%" >
      <v-card-title class="font-weight-semibold"><h3 class="mx-auto"> {{resource.nom}} </h3></v-card-title>
     <v-card-text>
        <div class="mx-auto mb-4 mt-4" >
          <object :data="`${docUrl}`" type="application/pdf" style="width:100%; height:600px;" name="obj1">
            <iframe :src="`${docUrl}`" frameborder="0" allowfullscreen ref="iframe"></iframe>
          </object>
        </div>
     </v-card-text>
    </v-card>
  </v-row>
</template>
<script>
import store from '../../store/index'
export default {
    data(){
        return {
            resource : [],
            b64Pdf : '',
            docUrl :'',
        }
    },
    created () {
         this.geteResource()
    },
    methods : {
       geteResource(){
           const id = this.$route.params.id
           store.dispatch('geteResource2',id)
          .then((response)=>{
           this.resource = response.data.resource
           this.b64Pdf = response.data.pdf // 'data:application/pdf;base64,' +
           const byteArray = new Uint8Array(
           atob(this.b64Pdf)
            .split('')
            .map(char => char.charCodeAt(0)),
        )
        this.blob = new Blob([byteArray], { type: 'application/pdf' })
        this.docUrl = URL.createObjectURL(this.blob)
      })
      .catch(err=>{
          console.log(err)
        })
       }
    }
}
</script>