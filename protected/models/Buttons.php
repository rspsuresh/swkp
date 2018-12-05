<?php

/**
 * This is the model class for Custom Model.
 *
 * The followings are the available columns in this Class:
 * @property string $butttons
 */
class Buttons extends CFormModel {
    /**
     * @Show Assign Buttons
     */
    public static function ActionButtons($id) {
        $buttons = "<div class='ActionButton'>";
        $buttons .= "<a class='userView md-fab md-fab-small md-fab-success md-fab-wave-light waves-effect waves-button waves-light' href='javascript:void(0)' onclick='fileAssignment($id)'  title='File Assignment'  data-uk-tooltip = \"{pos:'top'}\"><i class='material-icons'>assignment_turned_in</i></a>";
        $buttons .= "</div>";
        return $buttons;
    }

    /**
     * @Tree Buttoon
     */
    public static function Treebutton($data) {
        $result = '';
        if ($data['ja_status'] == 'IC' || $data['ja_status'] == 'IQP') {
            $result = "<a data-show='true' href='javascript:void(0)' onclick='gridload($data[primaryid],$(this))'><i class='material-icons'>add_circle_outline</i></a>";
        } else if ($data['ja_status'] == 'SC' || $data['ja_status'] == 'SQP' || $data['ja_status'] == 'QC') {
            $result = "<a data-show='true' href='javascript:void(0)' onclick='gridloader($data[primaryid],$(this))'><i class='material-icons'>add_circle_outline</i></a>";
        }
        return $result;
    }


    public static function ChooseButtons($jobId, $data, $process = "", $fileid,$p_id, $gridData) {
        //$opformat=$gridData->output;
       // print_r($gridData);
        if (empty($process) || $process == "All") {
            if ($data == 'IQ' || $data == 'SQ' || $data == 'EQ') {
                return Buttons::AllgridButtons($jobId, $data, $gridData);
            } else {
                return Buttons::ProcessSwapButton($jobId);
            }
        } else if ($process == "Completed") {
            $fileInfo = FileInfo::model()->findByPk($fileid);
            $buttons = "<div class='ActionButton'>";
                $buttons .= CHtml::link('<i class="material-icons" style="display:none;">&#xE2C4;</i>', Yii::app()->createUrl("fileinfo/download", array('p_id' => $p_id, 'f_id' => $fileid)));
			$action = Yii::app()->createUrl('filepartition/filesplit', array('id' => $gridData['partitionid'], 'status' => 'R'));
			if($fileInfo->ProjectMaster->skip_edit == 1){
				$buttons .= '<a class="lock" href="'.$action.'"><i class="material-icons md-24">&#xE2C8;</i></a>';
			}
			$buttons .= '<a class="Interference" href="javascript:void(0)" title="Interference"  data-uk-tooltip = {pos:"bottom"}\ onclick="Interference(' . $fileid . ')"><i class="material-icons md-24">&#xE8E5;</i></a>';
            //$buttons .= '<a  href="javascript:void(0)" ><i class="material-icons md-24">&#xE258;</i></a>';
            $buttons .= "</div>";
            return $buttons;
        } else {
            return Buttons::AllgridButtons($jobId, $data, $gridData);
        }
    }

