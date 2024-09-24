<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $areas = Area::all();
        $genres = Genre::all();
        return view('owner_page',['user_id' => $user_id, 'areas' => $areas, 'genres' => $genres]);
    }

    public function create(Request $request)
    {



        // 取得したファイル名で保存
        // storage/app/public/任意のディレクトリ名/
        // $shop_data['image']->storeAs('public/shopImage', $file_name);
        $extension = $request->file("image")->getClientOriginalExtension();
        $image=$request->file('image')->storeAs('', $request->user()->id . '.' .$extension, 'public');
 

        // $shop = new Shop();
        // $任意の変数名　=　テーブルを操作するモデル名();
        // storage/app/public/任意のディレクトリ名/
        // $image->image = $file_name;
        // $shop->create(['image' => $image]);


        $image_path= 'storage/' . $image;
        // $image->save();
$shop_data = $request->all();
        Shop::create([
            'user_id' => $shop_data['user_id'],
            'name' => $shop_data['name'],
            'area_id' => $shop_data['area_id'],
            'genre_id' => $shop_data['genre_id'],
            'overview' => $shop_data['overview'],
            'image' => $image_path
             ]);

            // 'image' => $image
       
        return redirect('/');
    }

    public function upload(Request $request)
    {


        // アップロードされたファイル名を取得
        $file_name = $request->file()->getClientOriginalName();

        // 取得したファイル名で保存
        // storage/app/public/任意のディレクトリ名/
        $request->file()->storeAs('public/shopImage', $file_name);

        $image = new Shop();
        // $任意の変数名　=　テーブルを操作するモデル名();
        // storage/app/public/任意のディレクトリ名/
        // $image->image = $file_name;
        $image->image = 'storage/app/public/shopImage' . $file_name;
        $image->save();
   
        return redirect('/');
    }
}
