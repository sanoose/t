<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  computed, onMounted, ref, watch  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2'
import VueEasyLightbox from 'vue-easy-lightbox'
import * as Functions from "@/jsFiles/Functions.js" ;
 
const props = defineProps([ "file" , "emails"  , "company_emails" ]) ;
 
let form = useForm ({
    file_id  : props.file.id ,
    clime_files :   [] ,
    }); 
  
const files_path = ref({ 
    clime_files      :  []  ,
}) , 
    files_type = ref({
        clime_files      :  []  ,
}) ; 

const clicked_index = ref(-1) ;
const visible_ref  = ref ({
    clime_files  : false ,
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


function Create () {
 
        form.post( route('Archiving.Claims.ClaimStore')  , { preserveState : true , 
            onSuccess : () =>  toast.success("تم الحفظ بنجاح")  ,
            onError :  (e) => { toast.error("حدث خطأ لم يتم الحفظ  ") ;  } ,
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
                            <h3>   انشاء مطالبة تخص الملف رقم     <span class="text-info"> ({{ `${props.file.company_name}/${props.file.year}/${props.file.folder_number}`  }}) </span>   </h3>
                            <hr />
                                    <div class="col-md-3">
                                        <label for="clime_files" class="form-label">ملفات المطالبة</label>
                                        <input type="file" class="form-control" id="clime_files"
                                        multiple
                                        @input="ImageFilePicked( $event , 'clime_files')" >
                                        <br>
                                        <div class="box_container">
                                            <div :class="'img_box'"
                                            v-if="files_path['clime_files']" 
                                            v-for="file , i in files_path['clime_files']" :key="i"
                                            >
                                                <img v-if="files_type['clime_files'][i] == 'image/' "
                                                    :src="file" alt=""  @click="ImageMagnified( 'clime_files' , i )  " > 
                                                    <a  v-else-if="  files_type['clime_files'][i]  == 'application/pdf'"
                                                    :href="file" target="_blank" ><fa class="fs-1"  icon = 'file-pdf' /></a>
                                                <span @click="RemoveImages('clime_files' , i)">X</span>
                                            </div>
                                        </div>
                                        
                                        <vue-easy-lightbox
                                            :visible="visible_ref['clime_files']"
                                            :imgs="files_path['clime_files']"
                                            :index = "clicked_index"
                                            @hide="HideImageMagnified('clime_files')"
                                        ></vue-easy-lightbox>
                                        <div v-if = "form.errors['clime_files']" class="text-danger">{{form.errors['clime_files']}}</div>
                                        </div>

                                    <div class="col-12">
                                        <Link   v-if ="!form.processing"   class="btn btn-info"  :href = "route('Archiving.Files.index')" > <fa icon = "arrow-right" />  {{ 'رجوع'}}   </Link>
                                        &nbsp;
                                        <button type="buttom" 
                                            @click="Create()"
                                        :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري   الحفظ ...' : 'حفظ'  }}</button>
                                    </div>
                        </div>
     </AppLayoutArchive>
</template>

<style scoped>

</style>

