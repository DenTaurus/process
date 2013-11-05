<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	'Users'=>array('index'),
//	'Manage',
//);

$this->menu=array(
//	array('label'=>'List Users', 'url'=>array('index')),
	array('label'=>' ',),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Список пользователей</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(
        'id',
        //'login',
        array(
            'name' => 'login',
            'value' => 'CHtml::link(CHtml::encode($data->login), Yii::app()->controller->createUrl("view", array("id" => $data->id)))',
            'type' => 'html',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{processes}',
            'buttons' => array(
                'processes' => array(
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/process.png',
                    'url' => 'Yii::app()->createUrl("process/admin",array("userId"=>$data->id))',
                ),
            ),
        ),
    ),
));?>
