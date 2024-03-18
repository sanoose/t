<script setup>

import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';



const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>




<template>
    <Head title="Reset Password" />
    <div class="main-content"> 
    <form @submit.prevent="submit">

        
        <Link :href = "route('Login')">
        <img src="/storage/logo/logo2.png" />
        </Link>
        <div class="mb-4 text-sm text-gray-600">
            <h6>قم بادخال كلمة المرور الجديدة</h6>

      </div>
     




           <div class="mt-4">
            <label for="email" class="form-label">الإيميل</label>
           
            <input type="email"    v-model="form.email" 
              class="form-control" id="email" required    autocomplete="username"  />

              <InputError class="mt-2" :message="form.errors.email" />
            </div>


           <div class="mt-4">
            <label for="password" class="form-label"> كلمة المرور</label>
           
            <input type="password"    v-model="form.password" 
              class="form-control" id="model" placeholder="" required />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>


        <div class="mt-4" >
            <label for="password_confirmation" class="form-label">تاكيد كلمة المرور</label>
              <input type="password"    v-model="form.password_confirmation" 
              class="form-control" id="password_confirmation" placeholder="" required />

            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
            <InputError class="mt-2" :message="form.errors.password_confirmation" />

            <!-- <label class="mt-2 text-danger" v-if = "form.errors.email" >الايميل غير موجود</label> -->
        </div>



        <div class="flex items-center justify-end mt-4">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    تغيير كلمة المرور 
            </PrimaryButton>
        </div>
    </form>
</div>
</template>


<style scoped>

          
        * {
            font-size: 17px;
        }
        img {
            width: 150px;
        }
        form {
            display: flex;
            justify-content: flex-start;
            flex-direction: column;
            align-items: center;
            width: 40%;
            background-color: white;
            margin: 10% auto;
            padding: 50px;
            border-radius: 20px;
            direction: rtl;
            border: 1px solid skyblue;
        }
        form div label  , h6 , p , div  {
            color: black !important;
        }

        form div label.text-danger {
            color: red !important;
        }

        form div {
            width: 100%;
        }

        form div button {
            display: block;
            margin-right:  auto;
            border-radius: 10px;
        }

        .text-success {
            color: #00ed00  !important;
        }
        @media (max-width : 1000px) {
            form {
                 width: 100%;
              }
        }
       
        button {
            background-color: navy;
        }

        h6 , p {
            text-align: center;
        }



</style>