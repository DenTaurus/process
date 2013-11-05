<?php
/* @var $this ProcessController */
/* @var $model Process */

$this->menu=array(
	array('label'=>'Список процессов', 'url'=>array('index')),
	array('label'=>'Создать процесс', 'url'=>array('create')),
	array('label'=>'Просмотр процесса', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Менеджер процессов', 'url'=>array('admin')),
);
?>

<h1>Update Process <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>