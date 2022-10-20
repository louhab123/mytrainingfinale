<template>
    <div>
        <v-row>
            <v-col cols="2"/>
            <v-col cols="8">
                <v-card>
                    <v-card-title><h3 class="mx-auto">Modifier le service :  {{service.nom}} </h3> </v-card-title>
                    <v-card-text>
                    <v-row>
                        <v-col cols="2" md="2" lg="2" sm="2"/>
                        <v-col cols="8" md="8" lg="8" sm="8">
                            <v-form>
                                <v-text-field label="Nom du service  : *" type="text" dense outlined class="mt-2" v-model="nom"></v-text-field>
                            </v-form>
                        </v-col>
                        <v-col cols="2" md="2" lg="2" sm="2"/>
                    </v-row>
                    </v-card-text>
                    <v-card-actions>
                    <v-row>
                        <v-col cols="8" sm="8" md="8" lg="8"></v-col>
                        <v-col cols="4" md="4" sm="4" lg="4">
                            <v-btn color="primary" outlined @click="editService">
                                Enregistrer
                            </v-btn>
                        </v-col>
                    </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="2"/>
        </v-row>
    </div>
</template>
<script>
import store from '../../store/index.js'
import Swal from 'sweetalert2'
export default {
    data() {
        return {
            service : {}, 
            nom  : ''
        }
    },
    methods : {
        getSevice() {
            const id = this.$route.params.id
            store.dispatch('getServices3',id)
            .then((response)=>{
                this.service = response.data
                
            })
        },
        editService() {

            const data = {
                service_id : this.$route.params.id,
                nom : this.nom
            }
            store.dispatch('editService',data)
            .then((response)=>{
                if(response.status===200) {
                    Swal.fire({
                    icon: 'success',
                    title: 'le service a été ajouté avec Succès ',
                    showConfirmButton: false,
                    timer: 1500
                    }).then(()=>{
                        this.$router.go(0)
                    })
                }
            })
        }
    },
    created() {
        this.getSevice()
    }
}
</script>