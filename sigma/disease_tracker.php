<?php
$cwd = getcwd();
chdir ("..");
require_once('db.php');
require_once('PHPExcel.php');
require_once('PHPExcel/Writer/Excel2007.php');
require_once('include.excel.php');
chdir ($cwd);
ini_set('memory_limit','-1');
ini_set('max_execution_time','60');	//1min

if(!isset($_REQUEST['id'])) return;
$id = mysql_real_escape_string(htmlspecialchars($_REQUEST['id']));

if(isset($_REQUEST['category']))
$categoryFlag = $_REQUEST['category'];
else
$categoryFlag = 0;


if(!is_numeric($id)) return;

if($_REQUEST['download'])
{
	DownloadDiseaseTrackerReports($categoryFlag);
	exit;
}

$page = 1;	
if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page']))
{
	$page = mysql_real_escape_string($_REQUEST['page']);
}

////Process Report Tracker
function showDiseaseTracker($id, $TrackerType, $page=1, $categoryFlag = false,  $data_matrix = array())
{
	$HTMLContent = '';  
	if(isset($_REQUEST['dwcount']))
		$CountType = $_REQUEST['dwcount'];
	else
		$CountType = 'total';

	$Return = DataGeneratorForDiseaseTracker($id, $TrackerType, $page, $CountType, $categoryFlag);
	
	$uniqueId = uniqid();
	
	///Required Data restored
	$data_matrix = $Return['matrix'];
	$Report_DisplayName = $Return['report_name'];
	$id = $Return['id'];
	$columns = $Return['columns'];
	$IdsArray = $Return['IdsArray'];
	$inner_columns = $Return['inner_columns'];
	$inner_width = $Return['inner_width'];
	$column_width = $Return['column_width'];
	$ratio = $Return['ratio'];
	$column_interval = $Return['column_interval'];
	$PhaseArray = $Return['PhaseArray'];
	$TotalPages = $Return['TotalPages'];
	$TotalRecords = $Return['TotalRecords'];
	$GobalEntityType = $Return['GobalEntityType'];
	$page = $Return['CurrentPage'];
	
	$MainPageURL = 'disease_tracker.php';
	if($TrackerType == 'PDT')	//DPT=DISEASE Disease TRACKER
		$MainPageURL = 'product.php';
	else if($TrackerType == 'CDT')	//DPT=DISEASE Disease TRACKER
		$MainPageURL = 'company.php';
	else if($TrackerType == 'MDT')	//DPT=DISEASE Disease TRACKER
		$MainPageURL = 'moa.php';
	else if($TrackerType == 'MCDT')	//DPT=DISEASE Disease TRACKER
		$MainPageURL = 'moacategory.php';			
	else if($TrackerType == 'INVESTDT')	//DPT=DISEASE Disease TRACKER
		$MainPageURL = 'investigator.php';			
	
	$HTMLContent .= DiseaseTrackerCommonCSS($uniqueId, $TrackerType);
	
	if($TrackerType=='DTH')
	$HTMLContent .= DiseaseTrackerHeaderHTMLContent($Report_DisplayName, $TrackerType);
	
	$HTMLContent .= DiseaseTrackerHTMLContent($data_matrix, $id, $columns, $IdsArray, $inner_columns, $inner_width, $column_width, $ratio, $column_interval, $PhaseArray, $TrackerType, $uniqueId, $TotalRecords, $TotalPages, $page, $MainPageURL, $GobalEntityType, $CountType);
	
	if($TotalPages > 1)
	{
		$paginate = DiseaseTrackerpagination($TrackerType, $TotalPages, $id, $page, $MainPageURL, $GobalEntityType, $CountType);
		$HTMLContent .= '<br/><br/>'.$paginate[1];
	}
	
	$HTMLContent .= DiseaseTrackerCommonJScript($uniqueId, $id, $MainPageURL, $GobalEntityType, $page, $TrackerType);
	
	return $HTMLContent;
}
///End of Process Report Tracker

