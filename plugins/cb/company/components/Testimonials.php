<?php namespace Cb\Company\Components;

use Cb\Company\Models\Testimonial;

class Testimonials extends Component
{
    public $table = 'hambern_company_testimonials';

    public function componentDetails()
    {
        return [
            'name' => 'cb.company::lang.components.testimonials.name',
            'description' => 'cb.company::lang.components.testimonials.description',
        ];
    }

    public function onRun()
    {
        $this->page['testimonial'] = $this->testimonial();
        $this->page['testimonials'] = $this->testimonials();
    }

    public function testimonial()
    {
        if (!empty($this->property('itemId'))) {
            if ($this->item) return $this->item;
            return $this->item = Testimonial::where($this->property('modelIdentifier', 'id'), $this->property('itemId'))
                ->with('picture')
                ->first();
        }
    }

    public function testimonials()
    {
        if (empty($this->property('itemId'))) {
            if ($this->list) return $this->list;
            $testimonials = Testimonial::published()
                ->with('picture')
                ->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
                ->take($this->property('maxItems'));

            return $this->list = $this->property('paginate') ?
                $testimonials->paginate($this->property('perPage'), $this->property('page')) :
                $testimonials->get();
        }
    }

    public function defineProperties()
    {
        $properties = parent::defineProperties();

        $properties['modelIdentifier'] = [
            'title' => 'cb.company::lang.misc.model_identifier',
            'description' => 'cb.company::lang.descriptions.model_identifier',
            'type' => 'dropdown',
            'options' => ['id' => 'id'],
            'default' => 'id',
        ];

        return $properties;
    }
}
