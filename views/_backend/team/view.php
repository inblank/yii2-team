<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model inblank\team\models\Team */

$isSport = Yii::$app->getModule('team')->mode === \inblank\team\Module::MODE_SPORT;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('team_backend', 'Teams'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;

/** @var \yii\web\UrlManager $frontendUrlManager */
$frontendUrlManager = $this->params['frontendUrlManager'];
?>
<div class="team-view">

    <h1><?= Yii::t('team_general', 'Team').' <span class="team-name">'.Html::encode($this->title).'</span>' ?></h1>

    <div class="view-header">
        <?php
        if($model->disbanded_at===null) {
            if(Yii::$app->user->can('team_updateTeam', ['model'=>$model])) {
                echo Html::a(Yii::t('team_backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            }
            if(Yii::$app->user->can('team_deleteTeam', ['model'=>$model])) {
                echo Html::a(Yii::t('team_backend', 'Disband'), ['disband', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('team_backend', 'Are you sure you want to disband this team?'),
                        'method' => 'post',
                    ],
                ]);
            }
        } else {
            echo Html::tag('div', Yii::t('team_general', 'Team disbanded'), ['class'=>'team-disband']);
        }
        echo Html::a(Yii::t('team_backend', $isSport ? 'Players list' : 'Members list'), ['members', 'id' => $model->id], ['class' => 'btn btn-warning']);
        ?>
    </div>

    <div class="team-view">
        <div class="team-info">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label'=>Yii::t('team_general', 'Creator'),
                        'attribute'=>'creator.name',
                    ],
                    [
                        'label'=>Yii::t('team_general', 'Owner'),
                        'attribute'=>'owner.name',
                    ],
                    [
                        'label'=>Yii::t('team_general', 'Team page'),
                        'format'=>'raw',
                        'value'=>Html::a(Yii::t('team_general', 'View'), $frontendUrlManager->createUrl(['/team/team/view', 'team'=>$model->slug])),
                    ],
                    'name',
                    'description:raw',
                    'created_at:date',
                    'disbanded_at:date',
                ],
            ]) ?>
        </div>
    </div>

</div>
