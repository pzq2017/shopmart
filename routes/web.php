<?php

Route::get('file/{type}/{filename}', function ($type, $filename) {
	\App\Http\Util\FileRoute::showfile($type, $filename);
});
