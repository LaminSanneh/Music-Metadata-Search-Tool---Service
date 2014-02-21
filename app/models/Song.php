<?php

class Song extends Eloquent {
	protected $guarded = array();
	protected $fillable = array('name');

	public static $rules = array();
}
