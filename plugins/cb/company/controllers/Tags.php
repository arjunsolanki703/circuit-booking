<?php namespace Cb\Company\Controllers;

use BackendMenu;
use Flash;
use Lang;
use Cb\Company\Models\Tag;

/**
 * Tags Back-end Controller
 */
class Tags extends Controller
{

    public $requiredPermissions = ['cb.company.access_services'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Cb.Company', 'company', 'tags');
    }

    /**
     * Deleted checked tags.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $tagId) {
                if (!$tag = Tag::find($tagId)) continue;
                $tag->delete();
            }

            Flash::success(Lang::get('cb.company::lang.tags.delete_selected_success'));
        } else {
            Flash::error(Lang::get('cb.company::lang.tags.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
