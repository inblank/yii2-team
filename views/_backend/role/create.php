<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model inblank\team\models\Role */

$this->title = Yii::t('team_backend', 'Create Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('team_backend', 'Team Roles'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
