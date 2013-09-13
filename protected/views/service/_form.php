<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'service-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php 
		    
		    echo $form->dropDownList($org_relation, 'organisation_id',
				CHtml::listData(
				Organisation::model()->with('users')->findAll('users_id=:ID', array(':ID'=>YII::app()->user->id)), 'id', 'name'),				
					array('prompt' => 'Select organisation')			
			);
	?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->checkboxRow($org_relation, 'visibility'); ?>
	<?php echo $form->checkboxRow($org_relation, 'privacy'); ?>
	<?php echo $form->checkboxRow($user_relation, 'visibility'); ?>
	<?php echo $form->checkboxRow($user_relation, 'privacy'); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
