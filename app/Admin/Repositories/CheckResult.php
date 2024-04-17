<?php

namespace App\Admin\Repositories;

use App\Models\CheckResult as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class CheckResult extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
