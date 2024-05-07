<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Support\Str;

class CheckResult extends Model
{
    use HasDateTimeFormatter;
    public $timestamps  = false;
    protected $fillable = [
        'report_code',
        'status',
        'check_result',
        'total_point',
        'deduction_point',
        'rectify_number',
        'firm_id',
    ];

    protected $casts = [
        'history_check_item' => 'json',
    ];

    public const STATUS_NORMAL  = 1;
    public const STATUS_BAD     = 2;
    public const STATUS_UNSAVED = 3;

    public static array $formatStatusMaps = [
        self::STATUS_NORMAL  => '合格',
        self::STATUS_BAD     => '不合格',
        self::STATUS_UNSAVED => '未保存',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->report_code = (string) Str::uuid();
        });
    }

    public function firm()
    {
        return $this->belongsTo(Firm::class, 'firm_id', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'check_user_id', 'id');
    }
}
