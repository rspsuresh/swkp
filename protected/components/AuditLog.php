<?php

class AuditLog extends CApplicationComponent {

    public function writeAuditLog($action, $modulename, $refid, $description) {
        $date = date('d-m-Y');
        $time = date('H:i:s');
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        //$user_name=Yii::app()->user->first_name;
        //$user_id=Yii::app()->user->id;
        $folderName = 1;
        $i = 1;
        $start = 0;
        $end = 10000;
        $user_name = Yii::app()->session['user_name'];
        $user_id = Yii::app()->session['user_id'];
        if ($refid > 0) {
            while ($i > 0) {
                if ($refid > $start && $refid < $end) {
                    $i = 0;
                } else {
                    $folderName = $folderName + 1;
                    $start = $start + 10000;
                    $end = $end + 10000;
                    $i++;
                }
            }
        }

        //---------------------------- USER WISE AUDITLOG--------------------------------------------------------

        if (!is_dir(Yii::app()->params['DataFolder'] . "AuditLog/User/" . $year . "/" . $month . "/" . $day)) {
            mkdir(Yii::app()->params['DataFolder'] . "AuditLog/User/" . $year . "/" . $month . "/" . $day, 0777, TRUE);
        }

        // For Write Content into file 
        $fnameUser = Yii::app()->params['DataFolder'] . "AuditLog/User/" . $year . "/" . $month . "/" . $day . "/" . "User_Details" . ".txt";

        $fopenUser = fopen($fnameUser, 'a');
        fputs($fopenUser, $date . "," . $time . "," . $user_name . "," . $user_id . "," . $action . "," . $modulename . "," . $refid . "," . $description . ".\n");
        fclose($fopenUser);

        //---------------------------- RECORD WISE AUDITLOG--------------------------------------------------------

        if (!is_dir(Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modulename . "/" . $folderName)) {
            mkdir(Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modulename . "/" . $folderName, 0777, TRUE);
        }

        // For Write Content into file 
        $fnameRecord = Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modulename . "/" . $folderName . "/" . $refid . ".txt";

        $fopenRecord = fopen($fnameRecord, 'a');
        if ($description == "") {
            fputs($fopenRecord, $date . "," . $time . "," . $user_name . "," . $user_id . "," . $action . "," . $modulename . "," . $refid . "," . $description . ".\n");
        } else {
            fputs($fopenRecord, $date . "," . $time . "," . $user_name . "," . $user_id . "," . $action . "," . $modulename . "," . $refid . "," . $description . ".\n");
        }

        fclose($fopenRecord);
    }

    public function readRecordAuditLog($userid, $date, $action, $modulename, $refid, $description) {
        $folderName = 1;
        $i = 1;
        $start = 0;
        $end = 10000;
        if ($refid > 0) {
            while ($i > 0) {
                if ($refid > $start && $refid < $end) {
                    $i = 0;
                } else {
                    $folderName = $folderName + 1;
                    $start = $start + 10000;
                    $end = $end + 10000;
                    $i++;
                }
            }
        }

        //---------------------------- RECORD WISE READ AUDITLOG--------------------------------------------------------		
        $fnameRecord = Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modulename . "/" . $folderName . "/" . $refid . ".txt";

        $ResultRecordArr = array();
        if (file_exists($fnameRecord)) {
            $freadRecord = fopen($fnameRecord, 'r');
            while (!feof($freadRecord)) {
                //echo fgets($freadRecord);
                $strLine = fgets($freadRecord);
                $expRecord = explode(",", $strLine);
                if (count($expRecord) > 1) { // For remove last blank line
                    $ResultRecordArr[$i]['sno'] = $i + 1;
                    $ResultRecordArr[$i]['date'] = date('d M Y',  strtotime($expRecord[0]));
                    $ResultRecordArr[$i]['time'] = $expRecord[1];
                    $ResultRecordArr[$i]['time'] = date('h:i A', strtotime($ResultRecordArr[$i]['time']));
                    $ResultRecordArr[$i]['user_name'] = $expRecord[2];
                    $ResultRecordArr[$i]['user_id'] = $expRecord[3];
                    $ResultRecordArr[$i]['action'] = $expRecord[4];
                    $ResultRecordArr[$i]['module_name'] = $expRecord[5];
                    $ResultRecordArr[$i]['refid'] = $expRecord[6];
                    $expRecord[7] = str_replace(";", ",</br>", $expRecord[7]);
                    $expRecord[7] = str_replace(",</br>.", ".", $expRecord[7]);
                    $ResultRecordArr[$i]['description'] = $expRecord[7];
                    $i = ($i + 1);
                }
            }
        }
        return array_reverse($ResultRecordArr);
    }

// End ReadAuditLogRecord

