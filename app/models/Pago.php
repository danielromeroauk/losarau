<?php

class Pago extends \Eloquent {

	protected $fillable = [];

	protected $table = 'pagos';

	public function user()
	{
		return $this->belongsTo('User');
	}

} #Pago