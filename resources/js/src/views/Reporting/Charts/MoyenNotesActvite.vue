<template>
    <div>
    <vue-apex-charts
      :options="chartOptions"
      :series="data"
      type="line"
    />

    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    components : {
        VueApexCharts,
    },
    props: {
    series: {
      type: Array,
      default: () => [],
        },
    categories : {
      type: Array,
      default: () => [],
    }    
    },
    data(){
        return {
         data : {}
            ,
        chartOptions: {
            chart: {
              height: 350,
              type: 'line',
              zoom: {
                enabled: false
              }
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
              curve: 'straight'
            },
            title: {
              text: '',
              align: ''
            },
            grid: {
              row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
              },
            },
            xaxis: {
              categories: [],
            }
          },
        }
    },
    created(){
     this.chartOptions.xaxis.categories = this.categories
      this.data = this.series
    }
}
</script>