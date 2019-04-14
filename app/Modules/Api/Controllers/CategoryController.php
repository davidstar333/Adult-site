<?php

namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Models\CategoryModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Repositories\Categories;

class CategoryController extends Controller {
    /*
     * response  object
     * 
     *    */

    public function findAll(Categories $categories) {
        
        return $categories->all();
    }

    /**
     * @param string $name category name
     * @author Phong Le <pt.hongphong@gmail.com>
     * @return Response
     */
    public function checkName() {
        $validator = Validator::make(Input::all(), [
                    'name' => 'unique:categories|required',
        ]);
        if ($validator->fails()) {
            return Response()->json(array('success' => false, 'error' => $validator->errors()->first('name')));
        }
        return Response()->json(array('success' => true));
    }

    /**
     * @param string $name category name
     * @author Phong Le <pt.hongphong@gmail.com>
     * @return response new category
     */
    public function store() {
        $validator = Validator::make(Input::all(), [
                    'name' => 'unique:categories|required',
        ]);
        if ($validator->fails()) {
            return Response()->json(array('success' => false, 'error' => $validator->errors()->first('name')));
        }
        
        $category = CategoryModel::create(Input::only('name'));
        return Response()->json(array('success' => true, 'message' => 'Category was successfully added.', 'category' => $category));

    }

    /**
     * @param string $name category name
     * @author Phong Le <pt.hongphong@gmail.com>
     * @return response category
     */
    public function update(CategoryModel $category) {
        $validator = Validator::make(Input::all(), [
                    'name' => 'unique:categories,name,' . $category->id . '|required',
        ]);
        if ($validator->fails()) {
            return Response()->json(array('success' => false, 'error' => $validator->errors()->first('name')));
        }
        $category->update(Input::only('name'));
        return Response()->json(array('success' => true, 'message' => 'Category was successfully updated.', 'category' => $category));

    }

    /**
     * @author Phong Le <pt.hongphong@gmail.com>
     * @param int $id category id
     * @return response
     */
    public function destroy(CategoryModel $category) {
        
        if ($category->delete()) {
            return Response()->json(array('success' => true, 'message' => 'Category was successfully deleted.'));
        } else {
            return Response()->json(array('success' => false, 'message' => 'System error, cannot delete category.'));
        }
    }

}
