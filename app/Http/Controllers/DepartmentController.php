<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $departments = Department::get()->toTree();
        // return       Auth::user() ; 
        // Depts
            // return Department::where("id" ,1)->first()->descendants();
            //     return Department::descendantsAndSelf( ) ;
            // return  $departments  = Department::where("user_id" , Auth::user()->department_id )
            // ->descendantsOf(Auth::user()->department_id ) ;
                // return Department::where("id" ,1)->first()->descendants();
                // $departments  = Department::all()->toTree() ; 
                
            if (auth()->user()->user_level == "سوبر أدمن")
            $departments  = Department::all()->toTree() ; 
            else  
            $departments  = Department::descendantsAndSelf(Auth::user()->department_id)->toTree() ; 
         
         
    //  return     $departments  ; 
        return inertia('Departments/Index', [
            'departments'  =>  $departments ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (auth()->user()->user_level == "سوبر أدمن")
        $departments = Department::all();
        else
        $departments  = Department::descendantsAndSelf(Auth::user()->department_id) ; 
        // return $departments ;
        return inertia('Departments/Create', compact("departments"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req )
    {
        $validator = Validator::make($req->all() , [
                'name' =>  'required|unique:departments'  ,
                'last_inbox_number' => 'required|numeric' ,
                'last_inbox_year' => 'required|numeric' ,
                'last_outbox_number' => 'required|numeric' ,
                'last_outbox_year' =>   'required|numeric' ,
              ]) ;

        $parent_id =  $req->parent_id ;
        if ( $req->parent_id != "" ) 
            $req->validate( [ 'parent_id' => 'required|numeric' ] ) ;
         else 
            $parent_id = auth()->user()->department_id ;

        if ($validator->fails() ) {
            return redirect()->back()->withErrors( $validator->errors()  ) ;
        }
         $department = Department::create([
            'name' =>  $req->name   ,
            'last_inbox_number' => $req->last_inbox_number ,
            'last_inbox_year' =>  $req->last_inbox_year ,
            'last_outbox_number' =>  $req->last_outbox_number ,
            'last_outbox_year' =>   $req->last_outbox_year ,
            'user_id' => auth()->user()->id ,
            'parent_id' =>   $parent_id  ,
        ]) ;

        if ( $department ) 
        return redirect()->back() ;
        else 
        return redirect()->back()->withErrors( $validator->errors()  ) ;

        }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id )
    {
        // return $id  ==   auth()->user()->department_id ;
        if ( $id ==  auth()->user()->department_id ) { return redirect()->back()->withErrors(["Error" , "لا يمكن تعديل الموكن الرئيسي"]) ; }

        $department = Department::find($id) ;
        if (auth()->user()->user_level == "سوبر أدمن")
        $departments = Department::all();
        else
        $departments  = Department::descendantsAndSelf(Auth::user()->department_id) ; 
        // return $departments ;
        return inertia('Departments/Edit', compact("departments" , "department" ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
