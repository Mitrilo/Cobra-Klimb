<?php

namespace App\Http\Controllers;

session_start();

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Schema;
use App\Models\Image;

class imageController extends Controller
{
    public function newImage() {
        return view('user.imageform');
    }

    public function uploadImage(Request $request) {
        $user = \Auth::user();
        $id=\Auth::user()->id;
        $image = new Image();

        $validate = $this->validate($request, [
            'description' => ['string', 'max:255'],
        ]);

        $description = $request->input('description');
        $img = $request->file('image');

        if ($img) {
            $path = $img->store('images');
            
            $filename = preg_replace('/^.+[\\\\\\/]/','',$path);

            $image->description=$description;
            $image->image_path=$filename;
            $image->user_id=$id;
        }
        

        $image->save();

        return redirect()->route('newimage')
                         ->with(['message'=>'Another happy landing! :)']); 
    }


    public function getImages($filename) {
        $file = Storage::disk('images')->get($filename);

        return new Response($file,200);
    }

    public function index() {
        //$file = Image::all();
        $file = Image::paginate(4);
        
        return view('home', ["file" => $file]);

        //return view('home', compact("file"));
    }
}