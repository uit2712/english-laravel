<?php

namespace App\Http\Controllers;

use Core\Features\Group\Facades\GroupApi;

class GroupController extends Controller
{
    public function index()
    {
        return GroupApi::getAll();
    }
}
