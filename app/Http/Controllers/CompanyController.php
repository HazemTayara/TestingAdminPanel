<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Report;


class CompanyController extends Controller
{


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $companies = Company::all(
            'uuid',
            'name',
            'phone',
            'email',
            'logo',
            'type',
            'description',
            'domain',
            'employess_count'
        );
        if (view()->exists('company.show')) {
            return view('company.show', ['companies' => $companies]);
        } else {
            return view('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function profile($uuid)
    {

        if (view()->exists('company.profile')) {
            $company =  Company::where('uuid', '=', $uuid)->first();

            return view('company.profile',  ['company' => $company]);
        } else {
            return view('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function reports($uuid)
    {
        if (view()->exists('company.reports')) {
            $company = Company::with('reports')->where('uuid', '=', $uuid)->get()->first();
            return view('company.reports', ['company' => $company]);
        } else {
            return view('404');
        }
    }
}
