<?php namespace Cb\Newsplus;

use System\Classes\PluginBase;
use Indikator\News\Models\Posts as PostsModel;

class Plugin extends PluginBase
{
    public $require = ['Indikator.News'];

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function boot()
    {
        PostsModel::extend(function($model) {
            $model->addDynamicMethod('nextPlus', function() use ($model) {
                return $model->isPublished()->applySibling(-1)->where('category_id', $model->category_id)->first();
            });
            $model->addDynamicMethod('prevPlus', function() use ($model) {
                return $model->isPublished()->applySibling()->where('category_id', $model->category_id)->first();
            });
        });
    }
}
