<?php
	class ApiToken extends Eloquent {
		protected $table = 'apitoken';
		public $timestamps = false;

		function user($token) {
			return User::find(static::where('value', $token)->first()->id);
		}
	}