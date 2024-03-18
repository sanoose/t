<script setup>

import { Head , useForm  , usePage } from "@inertiajs/vue3" ;
 
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
 
import { computed, onMounted } from "vue";
import { toast } from 'vue3-toastify';
import { router } from '@inertiajs/vue3'
 
 

defineOptions ({
   layout :   AppLayoutArchive ,
}) ;

 

const chart_data = {
  series: [11, 22 ],
  chartOptions: {
    chart: {
      type: "donut",
    },
    labels: ["الصادر", "الوارد"],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
  },
};

</script>

<template>

<Head title=" الرئيسية" />
          <h3>   الرئيسية </h3>
          <hr>
          <div class="">
          <img class = "main_img" src="/storage/logo/logo2.png" alt="" >
          </div>
          <hr>
          <div class="col-md-12">
          
          <div class="card-header">
            <h3 class="card-title">تحليل بيانات البريد</h3>
          </div>
    
          <div class="card-body">
            <VueApexCharts
              type="donut"
              width="380"
              :options="chart_data.chartOptions"
              :series="chart_data.series"
            ></VueApexCharts>
          </div>
        
      </div>
    
         
    </template>

<style scoped>


</style>

