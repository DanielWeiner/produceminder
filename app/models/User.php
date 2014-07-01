<?php

class User extends Eloquent{
	protected $table = 'user';
	public $timestamps = false;

	public function alerts() {
		return $this->hasMany('Alert');
	}
}
