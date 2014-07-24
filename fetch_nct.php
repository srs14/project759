<?php
//connect to Sphinx
if(!isset($sphinx) or empty($sphinx)) $sphinx = @mysql_connect("127.0.0.1:9306") or $sphinx=false;
require_once('db.php');
require_once('include.search.php');
require_once('include.util.php');
require_once('preindex_trial.php');
require_once('db.php');
require_once('include.import.php');
require_once('nct_common.php');
require_once('include.import.history.php');
ini_set('max_execution_time', '36000'); //10 hours
ignore_user_abort(true);

//Globals
global $logger;
$days = 0;
$last_id = 0;
$id_field = 0;
/*
if(isset($_GET['days']))
{
	$days_to_fetch = (int)$_GET['days'];
}
if(isset($days_to_fetch))	//$days_to_fetch comes from cron.php normally
{
	$days = 30+(int)$days_to_fetch;
}
else
{
	$days=1;
//	die('Need to set $days_to_fetch or $_GET[' . "'days'" . ']');
}
run_incremental_scraper($days);
*/
function run_incremental_scraper($days=NULL)
{
	global $update_id;
	$cron_run = isset($update_id); 	
	if(is_null($days)) $days = 1;
	else $days = 30+(int)$days;
	if($cron_run)
	{
		if(update_row_exists($update_id,"update_status"))
			$query = 'UPDATE update_status SET start_time="' . date("Y-m-d H:i:s", strtotime('now')) . '", updated_days='.$days.' ,  update_items_progress = "0"  WHERE update_id="' . $update_id . '"';
		else
			$query = 'INSERT INTO update_status SET update_id = "' . $update_id .'",  update_items_progress = "0",  start_time="' . date("Y-m-d H:i:s", strtotime('now')) . '", updated_days='.$days ;
		if(!$res = mysql_query($query))
			{
				$log='Unable to update update_status. Query='.$query.' Error:' . mysql_error();
				$logger->fatal($log);
				echo $log;
				//pass the control back to cron
				return false;
			}
	}

	echo("\n<br />" . 'Begin updating. Going back ' . $days . ' days.' . "\n<br />" . "\n<br />");

	$methode = "update";
	$url = "results?flds";

	echo('Searching for updated records...' . "\n<br />");
	$ids = getIDs('update',$days);
	if (count($ids) == 0) 
	{
		echo('There are none!' . "\n<br />");
		return false;
	} 
	/***** get only new updates  */
	$query = 'SELECT UNIX_TIMESTAMP(lastchanged_date) AS "lastchanged_date",source_id FROM data_trials WHERE 
				left(source_id,11) IN("' . implode('","', array_keys($ids)) . '")';

	$res = mysql_query($query);
	if ($res === false) return softDie('Bad SQL query getting lastchanged dates for existing nct_ids');
	$totcnt=count($ids);
	while ($row = mysql_fetch_assoc($res)) 
	{
		if($row['lastchanged_date'] >= substr($ids[$row['source_id']],0,11))
		{
	//		pr($row['source_id']);
			unset($ids[$row['source_id']]);
			unset($ids[substr($row['source_id'],0,11)]  );
		}
					
	}
	/*********/

	echo("<br /><br /> " . count($ids) . ' new updates out of ' . $totcnt . '.' . "\n<br />");
		if($cron_run)
		{
			
			$query = 'UPDATE update_status 
					  SET update_items_total="' . count($ids) . '",
					  update_items_start_time="' . date("Y-m-d H:i:s", strtotime('now')) . '" 
					  WHERE update_id="' . $update_id . '"';
					  
			if(!$res = mysql_query($query))
			{
				$log='Unable to update update_status. Query='.$query.' Error:' . mysql_error();
				$logger->fatal($log);
				echo $log;
				//pass the control back to cron
				return false;
			}
		}
		
		//Import the XML for all these new records
		echo('Fetching record content...' . "\n<br />");
		$progress_count = 2;
		foreach ($ids as $id => $one) 
		{
			scrape_history(unpadnct($id));
			if($cron_run)
			{
				$query = 'UPDATE update_status SET updated_time="' . date("Y-m-d H:i:s", strtotime('now')) . '",update_items_progress = update_items_progress+' . $progress_count . ' WHERE update_id="' . $update_id . '"';
				$progress_count = 1;
				if(!$res = mysql_query($query))
				{
					$log='Unable to update update_status. Query='.$query.' Error:' . mysql_error();
					$logger->fatal($log);
					echo $log;
					//pass the control back to cron
					return false;
				}
			}
		}
		if($cron_run)
		{
			$query = 'UPDATE update_status SET update_items_progress=update_items_total,updated_time="' . date("Y-m-d H:i:s", strtotime('now')) . '",update_items_complete_time ="' . date("Y-m-d H:i:s", strtotime('now')) . '" WHERE update_id="' . $update_id . '"';

			if(!$res = mysql_query($query))
			{
				$log='Unable to update update_status. Query='.$query.' Error:' . mysql_error();
				$logger->fatal($log);
				echo $log;
				//pass the control back to cron
				return false;
			}
		}


	if($cron_run)
	{
		$query = 'UPDATE update_status SET update_items_progress=update_items_total, end_time="' . date("Y-m-d H:i:s", strtotime('now')) . '" WHERE update_id="' . $update_id . '"';
		if(!$res = mysql_query($query))
		{
			$log='Unable to update update_status. Query='.$query.' Error:' . mysql_error();
			$logger->fatal($log);
			echo $log;
			//pass the control back to cron
			return false;
		}
	}
	echo('Done with everything.');
}
function update_row_exists($update_id,$update_table)
{
	$query = 'SELECT update_id from ' . $update_table .' where update_id = "' . $update_id . '" limit 1';
	$res = mysql_query($query);
	if ($res === false) return false;
	$row = mysql_fetch_assoc($res); 
	if(isset($row['update_id']))
		return true;
	else
		return false;
}

?>  