<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class CollectImage extends Model
{
    use HasDateTimeFormatter;
    public $timestamps = false;
}
