<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use App\Models\CompanySpecialization;
use App\Models\Specialization;

class HomepageController extends Controller
{
    public function index()
    {
        $types = ['خاصة','حكومية','مشتركة'];
        //$type_reports = ['pending','accept','reject','done'];
        $specializations = Specialization::pluck('title');
        return view('home.homepage',compact('types','specializations'));
    }

    public function filter( Request $request )
    {
       
   $query = Company::query(); 
 
    if ($request->input('name') ) { 
    
        $name = $request->input('name'); 
        $query->where('name','like', '%'.$request->name.'%');
        $company = $query->first();
   
    return view('home.company',['company' => $company]);
        
    } 
    elseif ($request->input('type') && $request->input('type') != 'Select One' ){ 
        
        $type = $request->input('type'); 
        $query->where('type','like', '%'.$request->type.'%');
        $companies = $query->get(); 
        return view('home.companies',['companies' => $companies]);
    }
    elseif ($request->input('specialization')  ) { 
        
        $specialization = Specialization::where('title',$request->input('specialization'))->first();

        $companies = $specialization->companies;
        return view('home.companies',['companies' => $companies]);
        
        
    }
}
        
    }
    
    
   
    
