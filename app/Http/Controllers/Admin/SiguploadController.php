<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SiguploadController extends Controller
{
    public function picture(Request $request)
    {
    	$picture_field = $request->field;
    	$picture = $request->file('file_'.$picture_field);
    	if ($picture->isValid()) {
    		$format = '/\.(jpg|jpeg|png|gif)$/i';
    		if ($request->supportFormat) {
    			$format = '/\.('.$request->supportFormat.')$/i';
    		}
    		$originalName = $picture->getClientOriginalName();
    		if (!preg_match($format, $originalName)) {
    			die("<script>top.Qk.msg('上传的图片格式不支持.', {icon: 2});</script>");
    		} else {
    			$temp_dir = \Storage::disk('local')->path('').'temp';
    			if (\Storage::exists('temp') == false) {
    				\Storage::makeDirectory('temp');
    			}
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
    							die("<script>top.Qk.msg('上传的图片尺寸必须是：'.$width.'*'.$height.'px.', {icon: 2});</script>");
    						}
    					}
    				}
    			}
    			$img->save($temp_dir.'/'.$newFileName);
    			die("<script>top.SiguploadHandle('$picture_field', '$newFileName', 'picture');</script>");
    		}
    	} else {
    		die("<script>top.Qk.msg('上传失败.', {icon: 2});</script>");
    	}
    }
}
