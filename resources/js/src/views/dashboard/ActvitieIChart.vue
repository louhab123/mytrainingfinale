<template>
    <div>
    <vue-apex-charts
      type="bar"
      height="285"
      :options="chartOptions"
      :series="data.series"
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
     data: {
      type: Object,
      default: () => {},
    },    
    },
    data(){
        return {
      chartOptions: {
        chart: {
          height: 350,
          type: 'bar',
          events: {},
        },
        // colors: ['#ea5455', '#00cfe8'],
        plotOptions: {
          bar: {
            borderRadius: 2,
            columnWidth: '40%',
            distributed: true,
          },
        },
        dataLabels: {
          enabled: true,
        },
        legend: {
          show: false,
        },
        xaxis: {
          categories: [],
          labels: {
            style: {
              colors: ['#000'],
              fontSize: '12px',
            },
          },
        },
        yaxis: {
          labels: {
            formatter: val => val.toFixed(0),
          },
        },
      },
        }
    },
    created(){
    this.chartOptions.xaxis.categories = this.data.data
    console.log(this.data)
    }
}
</script>