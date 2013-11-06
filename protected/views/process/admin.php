<?php
/* @var $this ProcessController */
/* @var $model Process */


$this->menu = array(
    array('label' => 'Создать процесс', 'url' => array('create')),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#process-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Менеджер процессов</h1>

<?php
Yii::app()->clientScript->registerScript('dc', "

var delay = 6000;
setInterval(function() {
   $.fn.yiiGridView.update('process-grid'); 
}, delay);


$('a[title=\"Stop\"]').live('click',function(event)
{
    event.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        success: function () {
           $.fn.yiiGridView.update('process-grid');
        } 
    });
});

$('a[title=\"Start\"]').live('click',function(event)
{
    event.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        success: function () {
           $.fn.yiiGridView.update('process-grid');
        } 
    });
});
");

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'process-grid',
    'dataProvider' => $model,
    'columns' => array(
        'id',
        //'name',
        array(
            'name' => 'name',
            'value' => 'CHtml::link(CHtml::encode($data->name), Yii::app()->controller->createUrl("view", array("id" => $data->id)))',
            'type' => 'html',
        ),
        'timeexec',
        array(
            'name' => 'status',
            'value' => 'Process::getLabelStatus($data->status)',
            'type' => 'html',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{Start}  {Stop}  {delete}',
            'buttons' => array(
                'Start' => array('label ' => 'Старт',
                    'visible' => '$data->status != 2',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/play.png',
                    'url' => 'Yii::app()->createUrl("process/admin",array("run"=>1,"id"=>$data->id))',
                ),
                'Stop' => array('label ' => 'Стоп',
                    'visible' => '$data->status == 2',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/stop.png',
                    'url' => 'Yii::app()->createUrl("process/admin",array("stop"=>1,"id"=>$data->id))',
                ),
                'delete' => array(
                    'visible' => 'Yii::app()->user->checkAccess("administrator")',
                )
            )
        ),
    ),
));
?>



