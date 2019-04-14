<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategoryModel extends Model {

    protected $table = "user_category";

    public function user() {
        return $this->belongsToMany(UserModel::class);
    }

}
