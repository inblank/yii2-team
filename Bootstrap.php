<?php

namespace inblank\team;

use yii;
use yii\base\Application;
use yii\console\Application as ConsoleApplication;
use yii\i18n\PhpMessageSource;
use yii\web\GroupUrlRule;

class Bootstrap implements yii\base\BootstrapInterface{

    /** @var array Model's map */
    private $_modelMap = [
    ];

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('team') && ($module = $app->getModule('team')) instanceof Module) {
            $this->_modelMap = array_merge($this->_modelMap, $module->modelMap);
            foreach ($this->_modelMap as $name => $definition) {
                $class = "inblank\\team\\models\\" . $name;
                Yii::$container->set($class, $definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
            }
            if ($app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'inblank\team\commands';
            } else {
                $configUrlRule = [
                    'prefix' => $module->urlPrefix,
                    'rules'  => defined('IS_BACKEND') ? $module->urlRulesBackend : $module->urlRulesFrontend,
                ];

                if ($module->urlPrefix != 'team') {
                    $configUrlRule['routePrefix'] = 'team';
                }

                $app->urlManager->addRules([new GroupUrlRule($configUrlRule)], false);

                if(defined('IS_BACKEND')){
                    // is backend, and controller have other namespace
                    $module->controllerNamespace = 'inblank\team\controllers\backend';
                    $module->frontendUrlManager = new yii\web\UrlManager([
                        'baseUrl'=>'/',
                        'enablePrettyUrl' => true,
                        'showScriptName' => false,
                    ]);
                    $configUrlRule['rules'] = $module->urlRulesFrontend;
                    $module->frontendUrlManager->addRules([new GroupUrlRule($configUrlRule)], false);
                }
            }
            if (!isset($app->get('i18n')->translations['team*'])) {
                $app->get('i18n')->translations['team*'] = [
                    'class'    => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                ];
            }
        }
    }
}
