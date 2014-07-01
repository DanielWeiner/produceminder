<?php
	class ApiToken extends Eloquent {
		protected $table = 'apitoken';
		public $timestamps = false;

		public static function user($token) {
			$apiToken = static::where('value', $token)->first();
			if ($apiToken) {
				return User::find($apiToken->id);
			}
			return null;
		}
	}