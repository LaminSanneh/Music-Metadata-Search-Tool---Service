<?php

class Album extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

    public function artist(){
        return $this->belongsTo('artist');
    }

    public function songs(){
        return $this->hasMany('song');
    }
}
