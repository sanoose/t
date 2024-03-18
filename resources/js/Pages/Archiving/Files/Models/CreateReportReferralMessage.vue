<script setup>
import { ref } from 'vue';


  const props = defineProps(['file']) ;
  function Print () {
    window.print() ;
  }
</script>

<!-- نموذج انشاء رسالة احالة بلاغ  -->
<template>
     <div class="body">
             <div class="print_container">
                <button class="btn_print btn btn-warning btn_info" @click="Print()">طباعة</button>
                &nbsp;
                <Link   class="btn btn-info btn_info"  :href = "route('Archiving.Files.index')" > <fa icon = "arrow-right" />  رجوع   </Link>

             </div>
           
             <div class="main_container">
                <br> 
                    <div class="header_content">
                        <span class="date_now"> <br> 2023 10 01</span>
                        <span class="file_number"> 2023/  م.م </span>
                    </div> 
                    <br>
                    <div class="header_content">
                        <span class=""> <br> <br> <br> <br>  رقم البطاقة العربية الموحدة <span class="text-danger"> 22222222222 </span>  </span>
                        <span class="text-center"> 
                                 <p class="">عناية السيد \ مدير إدارة تأمينيا للسيارات</p>
                                 <p class="text-danger">شركة المجموعة الدولية للتأمين</p>

                        </span>
                    </div> 

                    <div class="main_content rtl">
                            <p class=""> بعد التحية ...</p>
                            <p  class="has_indent" > 
                                نفيدكم أننا استلمنا بلاغ من المكتب الموحد التونسي 
                                للسيارات يفيد بوقوع حادث على البطاقة المشار 
                                إلى رقمها أعلاه والذي نتج عنه أضرار <span class="text-danger"> مادية </span>  بتاريخ <span class="text-danger">  21/08/2023 </span> .
                            </p>

                            <p> 
                                عليـه نأمل منكم سرعة تزويدنا بالبيانات الصحيحة لهذه البطاقة حتى يتسنى لنا مخاطبة 
                                المكتب الموحد التونسي للسيارات بتأكيد صحة التغطية التأمينية من عدمها وأن التأخير في تزويد المكتب بالبيانات المطلوبة يترتب عليه تحملكم للمسؤولية.  مع العلم بإننا فتحنا ملف تعويض لهذا الحادث 
                                 تحت رقم ب.ع.م      <span class="text-danger"> المجموعة الدولية 17/2023  </span> 
                                 نأمل منكم فتح ملف تعويض لهذا الحادث واعطائنا رقمه وسوف نوافيكم بتطورات هذا الحادث عند استلامها من المكتب الموحد التونسي للسيارات. 
                            </p>
                           
                            <p class="text-center">
                                " علماً بأن الاحتياطي المرصود لهذا الحادث <span class="text-danger">  (3,000) د.ت </span> " 
                                <br>
                                والســلام عليـكـم...
                            </p>
                    </div>

                    <div class="signature_section">
                          <p class="has_indent"> 
                              جمـال محمــد ســالم 
                              <br>
                              مدير المكتب الموحد 
                          </p>
                    </div>
                    <br> 
                    <br>
                    <br>
                    <div class="footer rtl ">
                            <p> <fa icon = "file-lines"/> صــــــورة إلـــى   /  </p>
                            <p> <fa icon = "folder-open"/> - الملف ب.ع.م المجموعة الدولية 17/2023 .  </p>
                            <p>  <fa icon = "file-pen"/> جمال <fa icon = "print"/>   سليم   </p>
                    </div>

             </div>
     </div>
</template>


<style scoped>

* {
    font-size: 16px;
}

.print_container {
    width: fit-content ;

    position: absolute;
    left: 10%;
    top: 5% ;
}

.has_indent {
   text-indent: 20px; 
}


div.body {
    background: white !important;
    width: 100%;
    height: 100vh;
}
 div.main_container {
    background: white !important;
    width: 90%;
    height: 100vh;
    /* border: 2px solid black ; */
    margin: 0px auto;
    padding: 5%;
}

.main_container .header_content {
  display: flex ;
  justify-content: space-between ;
}

.signature_section p {
    text-indent: 20px; 
    text-align: right;
    margin-right: auto;
    width: fit-content; 
    direction: rtl;
 }


 .footer p  {
    padding: 0px;
    margin: 0px;
    text-align: right;
}



@media print {
    .print_container {
        display: none ;
    }
}
</style>
