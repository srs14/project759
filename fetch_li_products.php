<?php
require_once 'db.php';
require_once 'include.page.php';
ini_set('max_execution_time','360000');	//100 hours

/**
* @name fetch_li_products
* @tutorial Function to sync LI products with LT products. All data are retrieved from LI in xml format.
* @param String $lastrun Last Run where the number on the end is a unix timestamp for
* how early you want to go back looking for changes. Subtract 24 hours from the timestamp
* to avoid timezone errors. Passing 0 returns the ID of every product
* Only do this when lastrun is at the defult value (when the item has never been run).
* @author Jithu Thomas
*/
function fetch_li_products($lastrun)
{
	//calculate 24 hours from last run.
	$lastRunMinus24H = strtotime('- 24 hours',$lastrun);
	
	//fetch all available li products within the $lastRunMinus24H timeframe.
	
	$liXmlProductList = file_get_contents(LI_API.'?tablename=product&timestamp='.$lastRunMinus24H);
	$xmlImportProductList = new DOMDocument();
	$xmlImportProductList->loadXML($liXmlProductList);
	
	//get total number products 
	$total_products=0;
	foreach($xmlImportProductList->getElementsByTagName('product_id') as $Product_ID)
	{
		$total_products++;
	}

	//** STATUS DISPLAY

	$prid = getmypid();

	$query = 'INSERT into update_status_fullhistory (process_id,status,update_items_total,start_time,trial_type,item_id) 
	  VALUES ("'. $prid .'","'. 2 .'",
	  "' . $total_products . '","'. date("Y-m-d H:i:s", strtotime('now')) .'", "' . "LI_IMPORT" . '" , "' . 0 . '" ) ;';
	 if( $total_products>1 ) mysql_query($query);
	 $up_id=mysql_insert_id();

	// STATUS DISPLAY **/
	$i=1;
	foreach($xmlImportProductList->getElementsByTagName('product_id') as $Product_ID)
	{
		$Product_ID = $Product_ID->nodeValue;
		$out = fetch_li_product_individual($Product_ID);
		
		if($out['exitProcess'])	
		{
			$query = '	update update_status_fullhistory set er_message="Bad Product XML data",	update_items_progress='. $i .', 
				status=3, updated_time="' . date("Y-m-d H:i:s", strtotime('now')) . '"  
				where update_id= "'. $up_id .'" limit 1'  ; 
			if(!$res = mysql_query($query))
			{
				global $logger;
				$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
				$logger->error($log);
				echo $log;
			}
			return array('exitProcess'=> true);
		}

		$query = '	update update_status_fullhistory set process_id="'. $prid . '",er_message="",status="'. 2 . '",
					trial_type="' . "LI_IMPORT" . '", update_items_total=' . $total_products . ',
					update_items_progress=' . ++$i .' , updated_time="' . date("Y-m-d H:i:s", strtotime('now')) . '"  
					where update_id= "'. $up_id .'" limit 1'  ; 

		if( $total_products>1 and isset($up_id) and isset($prid) )
		{
			if(!$res = mysql_query($query))
			{
				global $logger;
				$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
				$logger->error($log);
				mysql_query('ROLLBACK');
				echo $log;
				return false;
			}
		}
	}
	$query = '	update update_status_fullhistory set er_message="",	update_items_progress='. $total_products .', 
				status=0, updated_time="' . date("Y-m-d H:i:s", strtotime('now')) . '"  
				where update_id= "'. $up_id .'" limit 1'  ; 
	if(!$res = mysql_query($query))
	{
		global $logger;
		$log='There seems to be a problem with the SQL Query:'.$query.' Error:' . mysql_error();
		$logger->error($log);
		mysql_query('ROLLBACK');
		echo $log;
		return false;
	}
}
/**
 * @name fetch_li_product_individual
 * @tutorial Function to sync individual LI products with LT products. All data are retrieved from LI in xml format.
 * @param String $Product_ID = products.LI_id in LT 
 * @author Jithu Thomas
 */
function fetch_li_product_individual($Product_ID)
{
	$liXmlProduct = file_get_contents(LI_API.'?tablename=product&id='.$Product_ID);
	$xmlImportProduct = new DOMDocument();
	$xmlImportProduct->loadXML($liXmlProduct);
	$out = parseProductsXmlAndSave($xmlImportProduct,'products');
	echo 'Imported '.$out['success'].' records, Failed entries '.$out['fail']."<br/>\n";
	
	if($out['exitProcess'])	
	{
		echo "<br/>\nProduct Fetch process exited due to bad data<br/>\n";
		return array('exitProcess'=> true);
	} else return array('exitProcess'=> false);	
}

//controller
$timeStamp = '';
$timeStamp = $_GET['li_product_sync_timestamp'];
if($timeStamp !=='' && is_numeric($timeStamp))
{
	fetch_li_products($timeStamp);
}
$fetchLiScriptProductIndividualId = $_GET['fetch_li_script_product_individual_id'];
if($fetchLiScriptProductIndividualId !='')
{
	fetch_li_product_individual($fetchLiScriptProductIndividualId);
}
