<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel inblank\team\models\SpecialitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('team_backend', 'Member Specialities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('team_backend', 'Create Speciality'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => [
                    'class' => 'list-action',
                ],
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('team_backend', 'Delete'),
                            'aria-label' => Yii::t('team_backend', 'Delete'),
                            'data-confirm' => Yii::t('team_backend', 'Are you sure you want to delete this speciality?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/team/speciality/delete', 'id' => $model->id], $options);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
