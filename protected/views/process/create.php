<?php
/* @var $this ProcessController */
/* @var $model Process */


$this->menu=array(
	array('label'=>'Список процессов', 'url'=>array('admin')),
);
?>

<h1>Создание процесса</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>