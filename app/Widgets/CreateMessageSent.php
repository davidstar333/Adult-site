<?php

namespace App\Widgets;
use Arrilot\Widgets\AbstractWidget;

class CreateMessageSent extends AbstractWidget
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
    //Run Widget Message Sent
    public function run($msgSent, $routing )
    {
        return view("widgets.create_message_sent", [
            'msgSent' => $msgSent,
            'routing' =>$routing
        ]);
    }
}