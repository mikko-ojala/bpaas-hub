<?php
$this->breadcrumbs=array(
	'Services'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Service','url'=>array('index')),
	array('label'=>'Create Service','url'=>array('create')),
	array('label'=>'View Service','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Service','url'=>array('admin')),
);
?>

<h1>Update Service <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 
		'org_relation'=>$org_relation, 
		'user_relation'=>$user_relation));  ?>