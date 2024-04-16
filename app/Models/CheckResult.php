<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;

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
        'firm_id',
    ];

    public const STATUS_NORMAL  = 1;
    public const STATUS_BAD     = 2;
    public const STATUS_UNSAVED = 3;

    public static array $formatStatusMaps = [
        self::STATUS_NORMAL  => '合格',
        self::STATUS_BAD     => '不合格',
        self::STATUS_UNSAVED => '未保存',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class, 'firm_id','uuid');
    }
}
