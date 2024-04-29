<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Scope\SelfSystemItem;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class Firm extends BaseModel
{
    use HasDateTimeFormatter;

    protected $fillable = [
        'name',
        'status',
        'community',
        'head_man',
        'check_type',
        'phone',
        'floor',
        'area_quantity',
        'custom_number',
        'address',
        'community',
        'system_item_id',
        'remark',
    ];

    public const STATUS_WAIT            = 1;
    public const STATUS_CHECKED         = 2;
    public const STATUS_REVIEWED        = 3;
    public const STATUS_REMOVED         = 4;
    public const STATUS_CLOSED          = 5;
    public const STATUS_LOCKED          = 6;
    public const STATUS_NOT_FOUND       = 7;
    public const STATUS_SYSTEM_DELETE   = 8;
    public const STATUS_SELF_OCCUPATION = 9;
    public const STATUS_SEAL_UP         = 10;
    public const STATUS_REPEAT          = 11;
    public const STATUS_FITMENT         = 12;
    public const STATUS_DISASSEMBLE     = 13;
    public const STATUS_VACANCY         = 14;

    public static array $formatStatusMaps = [
        self::STATUS_WAIT            => '待查',
        self::STATUS_CHECKED         => '已检查',
        self::STATUS_REVIEWED        => '已复查',
        self::STATUS_REMOVED         => '搬迁',
        self::STATUS_CLOSED          => '停业',
        self::STATUS_LOCKED          => '锁门',
        self::STATUS_NOT_FOUND       => '找不到',
        self::STATUS_SYSTEM_DELETE   => '系统删除',
        self::STATUS_SELF_OCCUPATION => '自住',
        self::STATUS_SEAL_UP         => '查封',
        self::STATUS_REPEAT          => '重复',
        self::STATUS_FITMENT         => '装修',
        self::STATUS_DISASSEMBLE     => '拆除',
        self::STATUS_VACANCY         => '空置',
    ];

    public const CHECK_RESULT_DEFAULT  = 0;
    public const CHECK_RESULT_PASS     = 1;
    public const CHECK_RESULT_NOT_PASS = 2;

    public static array $formatCheckResultMaps = [
        self::CHECK_RESULT_DEFAULT  => '未知',
        self::CHECK_RESULT_PASS     => '合格',
        self::CHECK_RESULT_NOT_PASS => '不合格',
    ];

    /**
     * 模型的「引导」方法。
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new SelfSystemItem());
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function checkResults()
    {
        return $this->hasMany(CheckResult::class, 'uuid', 'firm_id');
    }
}
