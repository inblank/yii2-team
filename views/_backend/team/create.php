<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model inblank\team\models\Team */

$this->title = Yii::t('team_backend', 'Create Team');
$this->params['breadcrumbs'][] = ['label' => Yii::t('team_backend', 'Teams'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
