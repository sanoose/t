<script setup>
  import { Head ,  Link  ,  useForm  } from "@inertiajs/vue3" ;
import { onMounted, ref, shallowRef, watch } from "vue";
import { router } from '@inertiajs/vue3'

let is_loading = ref(false) ;
router.on("start", () => {
  is_loading.value = true;
 });
router.on("finish", () => {
  is_loading.value = false;
   });
 

  onMounted (() =>  {

    let switch_button = document.getElementById("switch-button") ;
    const root  = document.documentElement ;

    function CheckTheme () {
        if ( switch_button.checked == true  ) { // datk mode colors
            localStorage.setItem("isChecked" , true ) ;
            root.style.setProperty("--main_background", "#001034"); 
            root.style.setProperty("--body_background", "#001034");
            root.style.setProperty("--main_color", "white");
            root.style.setProperty("--img" , 'url("/storage/images/dark_mode.jpg")') ;
          } else if ( switch_button.checked == false  )  { // light mode colors
            localStorage.setItem("isChecked" , false ) ;
            root.style.setProperty("--main_background", "#e4e5fa");
            root.style.setProperty("--body_background", "#e4e5fa");
            root.style.setProperty("--main_color", "black");
            root.style.setProperty("--img", 'url("/storage/images/light_mode.jpg")' );
          }
      }

   
  
        if ( localStorage.getItem("isChecked") == "true" ) {
          switch_button.checked = true ;
          CheckTheme () ;
        } else {
          switch_button.checked = false ;
          CheckTheme () ;
        }

        switch_button.addEventListener("change" , function () {
          CheckTheme () ;
        }) ;

  })

</script>



<template   >


<!-- v-if="is_loading"  -->
        <transition
                name="fade"
                :duration="{ enter: 500, leave: 800 }"
                v-if="is_loading" 
            >
                <!-- Page Loader -->
                <div class="main-loader-wrapper">
                <div id="loader-wrapper">
                    <div class="row align-items-center">
                        <span class="loader"></span>
                        <h3 class="col text-center" >... الرجاء الإنتظار </h3>
                    </div>
                </div>
              </div>
                <!-- / End Page Loader -->
       </transition>

        <nav class="navbar navbar-light "  >
            <div class="container-fluid">

                   <div class="d-flex ">
                            <img src="/storage/logo/logo2.png" class="logo" alt="">
                    </div>
                    &nbsp;    &nbsp;
               <div class="dropdown">
                    <button class="btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    اختر النظام
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><Link class="dropdown-item" :href="route('HomeMain')"> عام</Link></li>
                        <li><Link class="dropdown-item" :href="route('Archiving.HomeArchive')">الأرشفة الإلكترونية</Link></li>
                        <li><Link class="dropdown-item" :href="'#'">المالية</Link></li>
                    </ul>
                </div>
                
                    <div class="d-flex burger_container">
                       <button class="btn  btn_burger color-white" type="submit">
                        <fa icon = "bars" />
                        </button>
                    </div>
        </div>
        </nav>

        
</template>

<style scoped >

.logo {
        width: 50px;
    }

    .btn_burger {
        z-index: 1000;
    }
 



/* laoder start  */
div.main-loader-wrapper {
    background: #00000085;
    width: 100%;
    height: 100%;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
}


#loader-wrapper {
    /* width: 100%; */
    /* height: 100%; */

    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin : auto; 
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px,
        rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px,
        rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;

    padding: 20px ;
    /* width: 20vw;
  height: 20vh; */
    width: 20em;
    text-align: center;
    height: 6em;
    background: #ffffffee;
    position: absolute;
    z-index: 99;
}
span.loader {
    width: 48px;
    height: 48px;
    border: 5px solid red;
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
 
}

.swal-cancel-button {
    background: #fff;
    color: #000;
}

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
 
</style>