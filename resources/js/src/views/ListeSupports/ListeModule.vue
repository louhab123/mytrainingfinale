<template>
  <v-row>
      <v-col md="4">
        <v-card  class="card" >
          <v-card-text>
              <v-img height="250px" eager :src="require('@/assets/images/modules/support.png').default" ></v-img>
          </v-card-text>
          <v-card-title class="font-weight-semibold"><h5>Les modules de formation  </h5> </v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
            <v-btn  small class="d-flex float-right" text @click="$router.push({name :'liste-fi'})"  outlined color="primary">
            Consulter 
            </v-btn>
            </v-card-actions>
        </v-card>
      </v-col>
      <v-col md="4">
        <v-card  class="card" >
            <v-card-text>
              <v-img eager height="250px" :src="require('@/assets/images/modules/videos.jpg').default"></v-img>
            </v-card-text>
            <v-card-title class="font-weight-semibold"><h5>Les vidéos de formation </h5>  </v-card-title>
          <v-card-actions >
            <v-spacer></v-spacer>
            <v-btn text small outlined color="primary" class="d-flex float-right" @click="$router.push('liste-videos')">
            Consulter 
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col md="4">
          <v-card class="card">
              <v-card-text>
                  <v-img height="250px" eager :src="require('@/assets/images/modules/quizs.png').default" ></v-img>
              </v-card-text>
              <v-card-title>
                <h5 class="font-weight-semibold d-flex justify-content-center">
                  Les quiz de formations
                </h5> 
              </v-card-title>
              <v-card-actions >
              <v-spacer></v-spacer>
              <v-btn small text outlined color="primary" class="d-flex float-right"  @click="$router.push('liste-quizs')">
                Consulter
              </v-btn>
              </v-card-actions>
          </v-card>
      </v-col>
  </v-row>
</template>
<style>
.card {
  zoom: 1;
  transition: 1s;
}
</style>