<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ClientApp
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $unReadNotifications = authClient()->user()->unReadNotifications;

        $readNotifications = [];

        if ($unReadNotifications->count() < 3) {
            $readNotifications = authClient()->user()->readNotifications()->limit(3)->get();
        }

        $view->with([
            'unReadNotifications' => $unReadNotifications,
            'readNotifications' => $readNotifications,
        ]);
    }

}
