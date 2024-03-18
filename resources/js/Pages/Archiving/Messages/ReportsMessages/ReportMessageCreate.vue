<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  computed, onMounted, ref, watch  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2'
import VueEasyLightbox from 'vue-easy-lightbox'
import * as Functions from "@/jsFiles/Functions.js" ;
 
const props = defineProps([ "file" , "emails"  , "company_emails"   ,  "reference_numbers"]) ;
 
 
 
 
let form = useForm ({
    file_id  : props.file.id ,
    reference_number_id :   ''  ,
    emails  :  [] , 
    message_type  :  '' , 
    message_title :  ''  ,
    message_content  :  ''  ,
    message_attachments   :   []  ,
 
    }); 
  
const files_path = ref({ 
        message_attachments      :  []  ,
}) , 
    files_type = ref({
        message_attachments      :  []  ,
}) ; 

const clicked_index = ref(-1) ;
const visible_ref  = ref ({
    message_attachments  : false ,
}) ;
 

function   ImageFilePicked (event , form_name  ) {
    const temp_files = event.target.files ; 
    for (let i = 0 ; i < temp_files.length ; i ++ ) {  
 
    form[form_name].push(  temp_files[i] ) ;
    files_path.value[form_name].push( URL.createObjectURL(temp_files[i]) ) ;
    if ( temp_files[i].type.includes('image/')  )  {
        files_type.value[form_name].push( 'image/' ) ;
    } else if ( temp_files[i].type.includes('application/pdf') )  {
        files_type.value[form_name].push( 'application/pdf' ) ;
    }
    console.log( files_type.value);
    }
}; 

function  RemoveImages   ( form_name , index  )  {
        files_path.value[form_name]   = files_path.value[form_name].filter( (el , i  ) => {  return  index != i   } ) ;
        files_type.value[form_name]   = files_type.value[form_name].filter( (el , i  ) => {  return  index != i   } ) ;
        form[form_name]           = form[form_name].filter( (el , i  ) => {  return  index != i   } ) ;
}


function  ImageMagnified  (img_name  , i )  {
    clicked_index.value = i ; 
    visible_ref.value[img_name] = true ;
}   

function  HideImageMagnified (img_name)  {
    visible_ref.value[img_name] = false 
} 

function IsImageOrPdf(file_path) {
  const image_extensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp'];
  const pdf_extension = '.pdf';
  const extension = file_path.substring(file_path.lastIndexOf('.')).toLowerCase();
  return image_extensions.includes(extension) ? 'image' : extension === pdf_extension ? 'pdf' : 'unknown';
}


                    

function SetMessageDefaultContent () {

    if (form.message_type == "إرسال بلاغ" ) {
        form.message_title =    `  احالة ملف جديد  ${props.file.company_name}/${props.file.year}/${props.file.folder_number} `  ;                         
        form.message_content =    ` تحية طيبة وبعد  الرجاء الإطلاع على المرفق والسلام عليكم`  ;     
    }
    else if (form.message_type == "أخرى" ) {
        form.message_title =    ``  ;                         
        form.message_content = `` ;   
    }
}
function Create () {

    // Swal.fire({
    //     title: "رسالة تأكيد ",
    //     icon: 'info',
    //     html :  "أرجو التحقق من البيانات قبل الإرسال هل انت متأكد من صحة البيانات ؟"   ,
    //     type: "info",
    //     showCancelButton: true,
    //     confirmButtonColor: "green",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "ارسال رسالة ",
    //     cancelButtonText: "إلغاء",
    //     showLoaderOnConfirm: true,
    //     preConfirm: () => {
    //         form.post( route('Archiving.Messages.ReportsMessages.StoreReportMessage')  , { preserveState : true , 
    //         onSuccess : () =>  toast.success("تم الإرسال بنجاح")  ,
    //         onError :  (e) => { toast.error("حدث خطأ لم تتم الإرسال  ") ;  } ,
    //         onFinish : () =>   { //  form.reset() ;
    //          }  ,
    //         }  ) ;
    //     }
    //     });


        form.post( route('Archiving.Messages.ReportsMessages.ReportMessageStore')  , { preserveState : true , 
            onSuccess : () =>  toast.success("تم الإرسال بنجاح")  ,
            onError :  (e) => { toast.error("حدث خطأ لم تتم الإرسال  ") ;  } ,
            onFinish : () =>   { //  form.reset() ;
                 console.log(form.errors);
             }  ,
            }  ) ;

}
   

</script>

