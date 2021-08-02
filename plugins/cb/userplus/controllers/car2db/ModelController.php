<?php namespace Cb\UserPlus\Controllers\Car2DB;

use Backend\Classes\Controller;
use Cb\Car2db\Models\Model;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index(Request $request)
    {
        $make_id = $request->input('make_id');
        $query = Model::query();

        if ($make_id) {
            $query = $query->where('id_make', $make_id);
        }
        return $query->get();
    }
}
