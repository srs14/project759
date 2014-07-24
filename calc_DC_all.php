<?php
require_once('db.php');
require_once('include.util.php');
ini_set('memory_limit','-1');
ini_set('max_execution_time', '360000'); //100 hours
ignore_user_abort(true);
$dc=false;
$data=array();$isactive=array();$instype=array();$ldate=array();$phases=array();$ostatus=array();$cnt_total=0;

/************ get all DC ids */
$query = 'select id from entities where class="Disease_Category" ';
$DC_ids=array();
$res = mysql_query($query);
	if($res === false)
	{
	
		$log = 'Bad SQL query getting `id` 
				from entities mysql_error=' . mysql_error() . ' query=' . $query;
		echo($log);
		return false;
	}

	while($DC_ids[]=mysql_fetch_assoc($res));
/**************************************/	


$parameters=array();
/********************************** PRODUCT IDs	 */  
$query = 'select distinct entity from entity_trials where entity in (select id from entities where class="product")';

$res = mysql_query($query);
	if($res === false)
	{
	
		$log = 'Bad SQL query getting `id` 
				from entities mysql_error=' . mysql_error() . ' query=' . $query;
		echo($log);
		return false;
	}

	$prodids=array();
	while($prodids[]=mysql_fetch_assoc($res));
/****************/	

/********************************** MOA IDs	 */
$query = 'select distinct entity from entity_trials where entity in (select id from entities where class="MOA")';

$res = mysql_query($query);
	if($res === false)
	{
	
		$log = 'Bad SQL query getting `id` 
				from entities mysql_error=' . mysql_error() . ' query=' . $query;
		echo($log);
		return false;
	}

	while($prodids[]=mysql_fetch_assoc($res));
/*********************/

/********************************** INSTITUTION IDs	 */
$query = 'select distinct entity from entity_trials where entity in (select id from entities where class="Institution")';

$res = mysql_query($query);
	if($res === false)
	{
	
		$log = 'Bad SQL query getting `id` 
				from entities mysql_error=' . mysql_error() . ' query=' . $query;
		echo($log);
		return false;
	}

	while($prodids[]=mysql_fetch_assoc($res));
/*********************/

foreach($DC_ids as $DC_id)
{
	pr('<b> Calculating Disease Category : '. $DC_id['id'] . '</b>');
	$parameters['entity1']=$DC_id['id'];
	$sno=0;
	foreach($prodids as $pid)
	{
		$sno++;
			$parameters['entity2']=$pid['entity'];
			if(!calc_cells($parameters))	echo '<br><b>Could complete calculating cells, there was an error.<br></b>';
	}
}
$diseaseids=array();

