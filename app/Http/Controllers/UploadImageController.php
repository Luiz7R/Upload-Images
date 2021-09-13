<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Images;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{

   /**
     * Handle an upload image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function AddImage (Request $request)
    { 
         $this->validate($request,[
             'images' => 'required',
             'images.*' => 'image|mimes:jpeg,png,jpg|max:4000' 
         ]);

        // Handle File Upload
           if ( $request->hasFile('images') )
           {

                  foreach ( $request->file('images') as $images )
                  {
                     $fileNameWithExt = $images->getClientOriginalName();

                     $filename = pathinfo( $fileNameWithExt, PATHINFO_FILENAME );

                     $extension = $images->getClientOriginalExtension();

                     $fileNameToStore = $filename.'_'.time().'.'.$extension;

                     $path = $images->storeAs('public/images', $fileNameToStore );
                     
                     $image = new Images;
                     $image->image = $fileNameToStore;
                     $image->save();

                  }

               //  // Get Filename with extension
               //     $fileNameWithExt = $request->file('images')->getClientOriginalName(); 

               //  // Get just Filename
               //     $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                   
               //  // Get just Extension
               //     $extension = $request->file('images')->getClientOriginalExtension();
                   
               //  // Filename to store
               //     $fileNameToStore  = $filename.'_'.time().'.'.$extension;
                   
               //  // Upload Image
               //     $path = $request->file('images')->storeAs('public/images', $fileNameToStore);   
           }

           
         return redirect('/')->with('success', 'Image Uploaded');
    }


    public function delImg($idImage)
    {
         $data = Images::find($idImage);

         Storage::delete('public/images/'.$data->image);

         $data->delete();

         return response(true, 200)->header('Content-Type', 'text/plain');
    }
}