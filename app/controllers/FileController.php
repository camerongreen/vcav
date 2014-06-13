<?php

class FileController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getIndex($fileName)
	{
    $fileDir = $_SERVER['DOCUMENT_ROOT'] . '/../videos';
    $file = $fileDir . '/' . $fileName;
    $comparisonRunner = new ComparisonRunner();
    $fileOutput = $comparisonRunner->getFileOutput($file);
    return Response::json($fileOutput);
	}

}
