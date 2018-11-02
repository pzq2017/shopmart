<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SiguploadController extends Controller
{
    use ResponseJsonTrait;

    public function picture(Request $request)
    {
    	$picture = $request->file;
    	if ($picture->isValid()) {
            $temp_dir = \Storage::disk('local')->path('').'temp';
            if (\Storage::exists('temp') == false) {
                \Storage::makeDirectory('temp');
            }
            $originalName = $picture->getClientOriginalName();
            $newFileName = md5($originalName.time()).'.'.$picture->getClientOriginalExtension();
            $img = Image::make($picture);
            $img_width = $img->width();
            $img_height = $img->height();
            if ($request->psize) {
                list($width, $height) = explode('*', $request->psize);
                if ($request->handleType) {
                    if ($request->handleType == 1) {
                        $img->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif ($request->handleType == 2) {
                        $img->fit($width, $height);
                    } else {
                        if ($img_width != $width || $img_height != $height) {
                            return $this->handleFail('上传的图片尺寸必须是：'.$width.'*'.$height.'px.');
                        }
                    }
                }
            }
            $img->save($temp_dir.'/'.$newFileName);
            return $this->handleSuccess($newFileName);
    	} else {
            return $this->handleFail();
    	}
    }
}
