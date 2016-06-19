<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel inblank\team\models\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('team_backend', 'Teams');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(Yii::$app->user->can('team_createTeam')):?>
    <p>
        <?= Html::a(Yii::t('team_backend', 'Create Team'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif;?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class'=>'team-list',
        ],
        'tableOptions'=>[
            'class'=>'table table-striped table-bordered table-hover',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',
            // 'description:ntext',
            'founded_at:date',
            'disbanded_at:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{members} {view} {update} {disband}',
                'contentOptions'=>[
                    'class'=>'list-action',
                ],
                'visibleButtons' => [
                    'update' => function($model){
                        /** @var inblank\team\models\Team $model */
                        return  $model->disbanded_at===null && Yii::$app->user->can('team_updateTeam', ['model'=>$model]);
                    },
                    'disband' => function($model){
                        /** @var inblank\team\models\Team $model */
                        return  $model->disbanded_at===null && Yii::$app->user->can('team_deleteTeam', ['model'=>$model]);
                    },
                ],
                'buttons' => [
                    'disband' => function ($url) {
                        $options = [
                            'title' => Yii::t('team_backend', 'Dismiss'),
                            'aria-label' => Yii::t('team_backend', 'Dismiss'),
                            'data-confirm' => Yii::t('team_backend', 'Are you sure you want to disband this team?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', $url, $options);
                    },
                    'members' => function ($url) {
                        $options = [
                            'title' => Yii::t('team_backend', 'Members list'),
                            'aria-label' => Yii::t('team_backend', 'Members list'),
                        ];
                        return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, $options);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
