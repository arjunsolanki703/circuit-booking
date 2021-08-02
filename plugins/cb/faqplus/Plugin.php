<?php namespace Cb\FaqPlus;

use System\Classes\PluginBase;
use Lang;

class Plugin extends PluginBase
{
    public $require = ['RedMarlin.Faq'];

    public function registerComponents()
    {
        return [
            'Cb\FaqPlus\Components\FaqAndCategory' => 'FaqAndCategory'
        ];
    }
}
