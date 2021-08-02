<?php namespace Cb\UserPlus\Controllers\Car2DB;

use Backend\Classes\Controller;
use Cb\Car2db\Models\Make;

class MakeController extends Controller
{
    public function index()
    {
        return Make::all();
    }
}
