<?php namespace Cb\Company\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use Cb\Company\Models\Tag;
use Cb\Company\Models\Role;

class Component extends ComponentBase
{

    public $item;
    public $list;
    public $table;

    public function componentDetails()
    {
    }

    public function defineProperties()
    {
        return [
            'itemId' => [
                'title' => 'cb.company::lang.labels.item_id',
                'description' => 'cb.company::lang.descriptions.item_id',
                'default' => '{{ :model }}',
            ],
            'modelIdentifier' => [
                'title' => 'cb.company::lang.misc.model_identifier',
                'description' => 'cb.company::lang.descriptions.model_identifier',
                'type' => 'dropdown',
                'options' => ['id' => 'id', 'slug' => 'slug'],
                'default' => 'id',
            ],
            'maxItems' => [
                'title' => 'cb.company::lang.labels.max_items',
                'description' => 'cb.company::lang.descriptions.max_items',
                'default' => 36,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
            ],
            'orderBy' => [
                'title' => 'cb.company::lang.labels.order_by',
                'description' => 'cb.company::lang.descriptions.order_by',
                'type' => 'dropdown',
                'default' => 'id',
                'group' => 'cb.company::lang.labels.order',
            ],
            'sort' => [
                'title' => 'cb.company::lang.labels.sort',
                'description' => 'cb.company::lang.descriptions.sort',
                'type' => 'dropdown',
                'default' => 'desc',
                'group' => 'cb.company::lang.labels.order',
            ],
            'paginate' => [
                'title' => 'cb.company::lang.labels.paginate',
                'description' => 'cb.company::lang.descriptions.paginate',
                'type' => 'checkbox',
                'default' => false,
                'group' => 'cb.company::lang.labels.paginate',
            ],
            'page' => [
                'title' => 'cb.company::lang.labels.page',
                'description' => 'cb.company::lang.descriptions.page',
                'type' => 'string',
                'default' => '1',
                'validationPattern' => '^[0-9]+$',
                'group' => 'cb.company::lang.labels.paginate',
            ],
            'perPage' => [
                'title' => 'cb.company::lang.labels.per_page',
                'description' => 'cb.company::lang.descriptions.per_page',
                'type' => 'string',
                'default' => '12',
                'validationPattern' => '^[0-9]+$',
                'group' => 'cb.company::lang.labels.paginate',
            ],
        ];
    }

    public function getSortOptions()
    {
        return [
            'desc' => Lang::get('cb.company::lang.labels.descending'),
            'asc' => Lang::get('cb.company::lang.labels.ascending'),
        ];
    }

    public function getOrderByOptions()
    {
        $schema = Schema::getColumnListing($this->table);
        foreach ($schema as $column) {
            $options[$column] = ucwords(str_replace('_', ' ', $column));
        }
        return $options;
    }

}
