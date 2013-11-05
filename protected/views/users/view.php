<?php
/* @var $this UsersController */
/* @var $model Users */


$this->menu=array(
	array('label'=>'Пользователи', 'url'=>array('admin')),
);
?>

<h1>View Users #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'login',
		array('name' => 'isadmin', 
                    'label'=>'Администратор', 
                    'value' => ($model->isadmin == 1) ? "Да":"Нет"),
	),
)); ?>
