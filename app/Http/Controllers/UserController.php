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
     * Show the application dashboard.
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