function DataGeneratorForDiseaseTracker($id, $TrackerType, $page=1, $CountType, $categoryFlag = false)
{
	global $db;
	global $now;
	global $logger;
	
	//IMP DATA
	$DiseaseIds = array();
	$NewDiseaseIds = array();
	$data_matrix=array();
	
	///// No of columns in our graph
	$columns = 10;
	$inner_columns = 10;
	$column_width = 80;
	$max_count = 0;
	$PhaseArray = array('na', '0', '1', '2', '3', '4');
	$Report_DisplayName = NULL;
	
	//END DATA
	
	$query = "SELECT `name`, `display_name`, `id`, `class` FROM `entities` WHERE id='" . $id ."'";
	$res = mysql_query($query) or die( $query . ' '.mysql_error());
	
	$header = mysql_fetch_array($res);
	
	if($header['display_name'] != NULL && trim($header['display_name']) != '')
	$Report_DisplayName = $header['display_name'];
	else
	$Report_DisplayName = $header['name'];
	
	$GobalEntityType = $header['class'];
	$id=$header['id'];
	
	if($GobalEntityType == 'Disease')
	{
		print "Disease tracker does not support disease as input.";
		exit();
	}
	
	if($GobalEntityType != 'Product')	//FOR OTHER THAH
	{
		if($categoryFlag)
		{
			$Ids = array_filter(array_unique(GetDiseasesCatFromEntity_DiseaseTracker($id, $GobalEntityType)));
			$DiseaseCategoryIds = $Ids;

			if(count($Ids)==0){
				$results[] = array(); 
			}else{			
				$DiseaseCategoryQuery = "SELECT * FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) WHERE e.`class` = 'Disease_Category' AND er.`parent` IN (" . implode(",", $DiseaseCategoryIds) . ") group by id";
				
				$DiseaseQueryResult = mysql_query($DiseaseCategoryQuery) or die($DiseaseCategoryQuery.' '.mysql_error());
				
				while ($results[] = mysql_fetch_array($DiseaseQueryResult));
			}
		}
		else
		{
			$Ids = array_filter(array_unique(GetDiseasesFromEntity_DiseaseTracker($id, $GobalEntityType)));
			$DiseaseIds =  $Ids;
			if(count($DiseaseIds) > 0)
			{
				$ImplodeDiseaseIds = implode("','",$DiseaseIds);
			}
			else
			{
				$ImplodeDiseaseIds = '';
			}
			
			if($GobalEntityType == 'MOA' || $GobalEntityType == 'Institution')
			{
				$DiseaseQuery = "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e2 ON((rpt.`entity1`=e2.`id` AND e2.`class`='Disease') ) WHERE (rpt.`count_total` > 0) AND er.`child` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";
				$DiseaseQuery2= "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e2 ON((rpt.`entity2`=e2.`id` AND e2.`class`='Disease') ) WHERE (rpt.`count_total` > 0) AND er.`child` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";
								
				$DiseaseQueryResult = mysql_query($DiseaseQuery) or die($DiseaseQuery.' '.mysql_error());
				if($DiseaseQuery2)
					$DiseaseQueryResult2 = mysql_query($DiseaseQuery2) or die($DiseaseQuery2.' '. mysql_error());
				$results=array();
				while ($results[] = mysql_fetch_array($DiseaseQueryResult));
				if($DiseaseQuery2)
					while($results[] = mysql_fetch_array($DiseaseQueryResult2));
			
			}
			elseif ($GobalEntityType == 'Investigator')
			{
									
				$DiseaseQuery = "	SELECT DISTINCT er.child, er.parent as id, 
									e1.`name` AS name, e1.`display_name` AS dispname,er.child AS ProdId, dt.`phase` AS phase,  
									er.parent as entity1, er.child as entity2
									from entity_trials et
									JOIN data_trials dt ON ( et.trial=dt.larvol_id  and et.entity = '". $id ."' )
									JOIN entity_trials et2 ON (dt.larvol_id = et2.trial )
									JOIN entities e ON (et2.entity = e.id and e.class='Product' AND (e.`is_active` <> '0' OR e.`is_active` IS NULL))
									JOIN entity_relations er ON (e.id = er.child and er.parent IN ('" . $ImplodeDiseaseIds . "')   )
									JOIN entities e1 ON (er.parent=e1.id)
									group by er.parent,er.child, dt.phase desc";
									
				$DiseaseQueryResult = mysql_query($DiseaseQuery) or die($DiseaseQuery.' '.mysql_error());
				$results=array();
				while ($results[] = mysql_fetch_array($DiseaseQueryResult));
			}
			else if($GobalEntityType == 'MOA_Category')
			{
				$DiseaseQuery = "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e3 ON (e3.`id`= er.`child`) JOIN `entity_relations` er3 ON(e3.`id` = er3.`child`) JOIN `entities` e2 ON((rpt.`entity1`=e2.`id` AND e2.`class`='Disease') ) WHERE (rpt.`count_total` > 0) AND er3.`parent` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND e3.`class`='MOA' AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";	//SELECTING DISTINCT PHASES SO WE WILL HAVE MIN ROWS TO PROCESS
				$DiseaseQuery2 = "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e3 ON (e3.`id`= er.`child`) JOIN `entity_relations` er3 ON(e3.`id` = er3.`child`) JOIN `entities` e2 ON((rpt.`entity2`=e2.`id` AND e2.`class`='Disease')) WHERE (rpt.`count_total` > 0) AND er3.`parent` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND e3.`class`='MOA' AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";
				
				$DiseaseQueryResult = mysql_query($DiseaseQuery) or die($DiseaseQuery.' '.mysql_error());
				if($DiseaseQuery2)
					$DiseaseQueryResult2 = mysql_query($DiseaseQuery2) or die($DiseaseQuery2.' '. mysql_error());
				$results=array();
				while ($results[] = mysql_fetch_array($DiseaseQueryResult));
				if($DiseaseQuery2)
					while($results[] = mysql_fetch_array($DiseaseQueryResult2));
			
			}
			
			
		}
		
		
		$key = 0;
		foreach($results as $result)
		{
			if($categoryFlag)
			{
				$key = $DiseaseCategoryId = $result['id'];
				$DiseaseIds = getDiseaseIdsFromDiseaseCat($DiseaseCategoryId);
				//print_r($DiseaseIds);
				if(count($DiseaseIds) > 0)
				{
					$ImplodeDiseaseIds = implode("','",$DiseaseIds);
				}
				else
				{
					$ImplodeDiseaseIds = '';
				}
				
				if($GobalEntityType == 'MOA' || $GobalEntityType == 'Institution' ||  $GobalEntityType == 'Investigator')
				{
					/*$DiseaseQuery = "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, 
					rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e2 ON((rpt.`entity1`=e2.`id` AND e2.`class`='Disease') ) WHERE (rpt.`count_total` > 0) AND er.`child` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";
					*/
					$DiseaseQuery="SELECT e3.`id` AS id, e3.`name` AS name, e2.`display_name` AS dispname, e3.`class` AS class, e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e2 ON(e2.`id` = er.`child`) JOIN `entity_relations` er2 ON(er2.`parent`=e.`id`) JOIN `entities` e3 ON(e3.`id` = er2.`child`) WHERE (rpt.`count_total` > 0) AND (rpt.`entity1` = '". $DiseaseCategoryId ."' OR rpt.`entity2` = '". $DiseaseCategoryId ."') AND e3.`id` = ". $id ." AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";	
					
					$DiseaseQuery2="SELECT e3.`id` AS id, e3.`name` AS name, e2.`display_name` AS dispname, e3.`class` AS class, e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity2`=e.`id` AND e.`class`='Product') OR (rpt.`entity1`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e2 ON(e2.`id` = er.`child`) JOIN `entity_relations` er2 ON(er2.`parent`=e.`id`) JOIN `entities` e3 ON(e3.`id` = er2.`child`) WHERE (rpt.`count_total` > 0) AND (rpt.`entity1` = '". $DiseaseCategoryId ."' OR rpt.`entity2` = '". $DiseaseCategoryId ."') AND e3.`id` = ". $id ." AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";	
					/*
					$DiseaseQuery2 = "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e2 ON((rpt.`entity2`=e2.`id` AND e2.`class`='Disease') ) WHERE (rpt.`count_total` > 0) AND er.`child` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";
					*/
				}
				else if($GobalEntityType == 'MOA_Category')
				{
					$DiseaseQuery = "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e3 ON (e3.`id`= er.`child`) JOIN `entity_relations` er3 ON(e3.`id` = er3.`child`) JOIN `entities` e2 ON((rpt.`entity1`=e2.`id` AND e2.`class`='Disease') ) WHERE (rpt.`count_total` > 0) AND er3.`parent` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND e3.`class`='MOA' AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";	//SELECTING DISTINCT PHASES SO WE WILL HAVE MIN ROWS TO PROCESS
					$DiseaseQuery2 = "SELECT e2.`id` AS id, e2.`name` AS name, e2.`display_name` AS dispname,e.`id` AS ProdId, rpt.`highest_phase` AS phase, rpt.`entity1`, rpt.`entity2`, rpt.`count_total` FROM `rpt_masterhm_cells` rpt JOIN `entities` e ON((rpt.`entity1`=e.`id` AND e.`class`='Product') OR (rpt.`entity2`=e.`id` AND e.`class`='Product')) JOIN `entity_relations` er ON(e.`id` = er.`parent`) JOIN `entities` e3 ON (e3.`id`= er.`child`) JOIN `entity_relations` er3 ON(e3.`id` = er3.`child`) JOIN `entities` e2 ON((rpt.`entity2`=e2.`id` AND e2.`class`='Disease')) WHERE (rpt.`count_total` > 0) AND er3.`parent` = '". $id ."' AND e2.`id` IN ('" . $ImplodeDiseaseIds . "') AND e3.`class`='MOA' AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";
				}
				$DiseaseQueryResult = mysql_query($DiseaseQuery) or die($DiseseQuery.' '.mysql_error());
				if($DiseaseQuery2)
					$DiseaseQueryResult2 = mysql_query($DiseaseQuery2) or die($DiseseQuery2.' '.mysql_error());
				$resultsCat=array();
				while ($resultsCat[] = mysql_fetch_array($DiseaseQueryResult));
				if($DiseaseQuery2)
					while($resultsCat[] = mysql_fetch_array($DiseaseQueryResult2));
				$rowDiseases = $resultsCat;
			}else{
				$key = $DiseaseId = $result['id'];
			}

			if((isset($DiseaseId) && $DiseaseId != NULL) || (isset($DiseaseCategoryId) && $DiseaseCategoryId != NULL))
			{
				if($data_matrix[$key]['RowHeader'] == '' || $data_matrix[$key]['RowHeader'] == NULL)
				{
					/// Fill up all data in Data Matrix only, so we can sort all data at one place
					if($result['dispname'] != NULL && trim($result['dispname']) != '')
					$data_matrix[$key]['RowHeader'] = $result['dispname'];
					else
					$data_matrix[$key]['RowHeader'] = $result['name'];
					
					$data_matrix[$key]['ID'] = $result['id'];
					$NewDiseaseIds[] = $result['id'];
					
					if($DiseaseCategoryId)
					{
						$data_matrix[$key]['HeaderLink'] = 'disease_category.php?DiseaseCatId=' . $data_matrix[$key]['ID'];
						$identifierKey = 'DiseaseCatId=';
						//$trackerType = array('Institution' => 'DCCPT', 'MOA' => 'DCMPT', 'MOA_Category' => 'DCMCPT');
						$trackerType = array('Institution' => 'DISCATCPT', 'MOA' => 'DISCATMPT', 'MOA_Category' => 'DISCATMCPT');
					}
					elseif($GobalEntityType == 'Investigator')
					{
						$data_matrix[$key]['HeaderLink'] = 'disease.php?DiseaseId=' . $data_matrix[$key]['ID'];
						$identifierKey = 'DiseaseId=';
						$trackerType = array('Investigator' => 'INVESTDT');
					}
					else
					{
						$data_matrix[$key]['HeaderLink'] = 'disease.php?DiseaseId=' . $data_matrix[$key]['ID'];
						$identifierKey = 'DiseaseId=';
						$trackerType = array('Institution' => 'DCPT', 'MOA' => 'DMPT', 'MOA_Category' => 'DMCPT');
					}
					
					
					
					
					if($GobalEntityType == 'Institution')
					{
						$data_matrix[$key]['ColumnsLink'] = 'company.php?CompanyId=' . $id . '&'. $identifierKey . $data_matrix[$key]['ID'] . '&TrackerType='.$trackerType['Institution'];
					}
					else if($GobalEntityType == 'MOA')
					{
						$data_matrix[$key]['ColumnsLink'] = 'moa.php?MoaId=' . $id . '&'. $identifierKey . $data_matrix[$key]['ID'] . '&TrackerType='.$trackerType['MOA'];
					}
					else if($GobalEntityType == 'MOA_Category')
					{
						$data_matrix[$key]['ColumnsLink'] = 'moacategory.php?MoaCatId=' . $id . '&'. $identifierKey . $data_matrix[$key]['ID'] . '&TrackerType='.$trackerType['MOA_Category'];
					}				
					else if($GobalEntityType == 'Investigator')
					{
						$data_matrix[$key]['ColumnsLink'] = 'investigator.php?InvestigatorId=' . $id . '&'. $identifierKey . $data_matrix[$key]['ID'] . '&TrackerType='.$trackerType['Investigator'];
					}				
					///// Initialize data
					$data_matrix[$key]['phase_na']=0;
					$data_matrix[$key]['phase_0']=0;
					$data_matrix[$key]['phase_1']=0;
					$data_matrix[$key]['phase_2']=0;
					$data_matrix[$key]['phase_3']=0;
					$data_matrix[$key]['phase_4']=0;
				
					$data_matrix[$key]['TotalCount'] = 0;
					$data_matrix[$key]['productIds'] = array();	
					$data_matrix[$key]['ProdExistance'] = array();		
				}
				if($DiseaseCategoryId){
					foreach($rowDiseases as $rowDisease)
					{
						//if(1==1)
						//if((($rowDisease['entity1'] == $key && !in_array($rowDisease['entity2'],$data_matrix[$key]['ProdExistance'])) || ($rowDisease['entity2'] == $key && !in_array($rowDisease['entity1'],$data_matrix[$key]['ProdExistance']))))	//Avoid duplicates like (1,2) and (2,1) type
						if( !in_array($rowDisease['larvol_id'],$data_matrix[$key]['ProdExistance']))
						{
							if($rowDisease['entity1'] == $key)
								$data_matrix[$key]['ProdExistance'][] = $rowDisease['entity2'];
							else
								$data_matrix[$key]['ProdExistance'][] = $rowDisease['entity1'];
								
							if($rowDisease['phase'] == 'N/A' || $rowDisease['phase'] == '' || $rowDisease['phase'] === NULL)
							{
								$CurrentPhasePNTR = 0;
							}
							else if($rowDisease['phase'] == '0')
							{
								$CurrentPhasePNTR = 1;
							}
							else if($rowDisease['phase'] == '1' || $rowDisease['phase'] == '0/1' || $rowDisease['phase'] == '1a'
									|| $rowDisease['phase'] == '1b' || $rowDisease['phase'] == '1a/1b' || $rowDisease['phase'] == '1c')
							{
								$CurrentPhasePNTR = 2;
							}
							else if($rowDisease['phase'] == '2' || $rowDisease['phase'] == '1/2' || $rowDisease['phase'] == '1b/2'
									|| $rowDisease['phase'] == '1b/2a' || $rowDisease['phase'] == '2a' || $rowDisease['phase'] == '2a/2b'
									|| $rowDisease['phase'] == '2a/b' || $rowDisease['phase'] == '2b')
							{
								$CurrentPhasePNTR = 3;
							}
							else if($rowDisease['phase'] == '3' || $rowDisease['phase'] == '2/3' || $rowDisease['phase'] == '2b/3'
									|| $rowDisease['phase'] == '3a' || $rowDisease['phase'] == '3b')
							{
								$CurrentPhasePNTR = 4;
							}
							else if($rowDisease['phase'] == '4' || $rowDisease['phase'] == '3/4' || $rowDisease['phase'] == '3b/4')
							{
								$CurrentPhasePNTR = 5;
							}
								
							$MAXPhasePNTR = $CurrentPhasePNTR;

							if(!in_array($rowDisease['ProdId'], $data_matrix[$key]['productIds']))//to avoid duplicates
							{
								if($rowDisease['phase'] != '' && $rowDisease['phase'] != NULL){
									$data_matrix[$key]['phase_'.$PhaseArray[$MAXPhasePNTR]]++; //INCREASE COUNTER
								}
								$data_matrix[$key]['productIds'][] = $rowDisease['ProdId'];
							}
								
							$data_matrix[$key]['TotalCount'] = count($data_matrix[$key]['productIds']);
							if($max_count < $data_matrix[$key]['TotalCount'])
								$max_count = $data_matrix[$key]['TotalCount'];
						}	//End of if Product Existsnace
					}	
						
				}
				else
				{
				
					if((($result['entity1'] == $key && !in_array($result['entity2'],$data_matrix[$key]['ProdExistance'])) || ($result['entity2'] == $key && !in_array($result['entity1'],$data_matrix[$key]['ProdExistance']))))	//Avoid duplicates like (1,2) and (2,1) type
					{
						if($result['entity1'] == $key)
							$data_matrix[$key]['ProdExistance'][] = $result['entity2'];
						else
							$data_matrix[$key]['ProdExistance'][] = $result['entity1'];
							
						if($result['phase'] == 'N/A' || $result['phase'] == '' || $result['phase'] === NULL)
						{
							$CurrentPhasePNTR = 0;
						}
						else if($result['phase'] == '0')
						{
							$CurrentPhasePNTR = 1;
						}
						else if($result['phase'] == '1' || $result['phase'] == '0/1' || $result['phase'] == '1a'
								|| $result['phase'] == '1b' || $result['phase'] == '1a/1b' || $result['phase'] == '1c')
						{
							$CurrentPhasePNTR = 2;
						}
						else if($result['phase'] == '2' || $result['phase'] == '1/2' || $result['phase'] == '1b/2'
								|| $result['phase'] == '1b/2a' || $result['phase'] == '2a' || $result['phase'] == '2a/2b'
								|| $result['phase'] == '2a/b' || $result['phase'] == '2b')
						{
							$CurrentPhasePNTR = 3;
						}
						else if($result['phase'] == '3' || $result['phase'] == '2/3' || $result['phase'] == '2b/3'
								|| $result['phase'] == '3a' || $result['phase'] == '3b')
						{
							$CurrentPhasePNTR = 4;
						}
						else if($result['phase'] == '4' || $result['phase'] == '3/4' || $result['phase'] == '3b/4')
						{
							$CurrentPhasePNTR = 5;
						}
							
						$MAXPhasePNTR = $CurrentPhasePNTR;
						$data_matrix[$key]['phase_'.$PhaseArray[$MAXPhasePNTR]]++; //INCREASE COUNTER
							
						$data_matrix[$key]['productIds'][] = $result['ProdId'];
							
						$data_matrix[$key]['TotalCount'] = count($data_matrix[$key]['productIds']);
						if($max_count < $data_matrix[$key]['TotalCount'])
							$max_count = $data_matrix[$key]['TotalCount'];
					}	//End of if Product Existsnace
				}
													
			} //END OF IF - Disease ID NULL OR NOT			
		}	//END OF While - Fetch data
	}//End of Product as golbal entity
	else if($GobalEntityType == 'Product')
	{
		
		if($categoryFlag){
			$Ids = array_filter(array_unique(GetDiseasesCatFromEntity_DiseaseTracker($id, $GobalEntityType)));
			$DiseaseCategoryIds = $Ids;
			if(count($Ids)){
				$DiseaseCategoryQuery = "SELECT * FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) WHERE e.`class` = 'Disease_Category' AND er.`parent` IN (" . implode(",", $DiseaseCategoryIds) . ") group by id";
				$DiseaseQueryResult = mysql_query($DiseaseCategoryQuery) or die($DiseseCategoryQuery.' '.mysql_error());
			}
		}else{
			$Ids = array_filter(array_unique(GetDiseasesFromEntity_DiseaseTracker($id, $GobalEntityType)));
			$DiseaseIds =  $Ids;
			$DiseaseQuery = "SELECT DISTINCT dt.`larvol_id`, dt.`is_active`, dt.`phase` AS phase, dt.`institution_type`,et2.relation_type as relation_type,  e.`id` AS id, e.`name` AS name, e.`display_name` AS dispname FROM data_trials dt JOIN entity_trials et ON (dt.`larvol_id` = et.`trial`) JOIN entity_trials et2 ON (dt.`larvol_id` = et2.`trial`) JOIN entities e ON (e.id = et.`entity` AND e.`class` = 'Disease') WHERE et.`entity` IN ('" . implode("','",$DiseaseIds) . "') AND et2.`entity`='" . $id ."'";
			$DiseaseQueryResult = mysql_query($DiseaseQuery) or die($DiseaseQuery.'- '.mysql_error());
		}

		if(count($Ids)){
			$key = 0;
			while($result = mysql_fetch_array($DiseaseQueryResult))
			{
				if($categoryFlag){
					$key = $DiseaseCategoryId = $result['id'];
					$DiseaseIds = getDiseaseIdsFromDiseaseCat($DiseaseCategoryId);
					$DiseaseQuery2 = "SELECT DISTINCT dt.`larvol_id`, dt.`is_active`, dt.`phase` AS phase, dt.`institution_type`,et2.relation_type as relation_type,  e.`id` AS id, e.`name` AS name, e.`display_name` AS dispname FROM data_trials dt JOIN entity_trials et ON (dt.`larvol_id` = et.`trial`) JOIN entity_trials et2 ON (dt.`larvol_id` = et2.`trial`) JOIN entities e ON (e.id = et.`entity` AND e.`class` = 'Disease') WHERE et.`entity` IN ('" . implode("','",$DiseaseIds) . "') AND et2.`entity`='" . $id ."'";
					$resultCat = mysql_query($DiseaseQuery2) or die($DiseaseQuery2.' - '.mysql_error());
					

					$rowDiseases = array();
					while($row = mysql_fetch_array($resultCat)){
						$rowDiseases[] = $row;
					}
				}else{
					$key = $DiseaseId = $result['id']; 
				}
				if((isset($DiseaseId) && $DiseaseId != NULL) || (isset($DiseaseCategoryId) && $DiseaseCategoryId != NULL))
				{
					if($data_matrix[$key]['RowHeader'] == '' || $data_matrix[$key]['RowHeader'] == NULL)
					{

						/// Fill up all data in Data Matrix only, so we can sort all data at one place
						if($result['dispname'] != NULL && trim($result['dispname']) != '')
							$data_matrix[$key]['RowHeader'] = $result['dispname'];
						else
							$data_matrix[$key]['RowHeader'] = $result['name'];
						
						$data_matrix[$key]['ID'] = $result['id'];
						$NewDiseaseIds[] = $result['id'];
						if($CountType=='active')
						{
							$link_part = '&list=1';
						}
						elseif($CountType=='total')
						{
							$link_part = '&list=2';
						}
						elseif($CountType=='owner_sponsored')
						{
							$link_part = '&list=1&osflt=on';
						}
						else
						{
							$link_part = '&list=1&itype=0';
						}
						
						if($DiseaseCategoryId){
							$data_matrix[$key]['HeaderLink'] = 'disease_category.php?DiseaseCatId=' . $data_matrix[$key]['ID'];
						}else{
							$data_matrix[$key]['HeaderLink'] = 'disease.php?DiseaseId=' . $data_matrix[$key]['ID'];
						}	
						$data_matrix[$key]['ColumnsLink'] = 'ott.php?e1=' . $id . '&e2=' . $data_matrix[$key]['ID'].$link_part.'&sourcepg=TZ';
						
						///// Initialize data
						$data_matrix[$key]['phase_na']=0;
						$data_matrix[$key]['phase_0']=0;
						$data_matrix[$key]['phase_1']=0;
						$data_matrix[$key]['phase_2']=0;
						$data_matrix[$key]['phase_3']=0;
						$data_matrix[$key]['phase_4']=0;
					
						$data_matrix[$key]['TotalCount'] = 0;
						$data_matrix[$key]['larvolIds'] = array();	
						$data_matrix[$key]['TrialExistance'] = array();		
					}
					
					if($CountType == 'indlead' || $CountType == 'owner_sponsored' || $CountType == 'active')
					{
						if(!$result['is_active']) continue;
						if($CountType == 'indlead' && $result['institution_type'] != 'industry_lead_sponsor') continue;
						if($CountType == 'owner_sponsored' &&  $result['relation_type'] != 'ownersponsored') continue;
					}
					
					if($DiseaseCategoryId){
							foreach($rowDiseases as $rowDisease)
							{
								//print_r($rowDisease); die;
								//$rowDisease['id'] == $key && 
								if(!in_array($rowDisease['larvol_id'],$data_matrix[$key]['TrialExistance']))	//Avoid duplicates like (1,2) and (2,1) type
								{
									$data_matrix[$key]['TrialExistance'][] = $rowDisease['larvol_id'];
										
									if($rowDisease['phase'] == 'N/A' || $rowDisease['phase'] == '' || $rowDisease['phase'] === NULL)
									{
										$CurrentPhasePNTR = 0;
									}
									else if($rowDisease['phase'] == '0')
									{
										$CurrentPhasePNTR = 1;
									}
									else if($rowDisease['phase'] == '1' || $rowDisease['phase'] == '0/1' || $rowDisease['phase'] == '1a'
											|| $rowDisease['phase'] == '1b' || $rowDisease['phase'] == '1a/1b' || $$rowDisease['phase'] == '1c')
									{
										$CurrentPhasePNTR = 2;
									}
									else if($rowDisease['phase'] == '2' || $rowDisease['phase'] == '1/2' || $rowDisease['phase'] == '1b/2'
											|| $rowDisease['phase'] == '1b/2a' || $rowDisease['phase'] == '2a' || $rowDisease['phase'] == '2a/2b'
											|| $rowDisease['phase'] == '2a/b' || $rowDisease['phase'] == '2b')
									{
										$CurrentPhasePNTR = 3;
									}
									else if($rowDisease['phase'] == '3' || $rowDisease['phase'] == '2/3' || $rowDisease['phase'] == '2b/3'
											|| $rowDisease['phase'] == '3a' || $rowDisease['phase'] == '3b')
									{
										$CurrentPhasePNTR = 4;
									}	
									else if($rowDisease['phase'] == '4' || $rowDisease['phase'] == '3/4' || $rowDisease['phase'] == '3b/4')
									{
										$CurrentPhasePNTR = 5;
									}
										
									$MAXPhasePNTR = $CurrentPhasePNTR;
									$data_matrix[$key]['phase_'.$PhaseArray[$MAXPhasePNTR]]++; //INCREASE COUNTER
			
									$data_matrix[$key]['larvolIds'][] = $row['larvol_id'];
										
									$data_matrix[$key]['TotalCount'] = count($data_matrix[$key]['larvolIds']);
									if($max_count < $data_matrix[$key]['TotalCount'])
										$max_count = $data_matrix[$key]['TotalCount'];
								}	//End of if larvol Existsnace
							}
					}else{
						if($result['id'] == $key && !in_array($result['larvol_id'],$data_matrix[$key]['TrialExistance']))	//Avoid duplicates like (1,2) and (2,1) type
						{
							$data_matrix[$key]['TrialExistance'][] = $result['larvol_id'];
								
							if($result['phase'] == 'N/A' || $result['phase'] == '' || $result['phase'] === NULL)
							{
								$CurrentPhasePNTR = 0;
							}
							else if($result['phase'] == '0')
							{
								$CurrentPhasePNTR = 1;
							}
							else if($result['phase'] == '1' || $result['phase'] == '0/1' || $result['phase'] == '1a'
									|| $result['phase'] == '1b' || $result['phase'] == '1a/1b' || $result['phase'] == '1c')
							{
								$CurrentPhasePNTR = 2;
							}
							else if($result['phase'] == '2' || $result['phase'] == '1/2' || $result['phase'] == '1b/2'
									|| $result['phase'] == '1b/2a' || $result['phase'] == '2a' || $result['phase'] == '2a/2b'
									|| $result['phase'] == '2a/b' || $result['phase'] == '2b')
							{
								$CurrentPhasePNTR = 3;
							}
							else if($result['phase'] == '3' || $result['phase'] == '2/3' || $result['phase'] == '2b/3'
									|| $result['phase'] == '3a' || $result['phase'] == '3b')
							{
								$CurrentPhasePNTR = 4;
							}
							else if($result['phase'] == '4' || $result['phase'] == '3/4' || $result['phase'] == '3b/4')
							{
								$CurrentPhasePNTR = 5;
							}
								
							$MAXPhasePNTR = $CurrentPhasePNTR;
							$data_matrix[$key]['phase_'.$PhaseArray[$MAXPhasePNTR]]++; //INCREASE COUNTER

							$data_matrix[$key]['larvolIds'][] = $result['larvol_id'];
								
							$data_matrix[$key]['TotalCount'] = count($data_matrix[$key]['larvolIds']);
							if($max_count < $data_matrix[$key]['TotalCount'])
								$max_count = $data_matrix[$key]['TotalCount'];
						}	//End of if larvol Existsnace					
					}				
										
				} //END OF IF - Disease ID NULL OR NOT			
			}	//END OF While - Fetch data		
		}
	}
	
	//print_r($data_matrix);
	/// This function willl Sort multidimensional array according to Total count	
	$data_matrix = sortTwoDimensionArrayByKeyDiseaseTracker($data_matrix,'TotalCount');
	
	///////////PAGING DATA
	global $TabDiseaseCount;
	$TabDiseaseCount = count($data_matrix);	
	$RecordsPerPage = 50;
	$TotalPages = 0;
	$TotalRecords = count($data_matrix);
	$page=!empty($_REQUEST['page'])?$_REQUEST['page']:1;
	
	if(!isset($_REQUEST['download']))
	{
		$TotalPages = ceil(count($data_matrix) / $RecordsPerPage);
		$StartSlice = ($page - 1) * $RecordsPerPage;
		$EndSlice = $StartSlice + $RecordsPerPage;
		$NewDiseaseIdsTemp = array_slice($data_matrix, $StartSlice, $RecordsPerPage);
		$data_matrix_temp = array_slice($data_matrix, $StartSlice, $RecordsPerPage);
		
		
		if (($TotalPages > 0 ) && (count($data_matrix_temp) == 0)){
			
			$StartSlice = ($TotalPages - 1) * $RecordsPerPage;
			$EndSlice = $StartSlice + $RecordsPerPage;
			$NewDiseaseIds = array_slice($data_matrix, $StartSlice, $RecordsPerPage);
			$data_matrix = array_slice($data_matrix, $StartSlice, $RecordsPerPage);
			$page=$TotalPages;
			
		} else {
			$NewDiseaseIds = $NewDiseaseIdsTemp;
			$data_matrix = $data_matrix_temp;
		}
		
		
	}
	
	/////////PAGING DATA ENDS
	
	$original_max_count = $max_count;
	$max_count = ceil(($max_count / $columns)) * $columns;
	$column_interval = $max_count / $columns;
	$inner_width = $column_width  / $inner_columns;
	
	if($max_count > 0)
	$ratio = ($columns * $inner_columns) / $max_count;
	
	///All Data send
	/*
	foreach($data_matrix as $key=>$val)
	{
		if( $val['phase_na']+$val['phase_0']+$val['phase_1']+$val['phase_2']+$val['phase_3']+$val['phase_4']==0 )
		{
			unset($data_matrix[$key]);
			unset($NewDiseaseIds[$key]);
		}
	}
	*/
	//$TotalRecords = count($data_matrix);
	$Return['matrix'] = $data_matrix;
	$Return['report_name'] = $Report_DisplayName;
	$Return['id'] = $id;
	$Return['columns'] = $columns;
	$Return['IdsArray'] = $NewDiseaseIds;
	$Return['inner_columns'] = $inner_columns;
	$Return['inner_width'] = $inner_width;
	$Return['column_width'] = $column_width;
	$Return['ratio'] = $ratio;
	$Return['column_interval'] = $column_interval;
	$Return['PhaseArray'] = $PhaseArray;
	$Return['TotalPages'] = $TotalPages;
	$Return['TotalRecords'] = $TotalRecords;
	$Return['GobalEntityType'] = $GobalEntityType;
	$Return['CurrentPage'] = $page;
	
	return $Return;
}
//// End of Data Generator	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Larvol Sigma</title>
<script type="text/javascript" src="scripts/popup-window.js"></script>
<script src="scripts/jquery-1.7.1.min.js"></script>
<script src="scripts/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="scripts/chrome.js"></script>
<script type="text/javascript" src="scripts/iepngfix_tilebg.js"></script>
<link href="css/popup_form.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/themes/cupertino/jquery-ui-1.8.17.custom.css" rel="stylesheet" type="text/css" media="screen" />
<style type="text/css">
body { font-family:Verdana; font-size: 13px;}
.report_name {
	font-weight:bold;
	font-size:18px;
}

					
</style>
<?php
function DiseaseTrackerCommonCSS($uniqueId, $TrackerType)
{
	$htmlContent = '';
	$htmlContent = '<style type="text/css">

					/* To add support for transparancy of png images in IE6 below htc file is added alongwith iepngfix_tilebg.js */
					img { behavior: url("css/iepngfix.htc"); }					
					a, a:hover{ height:100%; width:100%; display:block; text-decoration:none;}
					
					.controls td{
						border-bottom:1px solid #44F;
						border-right:1px solid #44F;
						padding: 0px 0 0 15px;
					}
					.controls th{
						font-weight:normal;
						border-bottom: 1px solid #4444FF;
						border-right: 1px solid #4444FF;
					}
					.right{
						border-right:0px !important;
					}
					
					.bottom{
						border-bottom:0px !important;
					}
					.controls input{
						margin:0.1em;
					}
					
					#slideout_'.$uniqueId.' {
						position: fixed;
						_position:absolute;
						top: '.(($TrackerType != 'DTH') ? '200':'40').'px;
						right: 0;
						margin: 12px 0 0 0;
					}
					
					.slideout_inner {
						position:absolute;
						top: '.(($TrackerType != 'DTH') ? '200':'40').'px;
						right: -255px;
						display:none;
					}
					
					#slideout_'.$uniqueId.':hover .slideout_inner{
						display : block;
						position:absolute;
						top: 2px;
						right: 0px;
						width: 280px;
						z-index:10;
					}
					
					.table-slide{
						border:1px solid #000;
						height:100px;
						width:280px;
					}
					.table-slide td{
						border-right:1px solid #000;
						padding:8px;
						padding-right:20px;
						border-bottom:1px solid #000;
					}
					
					.gray {
						background-color:#CCCCCC;
						width: 35px;
						height: 18px;
						float: left;
						text-align: center;
						margin-right: 1px;
						padding-top:3px;
					}
					
					.blue {
						background-color:#00ccff;
						width: 35px;
						height: 18px;
						float: left;
						text-align: center;
						margin-right: 1px;
						padding-top:3px;
					}
					
					.green {
						background-color:#99cc00;
						width: 35px;
						height: 18px;
						float: left;
						text-align: center;
						margin-right: 1px;
						padding-top:3px;
					}
					
					.yellow {
						background-color:#ffff00;
						width: 35px;
						height: 18px;
						float: left;
						text-align: center;
						margin-right: 1px;
						padding-top:3px;
					}
					
					.orange {
						background-color:#ff9900;
						width: 35px;
						height: 18px;
						float: left;
						text-align: center;
						margin-right: 1px;
						padding-top:3px;
					}
					
					.red {
						background-color:#ff0000;
						width: 35px;
						height: 18px;
						float: left;
						text-align: center;
						margin-right: 1px;
						padding-top:3px;
					}
					
					.downldbox {
						height:auto;
						width:310px;
						font-weight:bold;
					}
					
					.downldbox ul{
						list-style:none;
						margin:5px;
						padding:0px;
					}
					
					.downldbox ul li{
						width: 130px;
						float:left;
						margin:2px;
					}
					
					.dropmenudiv{
						position:absolute;
						top: 0;
						border: 1px solid #DDDDDD; /*THEME CHANGE HERE*/
						/*border-bottom-width: 0;*/
						font:normal 12px Verdana;
						line-height:18px;
						z-index:100;
						background-color: white;
						width: 50px;
						visibility: hidden;
					}
					
					.break_words{
						word-wrap: break-word;
					}
					
					.tag {
						color:#120f3c;
						font-weight:bold;
					}
					
					.graph_bottom {
						border-bottom:1px solid #CCCCCC;
					}
					
					th { 
						font-weight:normal; 
					}
					
					.last_tick_height {
						height:4px;
					}
					
					.last_tick_width {
						width:4px;
					}
					
					.graph_top {
						border-top:1px solid #CCCCCC;
					}
					
					.graph_right {
						border-right:1px solid #CCCCCC;
					}
					
					.graph_rightWhite {
						/*border-right:1px solid #FFFFFF;*/
					}
					
					.RowHeader_col {
						width:420px;
						max-width:420px;
						word-wrap: break-word;
					}
					
					.side_tick_height {
						height:1px;
						line-height:1px;
					}
					
					.graph_gray {
						background-color:#CCCCCC;
					}
					
					.graph_blue {
						background-color:#00ccff;
					}
					
					.graph_green {
						background-color:#99cc00;
					}
					
					.graph_yellow {
						background-color:#ffff00;
					}
					
					.graph_orange {
						background-color:#ff9900;
					}
					
					.graph_red {
						background-color:#ff0000;
					}
					
					.Link {
					height:20px;
					min-height:20px;
					max-height:20px;
					padding:0px;
					margin:0px;
					_height:20px;
					}
					
					.tag {
					color:#120f3c;
					font-weight:normal;
					}
					
					.pagination {
						width:100%;
						float:none;
						float: left; 
						padding-top:0px; 
						vertical-align:top;
						font-weight:bold;
						/*padding-bottom:25px;*/
						color:#4f2683;
					}
					
					.pagination a:hover {
						background-color: #aa8ece;
						color: #FFFFFF;
						font-weight:bold;
						display:inline;
					}
					
					.pagination a {
						margin: 0 2px;
						border: 1px solid #CCC;
						background-color:#4f2683;
						font-weight: bold;
						padding: 2px 5px;
						text-align: center;
						color: #FFFFFF;
						text-decoration: none;
						display:inline;
					}
					
					.pagination span {
						padding: 2px 5px;
					}
					
					.records {
						background-color:#aa8ece;
						color:#FFFFFF;
						float:right;
						font-weight: bold;
						height: 16px;
						padding: 2px;
					}
					.bottom .radio-input{
						vertical-align: middle;
					}
					</style>';
	return $htmlContent;				
}

