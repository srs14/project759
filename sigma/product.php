<?php
	define("SIGMA","1");
	header('P3P: CP="CAO PSA OUR"');
	session_start();
	//connect to Sphinx
	if(!isset($sphinx) or empty($sphinx)) $sphinx = @mysql_connect("127.0.0.1:9306") or $sphinx=false;
	
	$_REQUEST['sourcepg']='TZP';
	$cwd = getcwd();
	chdir ("..");
	require_once('db.php');
	require_once('include.util.php');
	require_once('intermediary.php');
	chdir ($cwd);
	require_once('disease_tracker.php');
	require_once('investigators_tracker.php');
	require_once('news_tracker.php');
	
	$e1 = NULL;
	if( ($_REQUEST['er']=='1%20month') or ($_REQUEST['er']=='1 month') )
		$_REQUEST['er']='1 month';
	
	if($_REQUEST['e1'] != NULL && $_REQUEST['e1'] != '' && isset($_REQUEST['e1']))
	{
		$e1 = $_REQUEST['e1'];
		$query = 'SELECT `name`, `id`,company FROM `entities` WHERE `class` = "Product" AND `id`=' . mysql_real_escape_string($e1);
		$res = mysql_query($query) or die($query.' '.mysql_error());
		$header = mysql_fetch_array($res);
		$e1 = $header['id'];
		$ProductName = $header['name'];
		$CompanyName[] = $header['company'];
	}
	$page = 1;
	if(isset($_REQUEST['page']) && is_numeric($_REQUEST['page']))
	{
		$page = mysql_real_escape_string($_REQUEST['page']);
	}
	
	$tab = 'diseasetrac';
	$TabDiseaseCount = $TabTrialsCount = $TabNewsCount = $TabInvestigatorCount = 0;
	if(isset($_REQUEST['tab']))
	{
		$tab = mysql_real_escape_string($_REQUEST['tab']);
	}
	$categoryFlag = (isset($_REQUEST['category']) ? $_REQUEST['category'] : 0);
	global $tabCommonUrl;
	$tabCommonUrl = 'product.php?e1='.$e1;
	
	if(isset($_REQUEST['dwcount']))
	$dwcount = $_REQUEST['dwcount'];
	else
	$dwcount = 'total';
	if($e1 !=NULL)
	{	
		$disTrackerData = showDiseaseTracker($e1, 'PDT', $page, $categoryFlag);		//PDT = PRODUCT DISEASE TRACKER

		$sqlGetTabs = "SELECT * from tabs where entity_id = $e1 AND  table_name = 'entities'";
		$resGetTabs = mysql_query($sqlGetTabs) or die($sqlGetTabs.'- Bad SQL query');
		$rowGetTabs = mysql_fetch_assoc($resGetTabs);
		if($categoryFlag == 1){
			$TabDiseaseCount = $rowGetTabs['diseases_categories'];
		}	
		else{
			$TabDiseaseCount = $rowGetTabs['diseases'];
		}
		$TabTrialsCount = $rowGetTabs['trials'];
		$TabNewsCount = $rowGetTabs['news'];
		$TabInvestigatorCount = $rowGetTabs['investigators'];
	}
	$meta_title = 'Larvol Sigma'; //default value
	$meta_title = isset($ProductName) ? $ProductName. ' - '.$meta_title : $meta_title;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $meta_title; ?></title>
	<style type="text/css">
		body
		{
			font-family:Arial;
			font-size:14px;
			color:#000000;
		}

		a {color:#1122cc;}      /* unvisited link */
		a:visited {color:#6600bc;}  /* visited link */
		/*a:hover {color:#FF00FF;}  /* mouse over link */
		/*a:active {color:#0000FF;}  /* selected link */

		.ReportHeading
		{
			color: rgb(83, 55, 130);
			font-size: xx-large;
			font-weight: bold;
		}

		.SearchBttn1
		{
			width:100px;
			height:35px;
			background-color:#4f2683;
			font-weight:bold;
			color:#FFFFFF;
		}

		.FoundResultsTb
		{
			background-color:#aa8ece;
			border:0;
			border-top:#4f2683 solid 2px;
		}

		#FoundResultsTb a 
		{
			display:inline;
		}
	</style>
	<!--tab css-->
	<style>
		.selectTab
		{
			background-image:url(../images/selectTab.png); 
			background-repeat:repeat-x;
		}

		.Tab
		{
			background-image:url(../images/Tab.png); 
			background-repeat:repeat-x;
		}

		#disease_tabs a
		{
			text-decoration:none;
			color:#000000;
			font-size:13px;
			font-family:Arial, Helvetica, sans-serif;
			display:block;
		}

		#diseaseTab_content
		{
			background-color: #ffffff;
			padding: 30px;
			border-top:#333333 solid 1px;
		}
	</style>
	<script src="scripts/jquery-1.7.1.min.js"></script>
	<script src="scripts/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="scripts/chrome.js"></script>
	<script type="text/javascript" src="scripts/iepngfix_tilebg.js"></script>
</head>

<body>
	<?php include "searchbox.php";?>
	<!-- Number of Results -->
	<br/>
	<table width="100%" border="0" class="FoundResultsTb">
		<tr>
			<td width="50%" style="border:0; font-weight:bold; padding-left:5px; color:#FFFFFF; font-size:23px; vertical-align:middle;" align="left">
				<table><tr>
				<?php 
					print '<td style="vertical-align:top;"><a style="color:#FFFFFF; display:inline; text-decoration:underline;" href="product.php?e1='.$e1.'">'.productFormatLI($ProductName, $CompanyName, $tag='').'</a>&nbsp;</td>';
				?>
				</tr></table>
			</td>
			<td width="50%" align="right" style="border:0; font-weight:bold; padding-right:5px;">			
			<?php
			if($db->loggedIn()) {
				echo('<div style="padding-left:10px;float:right;">Welcome, <a  style="display:inline;"  href="profile.php">'
					. htmlspecialchars($db->user->username) . '</a> :: <a  style="float:right;width:50px;"  href="login.php?logout=true">Logout</a> &nbsp; </div>');
			} else {
				echo ('<div style="padding-left:10px;float:right;font-size:18px;"><a href="login.php">login</a></div>');
			}
			?>			
			</td>
		</tr>
	</table>

	<!-- Displaying Records -->
	<br/>
	<table width="100%" border="0" style="" cellpadding="0" cellspacing="0">
		<?php
		print '
			<tr><td>				
				<table cellpadding="0" cellspacing="0" id="disease_tabs">
					<tr>
						'; 
						if($categoryFlag == 1){
							$CountExt = (($TabDiseaseCount == 1) ? 'Disease Category':'Disease Categories');
						}else{
							$CountExt = (($TabDiseaseCount == 1) ? 'Disease':'Diseases');
						}
						$diseaseLinkName = '<a href="'.$tabCommonUrl.'&tab=diseasetrac" title="'.$TabDiseaseCount.' '.$CountExt.'">&nbsp;'.$TabDiseaseCount.'&nbsp;'.$CountExt.'&nbsp;</a>';
						$CountExt = (($TabTrialsCount == 1) ? 'Trial':'Trials');
						$trialsLinkName = '<a href="'.$tabCommonUrl.'&tab=ott&sourcepg=TZP" title="'.$TabTrialsCount.' '.$CountExt.'">&nbsp;'.$TabTrialsCount.'&nbsp;'.$CountExt.'&nbsp;</a>';
						$CountExt = (($TabInvestigatorCount == 1) ? 'Investigator':'Investigators');
						$investigatorLinkName = '<a href="'.$tabCommonUrl.'&tab=investigatortrac" title="'.$TabInvestigatorCount.' '.$CountExt.'">&nbsp;'.$TabInvestigatorCount.'&nbsp;'.$CountExt.'&nbsp;</a>';
						$CountExt = (($TabNewsCount == 1) ? 'News':'News');
						$newsLinkName = '<a href="'.$tabCommonUrl.'&tab=newstrac" title="'.$TabNewsCount.' '.$CountExt.'">&nbsp;'.$TabNewsCount.'&nbsp;'.$CountExt.'&nbsp;</a>';
						
						if($tab == 'diseasetrac') {  
						print '<td>
									<img id="CompanyImg" src="../images/firstSelectTab.png" />
								</td>
								<td id="DiseaseTab" class="selectTab">' . $diseaseLinkName .'</td>
								<td>
									<img id="investigatorImg" src="../images/selectTabConn.png" />
								</td>
								<td id="InvestigatortracTab" class="Tab">' . $investigatorLinkName .'</td>
								<td>
									<img id="CompanyImg" src="../images/afterTab.png" />
								</td>
								<td id="DiseaseTab" class="Tab">'. $trialsLinkName .'</td>
								<td>
									<img id="CompanyImg" src="../images/afterTab.png" />
								</td>
								
								<td id="DiseaseTab" class="Tab">'. $newsLinkName .'</td>
								<td>
									<img id="lastImg" src="../images/lastTab.png" />
								</td>
								
								
								<td></td>';
						} else if($tab == 'investigatortrac') {
						print '<td>
									<img id="CompanyImg" src="../images/firstTab.png" />
								</td>
								<td id="DiseaseTab" class="Tab">' . $diseaseLinkName .'</td>
								<td>
									<img id="investigatorImg" src="../images/middleTab.png" />
								</td>
								<td id="InvestigatortracTab" class="selectTab">' . $investigatorLinkName .'</td>
								<td>
									<img id="CompanyImg" src="../images/selectTabConn.png" />
								</td>
								<td id="DiseaseTab" class="Tab">'. $trialsLinkName .'</td>
								<td>
									<img id="CompanyImg" src="../images/afterTab.png" />
								</td>
								<td id="DiseaseTab" class="Tab">'. $newsLinkName .'</td>
								<td>
									<img id="lastImg" src="../images/lastTab.png" />
								</td>
								<td></td>';
						} else if($tab == 'ott') { 
						print '<td>
									<img id="CompanyImg" src="../images/firstTab.png" />
								</td>
								<td id="DiseaseTab" class="Tab">' . $diseaseLinkName .'</td>
								<td>
									<img id="investigatorImg" src="../images/afterTab.png" />
								</td>
								<td id="InvestigatortracTab" class="Tab">' . $investigatorLinkName .'</td>
								<td>
									<img id="CompanyImg" src="../images/middleTab.png" />
								</td>
								<td id="DiseaseTab" class="selectTab">'. $trialsLinkName .'</td>
								<td>
									<img id="lastImg" src="../images/selectTabConn.png" />
								</td>
								<td id="InvestigatorTab" class="Tab">'. $newsLinkName .'</td>
								<td>
									<img id="lastImg" src="../images/lastTab.png" />
								</td>
								<td></td>';
						// print '<td><img id="CompanyImg" src="../images/firstSelectTab.png" /></td><td id="CompanyTab" class="selectTab">'. $companyLinkName .'</td></td><td><img id="lastImg" src="../images/selectLastTab.png" /></td><td></td>';
						 } else if($tab == 'newstrac') {
				 		print '<td><img id="investigatorImg" src="../images/firstTab.png" /></td>
							<td id="InvestigatortracTab" class="Tab">' . $investigatorLinkName .'</td>
							<td><img id="CompanyImg" src="../images/afterTab.png" /></td>
							<td id="DiseaseTab" class="Tab">'. $diseaseLinkName .'</td>
							<td><img id="CompanyImg" src="../images/afterTab.png" /></td>
							<td id="CompanyTab" class="Tab">'. $trialsLinkName .'</td></td>
							<td><img id="CompanyImg" src="../images/middleTab.png" /></td>
							<td id="CompanyTab" class="selectTab">'. $newsLinkName .'</td></td>
							<td><img id="lastImg" src="../images/selectLastTab.png" /></td><td></td>';
				 		// print '<td><img id="CompanyImg" src="../images/firstSelectTab.png" /></td><td id="CompanyTab" class="selectTab">'. $companyLinkName .'</td></td><td><img id="lastImg" src="../images/selectLastTab.png" /></td><td></td>';
				 		}
			print	'            
			
					</tr>
				</table>			
			</td>
		</tr>';
		?>
		<tr>
			<td align="center">
				<?php
				if($tab == 'diseasetrac'){
					print '<div id="diseaseTab_content" align="center">'.$disTrackerData;		//PDT = PRODUCT DISEASE TRACKER
				}
				else if($tab == 'investigatortrac'){
					print '<div id="diseaseTab_content" align="center">'.showInvestigatorTracker($e1, 'PIT', $page);		//PDT = PRODUCT INVESTIGATOR TRACKER  showInvestigatorTracker
				}
				else if($tab == 'newstrac'){
					print '<div id="diseaseTab_content" align="left">'.showNewsTracker($e1, 'PNT', $page);		//PDT = PRODUCT NEWS TRACKER  showNewsTracker
				}	
				else
				{
					chdir ("..");
					print '<div id="diseaseTab_content" align="center">'; DisplayOTT(); //SHOW OTT 	
					chdir ("$cwd");
				}
				print '</div>';
				?>
			</td>
		</tr>

	</table>
	<br/><br/>
	
	<?php include "footer.php" ;
/* Function to get News count from Product id */
	function GetNewsCountFromProduct($ProductID)
	{
		global $db;
		global $now;
		$NewsCount = 0;
		$query = "SELECT count(dt.`larvol_id`) as newsCount FROM `data_trials` dt JOIN `entity_trials` et ON(dt.`larvol_id` = et.`trial`)  JOIN `news` n ON(dt.`larvol_id` = n.`larvol_id`) WHERE et.`entity`='" . mysql_real_escape_string($ProductID) . "'";
		$res = mysql_query($query) or die('Bad SQL query getting trials count from Product id ');
	
		if($res)
		{
			while($row = mysql_fetch_array($res))
				$NewsCount = $row['newsCount'];
		}
		if ($NewsCount > 50) $NewsCount = 50;
		return $NewsCount;
	}
	/* Function to get Trials count from Disease id */
	function GetTrialsCountFromProduct($ProductID)
	{
		global $db;
		global $now;
		$TrialsCount = 0;
		$query = "SELECT count(Distinct(dt.`larvol_id`)) as trialCount FROM `data_trials` dt JOIN `entity_trials` et ON(dt.`larvol_id` = et.`trial`)  WHERE et.`entity`='" . mysql_real_escape_string($ProductID) . "'";
		$res = mysql_query($query) or die('Bad SQL query getting trials count from Product id in TZ');
		
		if($res)
		{
			while($row = mysql_fetch_array($res))
			$TrialsCount = $row['trialCount'];
		}
		return $TrialsCount;
	}
	?>
</body>
</html>