    public function writeuserAuditLog($action, $modelname, $userid, $description) {
        $date = date('d-m-Y');
        $time = date('H:i:s');
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $folderName = 1;
        $i = 1;
        $start = 0;
        $end = 10000;
        $user_name = Yii::app()->session['ud_first_name'];
        $user_id = Yii::app()->session['ud_id'];

        if ($userid > 0) {
            while ($i > 0) {
                if ($userid > $start && $userid < $end) {
                    $i = 0;
                } else {
                    $folderName = $folderName + 1;
                    $start = $start + 10000;
                    $end = $end + 10000;
                    $i++;
                }
            }
        }

        //---------------------------- USER WISE AUDITLOG--------------------------------------------------------

        if (!is_dir(Yii::app()->params['DataFolder'] . "AuditLog/User/" . $year . "/" . $month . "/" . $day)) {
            mkdir(Yii::app()->params['DataFolder'] . "AuditLog/User/" . $year . "/" . $month . "/" . $day, 0777, TRUE);
        }

        // For Write Content into file 
        $fnameUser = Yii::app()->params['DataFolder'] . "AuditLog/User/" . $year . "/" . $month . "/" . $day . "/" . $user_id . ".txt";

        $fopenUser = fopen($fnameUser, 'a');
        fputs($fopenUser, $date . "," . $time . "," . $user_name . "," . $user_id . "," . $action . "," . $modelname . "," . $userid . "," . $description . ".\n");
        fclose($fopenUser);


        //---------------------------- RECORD WISE AUDITLOG--------------------------------------------------------

        if (!is_dir(Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modelname . "/" . $folderName)) {
            mkdir(Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modelname . "/" . $folderName, 0777, TRUE);
        }

        // For Write Content into file 
        $fnameRecord = Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modelname . "/" . $folderName . "/" . $userid . ".txt";

        $fopenRecord = fopen($fnameRecord, 'a');
        fputs($fopenRecord, $date . "," . $time . "," . $user_name . "," . $user_id . "," . $action . "," . $modelname . "," . $userid . "," . $description . ".\n");
        fclose($fopenRecord);
    }

    public function readUserDetaillAuditLog($userid, $date, $action, $modulename, $refid, $description) {

        $folderName = 1;


        $i = 1;
        $start = 0;
        $end = 10000;
        if ($refid > 0) {
            while ($i > 0) {
                if ($refid > $start && $refid < $end) {
                    $i = 0;
                } else {
                    $folderName = $folderName + 1;
                    $start = $start + 10000;
                    $end = $end + 10000;
                    $i++;
                }
            }
        }


        //---------------------------- RECORD WISE READ AUDITLOG--------------------------------------------------------		
        $fnameRecord = Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $modulename . "/" . $folderName . "/" . $refid . ".txt";


        $ResultRecordArr = array();
        if (file_exists($fnameRecord)) {
            $freadRecord = fopen($fnameRecord, 'r');
            while (!feof($freadRecord)) {
//                echo fgets($freadRecord);
                $strLine = fgets($freadRecord);
                $expRecord = explode(",", $strLine);
                if (count($expRecord) > 1) { // For remove last blank line
                    $ResultRecordArr[$i]['sno'] = $i + 1;
                    $ResultRecordArr[$i]['date'] = $expRecord[0];
                    $ResultRecordArr[$i]['time'] = $expRecord[1];
                    $ResultRecordArr[$i]['user_name'] = $expRecord[2];
                    $ResultRecordArr[$i]['user_id'] = $expRecord[3];
                    $ResultRecordArr[$i]['action'] = $expRecord[4];
                    $ResultRecordArr[$i]['module_name'] = $expRecord[5];
                    $ResultRecordArr[$i]['refid'] = $expRecord[6];
                    $ResultRecordArr[$i]['description'] = $expRecord[7];
                    $i = ($i + 1);
                }
            }
        }
        return $ResultRecordArr;
    }
	
// End R
	
	
	public function readAuditLog($status, $refid) {
		
		$folderName = 1;
        $i = 1;
        $start = 0;
        $end = 10000;
        $user_name = Yii::app()->session['user_name'];
        $user_id = Yii::app()->session['user_id'];
        if ($refid > 0) {
            while ($i > 0) {
                if ($refid > $start && $refid < $end) {
                    $i = 0;
                } else {
                    $folderName = $folderName + 1;
                    $start = $start + 10000;
                    $end = $end + 10000;
                    $i++;
                }
            }
        }
		
        //---------------------------- RECORD WISE READ AUDITLOG--------------------------------------------------------		
        $fnameRecord = Yii::app()->params['DataFolder'] . "AuditLog/Record/" . $status . "/" . $folderName . "/" . $refid . ".txt";
	

        $ResultRecordArr = array();
        if (file_exists($fnameRecord)) {
            $freadRecord = fopen($fnameRecord, 'r');
            while (!feof($freadRecord)) {
                $strLine = fgets($freadRecord);
                $expRecord = explode(",", $strLine);
                if (count($expRecord) > 1) { // For remove last blank line
					$ResultRecordArr[] = $expRecord[2];
                }
            }
        }
        return $ResultRecordArr;
    }
	
    public function getChangeValue($attrubutes, $old_attrubutes, $model) {
        $result = array_filter(array_diff_assoc($attrubutes, $old_attrubutes));
        $description = "";
        array_pop($result);
        foreach ($result as $key => $value) {
            if (strcasecmp($key, "dob") == 0 || strcasecmp($key, "exp_date") == 0 || strcasecmp($key, "ud_dob") == 0) {
                $value = date_format(date_create($value), "d-m-Y");
                $old = date_format(date_create($old_attrubutes[$key]), "d-m-Y");
            } else {
                $old = $old_attrubutes[$key];
            }
            $lable = $model->getAttributeLabel($key);
            $description .= <<<DES
        $lable - $old to $value ;
DES;
        }
        return $description;
    }

    public function pagnitations($a, $b) {

    }

}

?>