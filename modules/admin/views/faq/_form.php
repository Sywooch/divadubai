<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Faq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faq-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'published')->checkbox() ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                'options' => [
                    'rows' => 1,
                    'id'=>'top-description',
                ],
                'preset' => 'basic',
                'clientOptions' => [
                    'allowedContent' => true,
                    'tabindex' => false,
                    'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
                ],
            ])->label('Description')
        ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