function DiseaseTrackerCommonJScript($uniqueId, $id, $MainPageURL, $GobalEntityType, $page, $TrackerType)
{
	$htmlContent = '';
	
	$url = 'id='.$id.'&page='.$page;
	if($TrackerType == 'PDT')	//PDT = PRODUCT DISEASE TRACKER
		$url = 'e1='.$id.'&page='.$page.'&tab=diseasetrac';
	else if($TrackerType == 'CDT')	//CDT = COMPANY DISEASE TRACKER
		$url = 'CompanyId='.$id.'&page='.$page.'&tab=diseasetrac';
	else if($TrackerType == 'MDT')	//MDT = MOA DISEASE TRACKER
		$url = 'MoaId='.$id.'&page='.$page.'&tab=diseasetrac';
	else if($TrackerType == 'MCDT')	//MCDT = MOA CATEGORY DISEASE TRACKER
		$url = 'MoaCatId='.$id.'&page='.$page.'&tab=diseasetrac';
	else if($TrackerType == 'INVESTDT')	
		$url = 'InvestigatorId='.$id.'&page='.$page.'&tab=Diseases';
		
		
	//Script for view change
	if($GobalEntityType == 'Product')
	$htmlContent .= "<script language=\"javascript\" type=\"text/javascript\">
					function change_view_".$uniqueId."_()
					{
						var dwcount = document.getElementById('".$uniqueId."_dwcount');
						if(dwcount.value == 'active')
						{
							location.href = \"". $MainPageURL ."?".$url."&dwcount=active\";
						}
						else if(dwcount.value == 'total')
						{
							location.href = \"". $MainPageURL ."?".$url."&dwcount=total\";
						}
						else if(dwcount.value == 'owner_sponsored')
						{
							location.href = \"". $MainPageURL ."?".$url."&dwcount=owner_sponsored\";
						}
						else
						{
							location.href = \"". $MainPageURL ."?".$url."&dwcount=indlead\";
						}
					}
						</script>";
		
	//Script for view change ends	
	
	//Script for Fixed header while resize
	$htmlContent .= "<script type=\"text/javascript\">
       				 var currentFixedHeader_".$uniqueId.";
       				 var currentGhost_".$uniqueId.";
					 var ScrollOn_".$uniqueId." = false;
		
					//Start - Header recreation in case of window resizing
					$(window).resize(function() {
							$.fn.reverse = [].reverse;
							var createGhostHeader_".$uniqueId." = function (header, topOffset, leftOffset) {
        			        // Recreate heaaderin case of window resizing even if there is current ghost header exists
        			       if (currentGhost_".$uniqueId.")
            		        $(currentGhost_".$uniqueId.").remove();
                
           			     var realTable = $(header).parents('#".$uniqueId."_ProdTrackerTable');
                
            		    var headerPosition = $(header).offset();
           			    var tablePosition = $(realTable).offset();
                
          			    var container = $('<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"vertical-align:middle; background-color:#FFFFFF;\" id=\"".$uniqueId."_ProdTrackerTable1\"></table>');
                
             		   // Copy attributes from old table (may not be what you want)
          		      for (var i = 0; i < realTable[0].attributes.length; i++) {
          		          var attr = realTable[0].attributes[i];
						 //We are not manually copying table attributes so below line is commented cause it does not work in IE6 and IE7
            	        //container.attr(attr.name, attr.value);
            		    }
                                
                	// Set up position of fixed row
          		    container.css({
                    	position: 'fixed',
                   		top: -topOffset,
                    	left: (-$(window).scrollLeft() + leftOffset),
                    	width: $(realTable).outerWidth()
                	});
                
                	// Create a deep copy of our actual header and put it in our container
                	var newHeader = $(header).clone().appendTo(container);
                
                	var collection2 = $(newHeader).find('td');
               	 
                	// TODO: Copy the width of each <td> manually
                	$(header).find('td').each(function () {
                	    var matchingElement = $(collection2.eq($(this).index()));
                	    $(matchingElement).width(this.offsetWidth + 0.5);
                	});
				
                	currentGhost_".$uniqueId." = container;
                	currentFixedHeader_".$uniqueId." = header;
                
                	// Add this fixed row to the same parent as the table
                	$(table_".$uniqueId.").parent().append(currentGhost_".$uniqueId.");
                	return currentGhost_".$uniqueId.";
            	};

            	var currentScrollTop_".$uniqueId." = $(window).scrollTop();

            	var activeHeader_".$uniqueId." = null;
            	var table_".$uniqueId." = $('#".$uniqueId."_ProdTrackerTable').first();
            	var tablePosition_".$uniqueId." = table_".$uniqueId.".offset();
            	var tableHeight_".$uniqueId." = table_".$uniqueId.".height();
            
            	var lastHeaderHeight_".$uniqueId." = $(table_".$uniqueId.").find('thead').last().height();
            	var topOffset_".$uniqueId." = 0;
            
            	if(tableHeight_".$uniqueId." != 0)//check if table is visible in tab then only create ghost header
				{
					// Check that the table is visible and has space for a header
            		if (tablePosition_".$uniqueId.".top + tableHeight_".$uniqueId." - lastHeaderHeight_".$uniqueId." >= currentScrollTop_".$uniqueId.")
            		{
                		var lastCheckedHeader_".$uniqueId." = null;
                		// We do these in reverse as we want the last good header
                		var headers_".$uniqueId." = $(table_".$uniqueId.").find('thead').reverse().each(function () {
                			var position_".$uniqueId." = $(this).offset();
                		   
                		   	if (position_".$uniqueId.".top <= currentScrollTop_".$uniqueId.")
                		   	{
                		       	activeHeader_".$uniqueId." = this;
                		       	return false;
                		   	}
                		   
                		   	lastCheckedHeader_".$uniqueId." = this;
                		});
                	
                		if (lastCheckedHeader_".$uniqueId.")
                		{
                		    var offset_".$uniqueId." = $(lastCheckedHeader_".$uniqueId.").offset();
                		    if (offset_".$uniqueId.".top - currentScrollTop_".$uniqueId." < $(activeHeader_".$uniqueId.").height())
                		        topOffset_".$uniqueId." = $(activeHeader_".$uniqueId.").height() - (offset_".$uniqueId.".top - currentScrollTop_".$uniqueId.") + 1;
                		}
            		}
            		// No row is needed, get rid of one if there is one
            		if (activeHeader_".$uniqueId." == null && currentGhost_".$uniqueId.")
	            	{
	            	    currentGhost_".$uniqueId.".remove();
		
    		            currentGhost_".$uniqueId." = null;
    	    	        currentFixedHeader_".$uniqueId." = null;
    	        	}
    	        
    	        	// We have what we need, make a fixed header row
    	        	if (activeHeader_".$uniqueId.")
					{
    	            	createGhostHeader_".$uniqueId."(activeHeader_".$uniqueId.", topOffset_".$uniqueId.", ($('#".$uniqueId."_ProdTrackerTable').offset().left));
					}
				}//end of if for checking table is visible or not in tab
			});
			//End - Header recreation in case of window resizing";
		
    //Script for Fixed header while resize
	$htmlContent .= "///Start - Header creation or align header incase of scrolling
					$(window).scroll(function() {
    		        $.fn.reverse = [].reverse;
					if(!ScrollOn_".$uniqueId.")
					{
    		        	ScrollOn_".$uniqueId." = true;
					}
    		        var createGhostHeader_".$uniqueId." = function (header_".$uniqueId.", topOffset_".$uniqueId.", leftOffset_".$uniqueId.") {
    		            // Don't recreate if it is the same as the current one
    		            if (header_".$uniqueId." == currentFixedHeader_".$uniqueId." && currentGhost_".$uniqueId.")
        		        {
            		        currentGhost_".$uniqueId.".css('top', -topOffset_".$uniqueId." + \"px\");
							currentGhost_".$uniqueId.".css('left',(-$(window).scrollLeft() + leftOffset_".$uniqueId.") + \"px\");
        		            return currentGhost_".$uniqueId.";
        		        }
        		     
       		        if (currentGhost_".$uniqueId.")
       	             $(currentGhost_".$uniqueId.").remove();
                
       		         var realTable_".$uniqueId." = $(header_".$uniqueId.").parents('#".$uniqueId."_ProdTrackerTable');
        	        
            	    var headerPosition_".$uniqueId." = $(header_".$uniqueId.").offset();
            	    var tablePosition_".$uniqueId." = $(realTable_".$uniqueId.").offset();
                
            	    var container_".$uniqueId." = $('<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"vertical-align:middle; background-color:#FFFFFF;\" id=\"".$uniqueId."_ProdTrackerTable1\"></table>');
                
                	// Copy attributes from old table (may not be what you want)
               		for (var i = 0; i < realTable_".$uniqueId."[0].attributes.length; i++) {
                	    var attr_".$uniqueId." = realTable_".$uniqueId."[0].attributes[i];
						//We are not manually copying table attributes so below line is commented cause it does not work in IE6 and IE7
                	    //container.attr(attr.name, attr.value);
                	}
                                
                	// Set up position of fixed row
                	container_".$uniqueId.".css({
                	    position: 'fixed',
                	    top: -topOffset_".$uniqueId.",
                	    left: (-$(window).scrollLeft() + leftOffset_".$uniqueId."),
                	    width: $(realTable_".$uniqueId.").outerWidth()
                	});
                
                	// Create a deep copy of our actual header and put it in our container
                	var newHeader_".$uniqueId." = $(header_".$uniqueId.").clone().appendTo(container_".$uniqueId.");
                	
                	var collection2_".$uniqueId." = $(newHeader_".$uniqueId.").find('td');
                	
                	// TODO: Copy the width of each <td> manually
                	$(header_".$uniqueId.").find('td').each(function () {
                	    var matchingElement_".$uniqueId." = $(collection2_".$uniqueId.".eq($(this).index()));
                	    $(matchingElement_".$uniqueId.").width(this.offsetWidth + 0.5);
                	});
				
                	currentGhost_".$uniqueId." = container_".$uniqueId.";
                	currentFixedHeader_".$uniqueId." = header_".$uniqueId.";
                
                	// Add this fixed row to the same parent as the table
                	$(table_".$uniqueId.").parent().append(currentGhost_".$uniqueId.");
                	return currentGhost_".$uniqueId.";
            	};

            	var currentScrollTop_".$uniqueId." = $(window).scrollTop();
            	var activeHeader_".$uniqueId." = null;
            	var table_".$uniqueId." = $('#".$uniqueId."_ProdTrackerTable').first();
            	var tablePosition_".$uniqueId." = table_".$uniqueId.".offset();
            	var tableHeight_".$uniqueId." = table_".$uniqueId.".height();
				var lastHeaderHeight_".$uniqueId." = $(table_".$uniqueId.").find('thead').last().height();
            	var topOffset_".$uniqueId." = 0;
           
		   		if(tableHeight_".$uniqueId." != 0)//check if table is visible in tab then only create ghost header
		   		{
					// Check that the table is visible and has space for a header
            		if (tablePosition_".$uniqueId.".top + tableHeight_".$uniqueId." - lastHeaderHeight_".$uniqueId." >= currentScrollTop_".$uniqueId.")
            		{
            		    var lastCheckedHeader_".$uniqueId." = null;
            		    // We do these in reverse as we want the last good header
            		    var headers_".$uniqueId." = $(table_".$uniqueId.").find('thead').reverse().each(function () {
            		        var position_".$uniqueId." = $(this).offset();
            		        
            		        if (position_".$uniqueId.".top <= currentScrollTop_".$uniqueId.")
            		        {
            		            activeHeader_".$uniqueId." = this;
            		            return false;
            		        }
            		        
            		        lastCheckedHeader_".$uniqueId." = this;
            			});
                	
            		  	if (lastCheckedHeader_".$uniqueId.")
            		 	{
            		       	var offset_".$uniqueId." = $(lastCheckedHeader_".$uniqueId.").offset();
            		       	if (offset_".$uniqueId.".top - currentScrollTop_".$uniqueId." < $(activeHeader_".$uniqueId.").height())
            		       	    topOffset_".$uniqueId." = $(activeHeader_".$uniqueId.").height() - (offset_".$uniqueId.".top - currentScrollTop_".$uniqueId.") + 1;
            		   	}
            		}
					// No row is needed, get rid of one if there is one
            		if (activeHeader_".$uniqueId." == null && currentGhost_".$uniqueId.")	
	            	{
	            	    currentGhost_".$uniqueId.".remove();
	
		                currentGhost_".$uniqueId." = null;
		                currentFixedHeader_".$uniqueId." = null;
		            }
	            
		            // We have what we need, make a fixed header row
		            if (activeHeader_".$uniqueId.")
					{
		                createGhostHeader_".$uniqueId."(activeHeader_".$uniqueId.", topOffset_".$uniqueId.", ($('#".$uniqueId."_ProdTrackerTable').offset().left));
					}
				}//end of if - checking table visible in tab
	        });
			///End - Header creation or align header incase of scrolling
		</script>";
		
		return $htmlContent;
}
?>
</head>
<body bgcolor="#FFFFFF" style="background-color:#FFFFFF;">
<?php 

function DiseaseTrackerHeaderHTMLContent($Report_DisplayName, $TrackerType)
{	
	$Report_Name = $Report_DisplayName;
	$htmlContent = '';
	
	if( ( (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'larvolinsight') == FALSE&& strpos($_SERVER['HTTP_REFERER'], 'delta') == FALSE) || !isset($_SERVER['HTTP_REFERER']) ) && ( !isset($_REQUEST['LI']) || $_REQUEST['LI'] != 1) )
	{
		$htmlContent .= '<table cellspacing="0" cellpadding="0" width="100%" style="background-color:#FFFFFF;">'
					   . '<tr><td width="33%" style="background-color:#FFFFFF;"><img src="../images/Larvol-Trial-Logo-notag.png" alt="Main" width="327" height="47" /></td>'
					   . '<td width="34%" align="center" style="background-color:#FFFFFF;" nowrap="nowrap"><span style="color:#ff0000;font-weight:normal;margin-left:40px;">Interface work in progress</span>'
					   . '<br/><span style="font-weight:normal;">Send feedback to '
					   . '<a style="display:inline;color:#0000FF;" target="_self" href="mailto:larvoltrials@larvol.com">'
					   . 'larvoltrials@larvol.com</a></span></td>'
					   . '<td width="33%" align="right" style="background-color:#FFFFFF; padding-right:20px;" class="report_name">Name: ' . htmlspecialchars($Report_Name) . ' Disease Tracker</td></tr></table><br/>';
	}
	return $htmlContent;
}

function DiseaseTrackerHTMLContent($data_matrix, $id, $columns, $IdsArray, $inner_columns, $inner_width, $column_width, $ratio, $column_interval, $PhaseArray, $TrackerType, $uniqueId, $TotalRecords, $TotalPages, $page, $MainPageURL, $GobalEntityType, $CountType)
{				
	if(count($data_matrix) != 0){
		require_once('../tcpdf/config/lang/eng.php');
		require_once('../tcpdf/tcpdf.php');  
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
		$Line_Width = 20;
		$phase_legend_nums = array('4', '3', '2', '1', '0', 'na');
	}
	$htmlContent = '';
	$htmlContent .= '<br style="line-height:11px;"/>'
					.'<form action="disease_tracker.php" method="post">'
					. '<table border="0" cellspacing="0" cellpadding="0" class="controls" align="center">'
					. '<tr>';
	if(count($data_matrix) != 0){				
		if($TrackerType == 'DTH')				
		$htmlContent .= '<td style="vertical-align:top; border:0px;"><div class="records">'. $TotalRecords .'&nbsp;'. (($TotalRecords == 1) ? 'Disease':'Diseases') .'</div></td>';
		
		if($TotalPages > 1)
		{
			$paginate = DiseaseTrackerpagination($TrackerType, $TotalPages, $id, $page, $MainPageURL, $GobalEntityType, $CountType);
			$htmlContent .= '<td style="padding-left:0px; vertical-align:top; border:0px;">'.$paginate[1].'</td>';
		}
	}	
		if($GobalEntityType == 'Product')
		{
				$htmlContent .= '<td class="bottom right"><select id="'.$uniqueId.'_dwcount" name="dwcount" onchange="change_view_'.$uniqueId.'_();">'
						. '<option value="total" '. (($CountType == 'total') ?  'selected="selected"' : '' ).'>All trials</option>'
						. '<option value="indlead" '. (($CountType == 'indlead') ?  'selected="selected"' : '' ).'>Active industry trials</option>'
						. '<option value="owner_sponsored" '. (($CountType == 'owner_sponsored') ?  'selected="selected"' : '' ).'>Active owner-sponsored trials</option>'
						. '<option value="active" '. (($CountType == 'active') ?  'selected="selected"' : '' ).'>Active trials</option>'
						. '</select></td>';
		}	
	if(count($data_matrix) != 0){			
		$htmlContent .= '<td class="bottom right">'
						. '<div style="border:1px solid #000000; float:right; margin-top: 0px; padding:2px; color:#000000;" id="'.$uniqueId.'_chromemenu">
							<a rel="'.$uniqueId.'_dropmenu">
							<span style="padding:2px; padding-right:4px; background-position:left center; background-repeat:no-repeat; background-image:url(\'../images/save.png\'); cursor:pointer; ">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font color="#000000">Export</font></b></span></a>
							</div>'
						. '</td>';
	}				
	global $tabCommonUrl;
	if(isset($_REQUEST['category']) && $_REQUEST['category'] == 1){
		$catChecked = ' CHECKED';
		$catHidden = '<input type="hidden" name="category" id="category" value="1" />';
		$diseaseChecked = '';
	}else{
		$catChecked = '';
		$diseaseChecked =  ' CHECKED';
		$catHidden = '';
	}
	if($GobalEntityType == 'Investigator')
	{
		$htmlContent .= '</tr>'. '</table>';
	
	}
		
	else
		$htmlContent .= '<td class="bottom right">'
					. '<input type="radio" name="category_switch" class="radio-input" value="Disease Category View" onclick="location.href=\''.$tabCommonUrl.'&tab=diseasetrac&category=1\'"'. $catChecked .'><b>Disease Category View</b>'
					. '&nbsp;&nbsp;&nbsp;'					
					.'<input type="radio" name="category_switch" class="radio-input" value="Disease View" onclick="location.href=\''.$tabCommonUrl.'&tab=diseasetrac\'"' . $diseaseChecked.'><b>Disease View</b>'
					. $catHidden
					. '</td>'
					. '</tr>'
					. '</table>';
	if(count($data_matrix) != 0){				
		$htmlContent  .= '<div id="'.$uniqueId.'_dropmenu" class="dropmenudiv" style="width: 310px;">'
						.'<div style="height:100px; padding:6px;"><div class="downldbox"><div class="newtext">Download options</div>'
						. '<input type="hidden" name="id" id="'.$uniqueId.'_id" value="' . $id . '" />'
						. '<input type="hidden" name="TrackerType" id="'.$uniqueId.'_TrackerType" value="'. $TrackerType .'" />'
						. '<ul><li><label>Which format: </label></li>'
						. '<li><select id="'.$uniqueId.'_dwformat" name="dwformat" size="3" style="height:50px">'
						//. '<option value="exceldown" selected="selected">Excel</option>'
						. '<option value="pdfdown" selected="selected">PDF</option>'
						. '<option value="excelchartdown">Excel Chart</option>'
						. '<option value="tsvdown">TSV</option>'
						. '</select></li>'
						. '</ul>'
						. '<input type="submit" name="download" title="Download" value="Download file" style="margin-left:8px;"  />'
						. '</div></div>'
						. '</div><script type="text/javascript">cssdropdown.startchrome("'.$uniqueId.'_chromemenu");</script>';
	}
	$htmlContent  .= '</form>';
	if(count($data_matrix) != 0){								
		$htmlContent .= '<table border="0" align="center" width="'.(420+8+($inner_columns*$columns*8)+8+10).'px" style="vertical-align:middle;" cellpadding="0" cellspacing="0" id="'.$uniqueId.'_ProdTrackerTable">'
						. '<thead>';
		//scale
		//Row to keep alignement perfect at time of floating headers
		$htmlContent .= '<tr class="side_tick_height"><th class="RowHeader_col" width="420px">&nbsp;</th><th width="8px" class="graph_rightWhite">&nbsp;</th>';
		for($j=0; $j < $columns; $j++)
		{
			for($k=0; $k < $inner_columns; $k++)
			$htmlContent .= '<th width="8px" colspan="1" '. (($k == ($inner_columns-1)) ? 'class="graph_rightWhite" ':'' ) .'>&nbsp;</th>';
		}
		$htmlContent .= '<th width="8px"></th></tr>';

		/* Modified by By PK to add a gray stripe behind the x axis label and numbering*/
		$htmlContent .= '<tr style="background-color:#CCCCCC;"><th class="RowHeader_col" align="right">'.(($GobalEntityType == 'Product') ? 'Trials' : 'Products') .'</th><th width="8px" class="graph_rightWhite">&nbsp;</th>';
		$htmlContent .= '<th align="right" class="graph_rightWhite" colspan="1" width="8px">0</th>';
		for($j=0; $j < $columns; $j++)
		{
			if($column_interval == 0){
				$htmlContent .= '<th align="right" class="graph_rightWhite" colspan="'.$inner_columns.'">'.($j+1 == $columns ? ($j+1) * $column_interval : "").'</th>';
			}else{
				$htmlContent .= '<th align="right" class="graph_rightWhite" colspan="'.$inner_columns.'">'.(($j+1) * $column_interval).'</th>';
			}
		}		
		$htmlContent .= '</tr>';
		
		$htmlContent .= '<tr class="last_tick_height"><th class="last_tick_height RowHeader_col"><font style="line-height:4px;">&nbsp;</font></th><th class="graph_right"><font style="line-height:4px;">&nbsp;</font></th>';
		for($j=0; $j < $columns; $j++)
		$htmlContent .= '<th colspan="'.$inner_columns.'" class="graph_right graph_bottom"><font style="line-height:4px;">&nbsp;</font></th>';
		$htmlContent .= '<th></th></tr>';
		
		
		$htmlContent .='</thead>';
		//scale ends

		$htmlContent .= '<tr class="side_tick_height"><th class="RowHeader_col" width="420px">&nbsp;</th><th width="8px" class="graph_right">&nbsp;</th>';
		for($j=0; $j < $columns; $j++)
		{
			for($k=0; $k < $inner_columns; $k++)
			$htmlContent .= '<th width="8px" colspan="1" class="'. (($k == ($inner_columns-1)) ? 'graph_right':'' ) .'">&nbsp;</th>';
		}
		$htmlContent .= '<th width="8px"></th></tr>';

		foreach($IdsArray as $key => $Ids)
		{	
			$htmlContent .= '<tr class="side_tick_height"><th class="RowHeader_col side_tick_height">&nbsp;</th><th class="graph_right">&nbsp;</th>';
			for($j=0; $j < $columns; $j++)
			{
				$htmlContent .= '<th colspan="'.$inner_columns.'" class="graph_right">&nbsp;</th>';
			}
			$htmlContent .= '<th></th></tr>';
			
			////// Color Graph - Bar Starts
			
			//// Code for Indlead
			
			$htmlContent .= '<tr id="'.$uniqueId.'_Graph_Row_A_'.$key.'"><th align="right" class="RowHeader_col" id="'.$uniqueId.'_RowHeaderCol_'.$key.'" rowspan="3"><a href="'.  $data_matrix[$key]['HeaderLink'] . '" style="text-decoration:underline;">'.$data_matrix[$key]['RowHeader'].'</th><th class="graph_right" rowspan="3">&nbsp;</th>';
		
			///Below function will derive number of lines required to display disease name, as our graph size is fixed due to fixed scale, we can calculate approx max area  
			///for disease column. From that we can calculate extra height which will be distributed to up and down rows of graph bar, So now IE6/7 as well as chrome will not 
			///have issue of unequal distrirbution of extra height due to rowspan and bar will remain in middle, without use of JS.
			$ExtraAdjusterHeight = (($pdf->getNumLines($data_matrix[$key]['RowHeader'], ((650)*17/90)) * $Line_Width)  - 20) / 2;
			
			for($j=0; $j < $columns; $j++)
			{
				$htmlContent .= '<th height="'.$ExtraAdjusterHeight.'px" colspan="'.$inner_columns.'" class="graph_right"><font style="line-height:1px;">&nbsp;</font></th>';
			}
			$htmlContent .= '<th></th></tr><tr id="'.$uniqueId.'_Graph_Row_B_'.$key.'" class="Link" >';
			
			$Err = CountErrs($data_matrix, $key, $ratio);
				
			$Max_ValueKey = Max_ValueKeyDiseaseTracker($data_matrix[$key]['phase_na'], $data_matrix[$key]['phase_0'], $data_matrix[$key]['phase_1'], $data_matrix[$key]['phase_2'], $data_matrix[$key]['phase_3'], $data_matrix[$key]['phase_4']);
				
			$total_cols = $inner_columns * $columns;
			$Total_Bar_Width = ceil($ratio * $data_matrix[$key]['TotalCount']);
			$phase_space = 0;
		
			foreach($phase_legend_nums as $phase_nums)
			{
				if($data_matrix[$key]['phase_'.$phase_nums] > 0)
				{
					$Color = getClassNColorforPhaseDiseaseTracker($phase_nums);
					$Mini_Bar_Width = CalculateMiniBarWidthDiseaseTracker($ratio, $data_matrix[$key]['phase_'.$phase_nums], $phase_nums, $Max_ValueKey, $Err, $Total_Bar_Width);
					$phase_space =  $phase_space + $Mini_Bar_Width;					
					$htmlContent .= '<th colspan="'.$Mini_Bar_Width.'" class="Link '.$Color[0].'" title="'.$data_matrix[$key]['phase_'.$phase_nums].'" style="height:20px; _height:20px;"><a href="' . $data_matrix[$key]['ColumnsLink'] . '&phase='. $phase_nums . '" class="Link" >&nbsp;</a></th>';
				}
			}
			
			$remain_span = $total_cols - $phase_space;
			
			if($remain_span > 0)
			$htmlContent .= DrawExtraHTMLCellsDiseaseTracker($phase_space, $inner_columns, $remain_span);
			
			$htmlContent .= '<th></th></tr><tr id="'.$uniqueId.'_Graph_Row_C_'.$key.'">';
			for($j=0; $j < $columns; $j++)
			{
				$htmlContent .= '<th height="'.$ExtraAdjusterHeight.'px" colspan="'.$inner_columns.'" class="graph_right"><font style="line-height:1px;">&nbsp;</font></th>';
			}
			$htmlContent .= '<th></th></tr>';
			
			////// End Of - Color Graph - Bar Starts
			
			$htmlContent .= '<tr class="side_tick_height"><th class="RowHeader_col side_tick_height">&nbsp;</th><th class="'. (($key == (count($IdsArray)-1)) ? '':'graph_bottom') .' graph_right">&nbsp;</th>';
			for($j=0; $j < $columns; $j++)
			{
				$htmlContent .= '<th colspan="'.$inner_columns.'" class="graph_right">&nbsp;</th>';
			}
			$htmlContent .= '<th></th></tr>';
		}			   

		//Draw scale			   
		$htmlContent .= '<tr class="last_tick_height"><th class="last_tick_height RowHeader_col"><font style="line-height:4px;">&nbsp;</font></th><th class="graph_right"><font style="line-height:4px;">&nbsp;</font></th>';
		for($j=0; $j < $columns; $j++)
		$htmlContent .= '<th colspan="'.$inner_columns.'" class="graph_top graph_right"><font style="line-height:4px;">&nbsp;</font></th>';
		$htmlContent .= '<th></th></tr>';
		/* Current no need of lower scale
		$htmlContent .= '<tr><th class="RowHeader_col"></th><th class="graph_rightWhite"></th>';
		for($j=0; $j < $columns; $j++)
		$htmlContent .= '<th align="right" class="graph_rightWhite" colspan="'.(($j==0)? $inner_columns+1 : $inner_columns).'">'.(($j+1) * $column_interval).'</th>';
		$htmlContent .= '</tr>';
		//End of draw scale
		*/

		$htmlContent .= '</table>';
	}
	if(count($data_matrix) == 0) 
		return $htmlContent .= (isset($_REQUEST['category']) && $_REQUEST['category'] == 1)?'<br /><div>No Disease Category Found</div>':'<br /><div>No Disease Found</div>';
	else{	
		///Add HELP Tab here only
		$htmlContent .= '<div id="slideout_'.$uniqueId.'">
							<img src="../images/help.png" alt="Help" />
							<div class="slideout_inner">
								<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="table-slide">
									<tr><td colspan="2" style="padding-right: 1px;">
											<div style="float:left;padding-top:3px;">Phase&nbsp;</div>
											<div class="gray">N/A</div>
											<div class="blue">0</div>
											<div class="green">1</div>
											<div class="yellow">2</div>
											<div class="orange">3</div>
											<div class="red">4</div>
									</td></tr>
								</table>
							</div>
						</div>';
	}
	return $htmlContent;
}

function DrawExtraHTMLCellsDiseaseTracker($phase_space, $inner_columns, $remain_span)
{
	$aq_sp = 0;
	while($aq_sp < $phase_space)
	$aq_sp = $aq_sp + $inner_columns;
	
	$extra_sp = $aq_sp - $phase_space;
	if($extra_sp > 0)
	$extraHTMLContent .= '<th colspan="'.($extra_sp).'" class="graph_right Link">&nbsp;</th>';
	
	$remain_span = $remain_span - $extra_sp;
	while($remain_span > 0)
	{
		$extraHTMLContent .= '<th colspan="'.($inner_columns).'" class="graph_right Link">&nbsp;</th>';
		$remain_span = $remain_span - $inner_columns;
	}
	
	return $extraHTMLContent;
}

function DiseaseTrackerpagination($TrackerType, $totalPages, $id, $CurrentPage, $MainPageURL, $GobalEntityType, $CountType)
{	
	$url = '';
	$stages = 5;
			
	$url = 'id=' . $id .'&amp;tab=diseasetrac';
	
	$url = 'id='.$id;
	if($TrackerType == 'PDT')	//PDT = PRODUCT DISEASE TRACKER
		$url = 'e1='.$id.'&amp;tab=diseasetrac';
	else if($TrackerType == 'CDT')	//CDT = COMPANY DISEASE TRACKER
		$url = 'CompanyId='.$id.'&amp;tab=diseasetrac';
	else if($TrackerType == 'MDT')	//MDT = MOA DISEASE TRACKER
		$url = 'MoaId='.$id.'&amp;tab=diseasetrac';
	else if($TrackerType == 'MCDT')	//MCDT = MOA CATEGORY DISEASE TRACKER
		$url = 'MoaCatId='.$id.'&amp;tab=diseasetrac';
	else if($TrackerType == 'INVESTDT')	
		$url = 'InvestigatorId='.$id.'&tab=Diseases';
	if($GobalEntityType == 'Product')
		$url .= '&amp;dwcount=' . $CountType;	
	
	
	$rootUrl = $MainPageURL.'?';
	$paginateStr = '<table align="center"><tr><td style="border:0px;"><span class="pagination">';
	
	if($CurrentPage != 1)
	{
		$paginateStr .= '<a href=\'' . $rootUrl . $url . '&page=' . ($CurrentPage-1) . '\'>&laquo;</a>';
	}

	$prelink = 	'<a href=\'' . $rootUrl . $url . '&page=1\'>1</a>'
				.'<a href=\'' . $rootUrl . $url . '&page=2\'>2</a>'
				.'<span>...</span>';
	$postlink = '<span>...</span>'
				.'<a href=\'' . $rootUrl . $url . '&page=' . ($totalPages-1) . '\'>' . ($totalPages-1) . '</a>'
				.'<a href=\'' . $rootUrl . $url . '&page=' . $totalPages . '\'>' . $totalPages . '</a>';
			
	if($totalPages > (($stages * 2) + 3))
	{
		if($CurrentPage >= ($stages+3)){
			$paginateStr .= $prelink;
			if($totalPages >= $CurrentPage + $stages + 2)
			{
				$paginateStr .= generateLink($CurrentPage - $stages,$CurrentPage + $stages,$CurrentPage,$rootUrl,$url);
				$paginateStr .= $postlink;			
			}else{
					$paginateStr .= generateLink($totalPages - (($stages*2) + 2),$totalPages,$CurrentPage,$rootUrl,$url);
			}
		}else{
			$paginateStr .= generateLink(1,($stages*2) + 3,$CurrentPage,$rootUrl,$url);	
			$paginateStr .= $postlink;
		}		
	}else{
		$paginateStr .= generateLink(1,$totalPages,$CurrentPage,$rootUrl,$url);	
	}	

	if($CurrentPage != $totalPages)
	{
		$paginateStr .= '<a href=\'' . $rootUrl . $url . '&page=' . ($CurrentPage+1) . '\'>&raquo;</a>';
	}
	$paginateStr .= '</span></td></tr></table>';
	return array($url, $paginateStr);
}

if(isset($_REQUEST['id']))
print showDiseaseTracker($_REQUEST['id'], 'DTH', $page, $categoryFlag = true);
?>
<?
if($db->loggedIn() && (strpos($_SERVER['HTTP_REFERER'], 'larvolinsight') == FALSE) && (strpos($_SERVER['HTTP_REFERER'], 'delta') == FALSE))
{
	$cpageURL = 'http://';
	$cpageURL .= $_SERVER["SERVER_NAME"].urldecode($_SERVER["REQUEST_URI"]);
	echo '<a href="../li/larvolinsight.php?url='. $cpageURL .'"><span style="color:red;font-weight:bold;margin-left:10px;">LI view</span></a><br>';
}
?>
</body>
</html>
<?php
function DownloadDiseaseTrackerReports($categoryFlag)
{
	ob_start();
	if(!isset($_REQUEST['id'])) return;
	$id = mysql_real_escape_string(htmlspecialchars($_REQUEST['id']));
	if(!is_numeric($id)) return;
	$TrackerType = $_REQUEST['TrackerType'];
	
	if($_REQUEST['dwcount']=='active')
	{
		$tooltip=$title="Active trials";
		$pdftitle="Active trials";
		$link_part = $commonPart2.'&list=1';
		$mode = 'active';
	}
	elseif($_REQUEST['dwcount']=='total')
	{
		$pdftitle=$tooltip=$title="All trials (Active + Inactive)";
		$link_part = $commonPart2.'&list=2';
		$mode = 'total';
	}
	elseif($_REQUEST['dwcount']=='owner_sponsored')
	{
		$pdftitle=$tooltip=$title="Active owner-sponsored trials";
		$link_part = $commonPart2.'&list=1&osflt=on';
		$mode = 'owner_sponsored';
	}
	else
	{
		$tooltip=$title="Active industry lead sponsor trials";
		$pdftitle="Active industry lead sponsor trials";
		$link_part = $commonPart2.'&list=1&itype=0';
		$mode = 'indlead';
	}	
		
	$Return = DataGeneratorForDiseaseTracker($id, $TrackerType, 0, $mode, $categoryFlag);
	
	///Required Data restored
	$data_matrix = $Return['matrix'];
	$Report_DisplayName = $Return['report_name'];
	$id = $Return['id'];
	$columns = $Return['columns'];
	$IdsArray = $Return['IdsArray'];
	$inner_columns = $Return['inner_columns'];
	$inner_width = $Return['inner_width'];
	$column_width = $Return['column_width'];
	$ratio = $Return['ratio'];
	$column_interval = $Return['column_interval'];
	$PhaseArray = $Return['PhaseArray'];
	$GobalEntityType = $Return['GobalEntityType'];
	
	$total_cols = $inner_columns * $columns;
	
	$phase_legend_nums = array('4', '3', '2', '1', '0', 'na');
	
	$Report_Name = $Report_DisplayName;
	
	if($_REQUEST['dwformat']=='exceldown')
	{
	  	$name = $Report_Name;
		
		$Header_Col = 'A';
		$Start_Char = 'B';
		
		// Create excel file object
		$objPHPExcel = new PHPExcel();
	
		// Set properties
		$objPHPExcel->getProperties()->setCreator(SITE_NAME);
		$objPHPExcel->getProperties()->setLastModifiedBy(SITE_NAME);
		$objPHPExcel->getProperties()->setTitle(substr($name,0,20));
		$objPHPExcel->getProperties()->setSubject(substr($name,0,20));
		$objPHPExcel->getProperties()->setDescription(substr($name,0,20));
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(8);
		$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('verdana_old'); 
	
		// Build sheet
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle(substr($name,0,20));
		//$objPHPExcel->getActiveSheet()->getStyle('A1:AA2000')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(36);
		
		$Excel_HMCounter = 0;
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . ++$Excel_HMCounter, 'Report name:');
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $Excel_HMCounter . ':BH' . $Excel_HMCounter);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $Excel_HMCounter)->getAlignment()->applyFromArray(
      									array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
      											'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
     											'rotation'   => 0,
      											'wrap'       => false));
		if($categoryFlag == 1){	
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $Excel_HMCounter, $Report_Name.' Disease Category Tracker');
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $Excel_HMCounter, $Report_Name.' Disease Tracker');
		}
		
		if($GobalEntityType == 'Product')
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . ++$Excel_HMCounter, 'Display Mode:');
			$objPHPExcel->getActiveSheet()->mergeCells('B' . $Excel_HMCounter . ':BH' . $Excel_HMCounter);
			$objPHPExcel->getActiveSheet()->getStyle('B' . $Excel_HMCounter)->getAlignment()->applyFromArray(
											array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
													'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
													'rotation'   => 0,
													'wrap'       => false));
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $Excel_HMCounter, $tooltip);
		}
		
		/// Extra Row
		$Excel_HMCounter++;
		$from = $Start_Char;
		$from++;
		for($j=0; $j < $columns; $j++)
		{
			$to = getColspanforExcelExportDiseaseTracker($from, $inner_columns);
			$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':'. $to . $Excel_HMCounter);
			$from = $to;
			$from++;
		}
		
		/// Set Dimension
		$Char = $Start_Char;
		$objPHPExcel->getActiveSheet()->getColumnDimension($Char)->setWidth(1);
		$Char++;
		for($j=0; $j < ($columns+1); $j++)
		{
			for($k=0; $k < $inner_columns; $k++)
			{
				$objPHPExcel->getActiveSheet()->getColumnDimension($Char)->setWidth(1);
				$Char++;
			}
		}
		
		foreach($IdsArray as $key => $Ids)
		{	
			$Excel_HMCounter++;
	
			////// Color Graph - Bar Starts
				
			$cell = $Header_Col . $Excel_HMCounter;
			$objPHPExcel->getActiveSheet()->SetCellValue($cell, $data_matrix[$key]['RowHeader']);
			$objPHPExcel->getActiveSheet()->getCell($cell)->getHyperlink()->setUrl($data_matrix[$key]['HeaderLink']); 
			$objPHPExcel->getActiveSheet()->getCell($cell)->getHyperlink()->setTooltip($data_matrix[$key]['RowHeader']);
			 
			$from = $Start_Char;
			
			//// Limit disease names so that they will not overlap other cells
			$white_font['font']['color']['rgb'] = 'FFFFFF';
			$objPHPExcel->getActiveSheet()->getStyle($from . $Excel_HMCounter)->applyFromArray($white_font);
			$objPHPExcel->getActiveSheet()->setCellValue($from . $Excel_HMCounter, '.');
			$from++;
				
			//// Graph starts
			$Err = CountErrs($data_matrix, $key, $ratio);
			
			$Max_ValueKey = Max_ValueKeyDiseaseTracker($data_matrix[$key]['phase_na'], $data_matrix[$key]['phase_0'], $data_matrix[$key]['phase_1'], $data_matrix[$key]['phase_2'], $data_matrix[$key]['phase_3'], $data_matrix[$key]['phase_4']);
			
			$total_cols = $inner_columns * $columns;
			$Total_Bar_Width = ceil($ratio * $data_matrix[$key]['TotalCount']);
			$phase_space = 0;
			
			foreach($phase_legend_nums as $phase_nums)
			{
				if($data_matrix[$key]['phase_'.$phase_nums] > 0)
				{
					$Mini_Bar_Width = CalculateMiniBarWidthDiseaseTracker($ratio, $data_matrix[$key]['phase_'.$phase_nums], $phase_nums, $Max_ValueKey, $Err, $Total_Bar_Width);
					$phase_space =  $phase_space + $Mini_Bar_Width;					
					$url .= $data_matrix[$key]['ColumnsLink'] . '&phase='. $phase_nums;
					$from = CreatePhaseCellforExcelExportDiseaseTracker($from, $Mini_Bar_Width, $url, $Excel_HMCounter, $data_matrix[$key]['phase_'.$phase_nums], $phase_nums, $objPHPExcel);
				}
			}
			
			$remain_span = $total_cols - $phase_space;
		
			if($remain_span > 0)
			{
				$aq_sp = 0;
				while($aq_sp < $phase_space)
				$aq_sp = $aq_sp + $inner_columns;
				
				$extra_sp = $aq_sp - $phase_space;
				if($extra_sp > 0)
				{
					$to = getColspanforExcelExportDiseaseTracker($from, $extra_sp);
					$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':' . $to . $Excel_HMCounter);
					$from = $to;
					$from++;
				}
				
				$remain_span = $remain_span - $extra_sp;
				while($remain_span > 0)
				{
					$to = getColspanforExcelExportDiseaseTracker($from, $inner_columns);
					$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':' . $to . $Excel_HMCounter);
					$from = $to;
					$from++;
					
					$remain_span = $remain_span - $inner_columns;
				}
			} // End of remain span
			////// End Of - Color Graph - Bar
		}	/// End of rows foreach		
		
		
		$Excel_HMCounter++;
		$from = $Start_Char;
		$from++;
		for($j=0; $j < $columns; $j++)
		{
			$to = getColspanforExcelExportDiseaseTracker($from, $inner_columns);
			$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':'. $to . $Excel_HMCounter);
			$from = $to;
			$from++;
		}
		$objPHPExcel->getActiveSheet()->getRowDimension($Excel_HMCounter)->setRowHeight(5);
			
		$Excel_HMCounter++;
		$from = $Start_Char;
		$from++;
		
		$to = getColspanforExcelExportDiseaseTracker($from, 2);
		$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':'. $to . $Excel_HMCounter);
		$objPHPExcel->getActiveSheet()->SetCellValue($from . $Excel_HMCounter, 0);
		$from = $to;
		$from++;
			
		for($j=0; $j < $columns; $j++)
		{
			$to = getColspanforExcelExportDiseaseTracker($from, (($j==0)? $inner_columns : $inner_columns));
			$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':'. $to . $Excel_HMCounter);
			$objPHPExcel->getActiveSheet()->SetCellValue($from . $Excel_HMCounter, (($j+1) * $column_interval));
			$from = $to;
			$from++;
		}
		//$objPHPExcel->getActiveSheet()->getRowDimension($Excel_HMCounter)->setRowHeight(5);
		
		/// Extra Row
		$Excel_HMCounter++;
		
		
		/////Phase Legend
		$Excel_HMCounter++;
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $Excel_HMCounter, 'Phase:');
		
		$phases = array('N/A', 'Phase 0', 'Phase 1', 'Phase 2', 'Phase 3', 'Phase 4');
		$phasenums = array(); foreach($phases as $k => $p)  $phasenums[$k] = str_ireplace(array('phase',' '),'',$p);
		$phase_legend_nums = array('N/A', '0', '1', '2', '3', '4');
		//$p_colors = array('DDDDDD', 'BBDDDD', 'AADDEE', '99DDFF', 'DDFF99', 'FFFF00', 'FFCC00', 'FF9900', 'FF7711', 'FF4422');
		$p_colors = array('BFBFBF', '00CCFF', '99CC00', 'FFFF00', 'FF9900', 'FF0000');
		$phase_legend_colors = array('BFBFBF', '00CCFF', '99CC00', 'FFFF00', 'FF9900', 'FF0000');
		
		$from = $Start_Char;
		$from++;
		foreach($p_colors as $key => $color)
		{
			$to = getColspanforExcelExportDiseaseTracker($from, $inner_columns);
			$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':'. $to . $Excel_HMCounter);
			$objPHPExcel->getActiveSheet()->getStyle($from . $Excel_HMCounter)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle($from . $Excel_HMCounter)->getFill()->getStartColor()->setRGB($color);
			$objPHPExcel->getActiveSheet()->getStyle($from . $Excel_HMCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getCell($from . $Excel_HMCounter)->setValueExplicit($phasenums[$key], PHPExcel_Cell_DataType::TYPE_STRING);
			$from = $to;
			$from++;
		}
			
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			
		//ob_end_clean(); 
		
		header("Pragma: public");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Larvol_' . substr($Report_Name,0,20) . '_Disease_Analytic_Excel_' . date('Y-m-d_H.i.s') . '.xlsx"');
			
		header("Content-Transfer-Encoding: binary ");
		$objWriter->save('php://output');
		@flush();
	} //Excel Function Ends
	
	if($_REQUEST['dwformat']=='tsvdown')
	{
		$TSV_data = "";
		
		$TSV_data ="Disease Name \t Phase 4 \t Phase 3 \t Phase 2 \t Phase 1 \t Phase 0 \t Phase N/A \n";
		
		foreach($IdsArray as $key => $Ids)
		{
			$TSV_data .= $data_matrix[$key]['RowHeader']. " \t ";
			$TSV_data .= $data_matrix[$key]['phase_4'] ." \t ". $data_matrix[$key]['phase_3'] ." \t ". $data_matrix[$key]['phase_2'] ." \t ". $data_matrix[$key]['phase_1'] ." \t ". $data_matrix[$key]['phase_0'] ." \t ". $data_matrix[$key]['phase_na'] ." \n";
		}
		
		header("Pragma: public");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Content-type: application/force-download"); 
		header("Content-Type: application/tsv");
		header('Content-Disposition: attachment;filename="' . substr($Report_Name,0,20) . '_Disease_Tracker_' . date('Y-m-d_H.i.s'). '.tsv"');
		header("Content-Transfer-Encoding: binary ");
		echo $TSV_data;
	}	/// TSV FUNCTION ENDS HERE
	
	if($_REQUEST['dwformat']=='pdfdown')
	{
		require_once('../tcpdf/tcpdf.php');  
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		//$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Larvol Trials');
		$pdf->SetTitle('Larvol Trials');
		$pdf->SetSubject('Larvol Trials');
		$pdf->SetKeywords('Larvol Trials Disease Analytics, Larvol Trials Disease Analytics PDF Export');
		// In pdf we have used two kinds of font- Actual text we are going to display will have size 8
		// While at other places like displying space in subcolumns of graph cell, we have used font size as 6, 
		// cause to display font 8 or 7 we require more width upto 2mm
		// we can't allocate 2mm width as we have total 100 subcolumsn of graph which leads to 200mm size only for Bar of Graph (total page size in normal orientation has only 210mm width including margin) so its not possible to have 8/7 font at any other places of graph otherwise PDF gets broken.
		
		$pdf->SetFont('verdana_old', '', 6);
		$pdf->setFontSubsetting(false);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
		// remove default header/footer
		$pdf->setPrintHeader(false);
		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->AddPage();
		
		$font_height = 6;
		$FontEight_font_height = 8;
		$Page_Width = 192;
		$Header_Col_Width = 50;
		$Line_Height = 3.6;	/// Line height for font of size 6
		$FontEight_Line_Height = 3.96;	/// Line height for font of size 8
		$Min_One_Liner = 4.5;
		$Tic_dimension = 1;
		$subColumn_width = 1.4;
		
		$pdf->SetFont('verdanab', '', 8);	//Set font size as 8
		
		$Repo_Heading = $Report_Name.$TrackerName.' Disease Tracker' . (($GobalEntityType == 'Product') ? ', '.$pdftitle:'');
		$current_StringLength = $pdf->GetStringWidth($Repo_Heading, 'verdanab', '', 8);
		$pdf->MultiCell($Page_Width, '', $Repo_Heading, $border=0, $align='C', $fill=0, $ln=1, '', '', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0);
		$pdf->Ln(5);
		$pdf->SetFont('verdana_old', '', 6);	//Reset font size as 6
		$pdf->setCellPaddings(0, 0, 0, 0);
		$pdf->setCellMargins(0, 0, 0, 0);
		
		$Main_X = $pdf->GetX();
		$Main_Y = $pdf->GetY();
		
		foreach($IdsArray as $key => $Ids)
		{	
			$dimensions = $pdf->getPageDimensions();
			//Height calculation depending on disease name
			$rowcount = 0;
			
			$pdf->SetFont('verdana_old', '', 8);	//set font size as 8
 			//work out the number of lines required
			$rowcount = $pdf->getNumLines($data_matrix[$key]['RowHeader'], $Header_Col_Width, $reseth = false, $autopadding = false, $cellpadding = '', $border = 0);
			$pdf->SetFont('verdana_old', '', 6);	//Reset font size as 6
			
			if($rowcount < 1) $rowcount = 1;
 			$startY = $pdf->GetY();
			$row_height = $rowcount * $FontEight_Line_Height;	//Apply line height of font size 8
			
			if($rowcount <= 1)
			$Extra_Spacing = 0;
			else
			$Extra_Spacing = ($row_height - $Line_Height) / 2;
			/// Next Row Height + Last Tick Row Height
			$Total_Height = 0;
			$Total_Height = $Tic_dimension + $row_height + $Tic_dimension + $Tic_dimension + $font_height;
			
			if (($startY + $Total_Height) + $dimensions['bm'] > ($dimensions['hk']))
			{
				//this row will cause a page break, draw the bottom border on previous row and give this a top border
				CreateLastTickBorderDiseaseTracker($pdf, $Header_Col_Width, $Tic_dimension, $columns, $inner_columns, $subColumn_width, $column_interval, $GobalEntityType);
				$pdf->AddPage();
			}
			
			$ln=0;
			$Main_X = $pdf->GetX();
			$Main_Y = $pdf->GetY();
			/// Bypass disease column
			$Place_X = $Main_X+$Header_Col_Width;
			$Place_Y = $Main_Y;
			
			if($key==0)
				$border = array('mode' => 'ext', 'TR' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
			else
				$border = array('mode' => 'ext', 'R' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
			$pdf->MultiCell($Tic_dimension, $Tic_dimension, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Tic_dimension);
			$Place_X = $Place_X+$Tic_dimension;
			$Place_Y = $Place_Y;
			for($j=0; $j < $columns; $j++)
			{
				for($k=0; $k < $inner_columns; $k++)
				{
					if($k == $inner_columns-1 && $key!=0)
					$border = array('mode' => 'ext', 'R' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
					else
					$border = 0;
					if($j == $columns-1 && $k == $inner_columns-1) 
					$ln=1;
					
					$pdf->MultiCell($subColumn_width, $Tic_dimension, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Tic_dimension);
					
					if($j == $columns-1 && $k == $inner_columns-1) 
					$Place_Y = $Place_Y+$Tic_dimension;
					$Place_X = $Place_X+$subColumn_width;
					
				}
			}
			
			$pdf->SetX($Main_X);
			$pdf->SetY($Place_Y);
			
			$Place_X = $pdf->GetX();
			$Place_Y = $pdf->GetY();
		
			$ln=0;
			$pdfContent = '<div align="right" style="vertical-align:top; float:none;"><a style="color:#000000; text-decoration:none;" href="'. $data_matrix[$key]['HeaderLink'] . '" target="_blank" title="'. $title .'">'.$data_matrix[$key]['RowHeader'].'</div>';
			$border = array('mode' => 'ext', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
			
			$pdf->SetFont('freesans', ' ', 8, '', false); // Font size as 8
			$pdf->MultiCell($Header_Col_Width, $row_height, $pdfContent, $border=0, $align='R', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=true, $autopadding=false, $maxh=$row_height);
			$pdf->SetFont('verdana_old', '', 6);	//Reset font size as 6
			
			$Place_X = $Place_X + $Header_Col_Width;
			if($key==0)
				$border = array('mode' => 'ext', 'TB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)), 'L' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255,255,255)));
			else
				$border = array('mode' => 'ext', 'B' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)), 'LT' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255,255,255)));
			$pdf->MultiCell($Tic_dimension, $Line_Height, '', $border=0, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=true, $autopadding=false, $maxh=$row_height);
			
			$Place_X = $Place_X + $Tic_dimension;
			$Middle_Place = $Place_X;
			
			///// Part added to divide extra space formed by multiple rows of disease name
			if($Extra_Spacing > 0)
			{
				$ln=0;
				$Place_X = $Middle_Place;
				$Place_Y = $Place_Y;
				for($j=0; $j < $columns; $j++)
				{
					for($k=0; $k < $inner_columns; $k++)
					{
						if($k == $inner_columns-1)
						$border = array('mode' => 'ext', 'R' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
						else if ($k == 0 && $j==0)
						$border = array('mode' => 'int', 'L' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
						else
						$border = 0;
						if($j == $columns-1 && $k == $inner_columns-1) 
						$ln=1;
						
						$pdf->MultiCell($subColumn_width, $Extra_Spacing, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Extra_Spacing);
					
						if($j == $columns-1 && $k == $inner_columns-1) 
						$Place_Y = $Place_Y+$Extra_Spacing;
						
						$Place_X = $Place_X+$subColumn_width;
						
					}
				}
			}
			///// End of Part added to divide extra space formed by multiple rows of disease name
			
			$Place_X = $Middle_Place;
			
			//// Graph starts
			$Err = CountErrs($data_matrix, $key, $ratio);
			$Max_ValueKey = Max_ValueKeyDiseaseTracker($data_matrix[$key]['phase_na'], $data_matrix[$key]['phase_0'], $data_matrix[$key]['phase_1'], $data_matrix[$key]['phase_2'], $data_matrix[$key]['phase_3'], $data_matrix[$key]['phase_4']);
				
			$total_cols = $inner_columns * $columns;
			$Total_Bar_Width = ceil($ratio * $data_matrix[$key]['TotalCount']);
			$phase_space = 0;
			
			foreach($phase_legend_nums as $phase_nums)
			{
				if($data_matrix[$key]['phase_'.$phase_nums] > 0)
				{
					$border = setStyleforPDFExportDiseaseTracker($phase_nums, $pdf);
					$Width = $subColumn_width;
					$Mini_Bar_Width = CalculateMiniBarWidthDiseaseTracker($ratio, $data_matrix[$key]['phase_'.$phase_nums], $phase_nums, $Max_ValueKey, $Err, $Total_Bar_Width);
					$phase_space =  $phase_space + $Mini_Bar_Width;
						
					$pdf->Annotation($Place_X, $Place_Y, ($Width*$Mini_Bar_Width), $Line_Height, $data_matrix[$key]['phase_'.$phase_nums], array('Subtype'=>'Caret', 'Name' => 'Comment', 'T' => (($GobalEntityType == 'Product') ? 'Trials' : 'Products'), 'Subj' => 'Information', 'C' => array()));	
						
					$m=0;
					while($m < $Mini_Bar_Width)
					{
						$Color = getClassNColorforPhaseDiseaseTracker($phase_nums);
						$pdfContent = '<div align="center" style="vertical-align:top; float:none;"><a style="color:#'.$Color[1].'; text-decoration:none; line-height:2px;" href="'. $data_matrix[$key]['ColumnsLink'] . '&phase='. $phase_nums . '">&nbsp;</a></div>';
						$pdf->MultiCell($Width, $Line_Height, $pdfContent, $border=0, $align='C', $fill=1, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=true, $autopadding=false, $maxh=$Line_Height);
						$Place_X = $Place_X + $Width;
						$m++;
					}
				}
			} /// Foreach ends
				 			
			$remain_span = $total_cols - $phase_space;
		
			if($remain_span > 0)
			{
				$aq_sp = 0;
				while($aq_sp < $phase_space)
				$aq_sp = $aq_sp + $inner_columns;
				
				$extra_sp = $aq_sp - $phase_space;
				if($extra_sp > 0)
				{
					$Width = $extra_sp * $subColumn_width;
					$border = array('mode' => 'int', 'L' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
					$pdf->MultiCell($Width, $Line_Height, '', $border=0, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=true, $autopadding=false, $maxh=$Line_Height);
					$Place_X = $Place_X + $Width;
				}
				
				$remain_span = $remain_span - $extra_sp;
				while($remain_span > 0)
				{
					$Width = $inner_columns * $subColumn_width;
					$border = array('mode' => 'int', 'L' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
					$pdf->MultiCell($Width, $Line_Height, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=true, $autopadding=false, $maxh=$Line_Height);
					$Place_X = $Place_X + $Width;
					$remain_span = $remain_span - $inner_columns;
				//	if($remain_span <= $inner_columns )
				//	$ln=1;
				}
			} // End of remain span
			
			///EXTRA CELL FOR MAKING LINEBREAK
			$ln=1;
			$border = array('mode' => 'int', 'L' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
			$pdf->MultiCell(1, $Line_Height, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=true, $autopadding=false, $maxh=$Line_Height);
			$Place_Y = $Place_Y + $Line_Height;
			///// Part added to divide extra space formed by multiple rows of disease name
			if($Extra_Spacing > 0)
			{
				$ln=0;
				$Place_X = $Middle_Place;
				$Place_Y = $Place_Y;
				for($j=0; $j < $columns; $j++)
				{
					for($k=0; $k < $inner_columns; $k++)
					{
						if($k == $inner_columns-1)
						$border = array('mode' => 'ext', 'R' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
						else if ($k == 0 && $j==0)
						$border = array('mode' => 'int', 'L' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
						else
						$border = 0;
						if($j == $columns-1 && $k == $inner_columns-1) 
						$ln=1;
						
						$pdf->MultiCell($subColumn_width, $Extra_Spacing, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Extra_Spacing);
					
						if($j == $columns-1 && $k == $inner_columns-1) 
						$Place_Y = $Place_Y+$Extra_Spacing;
						
						$Place_X = $Place_X+$subColumn_width;
						
					}
				}
			}
			///// End of Part added to divide extra space formed by multiple rows of disease name
			
			$ln=0;
			$Place_X = $Main_X;
			$Place_Y = $Place_Y;
			/// Bypass disease column
			$Place_X =$Place_X+$Header_Col_Width;
			$Place_Y = $Place_Y;
			$border = array('mode' => 'ext', 'RB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
			$pdf->MultiCell($Tic_dimension, $Tic_dimension, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Tic_dimension);
			$Place_X = $Place_X+$Tic_dimension;
			$Place_Y = $Place_Y;
			for($j=0; $j < $columns; $j++)
			{
				for($k=0; $k < $inner_columns; $k++)
				{
					if($k == $inner_columns-1)
					$border = array('mode' => 'ext', 'R' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
					else
					$border = 0;
					if($j == $columns-1 && $k == $inner_columns-1) 
					$ln=1;
					
					$pdf->MultiCell($subColumn_width, $Tic_dimension, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Tic_dimension);
					
					if($j == $columns-1 && $k == $inner_columns-1) 
					$Place_Y = $Place_Y+$Tic_dimension;
					
					$Place_X = $Place_X+$subColumn_width;
					
				}
			}
			
			$pdf->SetX($Main_X);
			$pdf->SetY($Place_Y);
		}
				
		CreateLastTickBorderDiseaseTracker($pdf, $Header_Col_Width, $Tic_dimension, $columns, $inner_columns, $subColumn_width, $column_interval, $GobalEntityType);
			
		ob_end_clean();
		//Close and output PDF document
		$pdf->Output(''. substr($Report_Name,0,20) .'_Disease_Tracker_'. date("Y-m-d_H.i.s") .'.pdf', 'D');
	}	/// End of PDF Function
	
	//Start of Real Chart Excel
	if($_REQUEST['dwformat']=='excelchartdown')
	{
		$Repo_Heading = $Report_Name;
		
		$objPHPExcel = new PHPExcel();
		if($categoryFlag == 1){
			$WorksheetName = 'Disease_Category_Tracker';
		}else{
			$WorksheetName = 'Disease_Tracker';
		}
		$objPHPExcel->getActiveSheet()->setTitle($WorksheetName);
		$sheetPHPExcel = $objPHPExcel->getActiveSheet();
		
		//Create Input Array for Excel Sheet in required format
		$ExcelChartArray = array();	///Input array
		
		$FirstGraphPnt = 4;
		if(count($IdsArray) < 6)
			$LastGraphPnt = round($FirstGraphPnt + (count($IdsArray) * 4));
		else
			$LastGraphPnt = round($FirstGraphPnt + (count($IdsArray) * 2.6));
		
		//Start placing data after the 20 rows plus after our graph ends
		$CurrentExcelRow = $LastGraphPnt + 20;
		$DataStartRow = $CurrentExcelRow;
		
		$DataColumns = array('BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG');
		
		//Add Phase Array to Input Array
		$CurrentExcelChartArray = array(  '', 'phase N/A', 'phase 0', 'phase 1', 'phase 2', 'phase 3', 'phase 4');
		$ExcelChartArray[] = $CurrentExcelChartArray;
		
		foreach($DataColumns as $colId=>$colName)
		{
			$objPHPExcel->getActiveSheet()->setCellValue($colName.$CurrentExcelRow, $CurrentExcelChartArray[$colId]);
			//Set row dimenstion minimum as dont want to view data
			$objPHPExcel->getActiveSheet()->getRowDimension($CurrentExcelRow)->setRowHeight(0.1);
		
		}
		
		//Add each disease data array to Input Array
		for($decr=(count($IdsArray) - 1); $decr >= 0 ; $decr--)
		{
			$currentRow = $decr;
			$CurrentExcelChartArray = array();
			if(isset($data_matrix[$currentRow]['RowHeader']) && $data_matrix[$currentRow]['RowHeader'] != NULL)
			{
				$CurrentExcelChartArray = array($data_matrix[$currentRow]['RowHeader'], $data_matrix[$currentRow]['phase_na'], $data_matrix[$currentRow]['phase_0'], $data_matrix[$currentRow]['phase_1'], $data_matrix[$currentRow]['phase_2'], $data_matrix[$currentRow]['phase_3'], $data_matrix[$currentRow]['phase_4']);				
			}
			else
			{
				$CurrentExcelChartArray = array('', 0, 0, 0, 0, 0, 0);
			}
			
			$ExcelChartArray[] = $CurrentExcelChartArray;
			$CurrentExcelRow++;
			foreach($DataColumns as $colId=>$colName)
			{
				$objPHPExcel->getActiveSheet()->setCellValue($colName.$CurrentExcelRow, $CurrentExcelChartArray[$colId]);
			}
			
			//Set row dimenstion zero as dont want to view data
			$objPHPExcel->getActiveSheet()->getRowDimension($CurrentExcelRow)->setRowHeight(0.1);
		}
		//End of Input Array
		
		//Below will automatically places data starting from 'A' column but we are putting manually as we dont want to start from column 'A'
		//$sheetPHPExcel->fromArray($ExcelChartArray);
		
		//Add reference to data columns
		$labels = $values = array();
		foreach($DataColumns as $colName)
		{
			//set width of data columns minimum as we dont want to view this data
			$objPHPExcel->getActiveSheet()->getColumnDimension($colName)->setWidth(0.1);
			if($colName == 'BA') continue;
			$labels[] = new PHPExcel_Chart_DataSeriesValues('String', $WorksheetName.'!$'.$colName.'$'.$DataStartRow, null, 1);
			$values[] = new PHPExcel_Chart_DataSeriesValues('Number', $WorksheetName.'!$'.$colName.'$'.($DataStartRow+1).':$'.$colName.'$'.($DataStartRow + count($IdsArray)), null, 4);
		}
		
		$categories = array(
		  new PHPExcel_Chart_DataSeriesValues('String', $WorksheetName.'!$'.$DataColumns[0].'$'.($DataStartRow+1).':$'.$DataColumns[0].'$'.($DataStartRow + count($IdsArray)), null, 4));
	
		$series = new PHPExcel_Chart_DataSeries(
		  PHPExcel_Chart_DataSeries::TYPE_BARCHART,       // plotType
		  PHPExcel_Chart_DataSeries::GROUPING_STACKED,    // plotGrouping
		  array(5, 4, 3, 2, 1, 0),                        // plotOrder
		  $labels,                                        // plotLabel
		  $categories,                                    // plotCategory
		  $values                                         // plotValues
		);
		
		$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_BAR);
		$plotarea = new PHPExcel_Chart_PlotArea(null, array($series));
		$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, null, false);
		$title = new PHPExcel_Chart_Title('');
		if($categoryFlag == 1){
			$X_Label = new PHPExcel_Chart_Title('Diseases Categories');
			$chart_name = ' Disease Category Tracker';
		}else{
			$X_Label = new PHPExcel_Chart_Title('Diseases');
			$chart_name = ' Disease Tracker';
		}
		$Y_Label = new PHPExcel_Chart_Title('Number of '.(($GobalEntityType == 'Product') ? 'Trials' : 'Products'));
		$chart = new PHPExcel_Chart(
		  $chart_name,		                               // name
		  $title,                                           // title
		  $legend,                                        	// legend
		  $plotarea,                                      	// plotArea
		  true,                                          	// plotVisibleOnly
		  0,                                              	// displayBlanksAs
		 $X_Label,                                          // xAxisLabel
		 $Y_Label                                           // yAxisLabel
		);

		$chart->setTopLeftPosition('A'.$FirstGraphPnt);
		$chart->setBottomRightPosition('T'.$LastGraphPnt);
		$sheetPHPExcel->addChart($chart);
		$Writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$Writer->setIncludeCharts(TRUE);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		
		//Set report name
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Report name:');
		$objPHPExcel->getActiveSheet()->mergeCells('B1:AA1');
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->applyFromArray(
      									array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
      											'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
     											'rotation'   => 0,
      											'wrap'       => false));
		
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', $Report_Name.$TrackerName.$chart_name);
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Display Mode:');
		$objPHPExcel->getActiveSheet()->mergeCells('B2:AA2');
		$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->applyFromArray(
      									array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
      											'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
     											'rotation'   => 0,
      											'wrap'       => false));
		$objPHPExcel->getActiveSheet()->SetCellValue('B2', $tooltip);
		
		$name = $Report_Name;
		$objPHPExcel->getProperties()->setCreator(SITE_NAME);
		$objPHPExcel->getProperties()->setLastModifiedBy(SITE_NAME);
		$objPHPExcel->getProperties()->setTitle(substr($name,0,20));
		$objPHPExcel->getProperties()->setSubject(substr($name,0,20));
		$objPHPExcel->getProperties()->setDescription(substr($name,0,20));
		
		ob_end_clean(); 
		
		header("Pragma: public");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . substr($Report_Name,0,20) . '_Disease_Tracker_' . date('Y-m-d_H.i.s') . '.xlsx"');
		header("Content-Transfer-Encoding: binary ");
		
		$Writer->save('php://output');
	}
	//End of Real Chart Excel
}

function getColspanforExcelExportDiseaseTracker($cell, $inc)
{
	for($i = 1; $i < $inc; $i++)
	{
		$cell++;
	}
	return $cell;
}

function getBGColorforExcelExportDiseaseTracker($phase)
{
	if($phase == '0')
	{
		$bgColor = (array('fill' => array('type'       => PHPExcel_Style_Fill::FILL_SOLID,
									'rotation'   => 0,
									'startcolor' => array('rgb' => '00CCFF'),
									'endcolor'   => array('rgb' => '00CCFF'))
						));
	}
	else if($phase == '1')
	{
		$bgColor = (array('fill' => array('type'       => PHPExcel_Style_Fill::FILL_SOLID,
									'rotation'   => 0,
									'startcolor' => array('rgb' => '99CC00'),
									'endcolor'   => array('rgb' => '99CC00'))
						));
	}
	else if($phase == '2')
	{
		$bgColor = (array('fill' => array('type'       => PHPExcel_Style_Fill::FILL_SOLID,
									'rotation'   => 0,
									'startcolor' => array('rgb' => 'FFFF00'),
									'endcolor'   => array('rgb' => 'FFFF00'))
						));
	}
	else if($phase == '3')
	{
		$bgColor = (array('fill' => array('type'       => PHPExcel_Style_Fill::FILL_SOLID,
									'rotation'   => 0,
									'startcolor' => array('rgb' => 'FF9900'),
									'endcolor'   => array('rgb' => 'FF9900'))
						));
	}
	else if($phase == '4')
	{
		$bgColor = (array('fill' => array('type'       => PHPExcel_Style_Fill::FILL_SOLID,
									'rotation'   => 0,
									'startcolor' => array('rgb' => 'FF0000'),
									'endcolor'   => array('rgb' => 'FF0000'))
						));
	}
	else if($phase == 'na')
	{
		$bgColor = (array('fill' => array('type'       => PHPExcel_Style_Fill::FILL_SOLID,
									'rotation'   => 0,
									'startcolor' => array('rgb' => 'BFBFBF'),
									'endcolor'   => array('rgb' => 'BFBFBF'))
						));
	}
	else
	{
		$bgColor = (array('fill' => array('type'       => PHPExcel_Style_Fill::FILL_SOLID,
									'rotation'   => 0,
									'startcolor' => array('rgb' => 'BFBFBF'),
									'endcolor'   => array('rgb' => 'BFBFBF'))
						));
	}
	
	return $bgColor;
}

function getClassNColorforPhaseDiseaseTracker($phase)
{
	$Color = array();
	if($phase == '0')
	{
		$Color[0] = 'graph_blue';
		$Color[1] = 'BFBFBF';
	}
	else if($phase == '1')
	{
		$Color[0] = 'graph_green';
		$Color[1] = '99CC00';
	}
	else if($phase == '2')
	{
		$Color[0] = 'graph_yellow';
		$Color[1] = 'FFFF00';
	}
	else if($phase == '3')
	{
		$Color[0] = 'graph_orange';
		$Color[1] = 'FF9900';
	}
	else if($phase == '4')
	{
		$Color[0] = 'graph_red';
		$Color[1] = 'FF0000';
	}
	else if($phase == 'na')
	{
		$Color[0] = 'graph_gray';
		$Color[1] = 'BFBFBF';
	}
	else
	{
		$Color[0] = 'graph_gray';
		$Color[1] = 'BFBFBF';
	}
	
	return $Color;
}

function getNameforPhaseDiseaseTracker($phase)
{
	$Name = '';
	if($phase == '0')
	{
		$Name = 'Phase 0';
	}
	else if($phase == '1')
	{
		$Name = 'Phase 1';
	}
	else if($phase == '2')
	{
		$Name = 'Phase 2';
	}
	else if($phase == '3')
	{
		$Name = 'Phase 3';
	}
	else if($phase == '4')
	{
		$Name = 'Phase 4';
	}
	else if($phase == 'na')
	{
		$Name = 'Phase N/A';
	}
	else
	{
		$Name = 'Phase N/A';
	}
	
	return $Name;
}

function CreatePhaseCellforExcelExportDiseaseTracker($from, $Bar_Width, $url, $Excel_HMCounter, $countValue, $phase, &$objPHPExcel)
{
	$to = getColspanforExcelExportDiseaseTracker($from, $Bar_Width);
	$objPHPExcel->getActiveSheet()->mergeCells($from . $Excel_HMCounter . ':' . $to . $Excel_HMCounter);
	$objPHPExcel->getActiveSheet()->getStyle($from . $Excel_HMCounter)->applyFromArray(getBGColorforExcelExportDiseaseTracker($phase));
	$objPHPExcel->getActiveSheet()->getCell($from . $Excel_HMCounter)->getHyperlink()->setUrl($url); 
	$objPHPExcel->getActiveSheet()->getCell($from . $Excel_HMCounter)->getHyperlink()->setTooltip($countValue);
	$from = $to;
	$from++;
	
	return $from;
}

function setStyleforPDFExportDiseaseTracker($phase, &$pdf)
{
	if($phase == '0')
	{
		$pdf->SetFillColor(0,204,255);
		$border = array('mode' => 'int', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0,204,255)));
	}
	else if($phase == '1')
	{
		$pdf->SetFillColor(153,204,0);
		$border = array('mode' => 'int', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(153,204,0)));
	}
	else if($phase == '2')
	{
		$pdf->SetFillColor(255,255,0);
		$border = array('mode' => 'int', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255,255,0)));
	}
	else if($phase == '3')
	{
		$pdf->SetFillColor(255,153,0);
		$border = array('mode' => 'int', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255,153,0)));
	}
	else if($phase == '4')
	{
		$pdf->SetFillColor(255,0,0);
		$border = array('mode' => 'int', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255,0,0)));
	}
	else if($phase == 'na')
	{
		$pdf->SetFillColor(191,191,191);
		$border = array('mode' => 'int', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(191,191,191)));
	}
	else
	{
		$pdf->SetFillColor(191,191,191);
		$border = array('mode' => 'int', 'LTRB' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(191,191,191)));
	}
	
	return $border;
}

