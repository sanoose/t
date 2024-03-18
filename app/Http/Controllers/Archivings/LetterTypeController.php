<?php

namespace App\Http\Controllers\Archivings;

use App\Http\Controllers\Controller;
use App\Models\Archivings\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
   
    public function index()
    {
 
        $letters_types =  LetterType::paginate(5) ;
        $letters_types->getCollection()->transform(function ($el) {
            $el->edit_id =   URL::signedRoute('Archiving.Settings.LetterTypes.edit', $el->id)  ;
            $el->delete_id =   URL::signedRoute('Archiving.Settings.LetterTypes.destroy', $el->id)  ;
            return $el;
        });
        
    //    return $letters_types ;
        return inertia("Archiving/Settings/LetterType/Index" , compact('letters_types')) ; 
    }

 
    public function create()
    {
       return inertia("Archiving/Settings/LetterType/Create") ; 
    }
    
 
    public function store(Request $req)
    {
        $req->validate([
            "name" => "required|unique:archive_letter_types" 
        ]) ;
        
       $letter_type = LetterType::create( [
            "name" => $req->name 
        ]) ;

        if ( $letter_type) 
        return redirect()->back() ; 
        else 
        return redirect()->back()->withErrors(["error" => "حدث خطا"]) ; 
    }

 
    public function show(string $id) {  }

 
    public function edit( Request $req , $id )
    {
        if (! $req->hasValidSignature()) 
        abort(403);

        $letter_type = LetterType::find($id) ;
        // return  $letter_type ;
        return inertia("Archiving/Settings/LetterType/Edit" , compact('letter_type')) ; 
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'name' => 'required|unique:users,name,'.$id,
        ]) ;
        $letter_type = LetterType::find($id)->update( [ "name" => $req->name ]) ;
            if ( $letter_type) 
            return redirect()->back() ; 
            else 
            return redirect()->back()->withErrors(["error" => "حدث خطا"]) ; 
    }

    public function destroy( Request $req , string $id)
    {    
        if (! $req->hasValidSignature()) 
        abort(403);

        if (LetterType::find($id)->delete()) 
        return redirect()->back() ; 
        else 
        return redirect()->back()->withErrors(["error" => "حدث خطا"]) ; 
        
    }

    public function  Deleted  ( Request $req  ) {
        $letters_types = LetterType::onlyTrashed()->paginate(5);
        return inertia("Archiving/Settings/LetterType/Deleted" , compact('letters_types' )) ;
   }
    

   public function  Restore  (  $id  ) {
        // Gate::allows("user_show") ? Response::allow() : abort(403) ;
        if ( LetterType::withTrashed()->where("id" , $id )->restore() )   
        { return redirect()->back() ;}
        else { return redirect()->withErrors([ "Error" => "حدث خطأ في عملية الاسترجاع"]) ;  }   
    }


}
