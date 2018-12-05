<?php
/* @var $this JobAllocationController */
/* @var $model JobAllocation */
?>

<h1>Manage Job Allocations</h1>

<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
          <?php /*  <div class="uk-width-medium-4-6">
            </div>
            <div class="uk-width-medium-2-6">
                <label for="UserDetails_ud_flag" class="inline-label">Inactive</label><!--switch_demo_small-->
                <input type="checkbox" data-switchery data-switchery-size="large" id="JobAllocation_ja_flag" name="JobAllocation[ja_flag]" class="inactive_record" checked/>
                <label for="UserDetails_ud_flag" class="inline-label">Active</label>
            </div> */?>
            <div class="uk-width-1-1">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'job-allocation-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                       // 'ja_job_id',
                        'ja_partition_id',
                        'ja_qc_id',
                        'ja_qc_allocated_time',
                        'ja_allocated_by',
                        'ja_qc_allocated_by',
                        /*
                        'ja_qc_accepted_time',
                        'ja_qc_completed_time',
                        'ja_qc_notes',
                        'ja_reviewer_id',
                        'ja_reviewer_allocated_time',
                        'ja_reviewer_accepted_time',
                        'ja_reviewer_completed_time',
                        'ja_reviewer_notes',
                        'ja_tl_id',
                        'ja_tl_accepted_time',
                        'ja_tl_completed_time',
                        'ja_tl_notes',
                        'ja_status',
                        'ja_created_date',
                        'ja_last_modified',
                        'ja_flag',
                        */
                       /* array(
                            'class' => 'CButtonColumn',
                        ),*/
                        array(
                            "header" => "Actions",
                            "value" => 'JobAllocation::ActionButtons($data->ja_job_id)'
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>