function CreateLastTickBorderDiseaseTracker(&$pdf, $Header_Col_Width, $Tic_dimension, $columns, $inner_columns, $subColumn_width, $column_interval, $GobalEntityType)
{
	$ln=0;
	$Main_X = $pdf->GetX();
	$Main_Y = $pdf->GetY();
	/// Bypass disease column
	$pdf->MultiCell($Header_Col_Width, $Tic_dimension, (($GobalEntityType == 'Product') ? 'Trials' : 'Products'), 0, $align='R', $fill=0, $ln, $Main_X, $Main_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=0);

	$Place_X = $Main_X+$Header_Col_Width;
	$Place_Y = $Main_Y;
	/// SET NOT REQUIRED BORDERS TO WHITE COLORS THAT WILL MAKE TABLE COMPACT OTHERWISE HEIGHT/WIDTH ISSUE HAPPENS
	$border = array('mode' => 'ext', 'RT' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
	$pdf->MultiCell($Tic_dimension, $Tic_dimension, '', $border, $align='C', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Tic_dimension);
	$Place_X = $Main_X+$Tic_dimension;
	$Place_Y = $Main_Y;
	for($j=0; $j < $columns; $j++)
	{
		$Width = $inner_columns * $subColumn_width;
		$border = array('mode' => 'ext', 'RT' => array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(204,204,204)));
		$pdf->MultiCell($Width, $Tic_dimension, '', $border, $align='C', $fill=0, $ln, '', '', $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=$Tic_dimension);
		$Place_X = $Main_X+$Width;
		
		if($j == $columns-1) 
		$Place_Y = $Place_Y+$Tic_dimension;
	}
	$pdf->SetX($Main_X);
	$pdf->SetY($Place_Y);
	
	$ln=0;
	$Main_X = $pdf->GetX();
	$Main_Y = $pdf->GetY();
	/// Bypass disease column
	$Place_X = $Main_X+$Header_Col_Width;
	$Place_Y = $Main_Y;
	/// SET NOT REQUIRED BORDERS TO WHITE COLORS THAT WILL MAKE TABLE COMPACT OTHERWISE HEIGHT/WIDTH ISSUE HAPPENS
	$border = 0;
	$pdf->MultiCell(($Tic_dimension * 2.5), $Tic_dimension, '0', $border, $align='R', $fill=0, $ln, $Place_X, $Place_Y, $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=0);
	$Place_X = $Main_X+$Tic_dimension;
	$Place_Y = $Main_Y;
	for($j=0; $j < $columns; $j++)
	{
		if($j==0)
		$Width = ($inner_columns * $subColumn_width);
		else
		$Width = $inner_columns * $subColumn_width;
		$border = 0;
		$pdf->MultiCell($Width, $Tic_dimension, ($column_interval == 0 ? ($j+1 == $columns ? ($j+1) * $column_interval : "") :($j+1) * $column_interval), $border, $align='R', $fill=0, $ln, '', '', $reseth=false, $stretch=0, $ishtml=false, $autopadding=false, $maxh=0);
		$Place_X = $Main_X+$Width;
			
		if($j == $columns-1) 
		$Place_Y = $Place_Y+$Tic_dimension;
	}
	$pdf->SetX($Main_X);
	$pdf->SetY($Place_Y);
}

