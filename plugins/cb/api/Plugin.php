<?php

namespace Cb\Api;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return  array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Api Extension',
            'description' => 'Api',
            'author' => '',
        ];
    }

}
