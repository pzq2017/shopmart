<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ResponseJsonTrait;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SiguploadController extends Controller
{
    use ResponseJsonTrait;

    public function upload(Request $request)
    {
    	$file = $request->file;
    	if ($file->isValid()) {
            $temp_dir = \Storage::path('').'temp';
            if (\Storage::exists('temp') == false) {
                \Storage::makeDirectory('temp');
            }
            $originalName = $file->getClientOriginalName();
            $newFileName = md5($originalName.time()).'.'.$file->getClientOriginalExtension();
            if ($request->type == 'images') {
                $img = Image::make($file);
                $img_width = $img->width();
                $img_height = $img->height();
                if ($request->pSize) {
                    list($width, $height) = explode('*', $request->pSize);
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
                \Storage::putFileAs('temp', $file, $originalName);
                return $this->handleSuccess($originalName);
            }
    	} else {
            return $this->handleFail();
    	}
    }
}
