<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>

	<?php  /*
	echo CHtml::encode($data->getAttributeLabel('create_at')); 
	echo CHtml::encode($data->create_at);
	

	echo CHtml::encode($data->getAttributeLabel('modified_at')); 
	echo CHtml::encode($data->modified_at);	
	echo CHtml::encode($data->getAttributeLabel('deleted_at'));
	echo CHtml::encode($data->deleted_at);
	echo CHtml::encode($data->getAttributeLabel('active'));
	echo CHtml::encode($data->active);
	echo CHtml::encode($data->getAttributeLabel('system_active')); 
	echo CHtml::encode($data->system_active); */?>

