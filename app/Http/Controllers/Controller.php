<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function upload_image_file($image, $image_path, $prefix=""){
        $imageName = $prefix.time().random_int(1000,9999).".". $image->getClientOriginalExtension();
        $image->move($image_path, $imageName);
        return $imageName;
    }
}
