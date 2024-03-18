<script setup>
console.log(22);
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
// import TextInput from "@/Components/TextInput.vue";
// import SelectInput from "@/Components/SelectInput.vue";


import { Head ,  useForm} from "@inertiajs/vue3" ;
import { toast } from 'vue3-toastify';
const props = defineProps({
  subjects: Array,
});


defineOptions ({
   layout :   AppLayoutArchive
})


const form = useForm({
  name: "",
  code: "",
  parent_id: 0,
});


 
function  Store () {
         form.post( route('Archiving.Settings.Subjects.store')  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم اضافة   البند  بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم يتم اضافة   البند") ;  } ,
         onFinish : () =>   { }  ,
         }) ;
}
</script>

<template>
 
 <form  class="row g-3"  @submit.prevent ="Store" >
                            <h3> إضافة   بند  جديد  </h3>
                            <hr />
                                   <div class="col-md-3">
                                        <label for="name" class="form-label">   إسم البند     </label>
                                        <input type="text" class="form-control" id="name"   v-model="form.name"
                                           placeholder="أدخل إسم البند"  >
                                        <div v-if = "form.errors.name" class="text-danger">{{form.errors.name}}</div>
                                    </div>

                                   <div class="col-md-2">
                                        <label for="code" class="form-label">     الرمز     </label>
                                        <input type="number" min="0" class="form-control" id="code"   v-model="form.code"
                                        placeholder="أدخل الرمز" >
                                        <div v-if = "form.errors.code" class="text-danger">{{form.errors.code}}</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="company_id" class="form-label">   تابعة الى  </label>
                                    <el-select 
                                        filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus " 
                                        placeholder="الرجاء تحديد البند الرئيسي"  remote    v-model="form.parent_id" >
                                        <el-option value="0" :label = "`بلا`" >بلا</el-option>
                                        <el-option v-for="subject in subjects"
                                        :value="subject.id"
                                        :key="subject.id"  :label = "` ${subject.code } - ${subject.name}  `" >
                                        
                                        </el-option>
                                    </el-select>
                                        <div v-if = "form.errors.id" class="text-danger">{{form.errors.id}}</div>
                                    </div>


                                    <div class="col-12">

                                    <Link  :href="route('Archiving.Settings.Subjects.index')" >     
                                          <button type="button" v-if="!form.processing" class="btn btn-info submit "> 
                                            <fa  icon = "arrow-right" />  رجوع         
                                          </button> 
                                      </Link>   

                                      <button type="buttom" 
                                          @click="Store()"
                                      :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري الحفظ ...' : 'حفظ'  }}</button>
                                    </div>

  
 
      <!-- <SelectInput
        v-model="form.parent_id"
        label="تابعة إلى"
        placeholder="الرجاء تحديد البند الرئيسي"
      >
        <option value="0">بلا</option>
        <option
          v-for="subject in subjects"
          :value="subject.id"
          :key="subject.id"
        >
          {{ subject.code }} - {{ subject.name }}
        </option>
      </SelectInput> -->
    </form>
<!-- 
    <template #footer>
      <div class="text-right">
        <button @click="store" type="button" class="btn btn-primary">
          حفظ
        </button>
      </div>
    </template> -->
 

</template>
