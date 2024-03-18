<script setup>
import { onMounted , ref   } from 'vue';
import { defineProps } from 'vue';

const props = defineProps ( ["user"] ) ; 

// max  index =  10   , max collapse =   11 
const icon = ref(["chevron-left" , "chevron-left" , "chevron-left"  , "chevron-left"  , "chevron-left"  
, "chevron-left" , "chevron-left"  , "chevron-left" , "chevron-left" , "chevron-left" , "chevron-left" , "chevron-left" ]);

const root  = document.documentElement ;



  
onMounted  (() => { 

//  when page load  make current ul open
let dropdown_lists = document.querySelectorAll(".dropdown_list") ;
// this condition must happent only if current page is in nested ul 
if (document.querySelector(".nested_ul .active_link") !== null) {
let btn_dropdown = document.querySelector(".nested_ul .active_link").parentElement.parentElement.parentElement ;
btn_dropdown.classList.add("show") ; 
let current_dropdown_list = btn_dropdown.parentElement ;

current_dropdown_list.classList.add("colored") ;
let current_arrow_index = Array.from(dropdown_lists).indexOf(current_dropdown_list) ;
  
icon.value[current_dropdown_list.children[0].dataset['index']]= "chevron-down" ; 
}

let btn_burger =  document.querySelector(".btn_burger") , 
content =  document.querySelector(".content")   ,
aside = document.querySelector(".aside")    ,
toggle_buttons = document.querySelectorAll("ul li button")    
// switch_button = document.getElementById("switch-button")
 ;
btn_burger.addEventListener("click" , function() {
    this.classList.toggle("burger_active") ;
 
    if ( this.classList.contains("burger_active") ) {
        content.style.marginRight = "0px" ;
        aside.style.width = "0px" ;
    } else {
        content.style.marginRight = "290px" ;
        aside.style.width = "290px" ;
    }
}) ;

toggle_buttons.forEach( (toggle_button , i ) => {
toggle_button.addEventListener("click" , function () {
    if (this.getAttribute("aria-expanded") == "true" ) {
      icon.value[this.dataset["index"]] = "chevron-down";
    } else {
      icon.value[this.dataset["index"]] = "chevron-left";
    }
}) ;
}) ;

let  width =  window.innerWidth ;
if (width <= 800 ) { btn_burger.classList.add("burger_active") ; }
window.addEventListener("resize" , function () {
    width =  window.innerWidth ;
       if (width <= 800 ) { btn_burger.classList.add("burger_active") ; }
       else { btn_burger.classList.remove("burger_active") ; }
}) ;
 
}) ;

</script>

