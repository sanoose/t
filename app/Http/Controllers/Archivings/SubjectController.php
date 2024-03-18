<?php

namespace App\Http\Controllers\Archivings;

use App\Http\Controllers\Controller;
use App\Models\Archivings\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all()->toTree();
      
        return inertia('Archiving/Settings/Subjects/Index', [
            'subjects'  => $subjects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::where("parent_id" , null)->get();

        return inertia('Archiving/Settings/Subjects/Create', [
            'subjects'  => $subjects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
          $req->validate([
                'name'      => 'required|unique:archive_subjects' ,
                'parent_id' => 'required|numeric' ,
                'code'      => 'required|numeric'  ,
            ]) ;
            $subject = Subject::create($req->all()) ;
            if ($subject)
            return redirect()->back() ;    
            else 
            return redirect()->back()->withErrors(["error" => "لم تتم اضافة البند"]) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subjects = Subject::all();
        $subject = Subject::find($id);

        return inertia('Archiving/Settings/Subjects/Edit', [
            'subject'    => $subject,
            'subjects'   => $subjects,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
     
        $req->validate([
            'name' => 'required|unique:archive_subjects,name,'.  $id ,
            'parent_id' => 'required|numeric' ,
            'code'      => 'required|numeric'  ,
        ]) ;
        $subject = Subject::find($id) ;
        $subject->update($req->all()) ;
        if ($subject)
        return redirect()->back() ;    
        else 
        return redirect()->back()->withErrors(["error" => "لم يتم تعديل البند"]) ;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
