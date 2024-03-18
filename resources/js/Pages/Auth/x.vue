<script setup>

//  import '@/style/app.css';

import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>


        <!-- <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div> -->



      
        <div class="main-content"> 
          
        <form @submit.prevent="submit">
            <Link :href = "route('home')">
            <img src="storage/logo/logo2.png" />
            </Link>

            <div v-if="status" class="mb-4 font-medium text-sm text-success">
                                {{ "تم ارسال رابط تغيير كلمة المرور الى بريدك "}}
            </div>

            <div>
                <label for="email" class="form-label">الإيميل</label>
                  <input type="text"   v-model="form.email" 
                  class="form-control" id="email" placeholder="ادخل بريدك الالكتروني">

                <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
                <label class="mt-2 text-danger" v-if = "form.errors.email" >الايميل غير موجود</label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    ارسال رابط تعيين كلمة المرور
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
        form div label {
            color: black !important;
        }
        form div {
            width: 100%;
        }

        form div button {
            display: block;
            margin-right:  auto;
            border-radius: 10px;
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
