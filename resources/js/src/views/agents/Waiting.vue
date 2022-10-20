<template>
   <v-row >
    <v-col md="2" lg="2" sm="2"/>
      <v-col  md="8" lg="8" sm="8">
        <v-card>
          <v-card-text class="h-100 justify-content-center align-items-center">
              <template>
                <div class="text-center">
                  <v-progress-circular
                    indeterminate
                    color="primary"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="red"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="purple"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="green"
                  ></v-progress-circular>

                  <v-progress-circular
                    indeterminate
                    color="amber"
                  ></v-progress-circular>
                </div>
              </template>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col md="2" lg="2" sm="2"/>
    </v-row>
</template>