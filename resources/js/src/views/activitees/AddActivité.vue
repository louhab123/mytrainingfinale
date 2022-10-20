<template>
<div>
    <v-card>
        <v-card-title>
            <h2 class="mx-auto">
                Nouvelle activité :
            </h2>
        </v-card-title>
        <v-card-text>
              <v-row>
                  <v-col cols="2" md="2" lg="2" sm="2"/>
                  <v-col cols="8" md="8" lg="8" sm="8">
                    <v-form>
                        <v-text-field label="Nom de l'activité : *" type="text" dense outlined class="mt-2" v-model="nom"></v-text-field>
                    </v-form>
                  </v-col>
                   <v-col cols="2" md="2" lg="2" sm="2"/>
              </v-row>
        </v-card-text>
        <v-card-actions>
            <v-row>
                <v-col cols="8" sm="8" md="8" lg="8"></v-col>
                <v-col cols="4" md="4" sm="4" lg="4">
                    <v-btn color="primary" outlined @click="addACtivite">
                        Enregistrer
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>
</div>
</template>
<script>
import store from '../../store/index.js'
import Swal from 'sweetalert2'
export default {
    data(){
        return {
            nom: '',
        }
    },
    methods: {
        addACtivite(){
            console.log(this.nom)
            const nom ={
                nom :  this.nom
            }
            if(!this.nom){
                   Swal.fire({
                        icon: 'error',
                        title: "Vous devez remplir le nom de l'activité ",
                        showConfirmButton: false,
                        timer: 3000
              })
            }
            else {
                store.dispatch('addActivite',nom)
                .then((response)=>{
                    if(response.status==200){
                    Swal.fire({
                        icon: 'success',
                        title: "l'activité a été ajouté avec Succès",
                        showConfirmButton: false,
                        timer: 3000
                    })
                    .then(()=>{
                        this.$router.go(-1)
                    })
                    }
                })
            }
        }
    },
}
</script>