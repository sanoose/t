<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\role;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

use function PHPUnit\Framework\returnSelf;

// use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class userController extends Controller
{

    public function LoginPage ()
    {   
        // return 22 ;
        return Inertia::render('Auth/Login' ); 
        if ( Auth::check()  ) {
            return redirect()->intended('/') ;
        } else 
        { return Inertia::render('Auth/Login' );  }
    }

    public function Login ( Request $request )
    {
            $credentials = $request->validate([
                'email' => ['required'] ,
                'password' => ['required'] ,
            ]) ;
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate() ;
                return redirect()->intended('/') ;
            }
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
    }

    public function Logout () {
        Auth::logout() ;
        return  redirect('/Login')  ;
    }

    public function Create () {
        Gate::allows("user_create") ? Response::allow() : abort(403) ;

        if (auth()->user()->user_level == "سوبر أدمن")
        $departments = Department::all();
        else
        $departments  = Department::descendantsAndSelf(Auth::user()->department_id) ; 

        return inertia("Users/Create" ,  compact("departments") ) ;
    }

    public function  Store  ( Request $req ) {
        Gate::allows("user_create") ? Response::allow() : abort(403) ;
        //  "user_level":"department_admin","email":"sanoose","password":"123","password_confirmation":"123","department_id":3 
        // return $req->all() ;
        $validator = Validator::make($req->all() , [
            'name' => 'required' ,
            'department_id' => 'required|numeric' ,
            'email' => 'required|unique:users'  ,
            'password' => 'required|confirmed' ,
            'password_confirmation' => 'required' ,
            'user_level' => 'required' ,
       ] , [
        "name.required" => "حقل الاسم فارغ" , "email.required" => "حقل الايميل فارغ" , 
        "email.unique" => "اسم المستخدم موجود مسبقا" , "password.confirmed" => "حقلي كلمة المرور غي متطابقة"
       ]) ;
        if ($validator->fails() ) {
            return redirect()->back()->withErrors( $validator->errors()  ) ;
        }
       $user =  User::create([
            'name' => $req->name ,
            'department_id' => $req->department_id ,
            'email' => $req->email ,
            'password' => Hash::make($req->password)  ,
            'user_level' => $req->user_level ,
            'added_by' => auth()->user()->id  ,
        ]) ;
        // return $req->roles ;
        if ($user) {
            role::create([
                'user_id'     =>  $user->id , 
                'user_create'    =>  $req->roles['user_create']    == "" ? "false" :  $req->roles['user_create']  , 
                'user_edit'   =>  $req->roles['user_edit']   == "" ? "false" :  $req->roles['user_edit']  , 
                'user_delete' =>  $req->roles['user_delete'] == "" ? "false" :  $req->roles['user_delete']  , 
                'file_create'    =>  $req->roles['file_create']    == "" ? "false" :  $req->roles['file_create']  , 
                'file_edit'   =>  $req->roles['file_edit']   == "" ? "false" :  $req->roles['file_edit']  , 
                'file_delete' =>  $req->roles['file_delete'] == "" ? "false" :  $req->roles['file_delete']  , 
            ])  ;
        } else {
            return redirect()->back()->withErrors(["error" => "لم تتم اضافة المستخدم"]) ;
        }
        
        return redirect()->back() ;
    }

    public function Index (Request $req) {
        Gate::allows("user_show") ? Response::allow() : abort(403) ;
        $department_id =  auth()->user()->department_id ;
        $department =  Department::find( $department_id )  ;
       
        $query = User::with(['role' , 'department' , 'user'])
        ->whereHas("role")->whereHas("department")->whereHas("user") ;
 
        switch  (auth()->user()->user_level) {
            case "سوبر أدمن"  :  break  ;  
            case "مشرف"       :  
                $departments_ids = $department->descendantsAndSelf($department_id)->pluck("id");
                $query->whereIn("department_id" ,  $departments_ids ) ;   break  ; 
            case "مشرف قسم"   :   $query->where("department_id" ,  $department_id ) ;   break  ; 
            default : return redirect()->back() ;  break  ;  
        } ;
        $users =  $query->filter(request()->all())->paginate(5);
        $filter =  $req->all() ;
        $users->appends($req->all()) ;
        $users->getCollection()->transform(function ($el) {
            $el->edit_id =   URL::signedRoute('Users.Edit', $el->id)  ;
            $el->delete_id =   URL::signedRoute('Users.Delete', $el->id)  ;
            return $el;
        });
        // return  $users ;
        return inertia("Users/Index" , compact('users' , 'filter')) ;
    }

    public function Edit ( Request $req , $id) {

        if (!$req->hasValidSignature()) 
        abort(403);

        if (auth()->user()->user_level == "سوبر أدمن")
        $departments = Department::all();
        else
        $departments  = Department::descendantsAndSelf(Auth::user()->department_id) ; 

        $user = User::with(['role' , 'department'])->whereHas("role")->where("id" , $id)->first() ; 
        $roles = Role::all() ;
        return  inertia("Users/Edit" , [
            "user" => $user , 
            "roles" => $roles ,
            "departments" => $departments ,
        ])  ;
    }

    public function Update ( Request $req ) {
            Gate::allows("user_edit") ? Response::allow() : abort(403) ;
            $validator = Validator::make($req->all() , [
                'name' => 'required' ,
                'email' => 'required|unique:users,email,'.$req->id,
                'password' => 'confirmed' ,
                'user_level' => 'required' ,
        ] , [
            "name.required" => "حقل الاسم فارغ" , "email.required" => "حقل الايميل فارغ" , 
            "email.unique" => "اسم المستخدم موجود مسبقا" , "password.confirmed" => "حقلي كلمة المرور غي متطابقة"
        ]) ;

            if ($validator->fails() ) {
                return redirect()->back()->withErrors( $validator->errors()  ) ;
            }

            $user = User::find($req->id) ;
            $user->name = $req->name ;
            $user->email = $req->email ; 
            $user->user_level =  $req->user_level ;
        
         
            if (!empty ($req->password)) {
             $user->password =  Hash::make($req->password) ;
             $user->is_new_user =  true  ;
            }  
            $user->save() ;
            // return $req->roles ;
            if ($user) {
                role::where('user_id' , $req->id)->update([
                    'user_create'    =>  $req->roles['user_create']    == "" ? "false" :  $req->roles['user_create']  , 
                    'user_edit'   =>  $req->roles['user_edit']   == "" ? "false" :  $req->roles['user_edit']  , 
                    'user_delete' =>  $req->roles['user_delete'] == "" ? "false" :  $req->roles['user_delete']  , 
                    'file_create'    =>  $req->roles['file_create']    == "" ? "false" :  $req->roles['file_create']  , 
                    'file_edit'   =>  $req->roles['file_edit']   == "" ? "false" :  $req->roles['file_edit']  , 
                    'file_delete' =>  $req->roles['file_delete'] == "" ? "false" :  $req->roles['file_delete']  , 
                ]) ;
            } else {
                return redirect()->back()->withErrors(["error" => "حدث خطأ لم يتم تعديل المستخدم"]) ;
            }
            return redirect()->back() ;
    }

    public function Delete ( Request $req , $id) {
        if (! $req->hasValidSignature()) 
        abort(403);

        if ( User::find($id)->delete()  )   
             { return redirect()->back() ;}
        else { return redirect()->withErrors([ "Error" => "حدث خطأ في عملية الحذف" ]) ;  }   
    }


    public function  Banned  ( $id  ) {
         User::find($id)->update( [
                "banned" =>  "true"
        ])    ;
        return redirect()->back() ;
    }

    public function   UnBanned  ( $id  ) {
         User::find($id)->update( [
                "banned" =>  "false"
        ])    ;
        return redirect()->back() ;

    }

    public function  Deleted  ( Request $req  ) {
        Gate::allows("user_show") ? Response::allow() : abort(403) ;
        $users = User::onlyTrashed()->with(['role'])->whereHas("role")->filter(request()->all())->paginate(2);
        $filter =  $req->all() ;
        $users->appends($req->all()) ;
        return inertia("Users/Deleted" , compact('users' , 'filter')) ;
   }
    

   public function  Restore  (  $id  ) {
        Gate::allows("user_show") ? Response::allow() : abort(403) ;
        if (       User::withTrashed()->where("id" , $id )->restore()    )   
        { return redirect()->back() ;}
        else { return redirect()->withErrors([ "Error" => "حدث خطأ في عملية الاسترجاع"]) ;  }   
    }


    public function UpdatePasswordForm () {
        return inertia("Profile/Partials/UpdatePasswordForm") ;
    }
}
