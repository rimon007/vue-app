<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
}); 

 
Route::get('/mail', function() {

	return view('send-mail');

});


Route::post('/mail', function(Request $request) {

	## save Any base64 file to local storage.
	$data = $request->input('attachment');
	list($type, $data) = explode(';', $data);
	list(, $data) = explode(',', $data);
	//$data = base64_decode($data);
	$typeFile = explode(':', $type);
	$fileType = $typeFile[1];
	$extension = explode('/', $typeFile[1]);
	$ext = $extension[1];
	$fileName = "product-".time().'.'.$ext;

	$data = [
	    'username' => $request->input('username'),
	    'email' => $request->input('email'),
	    'subject' => $request->input('subject'),
	    'bodyMessage' => $request->input('message'),
	    'attachment' => [
	    	'base64' => $data,
	    	'filename' => $fileName,
	    	'filetype' => $fileType
	    ],
	];


	\Mail::send('emails.contact', $data,
	    function ($m) use ($data) {
	        $m->from($data['email'], $data['username']);
	        $m->attachData(
	        	base64_decode($data['attachment']['base64']), 
	        	$data['attachment']['filename'], [
	        		'mime' => $data['attachment']['filetype']
	        	]);
	        $m->to($data['email']);
	        $m->subject($data['subject']);
	});

	return 'ture';



	return $imageData = $request->get('attachment');
	$png_url = "product-".time().".png";
	$path = public_path('images/'). $png_url;

	Image::make(file_get_contents($imageData))->save($path);     
	$response = array(
	    'status' => 'success',
	);
	return Response::json( $response  );



	## Only Image File save with validation
	$validator = Validator::make($request->all(), [
        'attachment' => 'required|image64:jpeg,jpg,png'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors'=>$validator->errors()]);
    }

	$imageData = $request->get('attachment');
    $fileName = Carbon\Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
	//Image::make($request->get('attachment'))->save(public_path('images/').$fileName);

    $data = [
		'email' => $request->email,
		'subject' => 'Test',
		'message' => $request->message,
		'a_file' => $request->get('attachment')
	];
	
	return $data['a_file']->getRealPath();

	dd(request()->all());

});
