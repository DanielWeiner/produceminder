<?php
class Alert extends Eloquent {
	protected $table = 'alert';

	public function user() {
		return $this->belongsTo('User');
	}
}