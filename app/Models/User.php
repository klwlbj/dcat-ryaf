<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasDateTimeFormatter;

    public const TYPE_FOREGROUND = 1;

    public static array $formatTypeMaps = [
        self::TYPE_FOREGROUND => '前台',
    ];

    public const STATUS_NORMAL = 1;
    public const STATUS_STOP   = 2;

    public static array $formatStatusMaps = [
        self::STATUS_NORMAL => '正常',
        self::STATUS_STOP   => '停用',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id','id');
    }

    public function checkResults()
    {
        return $this->hasMany(CheckResult::class, 'check_user_id','id');
    }
}
