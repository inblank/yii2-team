<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model inblank\team\models\Speciality */

$this->title = Yii::t('team_backend', 'Create Speciality');
$this->params['breadcrumbs'][] = ['label' => Yii::t('team_backend', 'Member Specialities'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