function Max_ValueKeyDiseaseTracker($valna, $val0, $val1, $val2, $val3, $val4)
{
$key = 'na';
$max = $valna;

	if($max < $val0)
	{
		$max = $val0;
		$key = '0';
	}
	
	if($max < $val1)
	{
		$max = $val1;
		$key = '1';
	}
	
	if($max < $val2)
	{
		$max = $val2;
		$key = '2';
	}
	
	if($max < $val3)
	{
		$max = $val3;
		$key = '3';
	}
	
	if($max < $val4)
	{
		$max = $val4;
		$key = '4';
	}
	
	return $key;
}

function CountErrs($data_matrix, $key, $ratio)
{
	$Rounded = (($data_matrix[$key]['phase_4'] > 0 && round($ratio * $data_matrix[$key]['phase_4']) < 1) ? 1:round($ratio * $data_matrix[$key]['phase_4'])) + (($data_matrix[$key]['phase_3'] > 0 && round($ratio * $data_matrix[$key]['phase_3']) < 1) ? 1:round($ratio * $data_matrix[$key]['phase_3'])) + (($data_matrix[$key]['phase_2'] > 0 && round($ratio * $data_matrix[$key]['phase_2']) < 1) ? 1:round($ratio * $data_matrix[$key]['phase_2'])) + (($data_matrix[$key]['phase_1'] > 0 && round($ratio * $data_matrix[$key]['phase_1']) < 1) ? 1:round($ratio * $data_matrix[$key]['phase_1'])) + (($data_matrix[$key]['phase_0'] > 0 && round($ratio * $data_matrix[$key]['phase_0']) < 1) ? 1:round($ratio * $data_matrix[$key]['phase_0'])) + (($data_matrix[$key]['phase_na'] > 0 && round($ratio * $data_matrix[$key]['phase_na']) < 1) ? 1:round($ratio * $data_matrix[$key]['phase_na']));
	$Actual = ($ratio * $data_matrix[$key]['phase_4']) + ($ratio * $data_matrix[$key]['phase_3']) + ($ratio * $data_matrix[$key]['phase_2']) + ($ratio * $data_matrix[$key]['phase_1']) + ($ratio * $data_matrix[$key]['phase_0'])+ ($ratio * $data_matrix[$key]['phase_na']);
	$Err = floor($Rounded - $Actual);
	
	return $Err;
}

