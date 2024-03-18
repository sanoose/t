<script setup>
import { ref } from 'vue';
import { Head ,  useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';


 
import AppLayoutMain from  '@/Layouts/AppLayoutMain.vue';
import { toast } from 'vue3-toastify';
import { onMounted } from "vue";

const props = defineProps ( ['errors'  , 'departments']) ;

defineOptions ({
   layout :   AppLayoutMain
})


const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () =>{ form.reset() ;  toast.success("تم تغيير كلمة المرور بنجاح") ;},
        onError: () => {
            toast.error("حدث خطأ لم تتم عملية تغيير كلمة المرور") ;
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <Head title="  تغيير كلمة المرور   " />
 
                
            <form class="row g-1" @submit.prevent="updatePassword" >
                    <h3>   تغيير كلمة المرور    </h3>

                    <hr />
                    <div class="col-md-4">
                            <label for="current_password" class="form-label">  كلمة المرور الحالية</label>
                            <input type="password" class="form-control" 
                            placeholder="ادخل كلمة المرور الحالية"
                            ref="currentPasswordInput" v-model="form.current_password"  >
                            <div v-if = "form.errors.current_password" class="text-danger">{{form.errors.current_password}}</div>
                    </div>

                    <div class="col-md-4">
                            <label for="password" class="form-label">  كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="password" v-model="form.password" 
                            placeholder="ادخل كلمة المرور الجديدة">
                            <div v-if = "form.errors.password" class="text-danger">{{form.errors.password}}</div>
                    </div>

                    <div class="col-md-4">
                            <label for="password_confirmation" class="form-label">تاكيد كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="password_confirmation" v-model="form.password_confirmation" 
                            placeholder="تاكيد كلمة المرور الجديدة" >
                            <div v-if = "form.errors.password_confirmation" class="text-danger">{{form.errors.password_confirmation}}</div>
                    </div>
                    <div class="col-12"></div>
                    <div class="col-12">
                                <button type="submit" :disabled ="form.processing" class="btn btn-primary submit">{{form.processing ?  'جاري الحفظ ...':' حفظ'}}</button>
                         
                    </div>

             </form>
 
 
</template>
