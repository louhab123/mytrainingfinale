<template>
    <div>
        <v-dialog v-model="dialog" width="500px">
            <v-card color="primary" dark>
                <v-card-text>
                    Entrain d'envoeyer ton message....
                    <v-progress-linear indeterminate color="white">
                    </v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    data(){
        return {
            dialog:true
        }
    }
}
</script>