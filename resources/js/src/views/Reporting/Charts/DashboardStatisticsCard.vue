<template>
  <v-card>
    <v-card-title class="align-start">
      <span class="font-weight-semibold"></span>
      <v-spacer></v-spacer>
    
    </v-card-title>



    <v-card-text>
      <v-row>
        <v-col
          v-for="data in statisticsData"
          :key="data.title"
          cols="6"
          md="3"
          class="d-flex align-center"
        >
          <v-avatar
            size="44"
            :color="resolveStatisticsIconVariation (data.title).color"
            rounded
            class="elevation-1"
          >
            <v-icon
              dark
              color="white"
              size="30"
            >
              {{ resolveStatisticsIconVariation (data.title).icon }}
            </v-icon>
          </v-avatar>
          <div class="ms-3">
            <p class="text-xs mb-0">
              {{ data.title }}
            </p>
            <h3 class="text-xl font-weight-semibold">
              {{ data.total }}
            </h3>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiAccountOutline, mdiCurrencyUsd, mdiTrendingUp, mdiDotsVertical, mdiLabelOutline, mdiBriefcaseVariantOutline,mdiBookOpenVariant , mdiBookOpenPageVariantOutline } from '@mdi/js'

export default {
  setup() {
    const statisticsData = [
      {
        title: 'Vagues',
        total: '24',
      },
      {
        title: 'Effectif formé',
        total: '1200',
      },
      {
        title: 'Formations Continues',
        total: '12',
      },
      {
        title: 'Formations Initiales',
        total: '18',
      },
    ]

    const resolveStatisticsIconVariation = data => {
      if (data === 'Vagues') return { icon: mdiBriefcaseVariantOutline , color: 'primary' }
      if (data === 'Agents') return { icon: mdiAccountOutline, color: 'success' }
      if (data === 'Formations Continues') return { icon: mdiBookOpenPageVariantOutline , color: 'warning' }
      if (data === 'Formations Initiales') return { icon: mdiBookOpenVariant, color: 'info' }

      return { icon: mdiAccountOutline, color: 'success' }
    }

    return {
      statisticsData,
      resolveStatisticsIconVariation,

      // icons
      icons: {
        mdiDotsVertical,
        mdiTrendingUp,
        mdiAccountOutline,
        mdiLabelOutline,
        mdiCurrencyUsd,
        mdiBriefcaseVariantOutline ,
        mdiBookOpenPageVariantOutline ,
        mdiBookOpenVariant,
      },
    }
  },
}
</script>
