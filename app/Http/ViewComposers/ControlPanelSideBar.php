<?php
namespace App\Http\ViewComposers;

use App\Http\Helper\NewRequests;
use Illuminate\View\View;

class ControlPanelSideBar
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('notifications', NewRequests::getInstance()->getRequests());
    }

}
