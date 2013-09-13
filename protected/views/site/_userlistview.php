<div class="view">

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	
	<?php echo CHtml::link(CHtml::encode($data->username), array('site/viewuser', 'id'=>$data->id)); ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->lastvisit_at); ?>
	
</div>