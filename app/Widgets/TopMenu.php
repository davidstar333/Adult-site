<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Modules\Api\Models\CategoryModel;

class TopMenu extends AbstractWidget {
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view("widgets.top_menu", [
            'categories' => Categorymodel::archives()
        ]);
    }
}
