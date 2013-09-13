<?php
$this->breadcrumbs=array(
	'Organisations'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Organisation','url'=>array('index')),
	array('label'=>'Create Organisation','url'=>array('create')),
	array('label'=>'Update Organisation','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Organisation','url'=>'#','linkOptions'=>array('submit'=>array('admindelete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Organisation','url'=>array('admin')),
);
?>

<h1>View Organisation <?php echo $model->name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_at',
		'modified_at',
		//'deleted_at',
		//'active',
		//'system_active',
		'name',
	),
)); ?>
