<?php namespace Cb\Pgmware\Components;

use Cms\Classes\ComponentBase;
use Lang;
use Request;
use Cb\Pgmware\Models\LocationFilterCircuits as LocationModel;

class FilterCircuits extends Filter
{
    public function componentDetails()
    {
        return [
            'name' => 'cb.pgmware::lang.component.filterCircuits',
            'description' => ''
        ];
    }

    public function onRun()
    {
    }

    public function init()
    {

    }

    protected function getUrl($r) {
        return $this->pageUrl('circuits/circuits-item', ["country" => $r->country_slug, "continent" => $r->continent_code, "slug" => $r->slug]);
    }

    public function onFilter()
    {
        $this->initVarsWithPost();
        $page = Request::input('page');
        $page = $page ? $page : 1;
        $perPage = $this->perPage;
        $loc = new LocationModel();
        if (Request::input('perPage')) {
            $perPage = Request::input('perPage');
        }
        $onlyGeo = false;
        if (Request::input('onlyGeo')) {
            $onlyGeo = true;
        }

        $extraFilderClass = new \stdClass();

        $variants = $loc->getByFilter(
            $this->continent,
            $this->country,
            $this->grade,
            $this->length,
            $this->vehicleType,
            $this->search,
            $perPage,
            $page,
            $extraFilderClass,
            $onlyGeo
        );

        $this->filteredVariants = $this->prepareResult($variants, $onlyGeo);
        $this->filteredVariants['superTotal'] = $loc->getFilterSuperTotal($this->continent, $this->country);

        if (Request::input('isSearch')) {
            return [
                'result' => $this->renderPartial('@search.htm'),
                'json' => $this->filteredVariants
            ];
        } else {
            return [
                'filter' => $this->renderPartial('@filter.htm'),
                'result' => $this->renderPartial('@result.htm'),
                'filterHelper' => $this->renderPartial('@filter-helper.htm'),
                'json' => $this->filteredVariants
            ];
        }
    }
}
