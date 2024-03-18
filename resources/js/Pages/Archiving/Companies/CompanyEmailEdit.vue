<script setup>

import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;
import   Navbar from  '@/Layouts/Navbar.vue';
import   AsideArchive from  '@/Layouts/AsideArchive.vue';
import { toast } from 'vue3-toastify';

const props = defineProps( ["company_email" , "company"] ) ;

let form = useForm ({
    id : props.company_email.id ,
    company_email : props.company_email.company_email ,
    for : props.company_email.for  , 
}); 

function  Update () {
         form.put( route('Archiving.Companies.CompanyEmailUpdate'  )  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم تعديل ايميل الشركة بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم تعديل ايميل  الشركة ") ;  } ,
         onFinish : () =>   {  }  ,
         }  ) ;
}

 
 
</script>

<template>
    <Head title="تعديل ايميل الشركة" />
        <div class="wrapper">
            <AsideArchive  />          
            <div class="content" >
                <Navbar />
                <div class="main-content">
                    <div class="row g-3"  >
                            <h3> تعديل إيميل شركة  ( {{ company.company_name }} ) </h3>
                            <hr />
                            <div class="col-md-4">
                                <label for="company_email" class="form-label">  الإيميل </label>
                                <input type="text" class="form-control" id="company_email" v-model="form.company_email"  >
                                <div v-if = "form.errors.company_email" class="text-danger">{{form.errors.company_email}}</div>
                            </div>

                            <div class="col-md-4">
                                <label for="for" class="form-label">  تابع ل</label>
                                <input type="text" class="form-control" id="for"  v-model="form.for"   />
                                <div v-if = "form.errors.for" class="text-danger">{{form.errors.for}}</div>
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

