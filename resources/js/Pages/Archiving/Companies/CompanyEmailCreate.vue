<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  ref  } from 'vue';
import Navbar from  '@/Layouts/Navbar.vue';
import AsideArchive from  '@/Layouts/AsideArchive.vue';
import { toast } from 'vue3-toastify';

 const props =  defineProps( ["company"] ) ;

const email_regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

let   is_email_duplicate = ref(false) ;
let form = useForm ({
    company_id : props.company.id  , 
    company_email : 'sanoose43@gmail.com' , 
    for   : 'مدير الشركة' , 
    old_emails :  props.company.company_emails ,
    emails :  [] ,
 
}); 

 
function  Create () {
 
         form.post( route('Archiving.Companies.CompanyEmailStore')  , { 
            // preserveState : true , 
         onSuccess : () =>  {
             toast.success("تم اضافة ايميل الشركة بنجاح")  ; 
             form.old_emails.push(
                ...form.emails.map( (el) =>  
                { return { "company_email" : el.company_email , "for" : el.for }  ; } )
             ) ;
             form.emails = [] ;
            } ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة ايميل الشركة") ;  } ,
         onFinish : () =>   {  }  ,
         }  ) ;
}


function RemoveCompanyEmail(index) {
    if (index >= 0  )  {
        form.emails =  form.emails.filter( ( el ,  i ) => { return i != index ;  }) ;
    }
}
 
function AddCompanyEmail() {

     is_email_duplicate.value = form.emails.some(email => email.company_email == form.company_email) ||  
                                form.old_emails.some(email => email.company_email == form.company_email) ;
    if (is_email_duplicate.value) 
        return null ;
    if (form.company_email !== '' &&   form.for !== ''  ) {

    if (email_regex.test(form.company_email)) {
        form.emails.push( { "company_email" : form.company_email , "for" : form.for } ) ;
        form.company_email = "" ;
    } else {
    console.log('البريد الإلكتروني غير صحيح');
    }

}
 
  
}
 


</script>

<template>
    <Head title="اضافة ايميل شركة" />

        <div class="wrapper">
            <AsideArchive  />          

            <div class="content" >
                <Navbar />
                <div class="main-content">
                    <div class="row g-3"  >
                            <h3> إضافة ايميل شركة   </h3>
                            <hr />
 
                            <div class="col-md-3"  >
                                    <label for="company_email" class="form-label"  >ايميل الشركة</label>
                                    <div class="plus_field_container">
                                        <input type="text" class="form-control" id="company_email" v-model="form.company_email" 
                                        @keydown.enter = "AddCompanyEmail()" >
                                        <div v-if = "is_email_duplicate" class="text-danger">الإيميل مضاف مسبقا</div>
                                        <div v-if = "form.errors.company_email" class="text-danger">{{form.errors.company_email}}</div>
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

 
                                <label v-for="e , i in  form.emails"  >
                                    {{  `${e.company_email}  - ${e.for}`  }} 
                                    <fa  icon = "trash" class="danger_hover" @click = "RemoveCompanyEmail(i)" />     &nbsp;  </label>
                          </div>

                            <div class="col-12">
                                <Link  :href="route('Archiving.Companies.index')" >     
                                    <button type="button" v-if="!form.processing" class="btn btn-info submit "> 
                                      <fa  icon = "arrow-right" />  رجوع         
                                    </button> 
                                </Link>  

                                <button type="buttom"  @click="Create()" class="btn btn-primary submit"
                                :disabled ="form.processing"  > {{ form.processing ?  'جاري الحفظ ...' : 'حفظ'  }} </button>
                       
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

