<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model inblank\team\models\Team */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="team-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'autofocus' => true,
    ]) ?>
    <?= $form->field($model, 'founded_at')->widget(
        DateControl::classname(), [
        'type' => DateControl::FORMAT_DATE,
        'displayFormat' => 'php:d-m-Y',
        'saveFormat' => 'php:Y-m-d',
        'options' => [
            'options' => [
                'placeholder' => Yii::t('team_general', 'Select date of founding'),
            ],
            'pluginOptions' => [
                'minuteStep' => 15,
                'weekStart' => 1,
                'autoclose' => true,
                'todayHighlight' => true,
                'todayBtn' => true,
            ]
        ]
    ]); ?>
    <?= $form->field($model, 'description')->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => [
            'rows' => 6,
            'class' => 'form-control',
        ],
        'preset' => 'basic',
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('team_backend', 'Create') : Yii::t('team_backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
