<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Books extends Eloquent {

	protected $fillable = ['title'];
	public $timestamp = false;
}
