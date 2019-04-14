<?php

namespace App\Widgets;
use Arrilot\Widgets\AbstractWidget;

class CreateMessageTrash extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function placeholder()
    {
        return 'Loading....';
    }
    //Run Widget Message Strash
    public function run($msgTrash, $routing)
    {
        return view("widgets.create_message_trash", [
            'msgTrash' => $msgTrash,
            'routing' =>$routing
        ]);


    }
}