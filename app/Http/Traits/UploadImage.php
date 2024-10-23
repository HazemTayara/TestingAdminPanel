<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;


trait UploadImage
{
    public function uploadimage(Request $request ,$folderName)
    {
      $image = $request->file('image')->getClientOriginalName();
      $url = $request->file('image')->storeAs($folderName,$image,'public') ;
      return $url ;

    }

 
}


