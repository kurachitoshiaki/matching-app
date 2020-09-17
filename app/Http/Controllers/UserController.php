<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest; 
use App\User; 
use Intervention\Image\Facades\Image;
use App\Services\CheckExtensionServices;
use App\Services\FileUploadServices;
use JD\Cloudder\Facades\Cloudder;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findorFail($id);

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findorFail($id);

        return view('users.edit', compact('user')); 
    }

    public function update($id, ProfileRequest $request) 
    {

        $user = User::findorFail($id);

        if(!is_null($request['img_name'])){
            $image_name = $request['img_name'];
            // Cloudinaryへアップロード
            Cloudder::upload($image_name, null);
            list($width, $height) = getimagesize($image_name);
            // 直前にアップロードした画像のユニークIDを取得します。
            $publicId = Cloudder::getPublicId();
            // URLを生成します
            $logoUrl = Cloudder::show($publicId, [
                'width'     => 200,
                'height'    => 200
            ]);
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->self_introduction = $request->self_introduction;
        $user->img_name = $logoUrl;

        $user->save();

        return redirect('home'); 
    }
}
