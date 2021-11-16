<?php

namespace Sinarajabpour1998\LogManager\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Sinarajabpour1998\LogManager\Facades\LogFacade;

class LogMenu extends Component
{
    /**
     * The type of menu, modules or manager
     * @var
     */
    public $type, $error_log_count = 0;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

    public function render()
    {
        switch ($this->type){
            case "error-log-counter":
                $this->getErrorLogCount();
                return view('vendor.LogManager.components.error_log_counter');
            default:
                return view('vendor.LogManager.components.log_menu');
        }
    }

    protected function getErrorLogCount()
    {
        $this->error_log_count = LogFacade::getErrorLogCount();
    }
}