<template    >
   <aside class="flex-shrink-0 p-3  aside"   >

    <div href="/" class="d-flex align-items-center flex-column  pb-3 mb-3  text-decoration-none border-bottom">
      <h6 class="fs-5 fw-semibold">   عام    </h6>
      <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
      <h6> 
        <!-- المستخدم :   -->
        مرحبا بك :    {{$page.props.auth.user.name }}   
        <br>
         {{ $page.props.auth.user.user_level }}  
      </h6>
      <h6> </h6>
     
    </div>
    <ul class="list-unstyled ps-0">
     
      <li class="mb-1">
        <a class="btn  align-items-center rounded " >
          
            <Link  :href="route('HomeMain')" class="rounded"
              :class = "{'active_link' : route().current('HomeMain') }" >   <fa  icon = "home" /> الرئيسية </Link> 
        </a>
      
      </li>
 

      <li class="mb-1  dropdown_list">
     
     <button class="btn btn-toggle align-items-center rounded collapsed" data-index = "0"  data-bs-toggle="collapse" data-bs-target="#dashboard-collapse0" 
     aria-expanded= "false"  >
         <fa  icon = "users" /> ادارة المستخدمين <fa  :icon = "icon[0]" class="arrow"  />
     </button>
     <div class="collapse" id="dashboard-collapse0" >
       <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small nested_ul">
         <li>   
           <Link  :href="route('Users.Create')" class="rounded"
           :class = "{'active_link' :  route().current('Users.Create') }" >
           <fa  icon = "user-plus" /> 
           اضافة مستخدم
          </Link> 
         </li>
     
         <li>   
           <Link  :href="route('Users.Index')" class="rounded"
           :class = "{'active_link' :  route().current('Users.Index') }" >
           <fa  icon = "eye" /> 
           عرض المستخدمين
          </Link> 
         </li>
       
         <li>   
           <Link  :href="route('Users.Deleted')" class="rounded"
           :class = "{'active_link' :  route().current('Users.Deleted') }" >
           <fa  icon = "trash" /> 
            المستخدمين المحذوفين
          </Link> 
         </li>


       </ul>
     </div>
   </li>


   <li class="mb-1  dropdown_list">
     
     <button class="btn btn-toggle align-items-center rounded collapsed" data-index = "1"  data-bs-toggle="collapse" data-bs-target="#dashboard-collapse1" 
     aria-expanded= "false"  >
         <fa  icon = "building" />   الهيكل التنظيمي <fa  :icon = "icon[1]" class="arrow"  />
     </button>
     <div class="collapse" id="dashboard-collapse1" >
       <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small nested_ul">
         <li>   
           <Link  :href="route('Departments.create')" class="rounded"
           :class = "{'active_link' :  route().current('Departments.create') }" >
           <fa  icon = "plus" /> 
           اضافة مكون جديد
          </Link> 
         </li>
     
         <li>   
           <Link  :href="route('Departments.index')" class="rounded"
           :class = "{'active_link' :  route().current('Departments.index') }" >
           <fa  icon = "eye" /> 
           عرض الموكنات
          </Link> 
         </li>
         
         <!-- <li>   
           <Link  :href="route('Departments.Deleted')" class="rounded"
           :class = "{'active_link' :  route().current('Departments.Deleted') }" >
           <fa  icon = "trash" /> 
           المكونات المحذوفة
          </Link> 
         </li> -->
       </ul>
     </div>
   </li>
 
   <li class="mb-1 ">
        <Link class="btn  align-items-center rounded " 
        :class = "{'active_link' :  route().current('Users.Profile.Partials.UpdatePasswordForm') }" 
        :href = "route('Users.Profile.Partials.UpdatePasswordForm')" >
            <fa  icon = "address-card"   />   تعديل كلمة المرور  
      </Link>
      </li>

   

 

      <li class="mb-1 ">
        <Link class="btn  align-items-center rounded " :href = "route('Logout')" >
            <fa  icon = "arrow-right" class="animate_right"  />  تسجيل الخروج      
      </Link>
      </li>
    </ul>

    <input type="checkbox" id="switch-button">
      <label for="switch-button">
        <fa icon="sun"  class = "sun"  />
        <fa icon="moon"  class = "moon" />
      </label>

   
    <input type="checkbox" class="chagneTheme" >
    </aside>            

</template>

<style scoped>
:root {
    --color : red ;
}


  .active_link {
      color: var(--hover_color ) !important;
  }
    li:hover  .animate_right {
   
       animation: moving_right linear 1s infinite;
    }
    .aside {
   
        transition: 0.3s;
        border-radius: 25px;
        box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
        height: 100%;
        position: absolute;
        width: 290px;
        overflow: auto;

        right: 0px ;
        direction: rtl;
        padding: 0px !important;
        padding-top: 20px !important;

   
    }


    .nested_ul {
        display: flex;
        flex-direction: column;
        gap: 9px;

        margin-right: -16px;
    }

    .nested_ul li a {
        text-decoration: none;
    }

    @keyframes moving_right  {100% {transform: translateX(10px);}}



  input[type="checkbox"]{
  display:none;
  }
  label{
    /* position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%); */

    transform: translateX(-158%);

    border: 2px solid gray;
    border-radius: 30px;
    padding: 10px;
    cursor: pointer;
  }
 
  label .sun {

    font-size:25px;
    text-shadow:0px 0px 20px orange;
    transform:translateX(5px);
    transition:.3s;
  }
  .moon{
    color: skyblue  ;
    font-size:25px;
    text-shadow:0px 0px 20px white;
    transform:translateX(10px);
    opacity:0;
    transition:.3s;
  }
 
  #switch-button:checked ~ label > .sun{
    opacity:0;
    transform:translateX(0px);
  }
  #switch-button:checked ~ label > .moon{
    opacity:1;
    transform:translateX(0px);
  }

  .colored button {
     color: var(--hover_color ) !important;
  }


.settings {
  display: none ;
}

.settings_active  a  , .settings_active  span   {
    color: #e91e63 !important ;
}

</style>

