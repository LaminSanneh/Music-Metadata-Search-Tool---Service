<?php

class Role extends \Eloquent {
	protected $fillable = ['name'];

    /**
     * Get the users with a certain role
     */
    public function users(){
        return $this->belongsToMany('\User');
    }
}