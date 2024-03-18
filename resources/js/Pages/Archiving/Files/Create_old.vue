<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  computed, ref  } from 'vue';
import Navbar from  '@/Layouts/Navbar.vue';
import AsideArchive from  '@/Layouts/AsideArchive.vue';
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2'

import VueEasyLightbox from 'vue-easy-lightbox'
 
const props = defineProps([ "companies"  , "report_parties" , "libyan_party"]) ;
const damage_types = ["مادي" , "بدني" , "مادي بدني" , "قاتل"] ;

const now = new Date();
let localDateTime = `${now.getFullYear()}-${(now.getMonth() + 1).toString().padStart(2, '0')}-${now.getDate().toString().padStart(2, '0')}T${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}` ;

let form = useForm ({
    company_id :  '' ,
    company_name :   ''  , 
    year  : '' ,
    file_number  : '' , 
    receive_report_date   :   localDateTime , 
    real_report_date   : '' , 
    external_reference   : '' , 
    card_number   : '' , 
    insurance_date_from   : '' , 
    insurance_date_to  : new Date() , 
    accident_date  : '' , 
    insurance_name  : '' , 
    vehicle_type  : '' , 
    plate_number   : '' , 
    report_party_id  : '' , 
    currency_type  : '' , 
    reserve  : '' , 
    forien_price  : '' , 
    libyan_price  : '' , 
    damage_type   : '' ,  
    report_img  :  []  , 
    file_status  : 'ملف جديد' , 
    accident_not_covered_reason : '' , 
    date_errors :   {  accident_date  : '' , real_report_date : '' ,   real_accident_date : '' } ,
}); 
 
const clicked_index = ref(-1) ;

const visible_ref  = ref ({
    report_img  : false ,
}) ;

const files_path = ref({ 
    report_img      :  []  ,
}) , 
        files_type = ref({
        report_img      :  []  ,
}) ; 

let forien_price_text = ref('') ,
    libyan_price_text = ref('')   ;
function  Create () {

    if (form.date_errors.accident_date ||  form.date_errors.real_report_date  || form.date_errors.real_accident_date   ) {
    // if ( true  ) {

        Swal.fire({
        title: "رسالة تنبيه ",
        icon: 'warning',
        html : ` لديك بعض الأخطاء في إدخال التواريخ هل انت متأكد من أنك تريد حفظ  الملف ؟
            <br />   <span class = "text-danger text-bold"> . ${form.date_errors.accident_date} -</span> 
            <br />   <span class = "text-danger text-bold"> . ${form.date_errors.real_report_date} -</span>  
            <br />   <span class = "text-danger text-bold"> . ${form.date_errors.real_accident_date} -</span>`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حفظ الملف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            form.post( route('Archiving.Files.store')  , { preserveState : true , 
            onSuccess : () =>  toast.success("تم اضافة الملف بنجاح")  ,
            onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة الملف") ;  } ,
            onFinish : () =>   {}  ,
            }  ) ;
        }
        });

        form.post( route('Archiving.Files.store')  , { preserveState : true , 
            onSuccess : () =>  toast.success("تم اضافة الملف بنجاح")  ,
            onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة الملف") ;  } ,
            onFinish : () =>   {}  ,
            }  ) ;


    }
 

    
}


// تعطيل الأيام التي اكبر من تاريخ وصول البلاغ في تاريخ البلاغ الحقيقي
const disable_next_real_report_date =  computed ( () => DisableNextDate(form.receive_report_date)  ) ;
const disable_next_date_from =  computed ( () => DisableNextDate(form.insurance_date_to)  ) ;
const disable_previes_date_to =  computed ( () => DisablePreviesDate(form.insurance_date_from)  ) ;
 
function DisableNextDate(date) {
          date = new Date(date) ;
        if (!isNaN(date.getTime())) {
            date.setDate(date.getDate()  );
          return date.toISOString().slice(0, 16);
        }
        return null; 
}

function DisablePreviesDate(date) {
          date = new Date(date) ;
        if (!isNaN(date.getTime())) {
            date.setDate(date.getDate()  + 1  );
          return date.toISOString().slice(0, 16);
        }
        return null; 
}

// تحقق ان تاريخ الحادث يكون ما بين تاريخ من الى
function CheckeAccidentDateError( from_date , to_date ,  accident_date ) {
      console.log(from_date , to_date  , accident_date );
      if (from_date != ''  &&   to_date != '' && accident_date != '' )
      {
        from_date = new Date(from_date);
        to_date = new Date(to_date);
        accident_date = new Date(accident_date);
        if ( accident_date >= from_date  && accident_date <= to_date  ) {
        form.date_errors    = [] ;
        console.log(  'done' );
      } else {
        form.date_errors.accident_date = "تاريخ الحادث يجب ان يكون ما بين تاريخ التأمين  من  إلى ";
      

        console.log(  "تاريخ الحادث يجب ان يكون ما بين تاريخ التأمين  من  إلى " );
      }
    } else {
        form.date_errors.accident_date =  '' ;
        console.log(  "احد الحقول فارغ" );
    }
}

