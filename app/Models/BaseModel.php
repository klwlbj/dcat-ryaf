<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
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

    /**
     * 检查类型
     * @var array|string[]
     */
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
}
