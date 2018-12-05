<?php
/* @var $this ProjectController */
/* @var $model Project */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#Project_p_flag').change(function(){
    var s=($(this).hasClass('inactive_record'))?'I':'A';
    $(this).toggleClass('inactive_record');
      $('#project-grid').yiiGridView('update', {
      data:{status:s}
    });
    return false;
});
");
?>
<h1>Manage Projects</h1>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'project-grid',
                    'template' => '{items}{summary}{pager}',
                    'dataProvider' => $model->search(),
                    'afterAjaxUpdate' => 'js:function(){$("select[name=\'Project[p_client_id]\']").chosen();$("select[name=\'Project[p_op_format]\']").chosen();$("select[name=\'Project[p_key_type]\']").chosen();}',
                    'filter' => $model,
                    'columns' => array(
                        //'p_pjt_id',
                        //'p_client_id',
                        'p_name',
                        //'p_op_format',
                        array(
                            'name' => 'p_op_format',
                            'filter' => CHtml::dropDownList('Project[p_op_format]', $model->p_op_format, array("XLS" => "XLS","XML" => "XML","PDF" => "PDF") , array('empty' => 'Select format')),
                        ),
                        //'p_key_type',
                        array(
                            'name' => 'p_key_type',
                            'filter' => CHtml::dropDownList('Project[p_key_type]', $model->p_key_type, array("M" => "Medical","N" => "Non-Medical") , array('empty' => 'Select type')),
                            'value' => '($data->p_key_type == "M")?"Medical":"Non Medical"',
                        ),
                        'p_category_ids',
                        /*
                        'p_created_date',
                        'p_last_modified',
                        'p_flag',
                        */
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>

<style>
    .grid-view table.items {
        display: table !important;
        white-space: nowrap;
    }
</style>
<script>
    $(document).ready(function(){
        $("select[name='Project[p_key_type]']").chosen();
        $("select[name='Project[p_op_format]").chosen();
        $("select[name='Project[p_client_id]").chosen();
    });
</script>