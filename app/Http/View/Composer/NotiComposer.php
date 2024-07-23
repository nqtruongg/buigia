<?php

namespace App\Http\View\Composer;

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Home\HomeController;
use Illuminate\View\View;

class NotiComposer
{
    protected $noti1;
    protected $noti7;
    protected $noti30;

    public function __construct(HomeController $noti1, HomeController $noti7, HomeController $noti30)
    {
        $this->noti1 = $noti1->noti_1();
        $this->noti7 = $noti7->noti_7();
        $this->noti30 = $noti30->noti_30();
    }

    public function compose(View $view)
    {
        $count = $this->noti1 + $this->noti7 + $this->noti30;
        $view->with('noti1', $this->noti1);
        $view->with('noti7', $this->noti7);
        $view->with('noti30', $this->noti30);
        $view->with('count', $count);
    }
}