function calc_cells($parameters,$update_id=NULL,$ignore_changes=NULL)
{
	
		if(!mysql_query('SET autocommit = 1;'))
			{
				global $logger;
				$log='Unable to begin transaction. Query='.$query.' Error:' . mysql_error();
				$logger->fatal($log);
				echo $log;
				return false;
			}
	global $data,$isactive,$instype,$ldate,$phases,$ostatus,$cnt_total;
	$data=array();$isactive=array();$instype=array();$ldate=array();$phases=array();$ostatus=array();$cnt_total=0;
	
	$display_status='NO';
	$id = mysql_real_escape_string($_GET['id']);

	$query='select `id` from entities where `id`="'.$parameters['entity1'].'"';
	$res = mysql_query($query);
	$entity1ids=array();
	
	while($entity1ids[]=mysql_fetch_assoc($res));
	
	//get entity2 ids
	if(isset($parameters['entity2']))
	{
		$query='select `id` from entities where `id`="'.$parameters['entity2'].'"';
	}

	$res = mysql_query($query);
	if($res === false)
	{
		$log = 'Bad SQL query getting id from entities mysql_error=' . mysql_error() . ' query=' . $query;
		global $logger;
		$logger->fatal($log);
		echo ($log);
		return false;
	}
	$entity2ids=array();
	while($entity2ids[]=mysql_fetch_assoc($res));
	$x=count($entity1ids); $y=count($entity2ids);

	$totalcount=($x*$y)/4;
	
//	pr($entity1ids);
//	pr($entity2ids);
	$counter=0;
	$progress_count = 0;
	//if it is a disease, do a recalculation for the category too.  so add the category to the array.

	global $diseaseids	;
	foreach ($entity1ids as $ak=>$av)
	{
		
		if(!$av['id'] or is_null($av['id']) or empty($av['id']))
		{
			continue;
		}
		$DC=$av['id'];
			
		$Query = 'select child from entity_relations where parent ="' . $DC . '" ';
		$Res = mysql_query($Query);
		$diseaseids=array();
		while($row = mysql_fetch_assoc($Res))
		{
			$diseaseids[] = $row['child'];
		}
		if($DC==$pv['id']) 
			$nonDC=$av['id'];
		else
			$nonDC=$pv['id'];
		$diseaseids = implode(",", $diseaseids);
				
		foreach($entity2ids as $pk=>$pv)
		{
			
			$data=array();$isactive=array();$instype=array();$ldate=array();$phases=array();$ostatus=array();$cnt_total=0;
		
			if(!$pv['id'] or is_null($pv['id']) or empty($pv['id']))
			{
				continue;
			}

			
			//check if any of the entities is a Disease category, and if yes, then do a separate calculation 
			
			$DC=isDiseaseCategory($av['id'],$pv['id']);
			if($DC)
			{
				global $dc;
				$dc=true;
				if($DC==$pv['id']) 
					$nonDC=$av['id'];
				else
					$nonDC=$pv['id'];
		//		$trialids=calculateDCforEntities($diseaseids,$pv['id']);
				$trialids=calculatenonDCtrials($nonDC);
				if(empty($trialids)) continue;
				
				$query_m=	'	SELECT 	distinct a.trial,d.source_id,d.is_active,p.relation_type as relation_type,d.institution_type,d.source_id,d.lastchanged_date,
										d.firstreceived_date,d.phase,d.overall_status from entity_trials a 
							JOIN 		entity_trials p ON a.`trial`=p.`trial`
							LEFT JOIN 	data_trials d ON p.`trial`=d.`larvol_id`
							WHERE 		a.trial in  ('. $trialids . ')   and p.`entity` in ('. $diseaseids . ')  ';
				
				/*
				$overall_statuses=calculateDCcell($diseaseids,$pv['id']);
				add_data($av['id'],$pv['id'],$overall_statuses['cnt_total'],$overall_statuses['cnt_active'],$overall_statuses['cnt_active_indlead'],$overall_statuses['cnt_active_owner_sponsored'],"none",$overall_statuses['max_phase'],$overall_statuses,false,true);
				continue;
				*/
			}
			
			if(!$res = mysql_query($query_m))
					{
						$log='There seems to be a problem with the SQL Query:'.$query_m.' Error:' . mysql_error();
						global $logger;
						$logger->error($log);
						echo $log;
						return false;
					}
			$row = mysql_fetch_assoc($res);
			if(!$row) continue;
			$phasez=array();
			
			$overall_statuses=array();
			$overall_statuses['not_yet_recruiting']=0;
			$overall_statuses['recruiting']=0;
			$overall_statuses['enrolling_by_invitation']=0;
			$overall_statuses['active_not_recruiting']=0;
			$overall_statuses['completed']=0;
			$overall_statuses['suspended']=0;
			$overall_statuses['terminated']=0;
			$overall_statuses['withdrawn']=0;
			$overall_statuses['available']=0;
			$overall_statuses['no_longer_available']=0;
			$overall_statuses['approved_for_marketing']=0;
			$overall_statuses['no_longer_recruiting']=0;
			$overall_statuses['withheld']=0;
			$overall_statuses['temporarily_not_available']=0;
			$overall_statuses['ongoing']=0;
			$overall_statuses['not_authorized']=0;
			$overall_statuses['prohibited']=0;
			$overall_statuses['new_trials']=0;
			
			$overall_statuses['not_yet_recruiting_active']=0;
			$overall_statuses['recruiting_active']=0;
			$overall_statuses['enrolling_by_invitation_active']=0;
			$overall_statuses['active_not_recruiting_active']=0;
			$overall_statuses['completed_active']=0;
			$overall_statuses['suspended_active']=0;
			$overall_statuses['terminated_active']=0;
			$overall_statuses['withdrawn_active']=0;
			$overall_statuses['available_active']=0;
			$overall_statuses['no_longer_available_active']=0;
			$overall_statuses['approved_for_marketing_active']=0;
			$overall_statuses['no_longer_recruiting_active']=0;
			$overall_statuses['withheld_active']=0;
			$overall_statuses['temporarily_not_available_active']=0;
			$overall_statuses['ongoing_active']=0;
			$overall_statuses['not_authorized_active']=0;
			$overall_statuses['prohibited_active']=0;
			$overall_statuses['new_trials_active']=0;
			
			$overall_statuses['not_yet_recruiting_active_indlead']=0;
			$overall_statuses['recruiting_active_indlead']=0;
			$overall_statuses['enrolling_by_invitation_active_indlead']=0;
			$overall_statuses['active_not_recruiting_active_indlead']=0;
			$overall_statuses['completed_active_indlead']=0;
			$overall_statuses['suspended_active_indlead']=0;
			$overall_statuses['terminated_active_indlead']=0;
			$overall_statuses['withdrawn_active_indlead']=0;
			$overall_statuses['available_active_indlead']=0;
			$overall_statuses['no_longer_available_active_indlead']=0;
			$overall_statuses['approved_for_marketing_active_indlead']=0;
			$overall_statuses['no_longer_recruiting_active_indlead']=0;
			$overall_statuses['withheld_active_indlead']=0;
			$overall_statuses['temporarily_not_available_active_indlead']=0;
			$overall_statuses['ongoing_active_indlead']=0;
			$overall_statuses['not_authorized_active_indlead']=0;
			$overall_statuses['prohibited_active_indlead']=0;
			$overall_statuses['new_trials_active_indlead']=0;
			
			$overall_statuses['not_yet_recruiting_active_owner_sponsored']=0;
			$overall_statuses['recruiting_active_owner_sponsored']=0;
			$overall_statuses['enrolling_by_invitation_active_owner_sponsored']=0;
			$overall_statuses['active_not_recruiting_active_owner_sponsored']=0;
			$overall_statuses['completed_active_owner_sponsored']=0;
			$overall_statuses['suspended_active_owner_sponsored']=0;
			$overall_statuses['terminated_active_owner_sponsored']=0;
			$overall_statuses['withdrawn_active_owner_sponsored']=0;
			$overall_statuses['available_active_owner_sponsored']=0;
			$overall_statuses['no_longer_available_active_owner_sponsored']=0;
			$overall_statuses['approved_for_marketing_active_owner_sponsored']=0;
			$overall_statuses['no_longer_recruiting_active_owner_sponsored']=0;
			$overall_statuses['withheld_active_owner_sponsored']=0;
			$overall_statuses['temporarily_not_available_active_owner_sponsored']=0;
			$overall_statuses['ongoing_active_owner_sponsored']=0;
			$overall_statuses['not_authorized_active_owner_sponsored']=0;
			$overall_statuses['prohibited_active_owner_sponsored']=0;
			$overall_statuses['new_trials_active_owner_sponsored']=0;
			$suspended_or_terminated=0;
			
			while ($row = mysql_fetch_assoc($res))
			{	
				
				if($row["trial"])
				{
					
				if($row["overall_status"]=='Terminated' or $row["overall_status"]=='Suspended')
				{
					$suspended_or_terminated++;
				}
					$data[] = $row["trial"];
					$isactive[] = $row["is_active"];
					$instype[] = $row["institution_type"];
					$instype2[] = $row["relation_type"];
					$ldate[] = $row["lastchanged_date"];
					$phases[] = $row["phase"];
					if($row["phase"]<>'N/A') $phasez[] = $row["phase"];
					$ostatus[] = $row["overall_status"];
					$cnt_total++;

					/*********** trial counts according to overallstatus values ***********/

					//$base_date = date('Y-m-d', strtotime("-7 days"));
					$base_date = date('Y-m-d', strtotime("-30 days")); // consider one month's data.
					if($row["firstreceived_date"]>=$base_date) $overall_statuses['new_trials']=$overall_statuses['new_trials']+1;
					else
					{
						$query_dh= 'select larvol_id,overall_status_prev,overall_status_lastchanged from data_history 
									where overall_status_lastchanged is not null  and  larvol_id='. $row["trial"] . '
									limit 1 ';
						
						if(!$res_dh = mysql_query($query_dh))
								{
									$log='There seems to be a problem with the SQL Query:'.$query_dh.' Error:' . mysql_error();
									global $logger;
									$logger->error($log);
									echo $log;
									return false;
								}
						while ($row_dh = mysql_fetch_assoc($res_dh))
						{	
							
							if($row_dh["larvol_id"] and $row_dh["overall_status_lastchanged"]>=$base_date)
							{
								//switch ($row_dh["overall_status_prev"]) 
								// in case of active/industry lead trial, add +1 to status change totals accordingly
								switch ($row["overall_status"]) // use the value from data_trials instead of data_history
								{
									case 'Not yet recruiting':
										$overall_statuses['not_yet_recruiting']=$overall_statuses['not_yet_recruiting']+1;
										
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['not_yet_recruiting_active']=$overall_statuses['not_yet_recruiting_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored') )	$overall_statuses['not_yet_recruiting_active_indlead']=$overall_statuses['not_yet_recruiting_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['not_yet_recruiting_active_owner_sponsored']=$overall_statuses['not_yet_recruiting_active_owner_sponsored']+1;
										break;																														   
									case 'Recruiting':
										$overall_statuses['recruiting']=$overall_statuses['recruiting']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['recruiting_active']=$overall_statuses['recruiting_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor'  or $row['relation_type']=='ownersponsored')  )	$overall_statuses['recruiting_active_indlead']=$overall_statuses['recruiting_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['recruiting_active_owner_sponsored']=$overall_statuses['recruiting_active_owner_sponsored']+1;
										break;
									case 'Enrolling by invitation':
										$overall_statuses['enrolling_by_invitation']=$overall_statuses['enrolling_by_invitation']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['enrolling_by_invitation_active']=$overall_statuses['enrolling_by_invitation_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor'  or $row['relation_type']=='ownersponsored')  )	$overall_statuses['enrolling_by_invitation_active_indlead']=$overall_statuses['enrolling_by_invitation_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['enrolling_by_invitation_active_owner_sponsored']=$overall_statuses['enrolling_by_invitation_active_owner_sponsored']+1;
										break;
									case 'Active, not recruiting':
										$overall_statuses['active_not_recruiting']=$overall_statuses['active_not_recruiting']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['active_not_recruiting_active']=$overall_statuses['active_not_recruiting_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor'  or $row['relation_type']=='ownersponsored')  )	$overall_statuses['active_not_recruiting_active_indlead']=$overall_statuses['active_not_recruiting_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['active_not_recruiting_active_owner_sponsored']=$overall_statuses['active_not_recruiting_active_owner_sponsored']+1;
										break;
									case 'Completed':
										$overall_statuses['completed']=$overall_statuses['completed']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['completed_active']=$overall_statuses['completed_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor'  or $row['relation_type']=='ownersponsored') )	$overall_statuses['completed_active_indlead']=$overall_statuses['completed_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['completed_active_owner_sponsored']=$overall_statuses['completed_active_owner_sponsored']+1;
										break;
									case 'Suspended':
										$overall_statuses['suspended']=$overall_statuses['suspended']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['suspended_active']=$overall_statuses['suspended_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['suspended_active_indlead']=$overall_statuses['suspended_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['suspended_active_owner_sponsored']=$overall_statuses['suspended_active_owner_sponsored']+1;
										break;
									case 'Terminated':
										$overall_statuses['terminated']=$overall_statuses['terminated']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['terminated_active']=$overall_statuses['terminated_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor'  or $row['relation_type']=='ownersponsored') )	$overall_statuses['terminated_active_indlead']=$overall_statuses['terminated_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['terminated_active_owner_sponsored']=$overall_statuses['terminated_active_owner_sponsored']+1;
										
										break;
									case 'Withdrawn':
										$overall_statuses['withdrawn']=$overall_statuses['withdrawn']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['withdrawn_active']=$overall_statuses['withdrawn_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor'  or $row['relation_type']=='ownersponsored') )	$overall_statuses['withdrawn_active_indlead']=$overall_statuses['withdrawn_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['withdrawn_active_owner_sponsored']=$overall_statuses['withdrawn_active_owner_sponsored']+1;
										break;
									case 'Available':
										$overall_statuses['available']=$overall_statuses['available']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['available_active']=$overall_statuses['available_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['available_active_indlead']=$overall_statuses['available_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['available_active_owner_sponsored']=$overall_statuses['available_active_owner_sponsored']+1;
										break;
									case 'No Longer Available':
										$overall_statuses['no_longer_available']=$overall_statuses['no_longer_available']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['no_longer_available_active']=$overall_statuses['no_longer_available_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['no_longer_available_active_indlead']=$overall_statuses['no_longer_available_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['no_longer_available_active_owner_sponsored']=$overall_statuses['no_longer_available_active_owner_sponsored']+1;
										break;
									case 'Approved for marketing':
										$overall_statuses['approved_for_marketing']=$overall_statuses['approved_for_marketing']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['approved_for_marketing_active']=$overall_statuses['approved_for_marketing_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['approved_for_marketing_active_indlead']=$overall_statuses['approved_for_marketing_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['approved_for_marketing_active_owner_sponsored']=$overall_statuses['approved_for_marketing_active_owner_sponsored']+1;
										break;
									case 'No longer recruiting':
										$overall_statuses['no_longer_recruiting']=$overall_statuses['no_longer_recruiting']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['no_longer_recruiting_active']=$overall_statuses['no_longer_recruiting_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['no_longer_recruiting_active_indlead']=$overall_statuses['no_longer_recruiting_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['no_longer_recruiting_active_owner_sponsored']=$overall_statuses['no_longer_recruiting_active_owner_sponsored']+1;
										break;
									case 'Withheld':
										$overall_statuses['withheld']=$overall_statuses['withheld']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['withheld_active']=$overall_statuses['withheld_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['withheld_active_indlead']=$overall_statuses['withheld_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['withheld_active_owner_sponsored']=$overall_statuses['withheld_active_owner_sponsored']+1;										
										break;
									case 'Temporarily Not Available':
										$overall_statuses['temporarily_not_available']=$overall_statuses['temporarily_not_available']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['temporarily_not_available_active']=$overall_statuses['temporarily_not_available_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['temporarily_not_available_active_indlead']=$overall_statuses['temporarily_not_available_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['temporarily_not_available_active_owner_sponsored']=$overall_statuses['temporarily_not_available_active_owner_sponsored']+1;										
										break;
									case 'Ongoing':
										$overall_statuses['ongoing']=$overall_statuses['ongoing']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['ongoing_active']=$overall_statuses['ongoing_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['ongoing_active_indlead']=$overall_statuses['ongoing_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['ongoing_active_owner_sponsored']=$overall_statuses['ongoing_active_owner_sponsored']+1;										
										break;
									case 'Not Authorized':
										$overall_statuses['not_authorized']=$overall_statuses['not_authorized']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['not_authorized_active']=$overall_statuses['not_authorized_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['not_authorized_active_indlead']=$overall_statuses['not_authorized_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['not_authorized_active_owner_sponsored']=$overall_statuses['not_authorized_active_owner_sponsored']+1;										
										break;
									case 'Prohibited':
										$overall_statuses['prohibited']=$overall_statuses['prohibited']+1;
										if($row['is_active']==1 or $row['is_active']=="1")	$overall_statuses['prohibited_active']=$overall_statuses['prohibited_active']+1;
										if( ($row['is_active']==1 or $row['is_active']=="1") and  ($row['institution_type']=='industry_lead_sponsor' or $row['relation_type']=='ownersponsored')  )	$overall_statuses['prohibited_active_indlead']=$overall_statuses['prohibited_active_indlead']+1;
										elseif( ($row['is_active']==1 or $row['is_active']=="1") and  $row['relation_type']=='ownersponsored' )	$overall_statuses['prohibited_active_owner_sponsored']=$overall_statuses['prohibited_active_owner_sponsored']+1;																				
										break;
								}
								
							}
						}
					
					
					
					
					
					}
					
					/*********** END : trial counts according to overallstatus values ***********/
				}
				
				 
			}
			
			$cnt_total=count($data);
			
			if(!$cnt_total or $cnt_total<1) 
			{
				
				if($counter>=20000)
				{
					$counter=0;
					echo '<br>20000 records added, sleeping 1 second....'.str_repeat("  ",800);
					sleep(1);
				}
				
				add_data($av['id'],$pv['id'],0,0,0,'none','N/A',$overall_statuses,$ignore_changes);
				$progress_count ++;
				
				
				$counter++;
				continue;
			}
			
	//		pr($data);
			$cnt_active=0;
			foreach($isactive as $act)
			{
				if($act==1 or $act=="1")
				{
					$cnt_active++;
				}
			}
			$cnt_active_indlead=0;
			foreach($instype as $key=>$act)
			{
				if( ($isactive[$key]==1 or $isactive[$key]=="1") and  $act=='industry_lead_sponsor' )
				{
					$cnt_active_indlead++;
				}
			}
			
			$cnt_active_owner_sponsored=0;
			foreach($instype2 as $key=>$act)
			{
				if( ($isactive[$key]==1 or $isactive[$key]=="1") and $act=='ownersponsored' )
				{
					$cnt_active_owner_sponsored++;
				}
			}
			
			if(!empty($phasez))
			{
				$max_phase = max($phasez);
			}
			else
			{
			//	$max_phase = 'N/A';
				$max_phase = null;
			}
			 
			
			//check if any of the trials has been terminated or suspended 
			if(  $suspended_or_terminated > 0)  
			{
				$bomb=getBombdtl();
			}
			else
			{
				$bomb='none';
			}
			if($counter>=5000)
			{
				$counter=0;
				echo '<br>5000 records added, sleeping 1 second ....'.str_repeat("  ",800);
				sleep(1);
			}
			
			add_data($av['id'],$pv['id'],$cnt_total,$cnt_active,$cnt_active_indlead,$cnt_active_owner_sponsored,$bomb,$max_phase,$overall_statuses,true);
			$progress_count ++;
			
		}

	}
	
	//	echo '<br>All Done.';

	//activate the trigger if required.
	
	return true;
}			

//

function add_data($entity1id,$entity2id,$cnt_total,$cnt_active,$cnt_active_indlead,$cnt_active_owner_sponsored,$bomb,$max_phase,$overall_statuses=null,$ignore_changes=null,$dc1=false)
{
/*********/

global $dc;
if($dc===false)	global $data,$isactive,$instype,$ldate,$phases,$ostatus,$cnt_total;
	$query=	'	SELECT 	`entity1`,`entity2`,`count_total`
				FROM 	rpt_masterhm_cells
				WHERE	`entity1` IN ("' . $entity1id . '","' . $entity2id . '") 
						AND `entity2` IN ("' . $entity1id . '","' . $entity2id . '") 
				LIMIT 1';
			/*
			pr('---------------------------');
			pr($overall_statuses);
			pr('---------------------------');
			*/
	$curtime = date('Y-m-d H:i:s');
	
	if(!$res = mysql_query($query))
		{
			$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
			global $logger;
			$logger->error($log);
			echo $log;
			return false;
		}
		
	$row = mysql_fetch_assoc($res);
	
	if( is_null($max_phase) or empty($max_phase) )
		$highestPhaseUpdateString = "`highest_phase` = NULL,";
	elseif( ($max_phase=='N/A') and ( !isset($row["count_total"]) or is_null($row["count_total"]) or $cnt_total==0 or $row["count_total"]==0 ) )
		$highestPhaseUpdateString = "`highest_phase` = NULL,";
	else
		$highestPhaseUpdateString = "`highest_phase` = \"$max_phase\",";
	

	if($row["entity1"])
	{
		//get existing counts before updating
		
		$query=	'	SELECT  `count_active`,count_active_indlead,count_active_owner_sponsored,highest_phase,
							`count_total` 
					FROM	rpt_masterhm_cells  
					WHERE	`entity1` IN ("' . $entity1id . '","' . $entity2id . '") 
							AND `entity2` IN ("' . $entity1id . '","' . $entity2id . '") 
				';
					
		
		if(!$res = mysql_query($query))
		{
			$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
			global $logger;
			$logger->error($log);
			echo $log;
			return false;
		}
		
		$row = mysql_fetch_assoc($res);
		$count_active_old = $row["count_active"];
		$cnt_indlead_old = $row["count_active_indlead"];
		$cnt_owner_sponsored_old = $row["count_active_owner_sponsored"];
		$count_total_old = $row["count_total"];
		$highest_phase_old = $row["highest_phase"];
		//if there is a difference in counts, then update the _prev fields
		$aa='';$bb='';$cc='';$dd='';
		$ignore_changes='yes';
		if(isset($ignore_changes) and $ignore_changes=='yes')
		{
			$aa='';
		}
		else
		{
			if($count_active_old<>$cnt_active) $aa='`count_active_prev` = "'. $count_active_old .'",';
			if($count_total_old<>$cnt_total) $bb='`count_total_prev` = "'. $count_total_old .'",';
			if($cnt_indlead_old<>$cnt_active_indlead) $cc='`count_active_indlead_prev` = "'. $cnt_indlead_old .'",';
			if($cnt_owner_sponsored_old<>$cnt_active_owner_sponsored) $ee='`count_active_owner_sponsored_prev` = "'. $cnt_owner_sponsored_old .'",';
			if( empty($highest_phase_old) or empty($max_phase) or $max_phase <= $highest_phase_old)
			{
				if($cnt_total==0) $dd='`highest_phase_prev` = null,';
			}
			else
			{
				if($highest_phase_old<>$max_phase) $dd='`highest_phase_prev` = "'. $highest_phase_old .'",';
			}
			if($cnt_total==0) $dd='`highest_phase_prev` = null,';
		}
		
	
		if( empty($aa) && empty($bb) && empty($cc) && empty($dd) && empty($ee))
		{
		
			$query='UPDATE 	rpt_masterhm_cells 
					SET 
					`count_active` ="'. $cnt_active.'",
					`count_active_indlead` ="'. $cnt_active_indlead.'",
					`count_active_owner_sponsored` ="'. $cnt_active_owner_sponsored.'",
					`bomb_auto` = "'. $bomb .'",'. $highestPhaseUpdateString.
					'`count_total` = "'. $cnt_total .'",
					`not_yet_recruiting` = "'. $overall_statuses['not_yet_recruiting'] .'",
					`recruiting` = "'. $overall_statuses['recruiting'] .'",
					`enrolling_by_invitation` = "'. $overall_statuses['enrolling_by_invitation'] .'",
					`active_not_recruiting` = "'. $overall_statuses['active_not_recruiting'] .'",
					`completed` = "'. $overall_statuses['completed'] .'",
					`suspended` = "'. $overall_statuses['suspended'] .'",
					`terminated` = "'. $overall_statuses['terminated'] .'",
					`withdrawn` = "'. $overall_statuses['withdrawn'] .'",
					`available` = "'. $overall_statuses['available'] .'",
					`no_longer_available` = "'. $overall_statuses['no_longer_available'] .'",
					`approved_for_marketing` = "'. $overall_statuses['approved_for_marketing'] .'",
					`no_longer_recruiting` = "'. $overall_statuses['no_longer_recruiting'] .'",
					`withheld` = "'. $overall_statuses['withheld'] .'",
					`temporarily_not_available` = "'. $overall_statuses['temporarily_not_available'] .'",
					`ongoing` = "'. $overall_statuses['ongoing'] .'",
					`not_authorized` = "'. $overall_statuses['not_authorized'] .'",
					`prohibited` = "'. $overall_statuses['prohibited'] .'",
					`not_yet_recruiting_active` = "'. $overall_statuses['not_yet_recruiting_active']. '",
					`recruiting_active` = "'. $overall_statuses['recruiting_active']. '",
					`enrolling_by_invitation_active` = "'. $overall_statuses['enrolling_by_invitation_active']. '",
					`active_not_recruiting_active` = "'. $overall_statuses['active_not_recruiting_active']. '",
					`completed_active` = "'. $overall_statuses['completed_active']. '",
					`suspended_active` = "'. $overall_statuses['suspended_active']. '",
					`terminated_active` = "'. $overall_statuses['terminated_active']. '",
					`withdrawn_active` = "'. $overall_statuses['withdrawn_active']. '",
					`available_active` = "'. $overall_statuses['available_active']. '",
					`no_longer_available_active` = "'. $overall_statuses['no_longer_available_active']. '",
					`approved_for_marketing_active` = "'. $overall_statuses['approved_for_marketing_active']. '",
					`no_longer_recruiting_active` = "'. $overall_statuses['no_longer_recruiting_active']. '",
					`withheld_active` = "'. $overall_statuses['withheld_active']. '",
					`temporarily_not_available_active` = "'. $overall_statuses['temporarily_not_available_active']. '",
					`ongoing_active` = "'. $overall_statuses['ongoing_active']. '",
					`not_authorized_active` = "'. $overall_statuses['not_authorized_active']. '",
					`prohibited_active` = "'. $overall_statuses['prohibited_active']. '",
					`not_yet_recruiting_active_indlead` = "'. $overall_statuses['not_yet_recruiting_active_indlead']. '",
					`recruiting_active_indlead` = "'. $overall_statuses['recruiting_active_indlead']. '",
					`enrolling_by_invitation_active_indlead` = "'. $overall_statuses['enrolling_by_invitation_active_indlead']. '",
					`active_not_recruiting_active_indlead` = "'. $overall_statuses['active_not_recruiting_active_indlead']. '",
					`completed_active_indlead` = "'. $overall_statuses['completed_active_indlead']. '",
					`suspended_active_indlead` = "'. $overall_statuses['suspended_active_indlead']. '",
					`terminated_active_indlead` = "'. $overall_statuses['terminated_active_indlead']. '",
					`withdrawn_active_indlead` = "'. $overall_statuses['withdrawn_active_indlead']. '",
					`available_active_indlead` = "'. $overall_statuses['available_active_indlead']. '",
					`no_longer_available_active_indlead` = "'. $overall_statuses['no_longer_available_active_indlead']. '",
					`approved_for_marketing_active_indlead` = "'. $overall_statuses['approved_for_marketing_active_indlead']. '",
					`no_longer_recruiting_active_indlead` = "'. $overall_statuses['no_longer_recruiting_active_indlead']. '",
					`withheld_active_indlead` = "'. $overall_statuses['withheld_active_indlead']. '",
					`temporarily_not_available_active_indlead` = "'. $overall_statuses['temporarily_not_available_active_indlead']. '",
					`ongoing_active_indlead` = "'. $overall_statuses['ongoing_active_indlead']. '",
					`not_authorized_active_indlead` = "'. $overall_statuses['not_authorized_active_indlead']. '",
					`prohibited_active_indlead` = "'. $overall_statuses['prohibited_active_indlead']. '",				
					`not_yet_recruiting_active_owner_sponsored` = "'. $overall_statuses['not_yet_recruiting_active_owner_sponsored']. '",
					`recruiting_active_owner_sponsored` = "'. $overall_statuses['recruiting_active_owner_sponsored']. '",
					`enrolling_by_invitation_active_owner_sponsored` = "'. $overall_statuses['enrolling_by_invitation_active_owner_sponsored']. '",
					`active_not_recruiting_active_owner_sponsored` = "'. $overall_statuses['active_not_recruiting_active_owner_sponsored']. '",
					`completed_active_owner_sponsored` = "'. $overall_statuses['completed_active_owner_sponsored']. '",
					`suspended_active_owner_sponsored` = "'. $overall_statuses['suspended_active_owner_sponsored']. '",
					`terminated_active_owner_sponsored` = "'. $overall_statuses['terminated_active_owner_sponsored']. '",
					`withdrawn_active_owner_sponsored` = "'. $overall_statuses['withdrawn_active_owner_sponsored']. '",
					`available_active_owner_sponsored` = "'. $overall_statuses['available_active_owner_sponsored']. '",
					`no_longer_available_active_owner_sponsored` = "'. $overall_statuses['no_longer_available_active_owner_sponsored']. '",
					`approved_for_marketing_active_owner_sponsored` = "'. $overall_statuses['approved_for_marketing_active_owner_sponsored']. '",
					`no_longer_recruiting_active_owner_sponsored` = "'. $overall_statuses['no_longer_recruiting_active_owner_sponsored']. '",
					`withheld_active_owner_sponsored` = "'. $overall_statuses['withheld_active_owner_sponsored']. '",
					`temporarily_not_available_active_owner_sponsored` = "'. $overall_statuses['temporarily_not_available_active_owner_sponsored']. '",
					`ongoing_active_owner_sponsored` = "'. $overall_statuses['ongoing_active_owner_sponsored']. '",
					`not_authorized_active_owner_sponsored` = "'. $overall_statuses['not_authorized_active_owner_sponsored']. '",
					`prohibited_active_owner_sponsored` = "'. $overall_statuses['prohibited_active_owner_sponsored']. '",		
					
					`new_trials` = "'. $overall_statuses['new_trials'] .'",
					`last_calc` = "'. $curtime .'" 
					WHERE	`entity1` IN ("' . $entity1id . '","' . $entity2id . '") 
							AND `entity2` IN ("' . $entity1id . '","' . $entity2id . '") 
					';
					
		}
		else
		{
			$query='UPDATE rpt_masterhm_cells 
					SET 
					`count_active` ="'. $cnt_active.'",
					`count_active_indlead` ="'. $cnt_active_indlead.'",
					`count_active_owner_sponsored` ="'. $cnt_active_owner_sponsored.'",
					`bomb_auto` = "'. $bomb .'",'. $highestPhaseUpdateString.
					'`not_yet_recruiting` = "'. $overall_statuses['not_yet_recruiting'] .'",
					`recruiting` = "'. $overall_statuses['recruiting'] .'",
					`enrolling_by_invitation` = "'. $overall_statuses['enrolling_by_invitation'] .'",
					`active_not_recruiting` = "'. $overall_statuses['active_not_recruiting'] .'",
					`completed` = "'. $overall_statuses['completed'] .'",
					`suspended` = "'. $overall_statuses['suspended'] .'",
					`terminated` = "'. $overall_statuses['terminated'] .'",
					`withdrawn` = "'. $overall_statuses['withdrawn'] .'",
					`available` = "'. $overall_statuses['available'] .'",
					`no_longer_available` = "'. $overall_statuses['no_longer_available'] .'",
					`approved_for_marketing` = "'. $overall_statuses['approved_for_marketing'] .'",
					`no_longer_recruiting` = "'. $overall_statuses['no_longer_recruiting'] .'",
					`withheld` = "'. $overall_statuses['withheld'] .'",
					`temporarily_not_available` = "'. $overall_statuses['temporarily_not_available'] .'",
					`ongoing` = "'. $overall_statuses['ongoing'] .'",
					`not_authorized` = "'. $overall_statuses['not_authorized'] .'",
					`prohibited` = "'. $overall_statuses['prohibited'] .'",
					`not_yet_recruiting_active` = "'. $overall_statuses['not_yet_recruiting_active']. '",
					`recruiting_active` = "'. $overall_statuses['recruiting_active']. '",
					`enrolling_by_invitation_active` = "'. $overall_statuses['enrolling_by_invitation_active']. '",
					`active_not_recruiting_active` = "'. $overall_statuses['active_not_recruiting_active']. '",
					`completed_active` = "'. $overall_statuses['completed_active']. '",
					`suspended_active` = "'. $overall_statuses['suspended_active']. '",
					`terminated_active` = "'. $overall_statuses['terminated_active']. '",
					`withdrawn_active` = "'. $overall_statuses['withdrawn_active']. '",
					`available_active` = "'. $overall_statuses['available_active']. '",
					`no_longer_available_active` = "'. $overall_statuses['no_longer_available_active']. '",
					`approved_for_marketing_active` = "'. $overall_statuses['approved_for_marketing_active']. '",
					`no_longer_recruiting_active` = "'. $overall_statuses['no_longer_recruiting_active']. '",
					`withheld_active` = "'. $overall_statuses['withheld_active']. '",
					`temporarily_not_available_active` = "'. $overall_statuses['temporarily_not_available_active']. '",
					`ongoing_active` = "'. $overall_statuses['ongoing_active']. '",
					`not_authorized_active` = "'. $overall_statuses['not_authorized_active']. '",
					`prohibited_active` = "'. $overall_statuses['prohibited_active']. '",
					`not_yet_recruiting_active_indlead` = "'. $overall_statuses['not_yet_recruiting_active_indlead']. '",
					`recruiting_active_indlead` = "'. $overall_statuses['recruiting_active_indlead']. '",
					`enrolling_by_invitation_active_indlead` = "'. $overall_statuses['enrolling_by_invitation_active_indlead']. '",
					`active_not_recruiting_active_indlead` = "'. $overall_statuses['active_not_recruiting_active_indlead']. '",
					`completed_active_indlead` = "'. $overall_statuses['completed_active_indlead']. '",
					`suspended_active_indlead` = "'. $overall_statuses['suspended_active_indlead']. '",
					`terminated_active_indlead` = "'. $overall_statuses['terminated_active_indlead']. '",
					`withdrawn_active_indlead` = "'. $overall_statuses['withdrawn_active_indlead']. '",
					`available_active_indlead` = "'. $overall_statuses['available_active_indlead']. '",
					`no_longer_available_active_indlead` = "'. $overall_statuses['no_longer_available_active_indlead']. '",
					`approved_for_marketing_active_indlead` = "'. $overall_statuses['approved_for_marketing_active_indlead']. '",
					`no_longer_recruiting_active_indlead` = "'. $overall_statuses['no_longer_recruiting_active_indlead']. '",
					`withheld_active_indlead` = "'. $overall_statuses['withheld_active_indlead']. '",
					`temporarily_not_available_active_indlead` = "'. $overall_statuses['temporarily_not_available_active_indlead']. '",
					`ongoing_active_indlead` = "'. $overall_statuses['ongoing_active_indlead']. '",
					`not_authorized_active_indlead` = "'. $overall_statuses['not_authorized_active_indlead']. '",
					`prohibited_active_indlead` = "'. $overall_statuses['prohibited_active_indlead']. '",
					`not_yet_recruiting_active_owner_sponsored` = "'. $overall_statuses['not_yet_recruiting_active_owner_sponsored']. '",
					`recruiting_active_owner_sponsored` = "'. $overall_statuses['recruiting_active_owner_sponsored']. '",
					`enrolling_by_invitation_active_owner_sponsored` = "'. $overall_statuses['enrolling_by_invitation_active_owner_sponsored']. '",
					`active_not_recruiting_active_owner_sponsored` = "'. $overall_statuses['active_not_recruiting_active_owner_sponsored']. '",
					`completed_active_owner_sponsored` = "'. $overall_statuses['completed_active_owner_sponsored']. '",
					`suspended_active_owner_sponsored` = "'. $overall_statuses['suspended_active_owner_sponsored']. '",
					`terminated_active_owner_sponsored` = "'. $overall_statuses['terminated_active_owner_sponsored']. '",
					`withdrawn_active_owner_sponsored` = "'. $overall_statuses['withdrawn_active_owner_sponsored']. '",
					`available_active_owner_sponsored` = "'. $overall_statuses['available_active_owner_sponsored']. '",
					`no_longer_available_active_owner_sponsored` = "'. $overall_statuses['no_longer_available_active_owner_sponsored']. '",
					`approved_for_marketing_active_owner_sponsored` = "'. $overall_statuses['approved_for_marketing_active_owner_sponsored']. '",
					`no_longer_recruiting_active_owner_sponsored` = "'. $overall_statuses['no_longer_recruiting_active_owner_sponsored']. '",
					`withheld_active_owner_sponsored` = "'. $overall_statuses['withheld_active_owner_sponsored']. '",
					`temporarily_not_available_active_owner_sponsored` = "'. $overall_statuses['temporarily_not_available_active_owner_sponsored']. '",
					`ongoing_active_owner_sponsored` = "'. $overall_statuses['ongoing_active_owner_sponsored']. '",
					`not_authorized_active_owner_sponsored` = "'. $overall_statuses['not_authorized_active_owner_sponsored']. '",
					`prohibited_active_owner_sponsored` = "'. $overall_statuses['prohibited_active_owner_sponsored']. '",		
					`new_trials` = "'. $overall_statuses['new_trials'] .'",
					`count_total` = "'. $cnt_total .'",'
					. $aa . $bb . $cc . $dd .
					'`count_lastchanged` = "'. $curtime .'",
					`highest_phase_lastchanged` = "'. $curtime .'",
					`last_calc` = "'. $curtime .'",
					`last_update` = "'. $curtime .'" 
					WHERE	`entity1` IN ("' . $entity1id . '","' . $entity2id . '") 
						AND `entity2` IN ("' . $entity1id . '","' . $entity2id . '") 
					';
					
		}
		
		if(!$res = mysql_query($query))
		{
			$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
			global $logger;
			$logger->error($log);
			echo $log;
			return false;
		}
		
	}
	else
	{
	
		$query	=	'	INSERT INTO 	rpt_masterhm_cells 
						SET 
							`entity2` = "'. $entity2id .'",
							`entity1` = "'. $entity1id .'",
							`count_active` ="'. $cnt_active.'",
							`count_active_indlead` ="'. $cnt_active_indlead.'",
							`count_active_owner_sponsored` ="'. $cnt_active_owner_sponsored.'",
							`bomb_auto` = "'. $bomb .'",
							`not_yet_recruiting` = "'. $overall_statuses['not_yet_recruiting'] .'",
							`recruiting` = "'. $overall_statuses['recruiting'] .'",
							`enrolling_by_invitation` = "'. $overall_statuses['enrolling_by_invitation'] .'",
							`active_not_recruiting` = "'. $overall_statuses['active_not_recruiting'] .'",
							`completed` = "'. $overall_statuses['completed'] .'",
							`suspended` = "'. $overall_statuses['suspended'] .'",
							`terminated` = "'. $overall_statuses['terminated'] .'",
							`withdrawn` = "'. $overall_statuses['withdrawn'] .'",
							`available` = "'. $overall_statuses['available'] .'",
							`no_longer_available` = "'. $overall_statuses['no_longer_available'] .'",
							`approved_for_marketing` = "'. $overall_statuses['approved_for_marketing'] .'",
							`no_longer_recruiting` = "'. $overall_statuses['no_longer_recruiting'] .'",
							`withheld` = "'. $overall_statuses['withheld'] .'",
							`temporarily_not_available` = "'. $overall_statuses['temporarily_not_available'] .'",
							`ongoing` = "'. $overall_statuses['ongoing'] .'",
							`not_authorized` = "'. $overall_statuses['not_authorized'] .'",
							`prohibited` = "'. $overall_statuses['prohibited'] .'",
							`not_yet_recruiting_active` = "'. $overall_statuses['not_yet_recruiting_active']. '",
							`recruiting_active` = "'. $overall_statuses['recruiting_active']. '",
							`enrolling_by_invitation_active` = "'. $overall_statuses['enrolling_by_invitation_active']. '",
							`active_not_recruiting_active` = "'. $overall_statuses['active_not_recruiting_active']. '",
							`completed_active` = "'. $overall_statuses['completed_active']. '",
							`suspended_active` = "'. $overall_statuses['suspended_active']. '",
							`terminated_active` = "'. $overall_statuses['terminated_active']. '",
							`withdrawn_active` = "'. $overall_statuses['withdrawn_active']. '",
							`available_active` = "'. $overall_statuses['available_active']. '",
							`no_longer_available_active` = "'. $overall_statuses['no_longer_available_active']. '",
							`approved_for_marketing_active` = "'. $overall_statuses['approved_for_marketing_active']. '",
							`no_longer_recruiting_active` = "'. $overall_statuses['no_longer_recruiting_active']. '",
							`withheld_active` = "'. $overall_statuses['withheld_active']. '",
							`temporarily_not_available_active` = "'. $overall_statuses['temporarily_not_available_active']. '",
							`ongoing_active` = "'. $overall_statuses['ongoing_active']. '",
							`not_authorized_active` = "'. $overall_statuses['not_authorized_active']. '",
							`prohibited_active` = "'. $overall_statuses['prohibited_active']. '",
							`not_yet_recruiting_active_indlead` = "'. $overall_statuses['not_yet_recruiting_active_indlead']. '",
							`recruiting_active_indlead` = "'. $overall_statuses['recruiting_active_indlead']. '",
							`enrolling_by_invitation_active_indlead` = "'. $overall_statuses['enrolling_by_invitation_active_indlead']. '",
							`active_not_recruiting_active_indlead` = "'. $overall_statuses['active_not_recruiting_active_indlead']. '",
							`completed_active_indlead` = "'. $overall_statuses['completed_active_indlead']. '",
							`suspended_active_indlead` = "'. $overall_statuses['suspended_active_indlead']. '",
							`terminated_active_indlead` = "'. $overall_statuses['terminated_active_indlead']. '",
							`withdrawn_active_indlead` = "'. $overall_statuses['withdrawn_active_indlead']. '",
							`available_active_indlead` = "'. $overall_statuses['available_active_indlead']. '",
							`no_longer_available_active_indlead` = "'. $overall_statuses['no_longer_available_active_indlead']. '",
							`approved_for_marketing_active_indlead` = "'. $overall_statuses['approved_for_marketing_active_indlead']. '",
							`no_longer_recruiting_active_indlead` = "'. $overall_statuses['no_longer_recruiting_active_indlead']. '",
							`withheld_active_indlead` = "'. $overall_statuses['withheld_active_indlead']. '",
							`temporarily_not_available_active_indlead` = "'. $overall_statuses['temporarily_not_available_active_indlead']. '",
							`ongoing_active_indlead` = "'. $overall_statuses['ongoing_active_indlead']. '",
							`not_authorized_active_indlead` = "'. $overall_statuses['not_authorized_active_indlead']. '",
							`prohibited_active_indlead` = "'. $overall_statuses['prohibited_active_indlead']. '",
							`not_yet_recruiting_active_owner_sponsored` = "'. $overall_statuses['not_yet_recruiting_active_owner_sponsored']. '",
							`recruiting_active_owner_sponsored` = "'. $overall_statuses['recruiting_active_owner_sponsored']. '",
							`enrolling_by_invitation_active_owner_sponsored` = "'. $overall_statuses['enrolling_by_invitation_active_owner_sponsored']. '",
							`active_not_recruiting_active_owner_sponsored` = "'. $overall_statuses['active_not_recruiting_active_owner_sponsored']. '",
							`completed_active_owner_sponsored` = "'. $overall_statuses['completed_active_owner_sponsored']. '",
							`suspended_active_owner_sponsored` = "'. $overall_statuses['suspended_active_owner_sponsored']. '",
							`terminated_active_owner_sponsored` = "'. $overall_statuses['terminated_active_owner_sponsored']. '",
							`withdrawn_active_owner_sponsored` = "'. $overall_statuses['withdrawn_active_owner_sponsored']. '",
							`available_active_owner_sponsored` = "'. $overall_statuses['available_active_owner_sponsored']. '",
							`no_longer_available_active_owner_sponsored` = "'. $overall_statuses['no_longer_available_active_owner_sponsored']. '",
							`approved_for_marketing_active_owner_sponsored` = "'. $overall_statuses['approved_for_marketing_active_owner_sponsored']. '",
							`no_longer_recruiting_active_owner_sponsored` = "'. $overall_statuses['no_longer_recruiting_active_owner_sponsored']. '",
							`withheld_active_owner_sponsored` = "'. $overall_statuses['withheld_active_owner_sponsored']. '",
							`temporarily_not_available_active_owner_sponsored` = "'. $overall_statuses['temporarily_not_available_active_owner_sponsored']. '",
							`ongoing_active_owner_sponsored` = "'. $overall_statuses['ongoing_active_owner_sponsored']. '",
							`not_authorized_active_owner_sponsored` = "'. $overall_statuses['not_authorized_active_owner_sponsored']. '",
							`prohibited_active_owner_sponsored` = "'. $overall_statuses['prohibited_active_owner_sponsored']. '",		
							`new_trials` = "'. $overall_statuses['new_trials'] .'",'. $highestPhaseUpdateString.
							'`count_total` = "'. $cnt_total .'",
							`last_update` = "'. $curtime .'"
					';
		//prevent inserting records with no data
		
		if( !is_null($cnt_total) && $cnt_total>0 )
		{
			if(!$res = mysql_query($query))
			{
				$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
				global $logger;
				$logger->error($log);
				echo $log;
				return false;
			}
		}
		
	}
	/**************/
	$curtime = date('Y-m-d H:i:s');
	global $sno;
	echo '<br>'. $sno .'. '. $curtime . ' Entity1 id : '. $entity1id .' Entity2 id : '. $entity2id . ' - done.'. str_repeat("  ",800)  ;
	
	
}


function getBombdtl()
{
	global $data,$isactive,$instype,$ldate,$phases,$ostatus,$cnt_total;
	global $logger;
		
	if (count($data) == 0)
		return "";

	$bombStatuses = '"Active, not recruiting","Not yet recruiting","Recruiting","Enrolling by invitation"';
	//$past = "'".date("Y-m-d H:i:s", time() - (int)(540*24*3600))."'";
	$past = date('Y-m-d', strtotime("-180 days")); 
	$tmpphase=array();
	$cond1sb=false;  // first condition (terinated/suspended trial & > 18 months old)
	$cond2sb=false;  // 2nd condition (trial with status 'not yet recruiting' , 'active not recruiting', 'enrolling by invitation', or 'recruiting' in the highest phase)
	$bomb="none";
	foreach($ldate as $key=>$ld)
	{
		if( ($ostatus[$key]=='Terminated' or $ostatus[$key]=='Suspended') and $ld < $past )
		{
			$cond1sb=true;
		}
		elseif( ($ostatus[$key]=='Active, not recruiting' or $ostatus[$key]=='Not yet recruiting' or $ostatus[$key]=='Recruiting' or $ostatus[$key]=='Enrolling by invitation') )
		{
			$cond2sb=true;
			$tmpphase[]=$phases[$key];  // to find highest phase of this section
		}
			$allphases[]=$phases[$key];  // to find highest phase of all trials
	}
	if( $cond1sb and $cond2sb and (max($tmpphase)==max($allphases)) )  // all conditions met for small bomb
	{
		$bomb="small";
	}
	else	// No small bomb, now check for large bomb
	{
		$cond1bb=false;  // first condition (terinated/suspended trial & > 18 months old)
	
		foreach($ldate as $key=>$ld)
		{
			if( ($ostatus[$key]=='Terminated' or $ostatus[$key]=='Suspended') and $ld < $past )
			{
				$cond1bb=true;
			}
			elseif( ($ostatus[$key]=='Active, not recruiting' or $ostatus[$key]=='Not yet recruiting' or $ostatus[$key]=='Recruiting' or $ostatus[$key]=='Enrolling by invitation') )
			{
				$tmpphase[]=$phases[$key];  // to find highest phase of this section
			}
				$allphases[]=$phases[$key];  // to find highest phase of all trials
		}
		if( $cond1bb and (@max($tmpphase)<>@max($allphases)) )  // all conditions met for big bomb
		{
			$bomb="large";
		}
	}
	
		return $bomb;
	
}
function isDiseaseCategory($av,$pv)
{

	global $logger;
	$exists=false;
	if(!empty($av))
	{
		$query = 'SELECT id from entities where id="'.$av.'" and class="Disease_Category" limit 1';
		if(!$res = mysql_query($query))
		{
			$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
			$logger->error($log);
			echo $log;
			return false;
		}
		$res = mysql_fetch_assoc($res);
		if($res !== false)
			return $av;
	}
	if(!empty($pv) and $exists === false)
	{
		$query = 'SELECT id from entities where id="'.$pv.'" and class="Disease_Category" limit 1';
		if(!$res = mysql_query($query))
		{
			$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
			$logger->error($log);
			echo $log;
			return false;
		}
		$res = mysql_fetch_assoc($res);
		if($res !== false)
			return $pv;
		else
			return false;
	}
	return false;
}
function isDisease($av)
{

	global $logger;
	$exists=false;
	if(!empty($av))
	{
		$query = 'SELECT id from entities where id="'.$av.'" and class="Disease" limit 1';
		if(!$res = mysql_query($query))
		{
			$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
			$logger->error($log);
			echo $log;
			return false;
		}
		$res = mysql_fetch_assoc($res);
		if($res !== false)
			return $av;
	}
	return false;
}
function calculateDCcell($diseaseids,$pv)
{

if(empty($diseaseids) or empty($pv))	return false;
$DC_query = "SELECT 
sum(count_total) as cnt_total,
sum(count_active) as cnt_active,
sum(count_active_indlead) as cnt_active_indlead,
sum(count_active_owner_sponsored) as cnt_active_owner_sponsored, 
max(highest_phase) as max_phase,
sum(not_yet_recruiting) as not_yet_recruiting ,
sum(recruiting) as recruiting ,
sum(enrolling_by_invitation) as enrolling_by_invitation ,
sum(active_not_recruiting) as active_not_recruiting ,
sum(completed) as completed ,
sum(suspended) as suspended ,
sum(`terminated`) as `terminated` ,
sum(withdrawn) as withdrawn ,
sum(available) as available ,
sum(no_longer_available) as no_longer_available ,
sum(approved_for_marketing) as approved_for_marketing ,
sum(no_longer_recruiting) as no_longer_recruiting ,
sum(withheld) as withheld ,
sum(temporarily_not_available) as temporarily_not_available ,
sum(ongoing) as ongoing ,
sum(not_authorized) as not_authorized ,
sum(prohibited) as prohibited ,
sum(not_yet_recruiting_active) as not_yet_recruiting_active ,
sum(recruiting_active) as recruiting_active ,
sum(enrolling_by_invitation_active) as enrolling_by_invitation_active ,
sum(active_not_recruiting_active) as active_not_recruiting_active ,
sum(completed_active) as completed_active ,
sum(suspended_active) as suspended_active ,
sum(terminated_active) as terminated_active ,
sum(withdrawn_active) as withdrawn_active ,
sum(available_active) as available_active ,
sum(no_longer_available_active) as no_longer_available_active ,
sum(approved_for_marketing_active) as approved_for_marketing_active ,
sum(no_longer_recruiting_active) as no_longer_recruiting_active ,
sum(withheld_active) as withheld_active ,
sum(temporarily_not_available_active) as temporarily_not_available_active ,
sum(ongoing_active) as ongoing_active ,
sum(not_authorized_active) as not_authorized_active ,
sum(prohibited_active) as prohibited_active ,
sum(not_yet_recruiting_active_indlead) as not_yet_recruiting_active_indlead ,
sum(recruiting_active_indlead) as recruiting_active_indlead ,
sum(enrolling_by_invitation_active_indlead) as enrolling_by_invitation_active_indlead ,
sum(active_not_recruiting_active_indlead) as active_not_recruiting_active_indlead ,
sum(completed_active_indlead) as completed_active_indlead ,
sum(suspended_active_indlead) as suspended_active_indlead ,
sum(terminated_active_indlead) as terminated_active_indlead ,
sum(withdrawn_active_indlead) as withdrawn_active_indlead ,
sum(available_active_indlead) as available_active_indlead ,
sum(no_longer_available_active_indlead) as no_longer_available_active_indlead ,
sum(approved_for_marketing_active_indlead) as approved_for_marketing_active_indlead ,
sum(no_longer_recruiting_active_indlead) as no_longer_recruiting_active_indlead ,
sum(withheld_active_indlead) as withheld_active_indlead ,
sum(temporarily_not_available_active_indlead) as temporarily_not_available_active_indlead ,
sum(ongoing_active_indlead) as ongoing_active_indlead ,
sum(not_authorized_active_indlead) as not_authorized_active_indlead ,
sum(prohibited_active_indlead) as prohibited_active_indlead ,
sum(not_yet_recruiting_active_owner_sponsored) as not_yet_recruiting_active_owner_sponsored ,
sum(recruiting_active_owner_sponsored) as recruiting_active_owner_sponsored ,
sum(enrolling_by_invitation_active_owner_sponsored) as enrolling_by_invitation_active_owner_sponsored ,
sum(active_not_recruiting_active_owner_sponsored) as active_not_recruiting_active_owner_sponsored ,
sum(completed_active_owner_sponsored) as completed_active_owner_sponsored ,
sum(suspended_active_owner_sponsored) as suspended_active_owner_sponsored ,
sum(terminated_active_owner_sponsored) as terminated_active_owner_sponsored ,
sum(withdrawn_active_owner_sponsored) as withdrawn_active_owner_sponsored ,
sum(available_active_owner_sponsored) as available_active_owner_sponsored ,
sum(no_longer_available_active_owner_sponsored) as no_longer_available_active_owner_sponsored ,
sum(approved_for_marketing_active_owner_sponsored) as approved_for_marketing_active_owner_sponsored ,
sum(no_longer_recruiting_active_owner_sponsored) as no_longer_recruiting_active_owner_sponsored ,
sum(withheld_active_owner_sponsored) as withheld_active_owner_sponsored ,
sum(temporarily_not_available_active_owner_sponsored) as temporarily_not_available_active_owner_sponsored ,
sum(ongoing_active_owner_sponsored) as ongoing_active_owner_sponsored ,
sum(not_authorized_active_owner_sponsored) as not_authorized_active_owner_sponsored ,
sum(prohibited_active_owner_sponsored) as prohibited_active_owner_sponsored ,
sum(new_trials) as new_trials 
FROM rpt_masterhm_cells
WHERE ". $pv . " in (entity1,entity2) and 
( 
entity1 in (" . $diseaseids . ")
or
entity2 in (" . $diseaseids . ")
)
";

	if(!$res = mysql_query($DC_query))
	{
		global $logger;
		$log='There seems to be a problem with the SQL Query:'.$DC_query.' Error:' . mysql_error();
		$logger->error($log);
		echo $log;
		return false;
	}
	$res = mysql_fetch_assoc($res);
	if ($res === false)
		return false;
	else
	{
		return $res;
	}
}

function calculatenonDCtrials($pv)
{

if(empty($pv))	return false;
$DC_query = 'SELECT distinct
trial from entity_trials
where entity ="' . $pv . '"';
	if(!$res = mysql_query($DC_query))
	{
		global $logger;
		$log='There seems to be a problem with the SQL Query:'.$DC_query.' Error:' . mysql_error();
		$logger->error($log);
		echo $log;
		return false;
	}
	
	$trialids=array();
	while($row = mysql_fetch_assoc($res))
	{
		$trialids[] = $row['trial'];
	}
	
	$trialids = implode(",", $trialids);
	return $trialids;

}
function calculateDCforEntities($diseaseids,$pv)
{

if(empty($diseaseids) or empty($pv))	return false;
$DC_query = "SELECT distinct
trial from entity_trials
where entity in (" . $diseaseids . ")
";
	if(!$res = mysql_query($DC_query))
	{
		global $logger;
		$log='There seems to be a problem with the SQL Query:'.$DC_query.' Error:' . mysql_error();
		$logger->error($log);
		echo $log;
		return false;
	}
	
	$trialids=array();
	while($row = mysql_fetch_assoc($res))
	{
		$trialids[] = $row['trial'];
	}
	
	$trialids = implode(",", $trialids);
	return $trialids;

}

?>  