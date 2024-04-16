<?php

namespace App\Models;

use Illuminate\Support\Str;
use Dcat\Admin\Traits\ModelTree;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class CheckItem extends BaseModel
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
