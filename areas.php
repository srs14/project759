<?php
require_once('krumo/class.krumo.php');
require_once('db.php');
require_once('include.search.php');
require_once('include.util.php');
require_once 'include.page.php';
/**
 * 
 * 
 * [6] => Array
        (
            [Field] => coverage_area
            [Type] => tinyint(1)
            [Null] => NO
            [Key] => 
            [Default] => 0
            [Extra] => 
        )
 * 
 */
if(!$db->loggedIn())
{
	header('Location: ' . urlPath() . 'index.php');
	exit;
}

if(stripos($_REQUEST['searchdata'],'"ignore_changes":"no"')>2)
{	
	$_GET['ignore_changes']='no';
}
elseif(stripos($_REQUEST['searchdata'],'"ignore_changes":"yes"')>2)
{
	$_GET['ignore_changes']='yes';
}
	

//declare all globals
global $db;
global $page;
global $deleteFlag;
global $searchFormData;
$searchFormData = null;

$table = $script = 'areas';

//save search data
if(isset($_POST['searchformdata']))
{
	/*Start - Removing fields for which action is set to None (zero) or empty data - for ticket no. 42 over Trac*/ 
	$_POST = removeNullSearchdata($_POST);
	if($_POST['time_machine'] == '' || $_POST['time_machine'] == NULL)
		unset($_POST['time_machine']);
	
	if($_POST['override'] == '' || $_POST['override'] == NULL)
		unset($_POST['override']);
		
	if(empty($_POST['multifields']) || empty($_POST['multifields']['varchar+text'])) {
		unset($_POST['multifields']);
		unset($_POST['multivalue']);
	}	
		
	if(empty($_POST['action']))
		unset($_POST['action']);
	
	if(empty($_POST['searchval']))
		unset($_POST['searchval']);
	
	if(empty($_POST['negate']))
		unset($_POST['negate']);
		
	unset($_POST['searchformdata']);
	$areasId = $_POST['id'];
	unset($_POST['id']);
	/* End - Removing fields for which action is set to None (zero) or empty data*/	
	$searchData = null;
	$searchData = base64_encode(serialize($_POST));
	
}
//calulate delete flag
if($db->user->userlevel == 'admin')
$deleteFlag = 1;
else
$deleteFlag = null;

//Header controller
$_GET['header']='<script type="text/javascript" src="progressbar/jquery.progressbar.js"></script>
<link href="css/status.css" rel="stylesheet" type="text/css" media="all" />'."\n";
if(is_numeric($_REQUEST['id']))
{
	//get product status & progress bar controller
	$areaStatus = getPreindexProgress('AREA2',$_REQUEST['id']);
	if($areaStatus['update_items_start_time']!="0000-00-00 00:00:00"&&$areaStatus['update_items_complete_time']!="0000-00-00 00:00:00"&&$areaStatus['status']==COMPLETED)
	$areaPreindexProgress=100;
	else
	$areaPreindexProgress=number_format(($areaStatus['update_items_total']==0?0:(($areaStatus['update_items_progress'])*100/$areaStatus['update_items_total'])),2);
}
/* if(count($areaStatus)!=0 || 1)
 {
$_GET['header'] .= '<script type="text/javascript">'."\n";
//$_GET['header'] .=  "$('#product_new').progressBar();"."\n";
$_GET['header'] .=  "$('#product_update').progressBar({ barImage: 'images/progressbg_orange.gif'} );"."\n";
$_GET['header'] .= '</script>'."\n";
} */

//end Header controller

//reset controller
if($_GET['reset'])
header('Location: ' . urlPath() . $script.'.php');
require('header.php');
//reset header controller
unset($_GET['header']);
//
echo('<script type="text/javascript" src="delsure.js"></script>');
?>
<script type="text/javascript">
$('#product_update').progressBar({ 	
    barImage : {
		0:  'images/progressbg_red.gif',
		30: 'images/progressbg_orange.gif',
		70: 'images/progressbg_green.gif'
	},
} );

