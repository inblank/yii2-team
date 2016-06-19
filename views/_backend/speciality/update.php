<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model inblank\team\models\Speciality */

$this->title = Yii::t('team_backend', 'Update Speciality') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('team_backend', 'Member Specialities'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('team_backend', 'Update');
?>
<div class="speciality-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
