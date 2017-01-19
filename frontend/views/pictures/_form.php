<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pictures */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pictures-form">

    <?php $form = ActiveForm::begin();

    ?>

    <?php //echo $form->field($model, 'user_id')->textInput();

    if ($model->isNewRecord)
      echo $form->field($model, 'file')->fileInput();
    else {
      echo $form->field($model, 'picture')->textInput(['maxlength' => true,'readonly'=>'readonly']);
      echo '<img src="'.str_replace('/var/www/html','',$model->picture.'"/>');
      echo '<div class="form-group">';
      //echo  Html::Button('watermark',Yii::t('app', 'Watermark'), ['class' => 'btn btn-primary']);
      echo Html::a(Yii::t('app','Watermark'), ['watermark'], ['class' => 'btn btn-lg btn-primary',
        'id'=>'watermark',
        'onclick'=>'return watermarkGo(this,'.$model->id.')',
      ]);
      echo '</div>';

    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Upload') : Yii::t('app', 'Rotate'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
  function watermarkGo(oThis,numb) {
    window.location=oThis.href+'&id='+numb;
    return false;
  }
</script>
