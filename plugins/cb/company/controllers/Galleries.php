<?php namespace Cb\Company\Controllers;

use BackendMenu;
use Flash;
use Cb\Company\Models\Gallery;
use Lang;

/**
 * Galleries Back-end Controller
 */
class Galleries extends Controller
{

    public $requiredPermissions = ['cb.company.access_galleries'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Cb.Company', 'company', 'galleries');
    }

    /**
     * Deleted checked galleries.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $galleryId) {
                if (!$gallery = Gallery::find($galleryId)) {
                    continue;
                }

                $gallery->delete();
            }

            Flash::success(Lang::get('cb.company::lang.galleries.delete_selected_success'));
        } else {
            Flash::error(Lang::get('cb.company::lang.galleries.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
