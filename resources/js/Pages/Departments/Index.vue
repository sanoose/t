<script setup>

import TreeView from "@/Components/TreeView.vue";

// import HighchartsVue from "highcharts-vue";
import Highcharts from "highcharts";
import snakyInit from "highcharts/modules/sankey";
import origanizationInit from "highcharts/modules/organization";
import AppLayoutMain from  '@/Layouts/AppLayoutMain.vue' ;

import { onMounted, reactive } from "vue";
import { usePage } from "@inertiajs/vue3";

defineOptions ({
   layout :   AppLayoutMain ,
}) ;

const props = defineProps( ['departments'] ) ;

let   relationships =  [] 

   function  extractRelationships(nodes , parentName = null ) {
      for (const node of nodes) {
        if (parentName) {
          relationships.push([parentName, node.name]);
         } 
        if (node.children && node.children.length > 0 ) {
          extractRelationships(node.children, node.name);
        } else {
            relationships.push([    node.name  , null  ]); 
        }
      }
    } ;

    extractRelationships(props.departments) ;
   

snakyInit(Highcharts);
origanizationInit(Highcharts);
onMounted(() => {
 
 


    Highcharts.chart("container", {
        chart: {
            height: 600,
            inverted: true,
            backgroundColor: "transparent", 
        },
        title: {
            text: "الهيكل التنظيمي",
        },
        accessibility: {
            point: {
                descriptionFormat:
                    "{add index 1}. {toNode.name}" +
                    "{#if (ne toNode.name toNode.id)}, {toNode.id}{/if}, " +
                    "reports to {fromNode.id}",
            },
        },
        series: [
            {
                type: "organization",
                name: "Highsoft",
                keys: ["from", "to"],
                data:  relationships  ,
    
                colorByPoint: false,
                color: "#007ad0",
                dataLabels: {
                    color: "white",
                },
                nodeWidth: 65,
            },
        ],
        tooltip: {
            outside: true,
        },
        exporting: {
            allowHTML: true,
            sourceWidth: 800,
            sourceHeight: 600,
        },
    });
});


 
</script>

<template>

<Head title="عرض الهيكل التنظيمي" />

    
                  <h3> عرض  الهيكل التنظيمي </h3>
                    <hr>
                    <div class="row ">
                    <div class="col-md-8 ">
                      
                        <TreeView
                        :data="departments"
                        id="dep-tree"
                        edit-route="Departments.edit"
                       ></TreeView>

                       <div class="text-right">
                            <Link
                                :href="route('Departments.create')"
                                class="btn btn-primary"
                            >
                                إضافة
                            </Link>
                        </div>
                  

                    </div>
                  <div class="col-md-12">
                    <div id="container" class="highcharts"></div>
                </div>
                    <!-- <HighchartsVue :series="chart.series"></HighchartsVue> -->
                
                    
                    
                    </div>

               
     
</template>

<style scoped>

  

  .highcharts {
    /* background-color: transparent; */
  }
</style>

