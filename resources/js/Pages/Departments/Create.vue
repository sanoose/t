<script setup>

import { Head , useForm } from "@inertiajs/vue3" ;
import AppLayoutMain from  '@/Layouts/AppLayoutMain.vue' ;
import { toast } from 'vue3-toastify' ;
import { onMounted } from "vue";

 
// defineProps({ errors : Object }) ;

defineOptions ({
   layout :   AppLayoutMain ,
}) ;
 

    const years = [] ;
    const currentYear = new Date().getFullYear();
    const startYear = 2000;
    for (let year = startYear; year <= currentYear; year++) {
       years.push(year);
    }


const props = defineProps( ['departments'] );

const form = useForm({
  name : "مكون 1",
  parent_id :  null ,
  last_inbox_number : '1000' ,
  last_inbox_year   :  '2024'  ,
  last_outbox_number  :  '1000'  ,
  last_outbox_year    :  '2024'  ,
});

const store = () => {
  form.post(route("Departments.store"), {
    onSuccess : () => { toast.success("تمت الاضافة بنجاح") ; },
    onError : ()   => { toast.error("حدث خطأ لم يتم الاضافة") ; } ,
    onFinish: ()   => {},
  });
};

onMounted (() => {
  // window.jQuery("form").fadeOut(1111) ;
})

</script>

<template>
    <Head title="اضافة مكون جديد" />
                    <!-- <MainAppLayout >     </MainAppLayout> -->
                    <form class="row g-1" @submit.prevent="store" >
                            <h3>إضافة مكون جديد</h3>
                            <!-- <input type="file" @change="form.image = $event.target.files[0]" />  -->
                            <hr />
                            <div class="col-md-3">
                                <label for="name" class="form-label">اسم المكون</label>
                                <input type="text" class="form-control" id="name" v-model="form.name"  >
                                <div v-if = "form.errors.name" class="text-danger">{{form.errors.name}}</div>
                            </div>

                            <div class="col-md-3">
                              <label for="parent_id" class="form-label">  تابعة ل  </label>
                              <el-select 
                                  id="parent_id"
                                  filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus " 
                                  placeholder="الرجاء تحديد الجهة" remote v-model="form.parent_id"  >
                                  <el-option  :label="'بلا'" :value="''" ></el-option>
                                  <el-option v-for="department , i   in  departments" :key="i"
                                  :label="department.name" :value="department.id" ></el-option>
                              </el-select>
                              <div v-if = "form.errors.parent_id" class="text-danger">{{form.errors.parent_id}}</div>
                            </div>

                            <div class="col-md-2">
                                <label for="last_inbox_number" class="form-label"> آخر رقم وارد</label>
                                <input type="number" class="form-control" id="last_inbox_number" v-model="form.last_inbox_number"  >
                                <div v-if = "form.errors.last_inbox_number" class="text-danger">{{form.errors.last_inbox_number}}</div>
                            </div>

                            <div class="col-md-2">
                                <label for="last_inbox_year" class="form-label">  سنة الوارد</label>

                                <select name="" id=""  class="form-control" v-model="form.last_inbox_year"  >
                                  <option value="">---</option>
                                  <option v-for="year , i in years" :key="i"
                                  :value="year">{{year}}</option>
                                </select>
                             
                                <div v-if = "form.errors.last_inbox_year" class="text-danger">{{form.errors.last_inbox_year}}</div>
                            </div>

                            <div class="col-md-2">
                                <label for="last_outbox_number" class="form-label">  آخر رقم صادر</label>
                                <input type="number" class="form-control" id="last_outbox_number" v-model="form.last_outbox_number"  >
                                <div v-if = "form.errors.last_outbox_number" class="text-danger">{{form.errors.last_outbox_number}}</div>
                            </div>

                            <div class="col-md-2">
                                <label for="last_outbox_year" class="form-label">سنة الصادر</label>
                                <select name="" id=""  class="form-control" v-model="form.last_outbox_year"  >
                                  <option value="">---</option>
                                  <option v-for="year , i in years" :key="i"
                                  :value="year">{{year}}</option>
                                </select>
                                <div v-if = "form.errors.last_outbox_year" class="text-danger">{{form.errors.last_outbox_year}}</div>
                            </div>

                            <div class="col-12">
                              <Link   v-if ="!form.processing"   class="btn btn-info"  :href = "route('Departments.index')" > <fa icon = "arrow-right" />  {{ 'رجوع'}}   </Link>
                              &nbsp;
                              <button type="submit" :disabled="form.processing" class="btn btn-primary submit">
                              {{ !form.processing ?  'حفظ' :  'جاري الحفظ ...' }}
                              </button>
                            </div>
                        </form>
                  
         
</template>

<style scoped>

.main-content {
     height: fit-content;
}

form {
    gap: 10px;
}
</style>

