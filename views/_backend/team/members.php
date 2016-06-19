<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $team inblank\team\models\Team */
/* @var $searchModel inblank\team\models\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('team_backend', 'Team {team} members', [
    'team'=>$team->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('team_backend', 'Teams'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $team->name, 'url' => ['view', 'id' => $team->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'options' => [
            'class'=>'team-list',
        ],
        'tableOptions'=>[
            'class'=>'table table-striped table-bordered table-hover',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            //'emblem:image',
            'user.name',
            [
                'label'=>Yii::t('team_general', 'Role'),
                'format'=>'html',
                'value'=>function ($model) use($team){
                    $roles = $model->roles;
                    if(emptY($roles)) {
                        $rolesList = '<span class="team-warning">' . Yii::t('team_backend', 'Not set') . '</span>';
                    }else{
                        $rolesList = [];
                        foreach($roles as $role){
                            $rolesList[] = $role->name;
                        }
                        $rolesList = implode(', ', $rolesList);
                    }
                    if($team->disbanded_at===null && Yii::$app->user->can('team_updateTeam', ['model'=>$team])){
                        $options = [
                            'class'=>'btn btn-warning btn-xs team-role-change',
                            'title'=>Yii::t('team_backend', 'Change role'),
                        ];
                        $rolesList .= Html::a(
                            '<i class="glyphicon glyphicon-refresh"></i> '.Yii::t('team_backend', 'Change'),
                            ['/team/team/changeroles', 'id'=>$team->id, 'user'=>$model->user_id],
                            $options
                        );
                    }
                    return $rolesList;
                },
            ],
            [
                'label'=>Yii::t('team_general', 'Speciality'),
                'format'=>'raw',
                'value'=>function ($model) use($team){
                    $speciality = $model->speciality;
                    $speciality = $speciality ? $speciality->name : '<span class="team-warning">'.Yii::t('team_backend', 'Not set').'</span>';
                    if($team->disbanded_at===null && Yii::$app->user->can('team_updateTeam', ['model'=>$team])){
                        $options = [
                            'class'=>'btn btn-warning btn-xs team-role-change',
                            'title'=>Yii::t('team_backend', 'Change speciality'),
                        ];
                        $speciality .= Html::a(
                            '<i class="glyphicon glyphicon-refresh"></i> '.Yii::t('team_backend', 'Change'),
                            ['/team/team/changespeciality', 'id'=>$team->id, 'user'=>$model->user_id],
                            $options
                        );
                    }
                    return $speciality;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {delete}',
                'contentOptions'=>[
                    'class'=>'list-action',
                ],
                'visibleButtons' => [
                    'delete' => $team->disbanded_at!==null ? false : function() use ($team){
                        /** @var inblank\team\models\Team $model */
                        return  Yii::$app->user->can('team_deleteFromTeam', ['model'=>$team]);
                    },
                ],
                'buttons' => [
                    'delete' => function ($url, $model) use ($team) {
                        $options = [
                            'title' => Yii::t('team_backend', 'Delete member'),
                            'aria-label' => Yii::t('team_backend', 'Delete member'),
                            'data-confirm' => Yii::t('team_backend', 'Are you sure you want to delete member from team?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-ban-circle"></span>', ['left', 'id'=>$team->id, 'user'=>$model->user_id], $options);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
