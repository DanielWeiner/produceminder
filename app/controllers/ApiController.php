<?php

class ApiController extends BaseController {
	public function getUser($id) {
		$user = User::find($id);
		return Response::json($user);
	}
	public function deleteUser($id) {
		$user = User::find($id);
		$reponse = Response::json($user);
		$user->delete();
		return $reponse;
	}
	public function createUser() {
		$user = new User;
		$user->first_name = Input::get('firstName', 'Daniel');
		$user->last_name = Input::get('lastName', 'Weiner');
		$user->password = Hash::make(Input::get('password', 'pass123'));
		$user->save();
		return Response::json($user);
	}
	public function getUserFromApiToken() {
		$apiToken = Input::get('apiToken');
		$tokenObject = ApiToken::find($apiToken);
		if ($tokenObject) {
			$user = User::find($tokenObject->user_id);
			return Response::json(["data" => $user, "apiToken" => $apiToken]);
		}
		return Response::json(["data" => null, "apiToken" => null]);
	}
}