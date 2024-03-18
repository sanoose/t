<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  ref  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';

const props = defineProps(['letter_type' , 'errors' ] ) ;

defineOptions ({
   layout :   AppLayoutArchive
})

const form = useForm({
    name :   props.letter_type.name    ,
    id   :   props.letter_type.id      , 
});
 
function  Update () {
         form.put( route('Archiving.Settings.LetterTypes.update' , {id : form.id})  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم تعديل نوع البريد بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة نوع البريد") ;  } ,
         onFinish : (res) =>   { 
          console.log(props);
         }  ,
         }) ;
}

</script>

<template>
    <Head title="   تعديل نوع البريد " />
     
                    <form class="row g-3"  >
                            <h3> تعديل نوع البريد  </h3>
                            <hr />
                            <div class="col-md-4">
                                <label for="name" class="form-label">اسم نوع البريد <div>{{errors.error}}</div>  </label>
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
                                    @click="Update()"
                                :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري التعديل ...' : 'تعديل'  }}</button>
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

