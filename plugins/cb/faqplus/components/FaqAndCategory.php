<?php namespace Cb\FaqPlus\Components;

use Cms\Classes\ComponentBase;
use RedMarlin\Faq\Models\Question;
use RedMarlin\Faq\Models\Category;

class FaqAndCategory extends ComponentBase
{
    public $faqCategories;

    public function componentDetails()
    {
        return [
            'name'        => 'FAQ - Display All with categories',
            'description' => 'Displays list of FAQs from all categories'
        ];
    }

    public function defineProperties()
    {
        return [
            'sortOrder' => [
                'title'             => 'Sort Order',
                'description'       => 'Choose sort ordering method. Default newest questions first',
                'default'           => 'desc',
                'type'              => 'dropdown',
                'placeholder'       => 'Select sort order',
                'options'           => ['desc'=>'Newest first', 'asc'=>'Oldest first', 'order'=>'User order']
            ]
        ];
    }

    public function onRun()
    {
        $order = $this->property('sortOrder');
        $categories = Category::with(['question' => function ($query) use ($order) {
            $query->whereIsApproved('1');
            switch ($order) {
                case "desc":
                    $query = $query->orderBy('id', 'desc');
                    break;
                case "asc":
                    $query = $query->orderBy('id', 'asc');
                    break;
                case "order":
                    $query = $query->orderBy('sort_order');
                    break;
            }
        }])->get();
        $this->faqCategories = $categories;
    }
}