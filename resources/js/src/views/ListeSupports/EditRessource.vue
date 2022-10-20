<template>
    <div>
       <v-row>
          <v-col cols="12">
             <v-card>
                <v-card-title> Modifier le module de formation :  </v-card-title>
                <v-card-text class="mt-4">
                    <v-row class="mt-4">
                        <v-col cols="6" class="mt-4" lg="6" sm="6" md="6">
                            <v-text-field outlined dense v-model="resource.nom" label="Nom du module *:"></v-text-field>
                        </v-col>
                        <v-col cols="6" lg="6" sm="6" md="6">
                            <v-select item-text="nom" item-value="id" v-model="resource.activite" label="Activité *:" :items="activites"></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <v-select item-text="nom" item-value="id" v-model="resource.service" label="Service *:" :items="services" >

                            </v-select>
                        </v-col>
                    </v-row>
                <v-row class="ml-4 mt-4 mb-4">
                    <v-btn outlined color="primary" @click="SendRequestValidate" >Terminer</v-btn>
                </v-row>
                </v-card-text>
             </v-card>
          </v-col>
       </v-row>
    </div>
</template>
<script>
import store from '../../store/index'
import Swal from 'sweetalert2'
export default {
    data(){
        return {
            resource : {},
            activites : [],
            services : [],
        }
    },
    methods : {
    SendRequestValidate(){
    if(this.resource.nom == null){
    Swal.fire({
    icon: 'error',
    title: 'Vous devez attribuer un nom au module',
    showConfirmButton: false,
    timer: 3000
    })
    }
    else if( this.resource.activite == null){
    Swal.fire({
    icon: 'error',
    title: 'Vous devez attribuer une activitée au module',
    showConfirmButton: false,
    timer: 3000
    })
    }
    else if(this.resource.service == null){
    Swal.fire({
    icon: 'error',
    title: 'Vous devez attribuer un service  au module',
    showConfirmButton: false,
    timer: 3000
    })
    }
    else {
        this.sendRequest()
    }
    },
    sendRequest(){
        const data = {
            id  :this.$route.params.id,
            nom : this.resource.nom,
            activite : this.resource.activite,
            service  : this.resource.service
        }
        store.dispatch('editResources', data)
        .then((response)=>{
            if(response.status ==200){
                  Swal.fire({
                        icon: 'Success',
                        title: "Le module a été bien modifié ! ",
                        timer: 3000
                        })
                   .then(()=>{
                 this.$router.go(0)
                   })     
            }
        })
    },
    getServices(){
    store.dispatch('getServices')
    .then(response=>{
        this.services = response
    })
    },
    getActivities(){
        store.dispatch('getActivities')
    .then((response)=>{
    this.activites = response
    })  
    },
    getModule(){
    const id = this.$route.params.id
    store.dispatch('getModule', id)
    .then((response)=>{
        this.resource = response.data
    })
    },  
    }, 
    created(){
    this.getServices()
    this.getActivities()
    this.getModule()
    }
}
</script>