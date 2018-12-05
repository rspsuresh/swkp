<?php

/**
 * Class Filerecord
 * get a record based on File
 */
class Filerecord extends CApplicationComponent {

    public $dir = "filepartition/";

    /**
     * @get Saved Record File
     * @param $project_id
     * @param $file_id
     */
    public function getSavedRecord($project_id, $file_id) {
        $promodel =Project::model()->findByPk($project_id);
        $datform = array();
        if (!empty($promodel->date_format)) {
            $datform = array_values(json_decode($promodel->date_format, true));
        }
        $format = !empty($datform[0]) ? $datform[0] : 'dd/mm/yyyy';
		
		$catids = $promodel->p_category_ids;
		$noncatids = $promodel->non_cat_ids;
		
		$medopt = "";
		foreach(explode(",",$catids) as $catid){
			$catmodel = Category::model()->findByPk($catid);
			$medopt .= '<option value="'.$catmodel->ct_cat_name.'">'.$catmodel->ct_cat_name.'</option>';	
		}
		
		$nonmedopt = "";
		foreach(explode(",",$noncatids) as $noncatid){
			$noncatmodel = Category::model()->findByPk($noncatid);
			$nonmedopt .= '<option value="'.$noncatmodel->ct_cat_name.'">'.$noncatmodel->ct_cat_name.'</option>';	
		}
		
		$result = '';
        $medi = '';
        $nonmedi = '';
		
		$tab_medi = '';
        $tab_nonmedi = '';
		
		$tab_medi = '<table class="uk-table uk-table-hover uk-table-nowrap table_check">
                            <thead>
                            <tr>
                                <th class="uk-text-center">Page Numbers</th>
                                <th class="uk-text-center">DOS</th>
								<th class="uk-text-center">Category</th>
                                <th class="uk-text-center">Patient Name</th>';
                                if($promodel->p_name != "MV"){
									$tab_medi .= '<th class="uk-text-center">Provider Name</th>';
								}
		$tab_medi .= 			'
                            </tr>
							<tr class="filters" >
                                <td class="uk-text-center"><input type="text" class="medfilter"></th>';
                            if($format == "mm/dd/yyyy"){    
								$tab_medi .=  '<td class="uk-text-center"><input type="text" readonly="true" class="medfilter masked_input" data-uk-datepicker="{format:\'MM/DD/YYYY\'}"></th>';
							}
							else{
								$tab_medi .=  '<td class="uk-text-center"><input type="text" readonly="true" class="medfilter masked_input" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"></th>';
							}
							  $tab_medi .=  '<td class="uk-text-center"><select class="medfilter"><option value="">Select catgory</option>'.$medopt.'</select></th>
							  <td class="uk-text-center"></th>';
							  if($promodel->p_name != "MV"){
								$tab_medi .=  '<td class="uk-text-center"><input type="text" class="medfilter"></th>';
							  }
								$tab_medi .= '
                            </tr>
                            </thead>';
		
		$tab_nonmedi = '<table class="uk-table uk-table-hover uk-table-nowrap table_check">
                            <thead>
                            <tr>
                                <th class="uk-text-center">Page Numbers</th>
                                <th class="uk-text-center">Category</th>
								
                            </tr>
							<tr class="filters" >
                                <td class="uk-text-center"><input type="text" class="nonmedfilter"></th>
                                <td class="uk-text-center"><select class="nonmedfilter"><option value="">Select catgory</option>'.$nonmedopt.'</select></th>
								
                            </tr>
                            </thead>';
							
        $projectdir = Yii::app()->basePath . "/../filepartition/" . $project_id . "_breakfile";
        if (is_dir($projectdir)) {
            $file_dir = $projectdir . "/" . $file_id . ".txt";
            if (file_exists($file_dir)) {
                $i = 1;
                $j = 1;
                $k=1;
                $medsrow = 1;
                $mederow = 1;
                $nmedsrow = 1;
                $nmederow = 1;
				$dateofbirth = "";
                $bodyparts='';
                $diagonis='';

                foreach (file($file_dir) as $line) {
                    $exp_file = explode('|', trim($line));
                    $cat_id = isset($exp_file[3]) ? $exp_file[3] : '';
                    $catname = Category::getCatName($cat_id);
                    $gender = isset($exp_file[5]) ? $exp_file[5] : '';
                    $doi = isset($exp_file[6]) ? $exp_file[6] : '';
                    $facility = isset($exp_file[7]) ? $exp_file[7] : '';
                    $title = isset($exp_file[12]) ? $exp_file[12] : '';
                    $recorType = isset($exp_file[10]) ? $exp_file[10] : '';
					$dateofbirth = isset($exp_file[9]) ? $exp_file[9] : '';
					
                    $skipsummarymodel=Project::model()->findByPk($project_id);
                    if($skipsummarymodel->skip_edit=='1')
                    {
                        $bodyparts=isset($exp_file[14]) ? $exp_file[14] : '';
                        $diagonis=isset($exp_file[15]) ? $exp_file[15] : '';
                    }
					
					$ms_terms = "";
					$ms_value = "";
					$protem = Project::model()->with('template')->findByPk($project_id);
					$template = $protem->template->t_name; 
					if($template == "BACTESPDF"){
						$ms_terms = isset($exp_file[16]) ? $exp_file[16] : '';
						$ms_value = isset($exp_file[17]) ? $exp_file[17] : '';
					}
					
                    if ($recorType == 'M') {
                        if ($i == $medsrow) {
//                            $medi .= "<div class='uk-grid partionlen' style='padding:0;margin:0'>";
                            $medsrow += 4;
                            $mederow += 3;
                        }
//                        $medi .= "<div class='uk-width-small-1-4'>";
//                        $medi .= "<a tabindex='-1' id='brk_btn_$j'  data-bodyparts='$bodyparts' data-diagonis='$diagonis' data-row='$j' data-pagno='$exp_file[0]' data-dos='$exp_file[1]' data-pname='$exp_file[2]' data-cat='$exp_file[3]' title='$exp_file[0]' data-uk-tooltip='{cls:'long-text'}' data-provider='$exp_file[4]' data-gender='$gender' data-doi='$doi' data-dob='$dateofbirth' data-facility='$facility' data-title='$title' class='md-btn md-btn-primary  md-btn-wave-light waves-effect waves-button waves-light' href='javascript:void(0)' onfocus='getContent($(this))',onclick='getContent($(this))'>" . $catname . "<span id='cls' data-row='$j' data-type='M' onclick='divCls($(this))'>x</span></a>";
                        $medi .= "<a style='margin:0 1% 1% 0' tabindex='-1' id='brk_btn_$j'  data-bodyparts='$bodyparts' data-diagonis='$diagonis' data-msterms='$ms_terms' data-msvalue='$ms_value' data-row='$j' data-pagno='$exp_file[0]' data-dos='$exp_file[1]' data-pname='$exp_file[2]' data-cat='$exp_file[3]'  data-provider='$exp_file[4]' data-gender='$gender' data-doi='$doi' data-dob='$dateofbirth' data-facility='$facility' data-title='$title' class='md-btn md-btn-primary  md-btn-wave-light waves-effect waves-button waves-light' href='javascript:void(0)' onfocus='getContent($(this))',onclick='getContent($(this))'>" . $catname . "<span class='cls' data-row='$j' data-type='M' onclick='divCls($(this))'>x</span></a>";
						////onfocus="getContent($(this))" onclick="getContent($(this))"
						$tab_medi .=	'<tr class ="medicaltable" id="brk_btn_'.$j.'"  data-catname="'.$catname.'" data-bodyparts="'.$bodyparts.'" data-diagonis="'.$diagonis.'" data-msterms="'.$ms_terms.'" data-msvalue="'.$ms_value.'" data-row="'.$j.'" data-pagno="'.$exp_file[0].'" data-dos="'.$exp_file[1].'" data-pname="'.$exp_file[2].'" data-cat="'.$exp_file[3].'" data-provider="'.$exp_file[4].'" data-gender="'.$gender.'" data-doi="'.$doi.'" data-dob="'.$dateofbirth.'" data-facility="'.$facility.'" data-title="'.$title.'" data-type="M" onclick="getContent($(this))" ondblclick="Dbclk(\'M\',$(this))" href="javascript:void(0)" > 
                                    <td class="uk-text-center" title="'.$exp_file[0].'" data-uk-tooltip="{cls:"long-text"}">'.$exp_file[0].'</td>
                                    <td class="uk-text-center" title="'.$exp_file[1].'" data-uk-tooltip="{cls:"long-text"}">'.$exp_file[1].'</td>
									<td class="uk-text-center" title="'.$catname.'" data-uk-tooltip="{cls:"long-text"}">'.$catname.'</td>
                                    <td class="uk-text-center" title="'.$exp_file[2].'" data-uk-tooltip="{cls:"long-text"}">'.$exp_file[2].'</td>';
									if($promodel->p_name != "MV"){
								$tab_medi .= '<td class="uk-text-center" title="'.str_replace('^', ' ', $exp_file[4]).'" data-uk-tooltip="{cls:"long-text"}">'.str_replace('^', ' ', $exp_file[4]).'</td>';
									}
								$tab_medi .= '
                                </tr>';
								
						//                        $medi .= "</div>";
                        if ($mederow == $i) {
//                            $medi .= '</div>';
                        }
                        $i++;
                    } else if ($recorType == 'N') {
                        if ($nmedsrow == $k) {
//                            $nonmedi .= "<div class='uk-grid partionlen' style='padding:0;margin:0'>";
                            $nmedsrow += 4;
                            $nmederow += 3;
                        }
//                        $nonmedi .= "<div class='uk-width-small-1-4'>";
                        $nonmedi .= "<a style='margin:0 1% 1% 0' tabindex='-1' id='brk_btn_$j' data-bodyparts='$bodyparts' data-diagonis='$diagonis' data-msterms='$ms_terms' data-msvalue='$ms_value' data-row='$j' data-pagno='$exp_file[0]' data-dos='$exp_file[1]' data-pname='$exp_file[2]' data-cat='$exp_file[3]' title='$exp_file[0]' data-uk-tooltip='{cls:'long-text'}' data-provider='$exp_file[4]' data-gender='$gender' data-doi='$doi' data-facility='$facility' data-title='$title' class='md-btn md-btn-primary  md-btn-wave-light waves-effect waves-button waves-light' href='javascript:void(0)' onfocus='getContent($(this))',onclick='getContent($(this))'>" . $catname . "<span class='cls' data-row='$j' data-type='N' onclick='divCls($(this))'>x</span></a>";
						//onfocus="getContent($(this))" onclick="getContent($(this))"
						$tab_nonmedi .=	'<tr id="brk_btn_'.$j.'"  data-catname="'.$catname.'" data-bodyparts="'.$bodyparts.'" data-diagonis="'.$diagonis.'" data-msterms="'.$ms_terms.'" data-msvalue="'.$ms_value.'" data-row="'.$j.'" data-pagno="'.$exp_file[0].'" data-dos="'.$exp_file[1].'" data-pname="'.$exp_file[2].'" data-cat="'.$exp_file[3].'" data-provider="'.$exp_file[4].'" data-gender="'.$gender.'" data-doi="'.$doi.'" data-facility="'.$facility.'" data-title="'.$title.'"  data-type="N" onclick="getContent($(this))" ondblclick="Dbclk(\'N\',$(this))" href="javascript:void(0)">
                                    <td class="uk-text-center" title="'.$exp_file[0].'" data-uk-tooltip="{cls:"long-text"}">'.$exp_file[0].'</td>
									<td class="uk-text-center" title="'.$catname.'" data-uk-tooltip="{cls:"long-text"}">'.$catname.'</td>
									
                                </tr>';	
						//                        $nonmedi .= "</div>";
                        if ($nmederow == $k) {
//                            $medi .= '</div>';
                        }
                        $k++;
                    }
                    $j++;
                }
            }
        }
		$tab_medi .= "</table>";
		$tab_nonmedi .= "</table>";
        $result = array('medi' => $medi, 'nonmedi' => $nonmedi, 'tab_medi' => $tab_medi, 'tab_nonmedi' => $tab_nonmedi);
        return $result;
    }

//Get user name
    public function getUsername($id) {
        $out = '';
        $query = UserDetails::model()->findByPk($id);
        if ($query) {
            $out = $query->ud_username;
        }
        return $out;
    }

}

?>