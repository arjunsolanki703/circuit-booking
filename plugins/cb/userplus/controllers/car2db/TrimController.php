<?php namespace Cb\UserPlus\Controllers\Car2DB;

use Backend\Classes\Controller;
use Cb\Car2db\Models\Trim;
use Illuminate\Http\Request;

class TrimController extends Controller
{
    public function index(Request $request)
    {
        $model_id = $request->input('model_id');
        $serie_id = $request->input('serie_id');
        $query = Trim::query();

        if ($model_id) {
            $query = $query->where('id_model', $model_id);
        }

        if ($serie_id) {
            $query = $query->where('id_serie', $serie_id);
        }

        return $query->get();
    }
}
