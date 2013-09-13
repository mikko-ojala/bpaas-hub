<?php
$this->breadcrumbs=array(
	'Search'=>array('search'),
	'Results',
);
?>

<h1>Search results</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
