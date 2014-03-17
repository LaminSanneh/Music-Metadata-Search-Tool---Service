<?php

class ApiKey extends \Eloquent {
	protected $fillable = ['key','is_active','domain'];

    public function user(){
        return $this->belongsTo('\User');
    }
}