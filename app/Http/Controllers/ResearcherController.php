<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Researcher;
use App\Http\Traits\UploadImage;


class ResearcherController extends Controller
{
    use UploadImage;

    public function show()
    {
        $researchers = Researcher::all(
            'uuid',
            'name',
            'image',
            'points',
        );
        if (view()->exists('researcher.show')) {
            return view('researcher.show', ['researchers' => $researchers]);
        } else {
            return view('404');
        }
    }

    public function profile($uuid)
    {
        if (view()->exists('researcher.profile')) {
            $researcher =  Researcher::where('uuid', '=', $uuid)->first();
            return view('researcher.profile',  ['researcher' => $researcher]);
        } else {
            return view('404');
        }
    }

    // public function index()
    // {
    //     $researchers = Researcher::withCount('reports')->get();
    //     return view('researcher.show', ['researchers' => $researchers]);
    // }

    // public function edit(string $uuid)
    // {
    //     $researcher = Researcher::where('uuid', $uuid)->first();

    //     return view('researcher.edit', ['researcher' => $researcher]);
    // }

    // public function update(Request $request, string $uuid)
    // {
    //     if ($request->IsMethod("post")) {

    //         $validator = validator::make($request->all(), [
    //             'name' => 'required|string|regex:/[a-z]/',
    //             'email' => 'required|email|unique:researchers,email',
    //             'phone' => 'required|string',
    //             'code' => 'required|string|max:5',
    //             'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
    //             'facebook' => 'required|string|unique:researchers,facebook',
    //             'linkedin' => 'required|string|unique:researchers,linkedin',
    //             'github' => 'required|string|unique:researchers,github',
    //         ]);
    //         if ($validator->fails()) {
    //             return $validator->errors()->first();
    //         } else {
    //             $exsistResearcher = Researcher::where([['name', $request->name], ['email', $request->email], ['phone', $request->phone], ['facebook', $request->facebook], ['github', $request->github]])->first();

    //             if ($exsistResearcher) {
    //                 return response()->json(['message' => 'The researcher has been exsist already'], 409);
    //             } else {

    //                 $image = $this->uploadimage($request, 'images');
    //                 $data = [
    //                     'name' => $request->name,
    //                     'email' => $request->email,
    //                     'phone' => $request->phone,
    //                     'code' => $request->code,
    //                     'image' => $image,
    //                     'facebook' => $request->facebook,
    //                     'linkedin' => $request->linkedin,
    //                     'github' => $request->github
    //                 ];
    //                 $researcher = Researcher::where('uuid', $uuid)->first();

    //                 $updated = $researcher->update($data);
    //                 if ($updated) {
    //                     return redirect()->back()->withInput();
    //                 }
    //             }
    //         }
    //     }
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $uuid)
    // {
    //     $researcher = Researcher::where('uuid', $uuid)->first();
    //     $researcher->delete();
    //     $res = Researcher::all();
    //     return view('researcher.show', ['researchers' => $res]);
    // }

    // public function restore(string $uuid)
    // {
    //     $researcher = Researcher::withTrashed()->where('uuid', $uuid)->restore();
    //     $researchers = Researcher::all();
    //     return view('researcher.show', ['researchers' => $researchers]);
    // }
    // public function trashed()
    // {
    //     $trachedModels = Researcher::onlyTrashed()->get();
    //     return view('researcher.index', ['researchers' => $trachedModels]);
    // }
}
