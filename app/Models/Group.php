<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	use HasDateTimeFormatter;    
    public $timestamps = false;

}
