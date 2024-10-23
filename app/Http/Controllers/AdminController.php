<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('add_admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (view()->exists('admin.add')) {
            return view('admin.add');
        } else {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddAdminRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'type' => 'admin',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);
            Log::info('Admin Added succuessfully');
            return redirect()->route('home');
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
