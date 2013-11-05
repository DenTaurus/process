<?php
/* @var $this ProcessController */
/* @var $data Process */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Наименование процесса')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Время  работы процесса')); ?>:</b>
	<?php echo CHtml::encode($data->timeexec); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Автор')); ?>:</b>
	<?php echo CHtml::encode($data->iduser); ?>
	<br />


</div>