<?php
		if(isset($_REQUEST['id']))	//load search from Saved Search
		{
			$id = ($_REQUEST['id'])?$_REQUEST['id']:null;
			$searchDbData = getSearchData($table, 'searchdata', $id);
			//$show_value = 'loadQueryData("' . $data . '");';
			//$show_value = "loadQueryData('" . $searchDbData . "');";
			$show_value = "searchDbData = '" . $searchDbData . "';";
			echo($show_value);

		}
		else
		{
			$show_value = "searchDbData = '';";
			echo($show_value);
		}
		?>
function upmdelsure(){ return confirm("Are you sure you want to delete this area?"); }
$(document).ready(function(){
	var options, a,b;
	jQuery(function(){
	  options = { serviceUrl:'autosuggest.php',params:{table:<?php echo "'$table'"?>,field:'name'}, showOnSelect:true };
	  if($('#name').length>0)
	  a = $('#name').autocomplete(options);
	  b = $('#search_name').autocomplete(options);
	});
	$(".ajax").colorbox({
		onComplete:function(){ loadQueryData($('#searchdata').val());},
		onClosed:function(){ newSearch(); },
		inline:true, 
		width:"100%",
		height:"100%"
			});
	$("#inline_outer").hide();	
});
</script>
<div class="error">Under Development</div>

<?php 
//Start controller area
//Start controller area
//save operation controller
if($_REQUEST['save']=='Save')
{
	$searchDataOld = $_REQUEST['id']?getSearchData('areas', 'searchdata', $_REQUEST['id']):null;
	$_REQUEST = array_merge($_GET, $_POST); 
	$saveStatus = saveData($_REQUEST,$table);
}
//delete controller
if(isset($_REQUEST['deleteId']) && is_numeric($_REQUEST['deleteId']) && $deleteFlag)
{
	deleteData($_REQUEST['deleteId'],$table);
	$pattern = '/(\\?)(deleteId).*?(\\d+)/is';
	$_SERVER['REQUEST_URI'] =  preg_replace($pattern, '', $_SERVER['REQUEST_URI']);
	$_SERVER['REQUEST_URI'] = str_replace($script.'.php&', $script.'.php?', $_SERVER['REQUEST_URI']);
}
//set docs per list
$limit = 50;
$totalCount = getTotalCount($table);
$maxPage = $totalCount%$limit;
if(!isset($_GET['oldval']))
$page=0;

//pagination
$ignoreFields = array('searchdata');
pagePagination($limit,$totalCount,$table,$script,$ignoreFields,array('import'=>false,'add_new_record'=>true,'search'=>true));
//pagination controller

echo '<br/>';
echo '<div class="clr">';
//add edit form.
if($_REQUEST['add_new_record']=='Add New Record' || $_REQUEST['id'] && !$_REQUEST['save'] || $saveStatus===0)
{
	$id = ($_REQUEST['id'])?$_REQUEST['id']:null;
	echo '<div>';
	addEditUpm($id,$table,$script,array("formOnSubmit"=>"onsubmit=\"return chkbox(this,'delsearch','searchdata');\"",'deletebox'=>true,'saveStatus'=>$saveStatus,'preindexProgress'=>$areaPreindexProgress,'preindexStatus'=>$areaStatus));
	echo '</div>';
	echo '<br/>';
}


//normal upm listing
$start = $page*$limit;
contentListing($start,$limit,$table,$script,array('coverage_area'),array(),array('delete'=>false));
echo '</div>';
?>
<div id="inline_outer" >
<div id="inline_content">
<table>

<tr>

<td>
<div class="querybuilder" ></div>
</td>

<td valign="top" style="padding-top: 15px">
<table width="200px">
<tr>
<td class="graybk" style="text-align: center; font-weight: bold">
Actions</td>
</tr>
<tr>
<td style="padding-left: 30px;"><input type="submit"
style="width: 100px" onclick="testSQL();return false;"
value="Test Query" id="btnTest" /></td>
</tr>
</table>
</td>
</tr>
<tr>
	<td style="padding-left: 30px;"><input type="submit"
	style="width: 100px" onclick="submitSearch();return false;"
	value="Submit" id="btnSubmit" /></td>