// التحقق ان تاريخ البلاغ الحقيقي يكون بعد تاريخ التأمين من 
function CheckDateReportRealError(real_report_date , from_date ) {
    if ( real_report_date != ''  &&  from_date != '' ) {
        console.log( real_report_date + "  === " + from_date);
        from_date = new Date(from_date) ;
        real_report_date = new Date(real_report_date) ;
        if ( real_report_date  >  from_date    ) {
            form.date_errors.real_report_date =  '' ;
            console.log('done') ;
        } else {
            console.log('err') ;
          form.date_errors.real_report_date = "تاريخ التأمين من يجب ان يكون اقل من تاريخ البلاغ الحقيقي ";
        }
    } else {
        console.log(  "احد الحقول فارغ" );
    }
}

// التحقق ان تاريخ الحادث قبل تاريخ البلاغ   
function CheckDateReportRealAccidentDateError(real_report_date , accident_date ) {
    if ( real_report_date != ''  &&  accident_date != '' ) {
        console.log( real_report_date + "  === " + accident_date);
        accident_date = new Date(accident_date) ;
        real_report_date = new Date(real_report_date) ;
        if ( real_report_date  >  accident_date    ) {
            form.date_errors.real_report_date =  '' ;
            console.log('done') ;
        } else {
            console.log('err') ;
          form.date_errors.real_accident_date = "تاريخ الحادث   يجب ان يكون اقل من تاريخ البلاغ الحقيقي ";
        }
    } else {
        console.log(  "احد الحقول فارغ" );
    }
}

function HandleFunctionsErros() {
    CheckeAccidentDateError( form.insurance_date_from , form.insurance_date_to , form.accident_date ) ;
    CheckDateReportRealError( form.real_report_date , form.insurance_date_from ) ;
    CheckDateReportRealAccidentDateError(form.real_report_date , form.accident_date )
}



