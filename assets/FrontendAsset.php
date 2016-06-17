<?php

namespace inblank\team\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $sourcePath = '@inblank/team/assets/files';
    public $css = [
        'css/frontend.css',
    ];
    public $js = [
        'js/frontend.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
