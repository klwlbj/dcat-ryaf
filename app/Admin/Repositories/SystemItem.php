<?php

namespace App\Admin\Repositories;

use App\Models\SystemItem as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class SystemItem extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
