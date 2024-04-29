<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class Community extends Model
{
    use HasDateTimeFormatter;
    public $timestamps = true;
    protected $table   = 'communities';
}
