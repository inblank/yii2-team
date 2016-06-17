<?php

namespace inblank\team\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $sourcePath = '@inblank/team/assets/files';
    public $css = [
        'css/backend.css',
    ];
    public $js = [
        'js/backend.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
