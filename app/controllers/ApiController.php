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
		$user->first_name = Input::get('firstName');
		$user->last_name = Input::get('lastName');
		$user->save();
		return Response::json($user);
	}
}