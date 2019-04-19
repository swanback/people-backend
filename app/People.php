<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $fillable = ['email_addresses',
    						 'sorted_payload',
    						 'source_ip_address',
    						 'posted_at'
    						 ];
    						 
}
