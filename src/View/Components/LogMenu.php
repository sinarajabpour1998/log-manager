<?php

namespace Sinarajabpour1998\LogManager\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LogMenu extends Component
{
    /**
     * The type of menu, modules or manager
     * @var
     */
    public $type;

    public function __construct()
    {

    }

    public function render()
    {
        return view('vendor.LogManager.components.log_menu');
    }
}
