<?php

class Estado extends \Eloquent {

	protected $fillable = [];

	protected $table = 'estados';

	public function user()
	{
		return $this->belongsTo('User');
	}

} #Estado