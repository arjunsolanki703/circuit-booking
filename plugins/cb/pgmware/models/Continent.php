<?php namespace Cb\Pgmware\Models;

use Model;
use RainLab\Location\Models\Country as CountryModel;
use Cb\Pgmware\Models\Location as LocationModel;
use Cb\Pgmware\Models\Variant as VariantModel;
use Cms\Classes\Page as CmsPage;
use Url;

/**
 * Model
 */
class Continent extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Behaviours implemented by this model.
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name', 'description'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'cb_pgmware_continents';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required|between:2,191',
        'code' => 'required|between:1,3',
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'description'
    ];

    public $hasMany = [
        "countries" => ["RainLab\Location\Models\Country", 'conditions' => 'is_enabled = 1', 'key' => 'cb_continent_id'],
    ];

    /**
     * @var array Cache for nameList() method
     */
    protected static $nameList = null;
    
    public static function getNameList()
    {
        if (self::$nameList) {
            return self::$nameList;
        }
        return self::$nameList = self::isEnabled()->orderBy('name', 'asc')->lists('name', 'id');
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param \Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id'   => $this->id,
            'slug' => $this->code
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    public function getCountries()
    {
        $c = (new CountryModel())->table;
        $l = (new LocationModel())->table;
        $v = (new VariantModel())->table;
        $list = CountryModel::isEnabled()
                ->select($c.'.*', \DB::raw('count('.$v.'.id) as variants_count'))
                ->join($l, $l.'.country_id', '=', $c.'.id')
                ->join($v, $v.'.location_id', '=', $l.'.id')
                ->groupBy($c.'.id')
                ->where($c.'.cb_continent_id', $this->id)
                ->where($c.'.is_enabled', '1')
                ->where($l.'.deleted_at', null)
                ->where($v.'.deleted_at', null)
                ->get();
        return $list;
    }

    public static function getMenuTypeInfo($type)
    {
        if ($type == 'continent-page') {
            $references = [];
            $items = self::isEnabled()->orderBy('name')->get()->all();

            foreach ($items as $item) {
                $references[$item->id] = $item->name;
            }

            $result = [
                'references'   => $references,
                'nesting'      => false,
                'dynamicItems' => false
            ];
        }

        if ($result) {
            $pages = CmsPage::sortBy('baseFileName')->all();
            $result['cmsPages'] = $pages;
        }

        return $result;
    }

    public static function resolveMenuItem($item, $url, $theme)
    {
        $result = [];
        if ($item->type == 'continent-page') {
            if (!$item->reference || !$item->cmsPage) {
                return;
            }

            $element = self::find($item->reference);
            if (!$element) {
                return;
            }

            $pageUrl = self::getItemUrl($item->cmsPage, $element, $theme);
            if (!$pageUrl) {
                return;
            }

            $pageUrl = Url::to($pageUrl);
            $result = [];
            $result['url'] = $pageUrl;
            $result['isActive'] = $pageUrl == $url;
            $result['mtime'] = $element->updated_at;
        }

        return $result;
    }

    protected static function getItemUrl($pageCode, $item, $theme)
    {
        $page = CmsPage::loadCached($theme, $pageCode);
        if (!$page) {
            return;
        }

        $properties = $page->getComponentProperties('continent');
        if (!preg_match('/^\{\{([^\}]+)\}\}$/', $properties['continentSlug'], $matches)) {
            return;
        }

        $paramName = substr(trim($matches[1]), 1);

        return CmsPage::url($page->getBaseFileName(), [$paramName => $item->code]);
    }
}
