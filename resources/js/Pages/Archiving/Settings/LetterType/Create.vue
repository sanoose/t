<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  ref  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';

defineProps({ errors: Object }) ;


defineOptions ({
   layout :   AppLayoutArchive
})


let form = useForm ({
     name   : '' ,
}); 
 
 
function  Store () {
         form.post( route('Archiving.Settings.LetterTypes.store')  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم اضافة نوع البريد بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة نوع البريد") ;  } ,
         onFinish : () =>   { }  ,
         }) ;
}
 

</script>

<template>
    <Head title="اضافة إشاري" />

     
                    <form class="row g-3"  >
                            <h3> إضافة نوع بريد  </h3>
                            <hr />
                            <div class="col-md-4">
                                <label for="name" class="form-label">اسم نوع البريد  </label>
                                <input type="text" class="form-control" id="name" v-model="form.name"  >
                                <div v-if = "form.errors.name" class="text-danger">{{form.errors.name}}</div>
                            </div>

                            <div class="col-12">

                              <Link  :href="route('Archiving.Settings.LetterTypes.index')" >     
                                    <button type="button" v-if="!form.processing" class="btn btn-info submit "> 
                                      <fa  icon = "arrow-right" />  رجوع         
                                    </button> 
                                </Link>   

                                <button type="buttom" 
                                    @click="Store()"
                                :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري الحفظ ...' : 'حفظ'  }}</button>
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

