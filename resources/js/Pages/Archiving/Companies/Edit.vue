<script setup>

import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;
import Navbar from  '@/Layouts/Navbar.vue';
import AsideArchive from  '@/Layouts/AsideArchive.vue';
import { toast } from 'vue3-toastify';

const props = defineProps( ["company"] ) ;

let form = useForm ({
    id : props.company.id ,
    company_name : props.company.company_name ,
    company_code : props.company.company_code  , 
    company_password : props.company.company_password  , 
}); 

function  Update () {
         form.put( route('Archiving.Companies.update' , form.id )  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم تعديل الشركة بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم تعديل الشركة ") ;  } ,
         onFinish : () =>   {  }  ,
         }  ) ;
}

 
 
</script>

<template>
    <Head title="تعديل شركة" />
        <div class="wrapper">
            <AsideArchive  />          
            <div class="content" >
                <Navbar />
                <div class="main-content">
                    <div class="row g-3"  >
                            <h3> تعديل الشركة   </h3>
                            <hr />
                            <div class="col-md-4">
                                <label for="company_name" class="form-label">اسم الشركة </label>
                                <input type="text" class="form-control" id="company_name" v-model="form.company_name"  >
                                <div v-if = "form.errors.company_name" class="text-danger">{{form.errors.company_name}}</div>
                            </div>

                            <div class="col-md-4">
                                <label for="company_code" class="form-label">كود الشركة</label>
                                <input type="text" class="form-control" id="company_code"  v-model="form.company_code"   />
                                <div v-if = "form.errors.company_code" class="text-danger">{{form.errors.company_code}}</div>
                            </div>

                            <div class="col-md-4">
                                <label for="company_password" class="form-label">كود الشركة</label>
                                <input type="company_password" class="form-control" id="company_password" v-model="form.company_password"  />
                                <div v-if = "form.errors.company_password" class="text-danger">{{form.errors.company_password}}</div>
                            </div>

                            <div class="col-12">

                                <Link  :href="route('Archiving.Companies.index')" >     
                                    <button type="button" v-if="!form.processing" class="btn btn-info submit "> 
                                      <fa  icon = "arrow-right" />  رجوع         
                                    </button> 
                                </Link>  

                                <button type="buttom"  @click="Update()" class="btn btn-primary "
                                 :disabled ="form.processing"  > {{ form.processing ?  'جاري التعديل ...' : 'تعديل'  }} </button>
                            </div>

                        </div>
                </div>
                 
            </div>
        </div>
</template>

<style scoped>

.main-content {
     height: fit-content;
}

form {
    gap: 10px;
}
</style>

