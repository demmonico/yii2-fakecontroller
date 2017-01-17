<?php
/**
 * @author: dep
 * Date: 01.02.16
 */

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>



<?php $form = \yii\bootstrap\ActiveForm::begin(['enableAjaxValidation' => true, 'id' => 'admin-form']); ?>

    <?=$form->errorSummary($model)?>
    <?=$form->field($model, 'email')->textInput()?>
    <?=$form->field($model, 'email_is_confirmed')->checkbox()?>
    <?=$form->field($model, 'username')->textInput()?>
    <?=$form->field($model, 'role')->dropDownList($model->getRole())?>
    <?=$form->field($model, 'status')->dropDownList($model->getStatus())?>

    <?php /*if (!$model->isNewRecord) : ?>
        <?=$form->field($model, 'created')->textInput()?>
        <?=$form->field($model, 'updated')->textInput()?>
    <?php endif;*/ ?>


    <div class="form-group">
        <?=\yii\bootstrap\Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php \yii\bootstrap\ActiveForm::end(); ?>
