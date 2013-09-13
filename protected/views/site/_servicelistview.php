<div class="view">

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	
	<?php echo CHtml::link(CHtml::encode($data->name), array('site/viewservice', 'id'=>$data->id)); ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	
</div>