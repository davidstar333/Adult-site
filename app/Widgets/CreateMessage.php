<?php

namespace App\Widgets;
use App\Modules\Api\Models\UserModel;
use Arrilot\Widgets\AbstractWidget;

class CreateMessage extends AbstractWidget
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
    public function run($messageTo,$routing)
    {
        if($messageTo !== NULL){
            $getReceiver= UserModel::where('username','=',$messageTo)->first();
            return view("widgets.create_message", [
            'config' => $this->config,
            'messageTo' => $getReceiver,
            'routing' => $routing
            ]);
        }else{
            return view("widgets.create_message", [
            'config' => $this->config,
            ]);
        }

    }
}