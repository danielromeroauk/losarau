<?php

class Abono extends \Eloquent {

	protected $fillable = [];

	protected $table = 'abonos';

	public function user()
	{
		return $this->belongsTo('User');
	}

}