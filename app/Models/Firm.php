<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class Firm extends Model
{
    use HasDateTimeFormatter;

    public const CHECK_TYPE_THREE_SMALL      = 1;
    public const CHECK_TYPE_RENTAL_HOUSE     = 2;
    public const CHECK_TYPE_PUBLIC_PLACE     = 3;
    public const CHECK_TYPE_INDUSTRIAL       = 4;
    public const CHECK_TYPE_SYNTHESIS        = 5;
    public const CHECK_TYPE_RESIDENTIAL      = 6;
    public const CHECK_TYPE_ELECTRIC_VEHICLE = 7;
    public const CHECK_TYPE_UNIT_CHECK       = 8;
    public const CHECK_TYPE_ELECTRICAL_CHECK = 9;
    public const CHECK_TYPE_GAS_CHECK        = 10;
    public const CHECK_TYPE_FIRE_CHECK       = 11;

    public static array $formatCheckTypeMaps = [
        self::CHECK_TYPE_THREE_SMALL      => '三小场所',
        self::CHECK_TYPE_RENTAL_HOUSE     => '出租屋',
        self::CHECK_TYPE_PUBLIC_PLACE     => '公共建筑',
        self::CHECK_TYPE_INDUSTRIAL       => '工业建筑',
        self::CHECK_TYPE_SYNTHESIS        => '综合体',
        self::CHECK_TYPE_RESIDENTIAL      => '民宿',
        self::CHECK_TYPE_ELECTRIC_VEHICLE => '电动自行车停放充电场所建设',
        self::CHECK_TYPE_UNIT_CHECK       => '单位安全生产排查',
        self::CHECK_TYPE_ELECTRICAL_CHECK => '电气线路用气消防安全隐患排查及检测',
        self::CHECK_TYPE_GAS_CHECK        => '用气安全隐患排查及检测',
        self::CHECK_TYPE_FIRE_CHECK       => '消防安全隐患排查及检测',
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

    public const CHECK_RESULT_PASS     = 1;
    public const CHECK_RESULT_NOT_PASS = 2;

    public static array $formatCheckResultMaps = [
        self::CHECK_RESULT_PASS     => '合格',
        self::CHECK_RESULT_NOT_PASS => '不合格',
    ];
}
