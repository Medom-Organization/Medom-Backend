<?php

namespace Medom\Modules\Auth\Api\v1\Transformers;

use League\Fractal;
use Medom\Modules\Auth\Models\Role;

class RoleTransformer extends Fractal\TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id' => $role->_id,
            'name' => $role->display_name,
        ];
    }

}