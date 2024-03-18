<script setup>

import { Head ,  useForm } from "@inertiajs/vue3" ;
import AppLayoutMain from  '@/Layouts/AppLayoutMain.vue';


import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';


  

const props = defineProps ( ["user" , "roles" , "departments"] ) ; 

let form = useForm ({
    name : props.user.name ,
 
    user_level: props.user.user_level , 
    department_id : props.user.department.id , 
    email : props.user.email , 
    password :  "" , 
    password_confirmation : ""   , 
    id : props.user.id ,
    roles : 
    {
     user_create : props.user.role.user_create  ,  user_edit :  props.user.role.user_edit   , user_delete : props.user.role.user_delete   ,
     file_create  : props.user.role.file_create  ,  file_edit : props.user.role.file_edit   ,  file_delete : props.user.role.file_delete  ,  
     select_all : false 
    } ,
    processing : false ,
})

function SelectAll () {
        if (form.roles.select_all ) { 
            for(let key in form.roles ) {
                form.roles[key]  = "true" ;
                }
        } else {
            for(let key in form.roles ) {
                form.roles[key]  = "false" ;
                }
        }
}

let Update = () => {
    form.processing = true ;
         form.put( route('Users.Update')  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم تعديل المستخدم بنجاح")  ,
         onError :  (e) =>  toast.error("حدث خطأ لم تتم اضافة المستخدم") ,
         onFinish : () =>   { form.processing = false ; }  ,
         }  ) ;
}


</script>

<template>
    <Head title="تعديل مستخدم" />
       <AppLayoutMain>
                    <form class="row g-1"  >
                            <h3> تعديل المستخدم  </h3>
                            <hr />
                            <div class="col-md-3">
                                <label for="name" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="name" v-model="form.name"  >
                                <div v-if = "form.errors.name" class="text-danger">{{form.errors.name}}</div>
                            </div>
                          
                            <div class="col-md-3">
                              <label for="department_id" class="form-label"> تابع للمكون  </label>
                              <el-select 
                                  id="department_id"
                                  filterable default-first-option  :reserve-keyword="false" class = "d-block select_plus " 
                                  placeholder="الرجاء تحديد الجهة" remote v-model="form.department_id"  >
                                  <el-option v-for="department , i   in  departments" :key="i"
                                  :label="department.name" :value="department.id" ></el-option>
                              </el-select>
                              <div v-if = "form.errors.department_id" class="text-danger">{{form.errors.department_id}}</div>
                            </div>


                            <div class="col-md-4">
                                <label for="inputState" class="form-label">نوع المستخدم</label>
                                <select id="inputState" class="form-select" v-model="form.user_level"  >
                                <option value="مستخدم" selected>مستخدم</option>
                                <option value="مشرف قسم" >مشرف قسم</option>
                                <option value="مشرف" >مشرف</option>
                                <option value="سوبر أدمن" >سوبر ادمن</option>
                                </select>
                                <div v-if = "form.errors.user_level" class="text-danger">{{form.errors.user_level}}</div>
                            </div>

                            <div class="col-md-3">
                                <label for="email" class="form-label">اسم المستخدم</label>
                                <input type="text" class="form-control" id="email"  v-model="form.email"   />
                                <div v-if = "form.errors.email" class="text-danger">{{form.errors.email}}</div>
                            </div>
                            <div class="col-md-3">
                                <label for="password" class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" id="password" v-model="form.password"  />
                                <div v-if = "form.errors.password" class="text-danger">{{form.errors.password}}</div>
                            </div>

                            <div class="col-md-3">
                                <label for="password_confirmation" class="form-label">تاكيد كلمة المرور</label>
                                <input type="password" class="form-control" id="password_confirmation" 
                                v-model="form.password_confirmation"  />
                                <div v-if = "form.errors.password_confirmation" class="text-danger">{{form.errors.password_confirmation}}</div>
                            </div>

                            <hr>
                            <h5> إدارة الصلاحيات  -</h5>
                            <div class="col-md-2">
                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user_create" v-model="form.roles.user_create">
                                <label class="form-check-label" for="user_create">اضافة مستخدم</label>
                                </div>
                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user_edit" v-model="form.roles.user_edit">
                                <label class="form-check-label" for="user_edit">تعديل مستخدم</label>
                                </div>
                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user_delete" v-model="form.roles.user_delete" >
                                <label class="form-check-label" for="user_delete">حذف مستخدم</label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-md-2">
                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="file_create"  v-model="form.roles.file_create" >
                                <label class="form-check-label" for="file_create">اضافة ملف</label>
                                </div>

                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="file_edit"  v-model="form.roles.file_edit" >
                                <label class="form-check-label" for="file_edit"> تعديل ملف </label>
                                </div>

                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="file_delete"  v-model="form.roles.file_delete" >
                                <label class="form-check-label" for="file_delete">حذف ملف  </label>
                                </div>
                            </div>
                            <div class="col-12"></div>
                            <div class="col-2">
                                <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="select_all"  v-model="form.roles.select_all"
                                @change="SelectAll" />
                                <label class="form-check-label" for="select_all">حدد الكل</label>
                                </div>
                            </div>
                  
                            <div class="col-12">
                                <Link  :href="route('Users.Index')" >     
                                    <button type="button" v-if="!form.processing" class="btn btn-info submit "> 
                                      <fa  icon = "arrow-right" />  رجوع         
                                    </button> 
                                </Link>   

                                <button type="buttom"  @click="Update()" class="btn btn-primary "
                                 :disabled ="form.processing"  > {{ form.processing ?  'جاري التعديل ...' : 'تعديل'  }} </button>
                            </div>

                    </form>
       </AppLayoutMain>
</template>

<style scoped>

.main-content {
     height: fit-content;
}

form {
    gap: 10px;
}
</style>

