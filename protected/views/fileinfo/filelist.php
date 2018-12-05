<?php
/* @var $this FileInfoController */
/* @var $model FileInfo */
?>
<h3 class="heading_b uk-margin-bottom">Manage File Infos</h3>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid">
            <div class="uk-width-medium-1-4">
                <?php echo CHtml::dropDownList('listname', '', Yii::app()->params['Pagination'], array("data-md-selectize" => true, "id" => "selectf", 'class' => 'show_page', 'options' => array(yii::app()->session['pagination'] => array('selected' => 'selected')))); ?>
            </div>
            <div class="uk-width-1-1">
				<!--<ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#tabs_4'}">
                    <li class="uk-active uk-width-1-2 tab_select" id="P"><a href="#">Pending</a></li>
					<li class="uk-width-1-2 tab_select" id="C"><a href="#">Completed</a></li>
                </ul>
                <ul id="tabs_4" class="uk-switcher uk-margin">
                    <li>
						<form id="trn_from">-->
						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id' => 'file-info-grid',
							'dataProvider' => $model->search(),
							'afterAjaxUpdate' => 'js:function(){$("select[name=\'FileInfo[fi_pjt_id]\']").chosen();}',
							'filter' => $model,
							'columns' => array(
							  //  'fi_file_id',
							  //  'fi_pjt_id',
								array(
									'name' => 'fi_pjt_id',
									'value' => '$data->ProjectMaster->p_name',
									'filter' => CHtml::dropDownList('FileInfo[fi_pjt_id]', $model->fi_pjt_id, CHtml::listData(Project::model()->findAll(array("condition" => "p_flag= 'A'", 'order' => 'p_name')), 'p_pjt_id', 'p_name') , array('empty' => 'Select Project')),
								), 
								'fi_file_name',
								//'fi_file_ori_location',
								//'fi_file_completed_location',
							    'fi_file_uploaded_date',
								//'fi_file_completed_time',
								/*array(
									'name' => 'fi_file_completed_time',
									'value' => 'isset($data->fi_file_completed_time)?$data->fi_file_completed_time:""',
								),*/
                                array(
                                    'header' => 'Completed Date',
                                    'value' => function ($data) {
                                        if (isset($data->fi_file_id)) {
                                            $file = $data->fi_file_id;
                                            $findjob=JobAllocation::model()->find(array('condition' => "ja_file_id = $file and ja_flag ='A' and ja_status = 'QC'"));
                                            return   isset($findjob->ja_last_modified)? $findjob->ja_last_modified:"0000-00-00 00:00:00";
                                        }
                                       }
                                     ),
								array(
                                    'header' => 'Status',
                                    'value' => 'FileInfo::clientstatus($data->fi_file_id)',
                                    'htmlOptions' => array("style" => "text-align:center"),
                                ),
								/*
								'fi_file_completed_time',
								'fi_status',
								'fi_created_date',
								'fi_last_modified',
								'fi_flag',
								*/
								array(
									"header" => "Actions",
									"value" => 'FileInfo::ActionButton($data->fi_file_id,Yii::app()->session["user_type"])',
									'type' => 'raw',
								),
							),
						)); ?>
						<!--<input type="hidden" id="grid_tab" name="grid_tab" value="P">
						</form>
					</li>	
				</ul>-->		
            </div>
        </div>
    </div>
</div>

		<div id="fileinfoModal" class="uk-modal">	
			<div class="uk-modal-dialog  uk-modal-dialog-medium" style="padding-top:0">
                <div class="uk-modal-header" style="background: #1976D2;padding: 10px;">
                    <h3 class="uk-modal-title" style="display: inline-block;color: #fff;">Headline</h3>
                    <button type="button" class="uk-modal-close uk-close" style="display: inline-block;float: right;color: #fff;background: #fff;"></button>
                </div>
			<div class="uk-modal-content"></div>
			<div class="uk-modal-footer"></div>
			</div>
		</div>
<button id="triggerModal" data-uk-modal="{target:'#fileinfoModal'}" style="display: none;"></button>
<style>
    .ActionButtons {
        display: flex;
    }
	.grid-view table.items {
			white-space: nowrap;
	}
	.uk-badge-grey {
         background-color: #616161;
    }
    .uk-badge-pink {
         background-color: #d81b60;
    }
	.status-badge {
        width: 90%;
        line-height: 17px;
        -webkit-box-shadow: 0 10px 6px -6px #777;
        -moz-box-shadow: 0 10px 6px -6px #777;
        box-shadow: 0 9px 6px -6px #777;
        border-radius: 8px;
    }
</style>

<script>
	$(document).ready(function(){
		$("select[name='FileInfo[fi_pjt_id]']").chosen();
		
		$('.tab_select').click(function () {
            var id = $(this).attr('id');
            // Set id
			if(id == 'P'){
				$('#grid_tab').val('P');
			}
			else if(id == 'C'){
				$('#grid_tab').val('C');
			}
            $('.uk-tab-grid li').each(function () {
                $(this).removeClass('uk-active');
            });
            $(this).addClass('uk-active');
            $('#file-info-grid').yiiGridView('update', {
                data: {fi_st: $('#grid_tab').val()},
                complete: function (jqXHR, status) {
                    
                }
            });
            return false;
        });
	});
	
	function exportxls($fid) {
        window.location = '<?php echo Yii::app()->createUrl('fileinfo/export'); ?>/' + $fid;
    }
	
	$('#fileinfoModal').on({
        'show.uk.modal': function () {
        },
        'hide.uk.modal': function () {
            $("#fileinfoModal .uk-modal-header h3").html("");
            $("#fileinfoModal .uk-modal-content").html("");
            $('#file-info-grid').yiiGridView('update', {
                data: {}
            });
        }
    });
</script>	