<template>
    <Head title="  إسال رسالة  " />
    <AppLayoutArchive >
                    <div class="row g-3"  >


                            <h3>   إرسال رسالة تخص الملف رقم     <span class="text-info"> ({{ `${props.file.company_name}/${props.file.year}/${props.file.folder_number}`  }}) </span>   </h3>
                            <hr />
                            <!--" -->
                            <h5>   اختر الإيميلات     </h5>

                            <div class="col-md-4"  > 
                            <hr />
                            <h6>   ايميلات الشركة      </h6>
                            <div class="form-check form-switch  "  v-for="email , i in company_emails"  >
                            <input class="form-check-input" type="checkbox" role="switch" :id="email.id" v-model="form.emails" 
                            :value="{email : email.company_email  , for : email.for  }"  >
                            <label class="form-check-label" :for="email.id">  {{  `${email.company_email} - ${email.for}`   }} </label>
                         
                            </div>
                           </div>
                           <div class="col-md-1" >  </div>
                           <div class="col-md-4"  >
                         
                         <hr />
                         <h6>   ايميلات عامة      </h6>
                         <div class="form-check form-switch "  v-for="email , i in emails"  >
                         <input class="form-check-input" type="checkbox" role="switch" :id="email.id" v-model="form.emails"
                          :value="{email : email.company_email  , for : email.for  }">
                         <label class="form-check-label" :for="email.id">  {{  `${email.company_email} - ${email.for} `   }}  </label>
                        
                         </div>
                        </div>
                        <div v-if = "form.errors.emails" class="text-danger ">  عليك اختيار ايميل واحد على الأقل  </div>
                           <div class="col-md-5" >  </div>
 
                            <hr />
                        
                            <div class="col-md-2">
                                        <label for="message_type" class="form-label">نوع الرسالة</label>
                                        <el-select  @change = "SetMessageDefaultContent()"
                                            filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus "
                                            id="message_type" 
                                            placeholder = "اختر نوع الرسالة" remote v-model="form.message_type"  >
                                            <el-option  :label="'إرسال بلاغ'" :value="'إرسال بلاغ'" ></el-option>
                                            <el-option  :label="'أخرى'" :value="'أخرى'" ></el-option>
                                        </el-select>
                                        <div v-if = "form.errors.message_type" class="text-danger">{{form.errors.message_type}}</div>
                            </div>

                                    <div class="col-md-2">
                                        <label for="reference_number_id" class="form-label">الإشاري</label>
                                        <el-select 
                                            filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus " id = "reference_number_id" 
                                            placeholder = "اختر الإشاري" remote v-model="form.reference_number_id"  >
                                            <el-option   :value="''" :label="'بلا'"></el-option>
                                            <el-option v-for="reference_number , i   in  reference_numbers" :key="i"
                                            :label="`${reference_number.year}/${reference_number.reference_number} ${reference_number.title }` "
                                             :value="reference_number.id" ></el-option>
                                        </el-select>
                                        <div v-if = "form.errors.reference_number_id" class="text-danger">{{form.errors.reference_number_id}}</div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="message_title" class="form-label">العنوان</label>
                                        <input type="text" class="form-control" id="message_title" v-model="form.message_title"  >
                                        <div v-if = "form.errors.message_title" class="text-danger">{{form.errors.message_title}}</div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label for="message_content" class="form-label">محتوى الرسالة</label>
                                        <textarea  class="form-control" id="message_content" v-model="form.message_content"  rows="3"></textarea>
                                        <div v-if = "form.errors.message_content" class="text-danger">{{form.errors.message_content}}</div>
                                    </div>

 

                                    <div class="col-md-3">
                                        <label for="message_attachments" class="form-label">المرفقات</label>
                                        <input type="file" class="form-control" id="message_attachments"  
                                        multiple
                                        @input="ImageFilePicked( $event , 'message_attachments')" >
                                        <br>
                                        <div class="box_container">
                                            <div :class="'img_box'"
                                            v-if="files_path['message_attachments']" 
                                            v-for="file , i in files_path['message_attachments']" :key="i"
                                            >
                                                <img v-if="files_type['message_attachments'][i] == 'image/' "
                                                    :src="file" alt=""  @click="ImageMagnified( 'message_attachments' , i )  " > 
                                                    <a  v-else-if="  files_type['message_attachments'][i]  == 'application/pdf'"
                                                    :href="file" target="_blank" ><fa class="fs-1"  icon = 'file-pdf' /></a>
                                                <span @click="RemoveImages('message_attachments' , i)">X</span>
                                            </div>
                                        </div>
                                        
                                        <vue-easy-lightbox
                                            :visible="visible_ref['message_attachments']"
                                            :imgs="files_path['message_attachments']"
                                            :index = "clicked_index"
                                            @hide="HideImageMagnified('message_attachments')"
                                        ></vue-easy-lightbox>
                                        <div v-if = "form.errors['message_attachments.0']" class="text-danger">{{form.errors['message_attachments.0']}}</div>
                                        </div>

                      
                 

                                    <div class="col-12">
                                        <Link   v-if ="!form.processing"   class="btn btn-info"  :href = "route('Archiving.Files.index')" > <fa icon = "arrow-right" />  {{ 'رجوع'}}   </Link>
                                        &nbsp;
                                        <button type="buttom" 
                                            @click="Create()"
                                        :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري   الإرسال ...' : 'ارسال رسالة'  }}</button>
                                    </div>
                        </div>
     </AppLayoutArchive>
</template>

<style scoped>

</style>

