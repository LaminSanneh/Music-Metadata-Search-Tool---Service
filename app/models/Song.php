<?php

class Song extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

    public function album(){
        return $this->belongsTo('album');
    }
}