function sortTwoDimensionArrayByKeyDiseaseTracker($arr, $arrKey, $sortOrder=SORT_DESC)
{
	
	$key_arr = array();
	$res = array();
	if(is_array($arr) && count($arr) > 0)
	{
		foreach ($arr as $key => $row)
		{
			if($row[$arrKey] > 0)
			{
				$key_arr[$key] = $row[$arrKey];
				$res[$key] = $arr[$key];
			}
		}
		array_multisort($key_arr, $sortOrder, $res);
	}
	return $res;
}

//Get Diseases from Disease
function GetDiseasesFromEntity_DiseaseTracker($EntityID, $GobalEntityType)
{
	global $db;
	global $now;
	$Diseases = array();
	
	if($GobalEntityType == 'Product')
	{
		$query = "SELECT DISTINCT e.`id` FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) WHERE e.`class` = 'Disease' AND (e.`is_active` <> '0' OR e.`is_active` IS NULL) AND (e.`mesh_name` IS NOT NULL AND e.`mesh_name` <> '') AND er.`child`='" . mysql_real_escape_string($EntityID) . "'";
	}
	else if($GobalEntityType == 'Institution' || $GobalEntityType == 'MOA')
	{
		$query = "SELECT DISTINCT e.`id` FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) JOIN `entities` e2 ON (er.`child`=e2.`id`) JOIN `entity_relations` er2 ON(er2.`parent` = e2.`id`) WHERE e.`class` = 'Disease' AND e2.`class` = 'Product' AND er2.`child`='" . mysql_real_escape_string($EntityID) . "' AND (e2.`is_active` <> '0' OR e2.`is_active` IS NULL) AND (e.`is_active` <> '0' OR e.`is_active` IS NULL) AND (e.`mesh_name` IS NOT NULL AND e.`mesh_name` <> '')";
	}
	else if($GobalEntityType == 'MOA_Category')
	{
		$query = "SELECT DISTINCT e.`id` FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) JOIN `entities` e2 ON (er.`child`=e2.`id`) JOIN `entity_relations` er2 ON(er2.`parent` = e2.`id`) JOIN `entities` e3 ON (er2.`child`=e3.`id`) JOIN `entity_relations` er3 ON(er3.`child` = e3.`id`) WHERE e.`class` = 'Disease' AND e2.`class` = 'Product' AND e3.`class` = 'MOA' AND er3.`parent`='" . mysql_real_escape_string($EntityID) . "' AND (e2.`is_active` <> '0' OR e2.`is_active` IS NULL) AND (e.`is_active` <> '0' OR e.`is_active` IS NULL) AND (e.`mesh_name` IS NOT NULL AND e.`mesh_name` <> '')";
	}
	else if($GobalEntityType == 'Investigator' )
	{
				
		$query = "	
					SELECT DISTINCT e.`id` FROM `entity_trials` et 
					JOIN `entity_trials` et2 ON(et.`trial`=et2.trial and et.entity=".  mysql_real_escape_string($EntityID) .") 
					JOIN entities e on (et2.entity = e.id and e.class='Disease')
					JOIN `entity_relations` er ON(e.id=er.parent) 
					JOIN `entity_trials` et1 ON(er.child = et1.entity and et.trial=et1.trial ) 
					JOIN entities e1 on (et1.entity = e1.id and e1.class='Product')
					where (e.`is_active` <> '0' OR e.`is_active` IS NULL) AND (e.`mesh_name` IS NOT NULL AND e.`mesh_name` <> '')
					";
	}
	
	$res = mysql_query($query);// or die('Bad SQL query getting Diseases from Investigator id');
	
	if($res)
	{
		while($row = mysql_fetch_array($res))
		{
			$Diseases[] = $row['id'];
		}
	}
	
		return array_filter(array_unique($Diseases));
	
}

