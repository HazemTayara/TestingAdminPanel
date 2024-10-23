<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct() {}

    public function create()
    {
        if (view()->exists('specialization.add')) {
            return view('specialization.add');
        } else {
            return view('404');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $specializations = Specialization::all('title', 'created_at', 'updated_at', 'deleted_at');
        if (view()->exists('specialization.show')) {
            return view('specialization.show', ['specializations' => $specializations]);
        } else {
            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255|min:2|alpha',
        ];
        $messages = [
            'title.required' => 'The Title is required',
            'title.string' => 'Something wrong with the Title',
            'title.max' => 'The Title is too long',
            'title.min' => 'The Title must be more than 2 chars',
            'title.alpha' => 'The title may only contain alphabetic characters.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withInput($request->all())
                ->withErrors($validator);
        }

        Specialization::create([
            'title' => $request->title,
        ]);
        Log::info('Specialization Added Succuessfully');
        return redirect()->route('home')->with('success', 'User added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialization $specialization)
    {
        //
        return view('layouts.Specialization.edit', ['specialization' => $specialization]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255'
        ]);
        $title = request()->title;
        $specialization = Specialization::findOrFail($id);
        $specialization->update([
            'title' => $request->title
        ]);

        return redirect('/home/specializations')->with('success', 'you edit a specialization!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $specialization = Specialization::findOrFail($id);
        $specialization->delete();

        return redirect()->route('specializations.index')->with('success', 'Specialization deleted successfully.');
    }
    public function restore($id)
    {
        $specialization = Specialization::withTrashed()->findOrFail($id);
        $specialization->restore();

        return redirect()->route('specializations.index')->with('success', 'Specialization restored successfully.');
    }
}
