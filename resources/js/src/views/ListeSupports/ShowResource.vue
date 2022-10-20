<template>
  <div >
      <v-row v-if="nodata">
          <v-col>
            <v-card>
                    <v-card-title class="h-100 justify-content-center align-items-center">
                    <h6 class="mx-auto" >
                               
                               Aucun support de formation trouvé pour cette actvité 
                    </h6>
                    </v-card-title>
            </v-card>
          </v-col>
      </v-row>
    <!-- <v-row v-if="!nodata">
         <v-col md="3" sm="3" lg="3" cols="3" v-for="(fi,index) in resources" :key="index" >
            <v-card class="mx-auto" height="100%" max-width="400">
                <v-card-subtitle class="pb-0">
                  <v-icon size="29">{{mdiFilePdfBox}}</v-icon>
                </v-card-subtitle>
                <v-card-title class="text-primary">
                  <h7 class="mx-auto text-primary" style=" width: 100%;">{{fi.nom}}</h7>
                  </v-card-title>
                <v-card-actions >
                  <div class="m-auto">
                      <v-btn color="primary" x-small text @click="$router.push({ name: 'show-resource-details' ,params: { id: fi.id } })" >Consulter</v-btn>
                     <v-btn color="error" x-small text v-if="role!='agent' && role!='client'" @click="deleteResource(fi.id)" > Suprimer</v-btn>
                  </div>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row> -->
    <v-row>
      <v-col cols="12">
        <v-card >
          <v-list-item two-line>
            <v-list-item-content class=" mx-auto">
              <v-list-item-title class="text-h5">
              Liste des modules do formation de l'activite : 
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-data-table dense :headers="headers" :items="resources" :items-per-page="5">
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
                          <p outlined color="info" style="cursor:pointer"  @click="$router.push({ name: 'show-resource-details' ,params: { id: item.id } })" >
                          Consulter
                          </p>
                      </v-list-item-title>
                      </v-list-item>
                      <v-list-item >
                      <v-list-item-title>
                        <p @click="handlItem(item)" style="cursor:pointer" outlined color="success">
                        Modifier
                        </p>
                      </v-list-item-title>
                      </v-list-item>
                  </v-list>
                  </v-menu>
            </template>
             <!-- <template v-slot:item.consulter="{ item }">
                 <v-btn color="primary" x-small text @click="$router.push({ name: 'show-resource-details' ,params: { id: item.id } })" >Consulter</v-btn>
             </template>  -->
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>  
  </div>
</template>
<script>
import store from '../../store/index'
import Swal from 'sweetalert2'
import { mdiFileDocumentMultiple , mdiFilePdfBox, mdiDotsHorizontal } from '@mdi/js';
export default {
    data(){
        return {
            mdiDotsHorizontal,
            mdiFilePdfBox,
            mdiFileDocumentMultiple,
            resources : [],
            b64Pdf : '',
            docUrl :'',
            nodata : true,
            role : '',
            headers : [
              { text: 'Module de formation ',
                align: 'center',
                sortable: true,
                value: 'nom',
            },
            { text: 'activite', value: 'activite',align: 'center', },
            { text: 'service', value: 'service',align: 'center', },
            { text: 'Action', value:'action' , align: 'center', },
            ]
        }
    },
    mounted () {
         this.geteResource()
         this.role = sessionStorage.getItem('role')
        

    },
    methods : {
      handlItem(item){
 
        this.$router.push({name:'edit-resource' , params : { id : item.id}}) 

      },
       geteResource(){
           const id = this.$route.params.id
           store.dispatch('geteResource',id)
          .then((response)=>{
              if(response.data === 'nodata'){
                  this.nodata = true
              }
              else {
                this.nodata = false 
                this.resources = response.data
                console.log(this.resources)
              }
      })
      .catch(err=>{
          console.log(err)
        })
       },
       deleteResource(id){
        Swal.fire({
        title: 'Vous allez supprimer ce module de formation  ! cette opération est irréversible.',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Ok',
        denyButtonText: `annuler`,
        })
        .then((result) => {
          if (result.isConfirmed) {
            store.dispatch('deleteResource',id)
            .then((response)=>{
              if(response.status ==200){
                  Swal.fire('supprimé!', '', 'success')
                  .then(()=>{
                     this.$router.go(0)
                  })
              }
            })    
          } 
        })
       }   
    }
}
</script>