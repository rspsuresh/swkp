<?php
/* @var $this ClientDetailsController */
/* @var $model ClientDetails */
?>

<h1>Manage Client Details</h1>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'client-details-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        'cd_id',
                        'cd_downloadtype',
                        'cd_projectid',
                        'cd_url',
                        'cd_username',
                        'cd_password',
                        /*
                        'cd_port',
                        'cd_folderpath',
                        'cd_created_date',
                        'cd_last_modified_date',
                        'cd_flag',
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
