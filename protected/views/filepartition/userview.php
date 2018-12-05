<?php
/* @var $this FilePartitionController */
/* @var $model FilePartition */
?>

<h1>Manage File Partitions</h1>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'file-partition-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        'fp_part_id',
                        'fp_file_id',
                        'fp_filepath',
                        'fp_category',
                        'fp_cat_id',
                        'fp_page_nums',
                        /*
                        'fp_status',
                        'fp_created_date',
                        'fp_last_modified',
                        'fp_flag',
                        */
                        array(
                            'class' => 'CButtonColumn',
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>