function GetDiseasesCatFromEntity_DiseaseTracker($EntityID, $GobalEntityType)
{
	global $db;
	global $now;
	$Diseases = array();
	$DiseasesCatgories = array();
	
	if($GobalEntityType == 'Product')
	{
		$query = "SELECT DISTINCT e.`id` FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) WHERE e.`class` = 'Disease' AND er.`child`='" . mysql_real_escape_string($EntityID) . "'";
	}
	else if($GobalEntityType == 'Institution' || $GobalEntityType == 'MOA')
	{
		$query = "SELECT DISTINCT e.`id` FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) JOIN `entities` e2 ON (er.`child`=e2.`id`) JOIN `entity_relations` er2 ON(er2.`parent` = e2.`id`) WHERE e.`class` = 'Disease' AND e2.`class` = 'Product' AND er2.`child`='" . mysql_real_escape_string($EntityID) . "' AND (e2.`is_active` <> '0' OR e2.`is_active` IS NULL)";
	}
	else if($GobalEntityType == 'MOA_Category')
	{
		$query = "SELECT DISTINCT e.`id` FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) JOIN `entities` e2 ON (er.`child`=e2.`id`) JOIN `entity_relations` er2 ON(er2.`parent` = e2.`id`) JOIN `entities` e3 ON (er2.`child`=e3.`id`) JOIN `entity_relations` er3 ON(er3.`child` = e3.`id`) WHERE e.`class` = 'Disease' AND e2.`class` = 'Product' AND e3.`class` = 'MOA' AND er3.`parent`='" . mysql_real_escape_string($EntityID) . "' AND (e2.`is_active` <> '0' OR e2.`is_active` IS NULL)";
	}
	
	$res = mysql_query($query); // or die('Bad SQL query getting Diseases from products ids in DT');
	
	if($res)
	{
		while($row = mysql_fetch_array($res))
		{
			$Diseases[] = $row['id'];
		}
	}
	
		$UniqueDiseases = array_filter(array_unique($Diseases));
		if(count($UniqueDiseases) > 0){
			$UniqueDiseasesIds = implode(", ", $UniqueDiseases);
		}else{
			return array();//$UniqueDiseasesIds = '';
		}
			
		$query = "SELECT DISTINCT e.`id` FROM `entities` e JOIN `entity_relations` er ON(er.`parent` = e.`id`) WHERE e.`class` = 'Disease_Category' AND er.`child` IN (" . $UniqueDiseasesIds . ")  AND (e.`is_active` <> '0' OR e.`is_active` IS NULL)";
		$res = mysql_query($query); // or die('Bad SQL query getting Diseases from products ids in DT');
		if($res)
		{
			while($row = mysql_fetch_array($res))
			{
				$DiseasesCatgories[] = $row['id'];
			}
		}
		if(count($DiseasesCatgories) < 1) return array();
		return array_filter(array_unique($DiseasesCatgories));
}

