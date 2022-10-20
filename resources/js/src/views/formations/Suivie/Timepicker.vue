<template>
  <v-row>
    <v-col cols="6">
      <v-menu
        ref="menu"
        v-model="menu2"
        :close-on-content-click="false"
        :nudge-right="40"
        :return-value.sync="time"
        transition="scale-transition"
        offset-y
        max-width="290px"
        min-width="290px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="datapicker.startTime"
            label=" Heure d'arrivé"
            :prepend-icon="icons.mdiClockTimeFourOutline"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-time-picker
          v-if="menu2"
          v-model="time"
          color="primary"
          full-width
          @click:minute="$refs.menu2.save(time)"
        ></v-time-picker>
      </v-menu>
    </v-col>
      <v-col cols="6">
      <v-menu
        ref="menu"
        v-model="menu2"
        :close-on-content-click="false"
        :nudge-right="40"
        :return-value.sync="time"
        transition="scale-transition"
        offset-y
        max-width="290px"
        min-width="290px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="datapicker.endTime"
            label="Heure du départ"
            :prepend-icon="icons.mdiClockTimeFourOutline"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-time-picker
          v-if="menu1"
          v-model="time"
          color="primary"
          full-width
          @click:minute="$refs.menu1.save(time)"
        ></v-time-picker>
      </v-menu>
    </v-col>


  </v-row>
</template>

<script>
import { ref } from '@vue/composition-api'
import { mdiClockTimeFourOutline } from '@mdi/js'

export default {
    data(){
        return {
            time : '',
            menu2 : false,
            menu1 : false,
            modal2 : false,
              icons: {
                mdiClockTimeFourOutline,
            },
        }
    },
    props : {
        datapicker : {
            type: Object
        }
    },
}
</script>