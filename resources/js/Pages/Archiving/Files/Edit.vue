<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  computed, onMounted, ref, watch  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2'
import VueEasyLightbox from 'vue-easy-lightbox'
import * as Functions from "@/jsFiles/Functions.js" ;
// 2023-12-11 
const props = defineProps([ "file" , "companies"  , "report_parties" , "libyan_party"   ]) ;
const damage_types = ["مادي" , "بدني" , "مادي بدني" , "قاتل"] ;
const now = new Date();
let localDate = `${now.getFullYear()}-${(now.getMonth() + 1).toString().padStart(2, '0')}-${now.getDate().toString().padStart(2, '0')}` ;
let localTime = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}` ;

const date_errors =  JSON.parse( props.file.date_errors ) ;
 
 
let form = useForm ({

    id :  props.file.id   ,
    file_number : props.file.file_number , 
    year : props.file.year , 
    company_id :  props.file.company_id  ,
    old_company_id :  props.file.company_id  ,
    old_folder_number :  props.file.folder_number  ,
    company_name :  props.file.company_name   , 
    old_report_img  :  props.file.report_img , 


    receive_report_date   :  { date : props.file.receive_report_date  , time :  props.file.receive_report_time   , show_time : props.file.receive_report_time ? true : false  }, 
    report_date           :  { date :  props.file.report_date , time :    props.file.report_time  , show_time :   props.file.report_time ? true : false  }, 

    external_reference   :  props.file.external_reference  , 
    card_number          :  props.file.card_number  , 

    insurance_start_date    :  { date : props.file.insurance_start_date    , time :  props.file.insurance_start_time   , show_time : props.file.insurance_start_time ? true : false  }   , 
    insurance_end_date      :  { date : props.file.insurance_end_date    , time :  props.file.insurance_end_time   , show_time : props.file.insurance_end_time ? true : false  }   , 
    accident_date           :  { date : props.file.accident_date    , time :  props.file.accident_time   , show_time : props.file.accident_time ? true : false  }   , 

    insurance_name  :   props.file.insurance_name  , 
    vehicle_type  :  props.file.vehicle_type   , 
    plate_number   :  props.file.plate_number , 
    report_party_id  :  props.file.report_party_id  , 
    currency_type  :  props.file.currency_type  , 
    reserve        :  props.file.reserve         , 
    forien_price  :  props.file.forien_price  , 
    libyan_price  :  props.file.libyan_price   , 
    damage_type   :   props.file.damage_type   ,  
    report_img  :  []  , 
  
    file_status  :  props.file.file_status  , 
    accident_not_covered_reason : props.file.accident_not_covered_reason , 
    date_errors :   date_errors != null ? date_errors :  
                         {  accident_date_error  :      "" ,
                          report_date_error   :          "" ,
                          report_accident_date_error :   ""  , 
                          accident_time_error  :        ""   ,
                          report_time_error   :       ""   ,
                          report_accident_time_error :   ""    ,
                          report_receive_report_time_error :  ""  ,  
                        } ,
    }); 

const currency_type = computed( () =>  
{ 
    if (form.currency_type != 'دولار')
    {
        form.currency_type  =  props.report_parties.find( (el) => el.id ==  form.report_party_id ).currency_name  ;
         return  form.currency_type ; 
    } else {
        return props.report_parties.find( (el) => el.id ==  form.report_party_id ).currency_name  ;
    }
} 
)   ; 

const clicked_index = ref(-1) ;

const visible_ref  = ref ({
    report_img  : false ,
    old_report_img : false ,
}) ;

const files_path = ref({ 
      report_img      :  []  ,
}) , 
      files_type = ref({
      report_img      :  []  ,
}) ; 

let forien_price_text = ref('') ,
    libyan_price_text = ref('')  ;



// تعطيل الأيام التي اكبر من تاريخ وصول البلاغ في تاريخ البلاغ الحقيقي
const disable_next_report_date =  computed ( () => DisableNextDate(form.receive_report_date.date)  ) ;
const disable_next_start_date =  computed ( () => DisableNextDateMinus1(form.insurance_end_date.date)  ) ;
const disable_previes_end_date =  computed ( () => DisablePreviesDate(form.insurance_start_date.date)  ) ;

function DisableNextDate(date) {
          date = new Date(date) ;
        if (!isNaN(date)) {
          date.setDate(date.getDate());
          return date.toISOString().slice(0, 10);
        }
        return null; 
}

function DisableNextDateMinus1 (date) {
    date = new Date(date) ;
        if (!isNaN(date)) {
          date.setDate(date.getDate() - 1 );
          return date.toISOString().slice(0, 10);
        }
          return null; 
}

function DisablePreviesDate(date) {
          date = new Date(date) ;
        if (!isNaN(date)) {
          date.setDate(date.getDate()  + 1  );
         
          return date.toISOString().slice(0, 10);
        }
        // return null; 
}

function HandleDisabledDateKeyDown(event) {
       const selected = new Date( event.target.value ) ;
       if (event.target.getAttribute("max") != null ) {
        const max = new Date( event.target.getAttribute("max") ) ; 
        if (selected.getTime() > max.getTime() ) 
            event.target.value = event.target.getAttribute("max") ;
       } 
       else if (event.target.getAttribute("min") != null )   {
        const min = new Date( event.target.getAttribute("min") ) ; 
        if ( selected.getTime() < min.getTime() )
            event.target.value = event.target.getAttribute("min") ;
       }

    }

// تحقق ان تاريخ الحادث يكون ما بين تاريخ بداية ونهاية مدة التأمين  
function CheckeAccidentDateError( start_date , end_date ,  accident_date ) {
      if (start_date.date != ''  &&   end_date.date != '' && accident_date.date != '' )
      {
        // اضطررت لإعادة تعريف متغير جديد  لو استعملت نفس الاوبجكت الي داخل الباراميتر يمشي يغير قيمة الاوبجكت في فمتغير الفورم بق مفهمتش كيف جي 
        let start_date_      =  new Date(start_date.date);
        let start_time      =  start_date.time ;
     
        let end_date_        =  new Date(end_date.date);
        let end_time        =   end_date.time ;

        let accident_date_   =  new Date(accident_date.date);
        let accident_time    =   accident_date.time ;
 
        if ( accident_date_  >= start_date_  && accident_date_  <= end_date_ ) {
            if ( ( accident_date_.getTime() == start_date_.getTime() ) || (accident_date_.getTime() ==  end_date_.getTime() ) ) {
                    form.accident_date.show_time = true ;
                if (  accident_date_.getTime() == start_date_.getTime() )  {
                    form.insurance_start_date.show_time = true ;
                    form.insurance_end_date.show_time = false ;
                    if (accident_time  >=   start_time) {
                        form.date_errors.accident_time_error = "" ;  return  null  ;
                    }
                    else {
                        form.date_errors.accident_time_error = "وقت الحادث  اصغر من وقت بداية التأمين " ;  return  null  ;
                    }
                } 
                else if (accident_date_.getTime() ==  end_date_.getTime() ) {
                    form.insurance_end_date.show_time = true ;
                    form.insurance_start_date.show_time = false ;
                    // if ( accident_time  != ''  && end_time  != '' ) {
                    if ( accident_time  <= end_time  ) {
                        form.date_errors.accident_date_error    =   ''  ;
                        form.date_errors.accident_time_error = "" ;  return  null  ;
                    }
                    else {
                        form.date_errors.accident_date_error    =   ''  ;
                        form.date_errors.accident_time_error = "وقت الحادث  اكبر من تاريخ نهاية التأمين " ;  return  null  ;
                    }
                    // } else {
                    //     return null ;
                    // }
                }
 
            }  
            form.insurance_start_date.show_time = false ;
            form.insurance_end_date.show_time = false ;
            form.accident_date.show_time = false ;
            form.date_errors.accident_date_error    =  "" ;
        console.log(  'done' );
      } 
      else {
        form.insurance_start_date.show_time = false ;
        form.insurance_end_date.show_time = false ;
        form.accident_date.show_time = false ;
        form.date_errors.accident_time_error = "" ; 
        form.date_errors.accident_date_error = "تاريخ الحادث يجب ان يكون ما بين تاريخ بداية التأمين  وتاريخ نهاية التأمين";
      }
    }
     else {
        form.date_errors.accident_date_error =  '' ;
        console.log(  "احد الحقول فارغ" );
    }
}

// التحقق ان تاريخ الحادث قبل تاريخ البلاغ   
function CheckReportDateAccidentDateError(report_date , accident_date ) {
    if ( report_date.date != ''  &&  accident_date.date != '' ) {
        let accident_date_ = new Date(accident_date.date) ;
        let report_date_  = new Date(report_date.date) ;
        let accident_time  = accident_date.time  ;
        let report_time  = report_date.time ;

        if ( report_date_.getTime()   >=  accident_date_.getTime()   ) {
            if ( report_date_.getTime()   ==   accident_date_.getTime() ) {
            form.report_date.show_time = true ;
            form.accident_date.show_time = true ;
            // تاكد الوقت فيه بيانات قبل ما تدير مقارنة
            // if (report_time != '' && accident_time != '' )  {
                    if (report_time  >=   accident_time ) {
                form.date_errors.report_accident_date_error =  '' ;
                form.date_errors.report_accident_time_error =  ''  ;  return  null  ;
                    }
                    else {
                        form.date_errors.report_accident_date_error =  '' ;
                        form.date_errors.report_accident_time_error =  "وقت الحادث   يجب ان يكون اقل من وقت البلاغ " ;  return  null  ;
                    }
                // } else {
                //     return null ;
                // }
            }  
            form.report_date.show_time = false ;
            //  تأكد ان وقت بداية والنهاية مش ظاهرين قبل ما تخفي  وقت الحادث لأن لو ظاهرين معناه الشخص يدير فعملية في جهة بداية ونهاية التأمين ومزال محتاج وقت الحادث متخفيشي
            form.accident_date.show_time = !form.insurance_start_date.show_time  &&  !form.insurance_end_date.show_time  ?  false : true ;
            form.date_errors.report_accident_time_error = '' ;
            form.date_errors.report_accident_date_error =  '' ;
        } else {
            console.log('err') ;
            form.report_date.show_time = false ;
            form.accident_date.show_time = false ;
            form.date_errors.report_accident_time_error = '' ;
           form.date_errors.report_accident_date_error = "تاريخ الحادث   يجب ان يكون اقل من تاريخ البلاغ   ";
        }
    } else {
        console.log(  "احد الحقول فارغ" );
    }
}

// التحقق ان تاريخ البلاغ اكبر من تاريخ بداية مدة التأمين    
function CheckReportDateError(report_date , start_date ) {
    if ( report_date.date != ''  &&  start_date.date != '' ) {
        let report_date_ = new Date(report_date.date) ;
        let start_date_  = new Date(start_date.date) ;
        let report_time  = report_date.time ;
        let start_time   = start_date.time ;

        if ( report_date_.getTime()  >=  start_date_.getTime()   ) {
            if ( report_date_.getTime()   ==   start_date_.getTime() ) {

                    form.insurance_start_date.show_time = true ;
                    form.report_date.show_time = true ;
                    if (report_time  >=   start_time) {
                        form.date_errors.report_date_error =  '' ;
                        form.date_errors.report_time_error =  '' ;  return  null  ;
                    }
                    else {
                        form.date_errors.report_date_error =  '' ;
                        form.date_errors.report_time_error =  "وقت البلاغ   يجب ان يكون اكبر  من وقت بداية مدة التأمين   " ;  return  null  ;
                    }
            } 
            form.date_errors.report_date_error =  '' ;
            form.insurance_start_date.show_time = false ;
            form.report_date.show_time = false ;   
        } else {
            console.log('err') ;
            form.insurance_start_date.show_time = false ;
            form.report_date.show_time = false ;   
            form.date_errors.report_time_error =  '' ; 
            form.date_errors.report_date_error = "تاريخ البلاغ   يجب ان يكون اكبر  من تاريخ بداية مدة التأمين   ";
        }
    } else {
        console.log(  "احد الحقول فارغ" );
    }
}

// التحقق ان وقت استلام البلاغ اكبر من وقت البلاغ 
function CheckReportAndReceiveReportTimeError( receive_report_date , report_date )   {
    if ( receive_report_date.date != ''  &&  report_date.date != '' ) {
        let receive_report_date_ = new Date(receive_report_date.date) ;
        let report_date_  = new Date(report_date.date) ;
        let receive_report_time  = receive_report_date.time  ;
        let report_time  = report_date.time ;

        if ( receive_report_date_.getTime()   >=  report_date_.getTime()   ) {
            if ( receive_report_date_.getTime()   ==   report_date_.getTime() ) {
            form.report_date.show_time = true ;
            if (receive_report_time  >=   report_time ) {
                form.date_errors.report_receive_report_time_error =  ''  ;  return  null  ;
            }
            else {
                form.date_errors.report_receive_report_time_error =  "وقت البلاغ   يجب ان يكون اقل  من وقت استلام البلاغ  " ;  return  null  ;
            }
            }  
            form.report_date.show_time =  false ;
            form.date_errors.report_receive_report_time_error = '' ;
        } else {
            console.log('err') ;
            form.receive_report_date.show_time =  false ;
            form.date_errors.report_receive_report_time_error = '' ;
        }
    } else {
        console.log(  "احد الحقول فارغ" );
    }
}

function HandleFunctionsErros() {
    CheckeAccidentDateError( form.insurance_start_date , form.insurance_end_date , form.accident_date ) ;
    // CheckReportDateError( form.report_date , form.insurance_start_date ) ;
    CheckReportDateAccidentDateError(form.report_date , form.accident_date ) ;  // التحقق ان تاريخ الحادث قبل تاريخ البلاغ   
    // CheckReportAndReceiveReportTimeError(form.receive_report_date  , form.report_date  ) ;
}

function   ImageFilePicked (event , form_name  ) {
    const temp_files = event.target.files ; 
    form[form_name] = [] ;
    form.old_report_img = '' ;
    files_path.value[form_name] = [] ;
    files_type.value[form_name] = [] ;
    for (let i = 0 ; i < temp_files.length ; i ++ ) {  
    form[form_name].push(  temp_files[i] ) ;
    files_path.value[form_name].push( URL.createObjectURL(temp_files[i]) ) ;
    if ( temp_files[i].type.includes('image/')  )  
        files_type.value[form_name].push( 'image/' ) ;
    else if ( temp_files[i].type.includes('application/pdf') )  
        files_type.value[form_name].push( 'application/pdf' ) ;
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
 

  return image_extensions.includes(extension) ? 'image' :
                  extension === pdf_extension ? 'pdf' :
                  'unknown';
}
 
// حساب الاحتياطي
function CalcPrice () {
 
    if (form.reserve != '' &&  form.report_party_id != '' && form.currency_type !=  ''   ) {
       
        let report_party = props.report_parties.find( (el) =>  el.id == form.report_party_id ) ;
        if (form.currency_type == "دولار")
        {
            form.forien_price = (form.reserve  *  report_party.exchange_rate).toFixed(3);
            forien_price_text.value =  `${form.reserve}  *   سعر الصرف  ${report_party.exchange_rate}  =  ${ Functions.MakeNumberLikeMony ((form.reserve  *  report_party.exchange_rate).toFixed(3)) }   ${ report_party.currency_name }` ;
            form.libyan_price = (form.reserve *  props.libyan_party.exchange_rate ).toFixed(3) ;
            libyan_price_text.value  =  ` ${ Functions.MakeNumberLikeMony (form.reserve) }  $ *   سعر الصرف  ${props.libyan_party.exchange_rate}  = ${ Functions.MakeNumberLikeMony (form.libyan_price ) }    ${ props.libyan_party.currency_name }`  ;
        } 
        else if  (form.currency_type ==  currency_type.value)
        { 
           
            form.forien_price = (form.reserve  /  report_party.exchange_rate).toFixed(3) ;
            forien_price_text.value =  ` ${ Functions.MakeNumberLikeMony (form.reserve) }  /   سعر الصرف  ${report_party.exchange_rate}  =   ${ Functions.MakeNumberLikeMony (form.forien_price) } دولار`  ;
            form.libyan_price = (form.forien_price *  props.libyan_party.exchange_rate ).toFixed(3) ;
            libyan_price_text.value  =  ` ${ Functions.MakeNumberLikeMony (form.forien_price) } $  *   سعر الصرف  ${props.libyan_party.exchange_rate}  =  ${ Functions.MakeNumberLikeMony (form.libyan_price) }  ${ props.libyan_party.currency_name }` ;
        }
    } else { 
        forien_price_text.value = '' ;
    }
}

function GetNewProps () {
    form.file_number = props.file.file_number ;
    form.year = props.file.year  ;
    form.company_id =  props.file.company_id  ;
    form.old_company_id = props.file.company_id  ;
    form.old_folder_number =  props.file.folder_number  ;
    form.company_name =  props.file.company_name    ;
    form. old_report_img  =   props.file.report_img  ;
    form.report_img = [] ;
    files_path.value.report_img = [] ;
    files_type.value.report_img = [] ;
}

function  Update () {
    if (form.date_errors.accident_date_error ||  form.date_errors.report_date_error  || form.date_errors.report_accident_date_error  
    || form.date_errors.accident_time_error  || form.date_errors.report_time_error  || form.date_errors.report_accident_time_error || form.report_receive_report_time_error    ) {
        let errorMessage = "لديك بعض الأخطاء في إدخال التواريخ هل انت متأكد من أنك تريد حفظ  الملف ؟<br/>";
        errorMessage += form.date_errors.accident_date_error ? `<br/><span class="text-danger d-inline-block  rtl">- ${form.date_errors.accident_date_error} . </span>` : '';
        errorMessage += form.date_errors.report_date_error ? `<br/><span class="text-danger d-inline-block   rtl">- ${form.date_errors.report_date_error} .</span>` : '';
        errorMessage += form.date_errors.report_accident_date_error ? `<br/><span class="text-danger d-inline-block rtl">- ${form.date_errors.report_accident_date_error} .</span>` : '';
        errorMessage += form.date_errors.accident_time_error ? `<br/><span class="text-danger d-inline-block   rtl">- ${form.date_errors.accident_time_error} .</span>` : '';
        errorMessage += form.date_errors.report_time_error ? `<br/><span class="text-danger d-inline-block   rtl">- ${form.date_errors.report_time_error} .</span>` : '';
        errorMessage += form.date_errors.report_accident_time_error ? `<br/><span class="text-danger d-inline-block  rtl">- ${form.date_errors.report_accident_time_error} .</span>` : '';
        errorMessage += form.date_errors.report_receive_report_time_error ? `<br/><span class="text-danger d-inline-block   rtl">- ${form.date_errors.report_receive_report_time_error} .</span>` : '';

        Swal.fire({
        title: "رسالة تنبيه ",
        icon: 'warning',
        html :  errorMessage   ,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حفظ الملف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            form.post( route('Archiving.Files.FilesUpdate'  )  , {   preserveState : true ,
            onSuccess : () =>  { toast.success("تم تعديل الملف بنجاح") } ,
            onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة الملف") ;  } ,
            onFinish : () =>   {  GetNewProps () ;
             }  ,
            }  ) ;
        }
        });
    } else {
        form.post( route('Archiving.Files.FilesUpdate'  )  , {    preserveState : true , 
            onSuccess : () =>  {toast.success("تم تعديل الملف بنجاح") } ,
            onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة الملف") ;  } ,
            onFinish : () =>   {   
                console.log(form.old_company_id);
                GetNewProps (); 
               }  ,
            }  ) ;
    }
}


onMounted ( () => {
    CalcPrice () ;
}) ;



</script>

<template>
    <Head title="تعديل ملف" />
    <AppLayoutArchive >
                    <div class="row g-3"  >
                            <h3>   تعديل   الملف رقم   :  <span class="text-info"> ({{ `${form.company_name}/${form.year}/${form.old_folder_number}`  }}) </span>   </h3>
                            <hr />
                                    <div class="col-md-2">
                                        <label for="company_id" class="form-label">اختر   الشركة  </label>
                                        <el-select 
                                            filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus " 
                                            placeholder = "اختر الشركة" remote v-model="form.company_id"  >
                                            <el-option v-for="company , i   in  companies" :key="i"
                                            :label="company.company_name" :value="company.id" ></el-option>
                                        </el-select>
                                        <div v-if = "form.errors.id" class="text-danger">{{form.errors.id}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="receive_report_date.date" class="form-label">  تاريخ استلام البلاغ </label>
                                        <input type="date" class="form-control" id="receive_report_date.date" v-model="form.receive_report_date.date" 
                                           @input=" form.report_date.date = '' ">
                                        <div v-if = "form.errors['receive_report_date.date']" class="text-danger">{{form.errors['receive_report_date.date']}}</div>
                                    </div>

                                    <div class="col-md-2" v-if="form.receive_report_date.show_time" >
                                        <label for="receive_report_date.time" class="form-label">  وقت استلام البلاغ </label>
                                        <input
                                        @input="HandleFunctionsErros()"
                                        type="time" class="form-control" id="receive_report_date.time" v-model="form.receive_report_date.time"  >
                                        <div v-if = "form.errors.receive_report_date" class="text-danger">{{form.errors.receive_report_date}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="report_date.date" class="form-label">  تاريخ  البلاغ   </label>
                                        <input type="date" class="form-control"
                                          @input="HandleFunctionsErros()" @change="HandleDisabledDateKeyDown($event)"
                                          id="report_date.date" v-model="form.report_date.date" :max="disable_next_report_date"  
                                          :class="{'border_error'  :  form.date_errors.report_date_error }" 
                                          
                                          />  
                                        <div v-if = "form.date_errors.report_date_error" class="text-danger">{{ form.date_errors.report_date_error  }}</div>
                                        <div v-if = "form.errors['report_date.date']" class="text-danger">{{form.errors['report_date.date']}}</div>
                                    </div>

                                    <div class="col-md-2" v-if="form.report_date.show_time">
                                        <label for="report_date.time" class="form-label">  وقت البلاغ   </label>
                                        <input type="time" class="form-control"
                                          @input="HandleFunctionsErros()" id="report_date.time" v-model="form.report_date.time"  
                                        
                                          :class="{'border_error'  : form.date_errors.accident_time_error  || form.date_errors.report_accident_time_error , 
                                                 'shining_warning' : form.accident_date.show_time   ,
                                                 'shining_success' :  (!form.date_errors.report_accident_time_error && form.accident_date.time != '' ) }" 
                                                 />  
                                        <div v-if = "form.date_errors.report_time_error" class="text-danger">{{ form.date_errors.report_time_error  }}</div>
                                        <div v-if = "form.date_errors.report_receive_report_time_error" class="text-danger">{{ form.date_errors.report_receive_report_time_error  }}</div>
                                        <div v-if = "form.errors.report_date" class="text-danger">{{form.errors.report_date}}</div>
                                    </div>
                                 
                            

                                    <div class="col-md-2">
                                        <label for="external_reference" class="form-label">  رقم المرجع الخارجي </label>
                                        <input type="text" class="form-control" id="external_reference" v-model="form.external_reference"  >
                                        <div v-if = "form.errors.report_party_name" class="text-danger">{{form.errors.external_reference}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="card_number" class="form-label">  رقم   البطاقة </label>
                                        <input type="text" class="form-control" id="card_number" v-model="form.card_number"  >
                                        <div v-if = "form.errors.card_number" class="text-danger">{{form.errors.card_number}}</div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label for="insurance_name" class="form-label"> اسم المؤمن </label>
                                        <input type="text" class="form-control" id="insurance_name" v-model="form.insurance_name"  >
                                        <div v-if = "form.errors.insurance_name" class="text-danger">{{form.errors.insurance_name}}</div>
                                    </div>

                                 
                                    
                                    <div class="col-md-2">
                                        <label for="insurance_start_date.date" class="form-label">  تاريخ  بداية  التأمين   </label>
                                        <input type="date" class="form-control" 
                                        @input="HandleFunctionsErros()" @change="HandleDisabledDateKeyDown($event)"
                                        id="insurance_start_date.date" v-model="form.insurance_start_date.date"  :max="disable_next_start_date" >
                                        <div v-if = "form.errors['insurance_start_date.date']" class="text-danger">{{form.errors['insurance_start_date.date']}}</div>
                                    </div>
                                    <div class="col-md-2" v-if="form.insurance_start_date.show_time" >
                                        <label for="insurance_start_date.time" class="form-label">  وقت  بداية  التأمين   </label>
                                        <input type="time" class="form-control" id="insurance_start_date.time" v-model="form.insurance_start_date.time"  
                                        @input="HandleFunctionsErros()"
                                        :class="{'shining_warning' : form.insurance_start_date.show_time , 
                                                 'shining_success' :  (!form.date_errors.accident_time_error && form.insurance_start_date.time != '' )   }">
                                        <div v-if = "form.errors.insurance_start_date" class="text-danger">{{form.errors.insurance_start_date}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="insurance_end_date.date" class="form-label">  تاريخ  انتهاء  التأمين    </label>
                                        <input type="date" class="form-control" id="insurance_end_date.date" v-model="form.insurance_end_date.date"  :min="disable_previes_end_date" 
                                        @change="HandleDisabledDateKeyDown($event)" @input="HandleFunctionsErros()"   />
                                        <div v-if = "form.errors['insurance_end_date.date']" class="text-danger">{{form.errors['insurance_end_date.date']}}</div>
                                    </div>
                                    <div class="col-md-2" v-if="form.insurance_end_date.show_time" >
                                        <label for="insurance_end_date.time" class="form-label">  وقت   انتهاء التأمين    </label>
                                        <input type="time" class="form-control" id="insurance_end_date.time" v-model="form.insurance_end_date.time"   
                                        @input="HandleFunctionsErros()"  
                                        :class="{'shining_warning' : form.insurance_end_date.show_time , 
                                      'shining_success' :  (!form.date_errors.accident_time_error && form.insurance_end_date.time != '' )   }" />
                                        <div v-if = "form.errors.insurance_end_date" class="text-danger">{{form.errors.insurance_end_date}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="accident_date.date" class="form-label">  تاريخ الحادث</label>
                                        <input type="date" class="form-control" id="accident_date.date" v-model="form.accident_date.date" 
                                        @input="HandleFunctionsErros()"  
                                         :class="{'border_error'  : form.date_errors.accident_date_error  || form.date_errors.report_accident_date_error }" >
                                        <div v-if = "form.date_errors.accident_date_error" class="text-danger">{{form.date_errors.accident_date_error }}</div>
                                        <div v-if = "form.date_errors.report_accident_date_error" class="text-danger">{{ form.date_errors.report_accident_date_error  }} </div>
                                        <div v-if = "form.errors['accident_date.date']" class="text-danger">{{form.errors['accident_date.date']}}</div>
                                    </div>
                                    <div class="col-md-2" v-if="form.accident_date.show_time" >
                                        <label for="accident_date.time" class="form-label">  وقت الحادث</label>
                                        <input type="time" class="form-control" id="accident_date.time" v-model="form.accident_date.time" 
                                        @input="HandleFunctionsErros()"  
                                        :class="{'border_error'  : form.date_errors.accident_time_error  || form.date_errors.report_accident_time_error , 
                                                 'shining_warning' : form.accident_date.show_time   ,
                                                 'shining_success' :  (!form.date_errors.accident_time_error  && !form.date_errors.report_accident_time_error && form.accident_date.time != '' ) }" >
                                        <div v-if = "form.date_errors.accident_time_error" class="text-danger">{{form.date_errors.accident_time_error }}</div>
                                        <div v-if = "form.date_errors.report_accident_time_error" class="text-danger">{{ form.date_errors.report_accident_time_error  }} </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="vehicle_type" class="form-label">   نوع المركبة </label>
                                        <input type="text" class="form-control" id="vehicle_type" v-model="form.vehicle_type"  >
                                        <div v-if = "form.errors.vehicle_type" class="text-danger">{{form.errors.vehicle_type}}</div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="plate_number" class="form-label">   رقم اللوحة </label>
                                        <input type="text" class="form-control" id="plate_number" v-model="form.plate_number"  >
                                        <div v-if = "form.errors.plate_number" class="text-danger">{{form.errors.plate_number}}</div>
                                    </div>

                               

                                    <div class="col-md-2" >
                                        <label for="report_party_id" class="form-label">  جهة البلاغ </label>
                                        <select
                                            @change="CalcPrice()"
                                            class="form-control"
                                            placeholder = "اختر جهة البلاغ" remote v-model="form.report_party_id"  >
                                            <option v-for="report_party , i   in  report_parties" :key="i"
                                             :value="report_party.id"   > {{ report_party.report_party_name }} </option>
                                        </select>
                                        <div v-if = "form.errors.report_party_id" class="text-danger">{{form.errors.report_party_id}}</div>
                                    </div>

                                    <div class="col-md-2" >
                                        <label for="currency_type" class="form-label">نوع العملة</label>
                                        <select
                                            @change="CalcPrice()"
                                            class="form-control"
                                            placeholder = "اختر طريقة الدفع "   v-model="form.currency_type"  >
                                            <option  :value="currency_type"     > {{ currency_type  }} </option>
                                            <option  :value="'دولار'" >دولار</option>
                                        </select>
                                   
                                        <div v-if = "form.errors.currency_type" class="text-danger">{{form.errors.currency_type}}</div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="reserve" class="form-label">   الإحتياطي </label>
                                        <input 
                                        @input="CalcPrice()"
                                        type="number" min="0" step="0.1" class="form-control" id="reserve" v-model="form.reserve"  >
                                        <div>{{ forien_price_text }}</div>
                                        <div class="text-pink">{{ libyan_price_text }}</div>
                                        <div v-if = "form.errors.reserve" class="text-danger">{{form.errors.reserve}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="company_id" class="form-label">    نوع الضرر </label>
                                        <el-select 
                                            filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus" 
                                            placeholder = "اختر   نوع الضرر" remote v-model="form.damage_type"  >
                                            <el-option v-for="damage_type , i   in damage_types" :key="i"
                                            :label="damage_type" :value="damage_type"></el-option>
                                        </el-select>
                                        <div v-if = "form.errors.damage_type" class="text-danger">{{form.errors.damage_type}}</div>
                                    </div>
                        
                                     <div class="col-md-3">
                                                <label for="report_img" class="form-label">صورة من البلاغ</label>
                                                <input type="file" class="form-control" id="report_img"  
                                                
                                                @input="ImageFilePicked( $event , 'report_img')" >
                                                <br>
                                                <div class="box_container">
                                                    <div :class="'img_box'"
                                                    v-if="files_path['report_img']" 
                                                    v-for="file , i in files_path['report_img']" :key="i"
                                                    >
                                                        <img v-if="files_type['report_img'][i] == 'image/' "
                                                         :src="file" alt=""  @click="ImageMagnified( 'report_img' , i )  " > 
                                                         <a  v-else-if="  files_type['report_img'][i]  == 'application/pdf'"
                                                          :href="file" target="_blank" ><fa class="fs-1"  icon = 'file-pdf' /></a>
                                                        <span @click="RemoveImages('report_img' , i)">X</span>
                                                    </div>
                                                </div>
                                              
                                                <vue-easy-lightbox
                                                    :visible="visible_ref['report_img']"
                                                    :imgs="files_path['report_img']"
                                                    :index = "clicked_index"
                                                    @hide="HideImageMagnified('report_img')"
                                                ></vue-easy-lightbox>
                                                <div v-if = "form.errors['report_img.0']" class="text-danger">{{form.errors['report_img.0']}}</div>

                                                <!--  صورة من المرفق القديم  -->
                                                <div class="col-md-3" v-if="form.old_report_img">
                                                <div class="box_container">
                                                    <div :class="'img_box'" >
                                                        <a :href="`/storage/${form.old_report_img}`" target="_blank"
                                                          v-if=" IsImageOrPdf(form.old_report_img) ==  'pdf' " > 
                                                          <fa class="fs-1"  icon = 'file-pdf' />
                                                         </a>
                                                        <img v-else-if="  IsImageOrPdf(form.old_report_img)  == 'image' "
                                                         :src="`/storage/${form.old_report_img}`" @click="ImageMagnified( 'old_report_img' , i )"  /> 
                                                     </div>
                                                </div>
                                              
                                                <vue-easy-lightbox
                                                    :visible="visible_ref['old_report_img']"
                                                    :imgs="[`${form.old_report_img}`]"
                                                    :index = "0"
                                                    @hide="HideImageMagnified('old_report_img')"
                                                ></vue-easy-lightbox>
                                                <div v-if = "form.errors['report_img.0']" class="text-danger">{{form.errors['report_img.0']}}</div>
                                               </div>
                                      </div>

                                    <div class="col-12">
                                        <Link   v-if ="!form.processing"   class="btn btn-info"  :href = "route('Archiving.Files.index')" > <fa icon = "arrow-right" />  {{ 'رجوع'}}   </Link>
                                        &nbsp;
                                        <button type="buttom" 
                                            @click="Update()"
                                        :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري تعديل الملف ...' : 'تعديل الملف'  }}</button>
                                    </div>
                        </div>
     </AppLayoutArchive>
</template>

<style scoped>

</style>

