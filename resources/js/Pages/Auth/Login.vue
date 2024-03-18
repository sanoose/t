<script setup >



import { Head ,  useForm } from "@inertiajs/vue3" ;

import { ref  } from "vue" ;


import { toast } from "vue3-toastify";



let processing = ref (false)  ;
const form = useForm({
        email : 's' , 
        password : '1' ,
        user_type : 'ضابط' ,

})


const Login = () => {
        processing.value = true ;
          form.post( route('Login')  , { preserveState : true , 
         onSuccess : () => { toast.success("تم   الدخول ") } ,
         onError :  () =>  {toast.error("خطأ لم يتم تسجيل الدخول") } ,
         onFinish : () => processing.value = false ,
         }  ) ;

}





     



</script>


<template>
<Head title="تسجيل الدخول" />

    <section class="section">
    <div class="container-fluid h-custom">
      
        <div class="row d-flex justify-content-center align-items-center h-100">
          
        <div class="col-md-9 col-lg-6 col-xl-5">
            <!-- <img src="images/2.png"  class="img-fluid" alt="Sample image"> -->
              <img src="storage/logo/logo2.png"  class="img-fluid" alt="Sample image">
        </div>

        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form @submit.prevent="Login">
             <h3>  منظومة  ادارة الموارد البشرية  </h3>
            <br>
            <!-- Email input -->
            <div class="form-outline mb-4">
                  <label class="form-label" for="username">اسم المستخدم </label>
                <input type="text" id="username" class="form-control form-control-lg"
                placeholder="Enter a valid email address" v-model="form.email" />
            </div>
            <!-- Password input -->
            <div class="form-outline mb-3">
                   <label class="form-label" for="password">كلمة المرور</label>
                <input type="password" id="password" class="form-control form-control-lg"
                v-model="form.password"  />
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="RememberMe" />
                <label class="form-check-label" for="RememberMe">
                    تذكرني
                </label>
                </div>
                <Link :href="route('ForgotPassword')" class=""> نسيت كلمة المرور ؟ </Link>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" class="btn btn-info btn-lg"
                 v-if="!processing" 
                >تسجيل الدخول</button>
                <button type="submit" class="btn btn-primary btn-lg"
                 v-if="processing" 
                disabled >  جاري تسجيل الدخول ...</button>
            </div>
            </form>
        </div>
        </div>
    </div>

    </section>
</template>

<style scoped>

    section {
        padding: 5%;
        margin: 66px;
        border-radius: 35px;
        height: 60% ;
    }

    form {
        direction: rtl;
    }

    button {
        color: navy !important ;
    }
    img {
        width : 60%;
        display: block;
        margin: 20px auto;
    }

</style>