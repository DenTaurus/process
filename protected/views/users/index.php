<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Пользователи',
);

?>

<h1>Пользователи</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
        'htmlOptions'=>array('style'=>'cursor: pointer;'),
        'selectionChanged'=>"function(id){window.location='" . Yii::app()->urlManager->createUrl('users/view', array('id'=>'')) . "' + $.fn.yiiGridView.getSelection(id);}",
	
)); ?>
