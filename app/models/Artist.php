<?php

class Artist extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

    public function albums(){
        return $this->hasMany('album');
    }
}
