<?php
$this->breadcrumbs=array(
	'Search'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Service','url'=>array('index')),
	array('label'=>'Create Service','url'=>array('create')),
	array('label'=>'Update Service','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Service','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Service','url'=>array('admin')),
);
?>

<h1>View Organisation <?php echo $model->name ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
//		'create_at',
		'modified_at',
//		'deleted_at',
//		'active',
//		'system_active',
	),
)); ?>
<h5> Related services </h5>
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$services,
	'itemView'=>'_servicelistview',
)); ?>
<br>

<h5> Related users </h5>
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$users,
	'itemView'=>'_userlistview',
)); ?>

