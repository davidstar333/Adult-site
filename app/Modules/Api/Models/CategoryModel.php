<?php

namespace App\Modules\Api\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model {
    protected $table = "categories";
    protected $guarded = [];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public static function archives(){
        static $categories = null;
        if (!$categories) {
            $categories = static::all();
        }

        return $categories;
    }

    public function performer() {
        return $this->belongsTo(PerformerModel::class);
    }

    public function save(array $options = array()) {
        $this->slug = str_slug($this->name);
        parent::save($options);
    }
}
