<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class CheckQuestion extends Model
{
    use HasDateTimeFormatter;
    public $timestamps = false;

    public const DIFFICULTY_EASY   = 1;
    public const DIFFICULTY_MEDIUM = 2;
    public const DIFFICULTY_HARD   = 3;

    public static array $formatDifficultyMaps = [
        self::DIFFICULTY_EASY   => '容易',
        self::DIFFICULTY_MEDIUM => '一般',
        self::DIFFICULTY_HARD   => '困难',
    ];
}
