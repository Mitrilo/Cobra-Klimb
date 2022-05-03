<?php

namespace App\Http\Controllers;

session_start();

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{

    public function form() {
        $_SESSION['passcheck'] = FALSE;
        return view('user.form');
    }

    public function update(Request $request) {
        $user = \Auth::user();
        $id=\Auth::user()->id;

        $validate = $this->validate($request, [
            'name'=> ['required', 'string', 'max:255'],
            'surname'=> ['required', 'string', 'max:255'],
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|max:255|unique:users,email,'.$id,
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        $image = $request->file('image');

        if ($image) {
            $path = $image->store('users');
            
            $filename = preg_replace('/^.+[\\\\\\/]/','',$path);

            $user->image=$filename;
        }

        $user->name=$name;
        $user->surname=$surname;
        $user->nick=$nick;
        $user->email=$email;

        $user->update();

        return redirect()->route('config')
                         ->with(['message'=>'Another happy landing! :)']);  

    }

    ### Obtenir imatge del avatar ###
    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);

        return new Response($file,200);
    }

    ### Actualitzar password ###
    
    # Generar vista formulari comprovar password
    public function viewPassForm() {
        return view('user.checkpass');
    }

    # Comprovar la password 
    public function checkPassw(Request $request) {
        $_SESSION['passcheck'] = FALSE;
        $user = \Auth::user();
        $id = \Auth::user()->id;

        if (Hash::check($request->password, $user->password)) {
            $_SESSION['passcheck'] = TRUE;
            return redirect()->route('changepw');

        } else {
            $_SESSION['passcheck'] = FALSE;
            return redirect()->route('checkpw')
                             ->with(['message' => "Password incorrecte :'("]);
        }
    }

    # Generar vista formulari de la nova password
    public function newPassword() {
        if ($_SESSION['passcheck'] == TRUE) {

            return view('user.formnewpass');
        } else {
            return redirect()->route('home');
        }

        session_destroy();
    }

    #Actualitzar password
    public function passwordUpdate(Request $request) {
        $user = \Auth::user();

        $validate = $this->validate($request, [
            'password' => 'required|string|min:8|confirmed|unique:users,password, '
        ]);

        $password = $request->input('password');
        $user->password = Hash::make($password);
        $user->update();

        return redirect()->route('changepw')
                         ->with(['message' => 'Password canviada :)']);
    }
}
