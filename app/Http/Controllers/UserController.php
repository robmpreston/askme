<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use Auth;
use App\User;
use Image;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * AJAX REQUEST
     * If Validation Fails Json Response w/ Errors
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'slug' => User::createSlug($request->first_name, $request->last_name),
            'password' => bcrypt($request->password),
        ]);

        Auth::loginUsingId($user->id);
        
        return response()->json(['success' => true, 'error' => null, 'data' => ['user' => $user]]);
    }

    /**
     * Upload a user's picture
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadPicture(Request $request)
    {
        if ($request->hasFile('file') && Auth::check()) {
            $user = Auth::user();
            $image = $request->file('file');
            $filename  = time() . '.' . $image->getClientOriginalExtension();
            $filePath = '/profile-pictures/' . $filename;

            $croppedImage = Image::make($image)->fit(400);
            $s3 = \Storage::disk('s3');
            $s3->put($filePath, $croppedImage->stream()->__toString(), 'public');

            $user->picture = $filename;
            $user->save();

            return [
                'success' => true,
                'error' => null,
                'data' => $user
            ];
        }
    }
}