function CalculateMiniBarWidthDiseaseTracker($Ratio, $countValue, $Key, $Max_ValueKey, $Err, $Total_Bar_Width)
{
	if(round($Ratio * $countValue) > 0)
		$Mini_Bar_Width = round($Ratio * $countValue);
	else
		$Mini_Bar_Width = 1;
	
	if($Max_ValueKey == $Key && $Mini_Bar_Width > 1 && $Mini_Bar_Width > $Err)
	$Mini_Bar_Width = $Mini_Bar_Width - $Err;
	
	if(($Total_Bar_Width - $Mini_Bar_Width) > 0)
		$Total_Bar_Width = $Total_Bar_Width - $Mini_Bar_Width;
	else
		$Mini_Bar_Width = $Total_Bar_Width;
		
		return $Mini_Bar_Width;
}

function getDiseaseIdsFromDiseaseCat($DiseaseCatId){
	$query = "SELECT * FROM `entities` e JOIN `entity_relations` er ON(er.`child` = e.`id`) WHERE e.`class` = 'Disease' AND er.`parent` ='" . $DiseaseCatId . "'";
	$res = mysql_query($query) or die($query.' '.mysql_error());
	if($res){
		while($row = mysql_fetch_array($res))
		{
			$DiseaseIds[] = $row['id'];
		}
	}
	return $DiseaseIds;
}
?>
