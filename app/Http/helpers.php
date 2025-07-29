<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

if (! function_exists('authUser')) {

	function authUser() {
		return \Auth::user();
	}

}

if (! function_exists('isActiveMenu')) {

	/**
	 * Will active string if current page route name is equal to parameters route name
	 * @param  String / Array  $routes Can accept single route name or multiple in form of array
	 * @return String
	 */
	function isActiveMenu($names){
		$curName = Illuminate\Support\Facades\Route::currentRouteName();
	    $state = '';

	    if(is_array($names)){
	        $state = in_array($curName, $names) ? 'active' : '';
	    } else {
	        $state = $curName == $names ? 'active' : '';
	    }

	    return $state;
	}
}

if (! function_exists('isOpenMenu')) {

	/**
	 * Will active string if current page route name is equal to parameters route name
	 * @param  String / Array  $routes Can accept single route name or multiple in form of array
	 * @return String
	 */
	function isOpenMenu($names){
		$curName = Illuminate\Support\Facades\Route::currentRouteName();
	    $state = '';

	    if(is_array($names)){
	        $state = in_array($curName, $names) ? 'nav-item-open' : '';
	    } else {
	        $state = $curName == $names ? 'nav-item-open' : '';
	    }

	    return $state;
	}
}

if (! function_exists('isShowMenu')) {

	/**
	 * Will active string if current page route name is equal to parameters route name
	 * @param  String / Array  $routes Can accept single route name or multiple in form of array
	 * @return String
	 */
	function isShowMenu($names){
		$curName = Illuminate\Support\Facades\Route::currentRouteName();
	    $state = '';

	    if(is_array($names)){
	        $state = in_array($curName, $names) ? 'show' : '';
	    } else {
	        $state = $curName == $names ? 'show' : '';
	    }

	    return $state;
	}
}

if (! function_exists('getFileSizeMB')) {

	function getFileSizeMB($file) {
		$toKB = (Storage::size($file) / 1000);
		return number_format($toKB / 1000, 3) . ' MB';
	}

}

if (! function_exists('formatFileLastModified')) {

	function formatFileLastModified($file) {
		return Carbon::createFromTimestamp(
			Storage::lastModified($file)
		)->format('D, M d, Y h:i a');
	}

}