    /**
     * @Allgrid Buttoon
     */
    public static function AllgridButtons($jobId, $data, $gridData) {
        $jobAllc = JobAllocation::model()->findByPk($jobId);
        $buttons = "<div class='ActionButton'>";
        if ($data == 'IQ' || $data == 'SQ') {
            $buttons .= '<a class="Reallocate" href="javascript:void(0)" onclick="quitprocess(' . $jobId . ',\'' . $data . '\')"><i class="material-icons md-24">&#xE8E5;</i></a>';
        } else if ($data == 'EQ') {
            $buttons .= '<a class="BackProcess" href="javascript:void(0)" onclick="backprcs(' . $jobId . ')"><i class="material-icons md-24">&#xE8E5;</i></a>';
        } else {
            if (Yii::app()->session['user_type'] == "A" || Yii::app()->session['user_type'] == "TL") {
                if ($gridData['ad_lock'] == 'L') {
                    $action = '';
                    if ($data == 'IA') {
                        $action = Yii::app()->createUrl('fileinfo/fileindexing/'.$jobAllc->ja_file_id.'?status=R');
                    }
                    else if ($data == 'IC' || $data == 'IQP')
                    {
                        $qjob = JobAllocation::model()->find(array('condition' => "ja_file_id =$jobAllc->ja_file_id and ja_flag ='A' and (ja_status = 'IQP' or ja_status = 'IC') "));
                        $adminpartition=FilePartition::model()->find(array('condition' => "fp_file_id =$qjob->ja_file_id and fp_category ='M'"));
                        if(!empty($adminpartition))
                        {
                            $action = Yii::app()->createUrl('fileinfo/fileindexing/'.$adminpartition->fp_part_id.'?status=QC');
                        }

                    } else if($data == 'SA'){
                        $action = Yii::app()->createUrl('filepartition/filesplit', array('id' => $gridData['partitionid'], 'status' => 'R'));
                    } else if ($data == 'SC' || $data == 'SQP') {
                        $action = Yii::app()->createUrl('filepartition/filesplit', array('id' => $gridData['partitionid'], 'status' => 'QC'));
                        //$action = Yii::app()->createUrl('filepartition/filesplit');
                    }
                    else if ($data == 'SA' || $data == 'SC' || $data == 'SQP') {
                        $action = Yii::app()->createUrl('filepartition/filesplit');
                    }
                    $buttons .= '<a class="lock" href="javascript:void(0)"  onclick="fileLock(' . $gridData['primaryid'] . ',$(this))"><i class="material-icons md-24 lock-red">&#xE897;</i></a>';
                    $buttons .= '<a class="lock" href="'.$action.'"><i class="material-icons md-24">&#xE2C8;</i></a>';
                    if ($data == 'SA' || $data=='IA') {
                        $buttons .= '<a class="ProcessSwap" href="javascript:void(0)"  title="Process Change"  data-uk-tooltip = {pos:"bottom"}\ onclick="ProcessSwap(' . $jobId . ')"><i class="material-icons md-24">cached</i></a>';
                        $buttons .= '<a class="AdminRealloc" href="javascript:void(0)" title="Reallocate"  data-uk-tooltip = {pos:"bottom"}\ onclick="adminrealloc(' . $jobId . ')"><i class="material-icons md-24">&#xE8E5;</i></a>';
                    }
                } else {
                    $buttons .= '<a class="lock" href="javascript:void(0)"  onclick="fileLock(' . $gridData['primaryid'] . ')"><i class="material-icons md-24 lock-green">&#xE898;</i></a>';
                     if ($data == 'SA' || $data=='IA') {
                        $buttons .= '<a class="ProcessSwap" href="javascript:void(0)"  title="Process Change"  data-uk-tooltip = {pos:"bottom"}\ onclick="ProcessSwap(' . $jobId . ')"><i class="material-icons md-24">cached</i></a>';
                        $buttons .= '<a class="AdminRealloc" href="javascript:void(0)" title="Reallocate"  data-uk-tooltip = {pos:"bottom"}\ onclick="adminrealloc(' . $jobId . ')"><i class="material-icons md-24">&#xE8E5;</i></a>';
                    }
                }
            }
        }
        $buttons .= "</div>";
        return $buttons;
    }

    /**
     * @Allgrid Procees swap popup Buttoon
     */
    public static function ProcessSwapButton($jobId = 0) {
        if ($jobId != 0) {
            $jobmodel = JobAllocation::model()->findByPk($jobId);
            if ($jobmodel->ja_status != 'QEC') {
                $buttons = "<div class='ActionButton'>";
                if (Yii::app()->session['user_type'] == "A") {
                    if ($jobId) {
                        $buttons .= '<a class="templatechange" href="javascript:void(0)"  title="Template Change"  data-uk-tooltip = {pos:"bottom"}\ onclick="templatechange(' . $jobmodel->ja_file_id . ')"><i class="material-icons md-24">&#xE0D7;</i></a>';
                        $buttons .= '<a class="ProcessSwap" href="javascript:void(0)"  title="Process Change"  data-uk-tooltip = {pos:"bottom"}\ onclick="ProcessSwap(' . $jobId . ')"><i class="material-icons md-24">cached</i></a>';
                    }
                }
                if ($jobmodel->ja_status == 'IA' || $jobmodel->ja_status == 'SA') {
                    $buttons .= '<a class="AdminRealloc" href="javascript:void(0)" title="Reallocate"  data-uk-tooltip = {pos:"bottom"}\ onclick="adminrealloc(' . $jobId . ')"><i class="material-icons md-24">&#xE8E5;</i></a>';
                }
                $buttons .= "</div>";
                return $buttons;
            }
        }
    }
}

?>