<?php

namespace App;


class Person 
{
	
	public $first_name;
	public $last_name;
	public $age;
	public $email;
	public $secret;
 	public $name;
   

 	public function __construct($parms) {
	 	$this->first_name = $parms['first_name'] ?? '';
	 	$this->last_name = $parms['last_name'] ?? '';
	 	$this->age = $parms['age'] ?? '';
	 	$this->email = $parms['email'] ?? '';
	 	$this->secret = $parms['secret'] ?? '';
	 	$this->name =$this->first_name  . ' ' .  $this->last_name;
	}
	
	public function toArray() {
		return (array) $this;
	}
}
