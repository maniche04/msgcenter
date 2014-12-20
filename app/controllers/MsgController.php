<?php

class MsgController extends BaseController {

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

	public function getoneMessage()
	{
		$thisuser = Auth::user()->username;
		$unread = DB::select("SELECT * FROM ic_notifications WHERE to_user = '" . $thisuser . "' AND read_status = 0 LIMIT 1");
		if (!$unread) {
			return View::make('msg/data',array('msg'=>'none','from'=>'none'));
		}
		$msg = $unread[0];
		$message_id = $msg->id;
		$message_from = $msg->from_user;
		DB::statement("UPDATE ic_notifications SET read_status = '1' WHERE id = '" . $message_id . "'");
		return View::make('msg/data',array('msg'=>$msg->msg, 'from'=>$message_from));
		

	}

	public function messageCenter()
	{
		$username = Auth::user()->username;
		$firstname = Auth::user()->firstname;
		$users = DB::select("SELECT username FROM users ORDER BY username ASC");

		return View::make('msg/center', array('user'=>$username, 'firstname' => $firstname, 'users' => $users));
	}

	public function adduser() {
		$username = 'john';
		$password = Hash::make('john789');
		$firstname = 'John';
		$lastname = 'Mark';
		if (DB::statement ("INSERT INTO users (`username`,`password`,`firstname`,`lastname`) VALUES ('" . $username . "','" . $password . "','" . $firstname . "','" . $lastname . "')")) {
			echo "Saved successfully!";
		} else {
			echo "Error!";
		}

	}

	public function sendoneMessage()
	{
		$to = Input::get('to');
		$msg = Input::get('msg');
		$from = Auth::user()->username;
		
		foreach ($to as $to_user) {
			if (DB::statement ("INSERT INTO ic_notifications (`from_user`,`to_user`,`msg`,`read_status`) VALUES ('" . $from . "','" . $to_user. "','" . $msg . "',0)")) {
		 		echo "Saved successfully!";
		 	} else {
		 		echo "Error!";
		 	}
		}

		
		

	}

	public function sendremoteMessage()
	{
		$to = Input::get('to');
		$msg = Input::get('msg');
		$from = Input::get('from');
		
		if (DB::statement ("INSERT INTO ic_notifications (`from_user`,`to_user`,`msg`,`read_status`) VALUES ('" . $from . "','" . $to. "','" . $msg . "',0)")) {
		 		echo "Saved successfully!";
		} else {
		 		echo "Error!";
		}
		

		
		

	}


}
