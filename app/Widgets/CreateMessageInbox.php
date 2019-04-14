<?php

namespace App\Widgets;
use App\Modules\Api\Models\UserModel;
use App\Modules\Api\Models\MessageModel;
use Arrilot\Widgets\AbstractWidget;

class CreateMessageInbox extends AbstractWidget
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
    //Run Widget Message inbox
    public function run($msgInbox,$routing)
    {
        return view("widgets.create_message_inbox", [
            'msgInbox' => $msgInbox,
            'routing' => $routing,
        ]);
    }
}