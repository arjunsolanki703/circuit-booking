<?php namespace Cb\UserPlus\Controllers\Car2DB;

use Backend\Classes\Controller;
use Cb\Car2db\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $model_id = $request->input('model_id');
        $query = Serie::query();

        if ($model_id) {
            $query = $query->where('id_model', $model_id);
        }
        return $query->get();
    }
}
