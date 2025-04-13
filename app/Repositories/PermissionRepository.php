<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Support\Collection;
use App\Models\Model;

class PermissionRepository extends BaseRepository
{
    /**
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    /**
    * @return Collection<int, Model>
    */
    public function all(): Collection
    {
        return $this->model->all();
    }
}