function   ImageFilePicked (event , form_name  ) {
    const temp_files = event.target.files ; 
    form[form_name] = [] ;
    files_path.value[form_name] = [] ;
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

function CalcPrice () {
    if (form.reserve != '' &&  form.report_party_id != '' && form.currency_type !=  ''   ) {
        let report_party = props.report_parties.find( (el) =>  el.id == form.report_party_id ) ;
        if (form.currency_type == "دولار")
        {
            form.forien_price = (form.reserve  *  report_party.exchange_rate).toFixed(3);
            forien_price_text.value =  `${form.reserve}  *   سعر الصرف  ${report_party.exchange_rate}  = ${(form.reserve  *  report_party.exchange_rate).toFixed(3)}   ${ report_party.currency_name }` ;
            form.libyan_price = (form.reserve *  props.libyan_party.exchange_rate ).toFixed(3) ;
            libyan_price_text.value  =  `${form.reserve} $ *   سعر الصرف  ${props.libyan_party.exchange_rate}  = ${ form.libyan_price }   ${ props.libyan_party.currency_name }`  ;
        } 
        else if  (form.currency_type == "عملة البلد")
        { 
            form.forien_price = (form.reserve  /  report_party.exchange_rate).toFixed(3) ;
            forien_price_text.value =  `${form.reserve}  /   سعر الصرف  ${report_party.exchange_rate}  = ${form.forien_price}   دولار`  ;
            form.libyan_price = (form.forien_price /  props.libyan_party.exchange_rate ).toFixed(3) ;
            libyan_price_text.value  =  `${form.forien_price} $  /   سعر الصرف  ${props.libyan_party.exchange_rate}  = ${form.libyan_price}   ${ props.libyan_party.currency_name }` ;
        }
   
    } else { 
        forien_price_text.value = '' ;
    }
}
</script>

<template>
    <Head title="اضافة ملف" />

        <div class="wrapper">
            <AsideArchive  />          

            <div class="content" >
                <Navbar />
                <div class="main-content">
                    <div class="row g-3"  >
                            <h3> إضافة   ملف جديد  </h3>
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
                                        <label for="receive_report_date" class="form-label">  تاريخ استلام البلاغ </label>
                                        <input type="datetime-local" class="form-control" id="receive_report_date" v-model="form.receive_report_date"  >
                                        <div v-if = "form.errors.receive_report_date" class="text-danger">{{form.errors.receive_report_date}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="real_report_date" class="form-label">  تاريخ  البلاغ   </label>
                                        <input type="datetime-local" class="form-control"
                                          @input="HandleFunctionsErros()" id="real_report_date" v-model="form.real_report_date" :max="disable_next_real_report_date"  
                                          :class="{'border_error'  :  form.date_errors.real_report_date }" />  
                                        <div v-if = "form.date_errors.real_report_date" class="text-danger">{{ form.date_errors.real_report_date  }}</div>
                                        <div v-if = "form.errors.real_report_date" class="text-danger">{{form.errors.real_report_date}}</div>
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
                                        <label for="insurance_date_from" class="form-label">  تاريخ    التأمين من </label>
                                        <input type="datetime-local" class="form-control" id="insurance_date_from" v-model="form.insurance_date_from"  :max="disable_next_date_from" 
                                        @input="HandleFunctionsErros()"
                                         >
                                        <div v-if = "form.errors.insurance_date_from" class="text-danger">{{form.errors.insurance_date_from}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="insurance_date_to" class="form-label">  تاريخ    التأمين  الى </label>
                                        <input type="datetime-local" class="form-control" id="insurance_date_to" v-model="form.insurance_date_to"  :min="disable_previes_date_to" 
                                        @input="HandleFunctionsErros()"  
                                        />
                                        <div v-if = "form.errors.insurance_date_to" class="text-danger">{{form.errors.insurance_date_to}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="accident_date" class="form-label">  تاريخ الحادث</label>
                                        <input type="datetime-local" class="form-control" id="accident_date" v-model="form.accident_date" 
                                        @input="HandleFunctionsErros()"  
                                         :class="{'border_error'  : form.date_errors.accident_date  || form.date_errors.real_accident_date }" >
                                        <div v-if = "form.date_errors.accident_date" class="text-danger">{{form.date_errors.accident_date }}</div>
                                        <div v-if = "form.date_errors.real_accident_date" class="text-danger">{{ form.date_errors.real_accident_date  }} </div>
                                        <div v-if = "form.errors.accident_date" class="text-danger">{{form.errors.accident_date}}</div>
                                      
                                        
                                    </div>

                                   

                                    <div class="col-md-2">
                                        <label for="vehicle_type" class="form-label">   نوع المركبة </label>
                                        <input type="text" class="form-control" id="vehicle_type" v-model="form.vehicle_type"  >
                                        <div v-if = "form.errors.vehicle_type" class="text-danger">{{form.errors.vehicle_type}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="plate_number" class="form-label">   رقم اللوحة </label>
                                        <input type="text" class="form-control" id="plate_number" v-model="form.plate_number"  >
                                        <div v-if = "form.errors.plate_number" class="text-danger">{{form.errors.plate_number}}</div>
                                    </div>

                               

                                    <div class="col-md-2" >
                                        <label for="company_id" class="form-label">  جهة البلاغ </label>
                                        <el-select 
                                            @change="CalcPrice()"
                                            filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus" 
                                            placeholder = "اختر جهة البلاغ" remote v-model="form.report_party_id"  >
                                            <el-option v-for="report_party , i   in  report_parties" :key="i"
                                            :label="report_party.report_party_name" :value="report_party.id"></el-option>
                                        </el-select>
                                        <div v-if = "form.errors.report_party_id" class="text-danger">{{form.errors.report_party_id}}</div>
                                    </div>

                                    <div class="col-md-2" >
                                        <label for="company_id" class="form-label">    طريقة الدفع </label>
                                        <el-select 
                                            @change="CalcPrice()"
                                            filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus" 
                                            placeholder = "اختر جهة البلاغ" remote v-model="form.currency_type"  >
                                            <el-option   :label="'دولار'" :value="'دولار'"></el-option>
                                            <el-option   :label="'عملة البلد'" :value="'عملة البلد'"></el-option>
                                        </el-select>
                                        <div v-if = "form.errors.report_party_id" class="text-danger">{{form.errors.report_party_id}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="reserve" class="form-label">   الإحتياطي </label>
                                        <input 
                                        @input="CalcPrice()"
                                        type="number" min="0" step="0.1" class="form-control" id="reserve" v-model="form.reserve"  >
                                        <div>{{ forien_price_text }}</div>
                                        <div class="text-info">{{ libyan_price_text }}</div>
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
                        
                                     <div class="col-md-2">
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
                                                          :href="file" target="_blank">{{  file  }}</a>
                                                        <span @click="RemoveImages('report_img' , i)">X</span>
                                                    </div>
                                                </div>
                                              
                                                <vue-easy-lightbox
                                                    :visible="visible_ref['report_img']"
                                                    :imgs="files_path['report_img']"
                                                    :index = "clicked_index"
                                                    @hide="HideImageMagnified('report_img')"
                                                ></vue-easy-lightbox>
                                                <div v-if = "form.errors.report_img" class="text-danger">{{form.errors.report_img}}</div>
                                      </div>
 
                            <div class="col-12">
                                <button type="buttom" 
                                    @click="Create()"
                                :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري الحفظ ...' : 'حفظ'  }}</button>
                     
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

