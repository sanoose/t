<script setup>
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';

import { Head ,  useForm} from "@inertiajs/vue3" ;
import { toast } from 'vue3-toastify';

const props = defineProps({
  subjects: Array,
  subject: Object,
});

defineOptions ({
   layout :   AppLayoutArchive
})

const form = useForm({
  name: props.subject.name,
  code: props.subject.code,
  parent_id: props.subject.parent_id,
  id: props.subject.id,
});

const Update = () => {
  form.put(
    route('Archiving.Settings.Subjects.update', {
      id: props.subject.id,
    }),
    {
      onSuccess : () =>  toast.success("تم تعديل   البند  بنجاح")  ,
      onError :  (e) => { toast.error("حدث خطأ لم يتم تعديل   البند") ;  } ,
      onFinish : () =>   { }  ,
       
    }
  );
};
</script>

<template>
 
    <form @submit.prevent ="Update" class="row g-3">
      <h3> تعديل   البند     </h3>
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
                                      :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري التعديل ...' : 'تعديل'  }}</button>
                                    </div>

    </form>

 
</template>