</tr>
</table>
</div>
</div>
<?php 
require_once 'querybuilder.php';
?>
<script type="text/javascript">
$(document).ready(function () {

});

    function testSQL()
    {
        var jsonData = getQueryData();   
		if(jsonData.length > 500)
		{
			requestType = 'POST';
		}
		else
		{
			requestType = 'GET';
		}
          $.ajax({
					type: requestType,
					url:  'searchhandler.php' + '?op=testQuery',
					data: 'data=' + jsonData,
					beforeSend:function (){
						$("#3009").show();
						$("#3009").html('<div style="height:50px;text-align: center;z-index: 99;"><img width="100" height="100" src="images/loading.gif" alt="loading..." title="loading..."/></div>');
						},
					success: function (data) {
							$("#3009").show();
        					$("#3009").html(data);
        		            //$("#3009").attr("style", "visibility:show");
        		        	
					}
        	});
        return;
    		
  }
    
    function runSQL()
    {
        var jsonData = getQueryData();   
        var url = 'queryresults.php' + '?op=runQuery&data=' + jsonData;
        window.location.href=url;
        return;
    }

    function submitSearch()
    {
    	//function to get the JSON data of the search
    	var jsonData = getQueryData();
    	
    	var ermsg = 'Null search data not allowed. If search data is already there & you are trying to remove it, please delete search data using the delete checkbox';
    	if(jsonData !='') 
    	var jsonDataArr = eval('('+jsonData+')');
    	if(jsonData =='')
    	{
			alert(ermsg);
			return false;        	
    	}
    	if(jsonDataArr.wheredata == '')
    	{
			alert(ermsg);
			return false;
    	}
    	
    	$('#searchdata').val(jsonData);
    	if($('#searchdata').val() != searchDbData)
    	$('#search_modifier').html('[Modified]');
    	if(jsonData=='')
    	{
        	$('#add_edit_searchdata_img').attr('src','images/add.png');
    	}
    	else
    	{
        	$('#add_edit_searchdata_img').attr('src','images/edit.png');
        }
    	$("#3009").hide();
    	$('.ajax').colorbox.close();
    	$(".ajax").colorbox({
    		onComplete:function(){ loadQueryData($('#searchdata').val());},
    		onClosed:function(){ newSearch(); },
    		inline:true, 
    		width:"100%",
    		height:"100%"
    			});    	
    	return false;

    }
    $('#product_update').progressBar();
  </script>
<?php 
//preindex after successful save and change of search data as a seperate worker thread.
if($saveStatus == 1 && $searchDataOld != $_REQUEST['searchdata'])
{
	echo input_tag(array('Type'=>'iframe','Field'=>'index_area.php?id='.$_REQUEST['id'].'&connection_close=1&ignore_changes='.$_GET['ignore_changes']),null,array('style'=>"display:none"));
	unset($_GET['ignore_changes']);
}
//add predindex for full delete through a seperate worker thread
if(isset($_REQUEST['delsearch']) && is_array($_REQUEST['delsearch']))
{
	foreach($_REQUEST['delsearch'] as $delId => $wok)
	{
		echo input_tag(array('Type'=>'iframe','Field'=>urlPath().'index_area.php?id='.$delId.'&connection_close=1&ignore_changes='.$_GET['ignore_changes']),null,array('style'=>"display:none"));
	}
}
echo '</html>';

function source_id_list_changed($oldd,$newd)
{
	$string='{"columnname":"source_id","opname":"Regex","chainname"';
	$pos = strpos($oldd, $string);
	$pos1 = strpos($newd, $string);

	
	if ($pos === false && $pos1 === false) // source id list DOES NOT EXIST. 
	{
		unset($oldd);
		unset($newd);
		return false;
	}
	

	if( get_source_id_list($oldd) <> get_source_id_list($newd) ) // CHANGE in  the source id list
	{
		unset($oldd);
		unset($newd);
		return true;
	}
	
	else  // NO CHANGE in the source id list.
	{
		unset($oldd);
		unset($newd);
		return false;
	}
}

function get_source_id_list($list)	
{
	$string='"source_id","opname":"Regex","chainname"';
	$pos_start = strpos($list, $string);
	if(isset($pos_start) and !empty($pos_start))
	{
		$pos_2 = strpos($list, '"columnvalue":',$pos_start);
		$strlen=strlen('"columnvalue":"');
		$pos_start=$pos_2;
		$pos_end = strpos($list, '"}',$pos_start);
		$listA=substr($list,$pos_start+$strlen,$pos_end-($pos_start+$strlen));
	}
	else
		$listA="";
	return $listA;
}

?>