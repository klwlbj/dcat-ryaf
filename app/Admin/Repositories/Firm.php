<?php

namespace App\Admin\Repositories;

use App\Models\Firm as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Firm extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
