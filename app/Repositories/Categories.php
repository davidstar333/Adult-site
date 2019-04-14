<?php

namespace App\Repositories;

use App\Modules\Api\Models\CategoryModel;

class Categories {

    public function all() {
        return CategoryModel::all();
    }

}
