<?php

namespace App\Models;

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class CheckItem extends Model
{
    use ModelTree;
    use HasDateTimeFormatter;

    protected $fillable = [
        'title',
        'parent_id',
        'rectify_content',
        'check_method',
        'order_by',
        'type',
        'check_type',
        'total_score',
    ];
    protected $table       = 'check_items';
    protected $orderColumn = 'order_by';
    protected $depthColumn = 'type';

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

    public const DIFFICULTY_EASY   = 1;
    public const DIFFICULTY_MEDIUM = 2;
    public const DIFFICULTY_HARD   = 3;

    public static array $formatDifficultyMaps = [
        self::DIFFICULTY_EASY   => '容易',
        self::DIFFICULTY_MEDIUM => '中等',
        self::DIFFICULTY_HARD   => '困难',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * Get options for Select field in form.
     *
     * @param  \Closure|null  $closure
     * @return array
     */
    public static function selectOptions(\Closure $closure = null, $rootText = null)
    {
        $rootText = $rootText ?: admin_trans_label('root');

        $options = (new static())->withQuery($closure)->buildSelectOptions();

        return collect($options)->prepend($rootText, 0)->all();
    }
}
