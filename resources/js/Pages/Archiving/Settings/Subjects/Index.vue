<script setup>
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import TreeView from "@/Components/TreeView.vue";

defineProps({
  subjects: Array,
});

defineOptions ({
   layout :   AppLayoutArchive
})

</script>

<template>
 
        <Head title="عرض الهيكل التنظيمي" />

            
        <h3> عرض  الهيكل التنظيمي </h3>
          <hr>
          <div class="row ">
          <div class="col-md-6 ">
            
              <TreeView
              :data="subjects"
              id="dep-tree"
              edit-route="Archiving.Settings.Subjects.edit"
            ></TreeView>

            <hr>
            <div class="text-right">
                  <Link
                      :href="route('Archiving.Settings.Subjects.create')"
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
