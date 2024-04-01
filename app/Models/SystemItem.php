<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class SystemItem extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'system_items';
    
}
