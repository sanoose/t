<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  ref  } from 'vue';
import Navbar from  '@/Layouts/Navbar.vue';
import AsideArchive from  '@/Layouts/AsideArchive.vue';
import { toast } from 'vue3-toastify';

defineProps({ errors: Object }) ;

const email_regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
let   is_email_duplicate = ref(false) ;
let form = useForm ({
    company_name : 'العالمية' ,

    company_code: 'ES6' , 
    company_password : '123' , 
  
    company_email : 'sanoose43@gmail.com' , 
    for   : 'مدير الشركة' , 
    emails :  [
    { company_email : 'sanoose43@gmail.com' , for : 'المدير' }  ,
    ],
 
}); 

 
function  Create () {
 
         form.post( route('Archiving.Companies.store')  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم اضافة الشركة بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة الشركة") ;  } ,
         onFinish : () =>   {  }  ,
         }  ) ;
}


function RemoveCompanyEmail(index) {
    if (index >= 0  )  {
        console.log(       form.emails  );
        form.emails =  form.emails.filter( ( el ,  i ) => { return i != index ;  }) ;
    }
}
 
function AddCompanyEmail() {

     is_email_duplicate.value = form.emails.some(email => email.company_email == form.company_email);
    if (is_email_duplicate.value) 
        return null ;

    if (form.company_email !== '' &&   form.for !== ''  ) {

    if (email_regex.test(form.company_email)) {
        form.emails.push( { "company_email" : form.company_email , "for" : form.for } ) ;
        form.company_email = "" ;
    } else {
    console.log('البريد الإلكتروني غير صحيح');
    }
    console.log(form.emails);

}
 
  
}
 


</script>

<template>
    <Head title="اضافة شركة" />

        <div class="wrapper">
            <AsideArchive  />          

            <div class="content" >
                <Navbar />
                <div class="main-content">
                    <div class="row g-3"  >
                            <h3> إضافة شركة جديدة </h3>
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
                                <label for="company_password" class="form-label">  الرمز السري</label>
                                <input type="company_password" class="form-control" id="company_password" v-model="form.company_password"  />
                                <div v-if = "form.errors.company_password" class="text-danger">{{form.errors.company_password}}</div>
                            </div>

                            <div class="col-md-3"  >
                                    <label for="company_email" class="form-label"  >ايميل الشركة</label>
                                    <div class="plus_field_container">
                                        <input type="text" class="form-control" id="company_email" v-model="form.company_email" 
                                        @keydown.enter = "AddCompanyEmail()" >
                                        <div v-if = "is_email_duplicate" class="text-danger">الإيميل مضاف مسبقا</div>
                                    </div>
                            </div>

                            <div class="col-md-3"  >
                                <label for="for" class="form-label"  > مالك الإيميل</label>
                                <div class="plus_field_container">
                                    <input type="text" class="form-control" id="for" v-model="form.for" 
                                      @keydown.enter = "AddCompanyEmail()"  >
                                      &nbsp;
                                    <fa  icon = "plus" class="icon_hover" @click="AddCompanyEmail()" />
                                </div>

                                <!-- <div v-if = "form.errors.for" class="text-danger">{{form.errors.emails}}</div> -->
                                <label v-for="e , i in  form.emails"  >
                                    {{  `${e.company_email}  - ${e.for}`  }} 
                                    <fa  icon = "trash" class="danger_hover" @click = "RemoveCompanyEmail(i)" />     &nbsp;  </label>
                          </div>

                            <div class="col-12">
                                <button type="buttom" 
                                    @click="Create()"
                                v-if="!form.processing" class="btn btn-primary submit">حفظ</button>
                                <button type="button" v-if="form.processing" disabled  class="btn btn-primary submit">جاري الحفظ ...</button>
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

