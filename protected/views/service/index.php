<?php
$this->breadcrumbs=array(
	'Services',
);

$this->menu=array(
	array('label'=>'Create Service','url'=>array('create')),
	array('label'=>'Manage Service','url'=>array('admin')),
);
?>

<h1>Services</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
