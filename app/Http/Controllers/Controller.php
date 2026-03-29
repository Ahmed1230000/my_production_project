<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseLaravelController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseLaravelController
{
    use AuthorizesRequests;
    //
}
