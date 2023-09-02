<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Retailer;
use App\Notice;
use App\Product;
use App\Profile;
use App\Ticket;
use App\User;
use App\UserAttendance;

class UploadsController extends Controller
{
  public function uploadUserImage(Request $request)
  {
    $request->validate([
      'id'        => 'required',
    ]);

 
    $imagePath = '';
    if ($request->hasFile('image_path')) {
      $file = $request->file('image_path');
      $name = $request->filename ?? 'photo' . time() . '.';
      $name = $name . $file->getClientOriginalExtension();;
      $imagePath = 'cms/users/' .  $request->id . '/' . $name;
      Storage::disk('s3')->put($imagePath, file_get_contents($file), 'public');

      $user = User::where('id', '=', request()->id)->first();
      $user->image_path = $imagePath;
      $user->update();
    }

    return response()->json([
      'data'  => [
        'image_path'  =>  $imagePath
      ],
      'success' =>  true
    ]);
  }
  public function uploadTicketImage(Request $request)
  {
    $request->validate([
      'id'        => 'required',
      // 'imagepath'        => 'required',
    ]);

    $imagepath = '';
    $asset = [];
    for ($i = 1; $i < 6; $i++) {
      if ($request->hasFile('image_path_' . $i)) {
        $file = $request->file('image_path_' . $i);
        $f_name = 'image_path_' . $i;
        $name = $request->filename ?? "$f_name.";
        $name = $name . $file->getClientOriginalExtension();
        $imagepath = 'cms/tickets/' .  $request->id . '/' . $name;
         Storage::disk('s3')->put($imagepath, file_get_contents($file), 'public');
        // Storage::disk('local')->put($imagepath, file_get_contents($file), 'public');


        $asset = Ticket::where('id', '=', request()->id)->first();
        $asset->$f_name = $imagepath;
        $asset->update();
      }
    }
    return response()->json([
      'data'  =>  $asset,
      'imagepath'  =>  $imagepath,
      'message' =>  "Asset Imagepath Upload Successfully",
      'success' =>  true
    ], 200);
  }
  public function uploadProductImage(Request $request)
  {
    $request->validate([
      'id'        => 'required',
      // 'imagepath'        => 'required',
    ]);

    $imagepath = '';
    $asset = [];
    for ($i = 1; $i < 6; $i++) {
      if ($request->hasFile('imagepath_' . $i)) {
        $file = $request->file('imagepath_' . $i);
        $f_name = 'imagepath_' . $i;
        $name = $request->filename ?? "$f_name.";
        $name = $name . $file->getClientOriginalExtension();
        $imagepath = 'cms/products/' .  $request->id . '/' . $name;
         Storage::disk('s3')->put($imagepath, file_get_contents($file), 'public');
        // Storage::disk('local')->put($imagepath, file_get_contents($file), 'public');


        $asset = Product::where('id', '=', request()->id)->first();
        $asset->$f_name = $imagepath;
        $asset->update();
      }
    }
    return response()->json([
      'data'  =>  $asset,
      'imagepath'  =>  $imagepath,
      'message' =>  "Asset Imagepath Upload Successfully",
      'success' =>  true
    ], 200);
  }
}
