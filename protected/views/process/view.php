<?php
/* @var $this ProcessController */
/* @var $model Process */



$this->menu = array(
    array('label' => 'Список процессов', 'url' => array('admin')),
    array('label' => 'Изменить процесс', 'url' => array('update', 'id' => $id)),
);
?>

<h1>Процесс Id-<?php echo $id; ?></h1>

</br>
<?php

Yii::app()->clientScript->registerScript('fc', "

$('a[title=\"Stop\"]').live('click',function(event)
{
    event.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        success: function () {
           $.fn.yiiGridView.update('processView-grid');
        } 
    });
});

$('a[title=\"Start\"]').live('click',function(event)
{
    event.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        success: function () {
           $.fn.yiiGridView.update('processView-grid');
        } 
    });
});
");




$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'processView-grid',
    'dataProvider' => $model,
    'columns' => array(
        'id',
        'name',
        'timeexec',
        array(
            'name' => 'status',
            'value' => 'Process::getLabelStatus($data->status)',
            'type' => 'html',
            'htmlOptions'=>array('class'=>'statusColumn'),
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
if(Yii::app()->user->checkAccess("administrator")){
    
    Yii::app()->clientScript->registerScript('hc', "
    var url = document.location.href + '?progress';
    $('<div class=\'progress-label\' style=\'position: absolute; left: 40%; top: 1px; font-weight: bold;text-shadow: 1px 1px 0 #fff;\'></div>').appendTo('#my_progressbar');
    var progressLabel = $('.progress-label');
    
    $.ajax({
            dataType: 'json',
            url: url,
            success: function (data) {
                $('#my_progressbar').progressbar({
                    value: parseInt(data.state, 10),
                    change: function() {
                        progressLabel.html($('#my_progressbar').progressbar('value') + '%');
                    },
                    complete: function() {
                        progressLabel.html('Complete!');
                    }
                });
                progress();
            } 
   });

   function progress() {
      
        var val = $('#my_progressbar').progressbar('value');
        
	$.ajax({
            dataType: 'json',
            url: url,
            success: function (data) {
                val = parseInt(data.state, 10);
                $('.statusColumn').html(data.status);
                $('#my_progressbar').progressbar('value', val);
                if(val < 99) {
                    setTimeout(progress, 100);
                }else{
                    $.fn.yiiGridView.update('processView-grid'); 
                    setTimeout(progress, 3000);
                }
            } 
        });
        
    }

", CClientScript::POS_READY);
    
$this->widget('zii.widgets.jui.CJuiProgressBar', array(
    'id' => 'my_progressbar',
    'htmlOptions' => array(
        'style' => 'height:20px; width:400px; position: relative;',
    ),
));

}
?>




