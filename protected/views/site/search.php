<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . '- Search';
?>

<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Search';
$this->breadcrumbs=array(
	'Search',
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'searchquery'); ?>
		<?php echo $form->textField($model,'searchquery'); ?>
		<?php echo $form->error($model,'searchquery'); ?>
	</div>

	<div class="row">

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_servicelistview',
)); ?>

<?php 

/*$this->widget('bootstrap.widgets.TbNavbar', array(
    'brand' => 'Search for services',
    'fixed' => false,
    'items' => array(
        '<form class="navbar-search pull-left">
        <input type="text" class="search-query" placeholder="search">
        <button type="submit" class="btn" value="search">Submit</button>
        </form>'
    )
));*/
?>
 
