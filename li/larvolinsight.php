<?php
//include_once('../include.util.php');
ini_set('max_execution_time','3600');
if (isset($_GET['url'])) 
{
	// delete existing temporary files
	foreach (glob("tmp_*.html") as $filename) 
	{
		 @unlink($filename); 
	}

	$pageURL = 'http://';
	$pageURL .= $_SERVER["SERVER_NAME"].urldecode($_SERVER["REQUEST_URI"]);
	$pos=	strpos($pageURL,'url=');
	$url=substr($pageURL,$pos+4);
	$url .= '&LI=1';
	$LIpage = getContents( $url );
	if ( isset($LIpage['errno']) and $LIpage['errno'] != 0 ) die('Could not load the page ('.$url.')');
//	elseif ( $LIpage['http_code'] != 200 ) die('Could not load the page - access denied. ('.$url .')');
	// correct relative path of files
	$LIpage = str_replace("images/", "../images/", $LIpage);
	$LIpage = str_replace("/date/date_input.css", "../date/date_input.css", $LIpage);
	$LIpage = str_replace("css/", "../css/", $LIpage);
	$LIpage = str_replace("scripts/", "../scripts/", $LIpage);
	// 
	$tmpfname = getTempFileName();
	$handle = fopen($tmpfname, "w");
	fwrite($handle, $LIpage);
	fclose($handle);
//	pr($tmpfname);
	

//	exit;
}
else
{
echo 
	'
	<form name="mode" action="larvolinsight.php" method="GET">
	<div align="left">
	Enter url : <input type="text" name="url" value="" size="200"/>
	<input type="submit" value="Submit" />
	</div>
	</form>
	'
	;
	exit;
}
function getTempFileName()
{
    $fname = 'tmp_'.md5(time().rand()).'.html';
    return $fname;
}
function getContents( $url )
{
	//$url=rawurlencode($url);
//	echo '<br>';
	return file_get_contents($url);
	$options = 
	array(
		CURLOPT_RETURNTRANSFER => true,     
		CURLOPT_HEADER         => false,    
		CURLOPT_FOLLOWLOCATION => true,     
		CURLOPT_ENCODING       => "",       
		CURLOPT_USERAGENT      => "spider", 
		CURLOPT_AUTOREFERER    => true,     
		CURLOPT_CONNECTTIMEOUT => 120,      
		CURLOPT_TIMEOUT        => 120,      
		CURLOPT_MAXREDIRS      => 10,       
		);
	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );
	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="theMasterHead">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="avg_ls_dom.js" type="text/javascript"></script><title>
	Larvol Insight
</title><link rel="shortcut icon" href="favicon.ico">







<script language="javascript" type="text/javascript">
    function setCurrentNavState(currentLocation)
    {
        switch(currentLocation)
        {
            case "about":
                document.getElementById("MDMCentralTab").className = 'active';
                break;
                            
            case "solutions":
                document.getElementById("SolutionsTab").className = 'active';
                break;
                            
            case "clients":
                document.getElementById("ClientsTab").className = 'active';
                break;
                            
            case "careers":
                document.getElementById("CareersTab").className = 'active';
                break;
                            
            case "contact":
                document.getElementById("ContactTab").className = 'active';
                break;

            default:
                document.getElementById("HomeTab").className = 'active';
                break;
        }
    }
</script>

    



<script type="text/javascript" src="jquery.tools.min.js"></script>

    

    

    <script type="text/javascript" src="jquery.loadmask.min.js"></script>


    
    
    
    
<!--[if IE]>
<style type="text/css">
    .ImportanceBarBg 
    {
	    padding: 3px 5px 2px 2px !important;
    }
</style>
<![endif]-->

        <!--[if IE 7]>
     <style type="text/css">
     
          .rtsIn
         {
             display:inline-block!important;
         }

         .rtsOut
         {
             display:inline-block!important;
           
         }
         
         .RadGrid_Larvol .rgAltRow td {
            background-color: #DFD8E8;
        }
     </style>

    <![endif]-->

<meta name="robots" content="noindex, nofollow"><meta http-equiv="imagetoolbar" content="no"><meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"><meta http-equiv="Cache-control" content="no-cache">
        
        <script type="text/javascript" src="errormanager.js"></script>
        
    
<link rel="stylesheet" type="text/css" href="index.css" media="all">
</head>
<body>  
          
        <form method="post" action="http://www.larvolinsight.com/CR/Custom/BI+Inflammatory+Bowel+Disease/Default.aspx?cr_name=BI+Inflammatory+Bowel+Disease" id="form1">
<div class="aspNetHidden">
<input name="__EVENTTARGET" id="__EVENTTARGET" value="" type="hidden">
<input name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="" type="hidden">
<input name="__VIEWSTATE" id="__VIEWSTATE" value="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AoICFgYfDRsAAAAAAABZQAcAAAAfDgUTcmlUZXh0Qm94IHJpRW5hYmxlZB8PAoICFgYfDRsAAAAAAABZQAcAAAAfDgUUcmlUZXh0Qm94IHJpRGlzYWJsZWQfDwKCAhYGHw0bAAAAAAAAWUAHAAAAHw4FEXJpVGV4dEJveCByaUVtcHR5Hw8CggIWBh8NGwAAAAAAAFlABwAAAB8OBRByaVRleHRCb3ggcmlSZWFkHw8CggJkAgIPFCsADQ8WCAUPUmVuZGVySW52aXNpYmxlZwUNU2VsZWN0ZWREYXRlcw8FjwFUZWxlcmlrLldlYi5VSS5DYWxlbmRhci5Db2xsZWN0aW9ucy5EYXRlVGltZUNvbGxlY3Rpb24sIFRlbGVyaWsuV2ViLlVJLCBWZXJzaW9uPTIwMTAuMi45MjkuMzUsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MTIxZmFlNzgxNjViYTNkNBQrAAAFC1NwZWNpYWxEYXlzDwWSAVRlbGVyaWsuV2ViLlVJLkNhbGVuZGFyLkNvbGxlY3Rpb25zLkNhbGVuZGFyRGF5Q29sbGVjdGlvbiwgVGVsZXJpay5XZWIuVUksIFZlcnNpb249MjAxMC4yLjkyOS4zNSwgQ3VsdHVyZT1uZXV0cmFsLCBQdWJsaWNLZXlUb2tlbj0xMjFmYWU3ODE2NWJhM2Q0FCsAAAURRW5hYmxlTXVsdGlTZWxlY3RoDxYEHwoFB0RlZmF1bHQfAWhkZBYEHw4FC3JjTWFpblRhYmxlHw8CAhYEHw4FDHJjT3RoZXJNb250aB8PAgJkFgQfDgUKcmNTZWxlY3RlZB8PAgJkFgQfDgUKcmNEaXNhYmxlZB8PAgIWBB8OBQxyY091dE9mUmFuZ2UfDwICFgQfDgUJcmNXZWVrZW5kHw8CAhYEHw4FB3JjSG92ZXIfDwICFgQfDgUxUmFkQ2FsZW5kYXJNb250aFZpZXcgUmFkQ2FsZW5kYXJNb250aFZpZXdfRGVmYXVsdB8PAgIWBB8OBQlyY1ZpZXdTZWwfDwICZAIFD2QWAmYPZBYCAgEPZBYCAgEPZBYEZg8UKwAIDxYKHwBkHwoFB0RlZmF1bHQfAWgfCwUHcmlMYWJlbB8MZWQWBh8NGwAAAAAAAFlABwAAAB8OBRFyaVRleHRCb3ggcmlIb3Zlch8PAoICFgYfDRsAAAAAAABZQAcAAAAfDgURcmlUZXh0Qm94IHJpRXJyb3IfDwKCAhYGHw0bAAAAAAAAWUAHAAAAHw4FE3JpVGV4dEJveCByaUZvY3VzZWQfDwKCAhYGHw0bAAAAAAAAWUAHAAAAHw4FE3JpVGV4dEJveCByaUVuYWJsZWQfDwKCAhYGHw0bAAAAAAAAWUAHAAAAHw4FFHJpVGV4dEJveCByaURpc2FibGVkHw8CggIWBh8NGwAAAAAAAFlABwAAAB8OBRFyaVRleHRCb3ggcmlFbXB0eR8PAoICFgYfDRsAAAAAAABZQAcAAAAfDgUQcmlUZXh0Qm94IHJpUmVhZB8PAoICZAICDxQrAA0PFggFD1JlbmRlckludmlzaWJsZWcFDVNlbGVjdGVkRGF0ZXMPBY8BVGVsZXJpay5XZWIuVUkuQ2FsZW5kYXIuQ29sbGVjdGlvbnMuRGF0ZVRpbWVDb2xsZWN0aW9uLCBUZWxlcmlrLldlYi5VSSwgVmVyc2lvbj0yMDEwLjIuOTI5LjM1LCBDdWx0dXJlPW5ldXRyYWwsIFB1YmxpY0tleVRva2VuPTEyMWZhZTc4MTY1YmEzZDQUKwAABQtTcGVjaWFsRGF5cw8FkgFUZWxlcmlrLldlYi5VSS5DYWxlbmRhci5Db2xsZWN0aW9ucy5DYWxlbmRhckRheUNvbGxlY3Rpb24sIFRlbGVyaWsuV2ViLlVJLCBWZXJzaW9uPTIwMTAuMi45MjkuMzUsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MTIxZmFlNzgxNjViYTNkNBQrAAAFEUVuYWJsZU11bHRpU2VsZWN0aA8WBB8KBQdEZWZhdWx0HwFoZGQWBB8OBQtyY01haW5UYWJsZR8PAgIWBB8OBQxyY090aGVyTW9udGgfDwICZBYEHw4FCnJjU2VsZWN0ZWQfDwICZBYEHw4FCnJjRGlzYWJsZWQfDwICFgQfDgUMcmNPdXRPZlJhbmdlHw8CAhYEHw4FCXJjV2Vla2VuZB8PAgIWBB8OBQdyY0hvdmVyHw8CAhYEHw4FMVJhZENhbGVuZGFyTW9udGhWaWV3IFJhZENhbGVuZGFyTW9udGhWaWV3X0RlZmF1bHQfDwICFgQfDgUJcmNWaWV3U2VsHw8CAmQCCQ8U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Ah8CaGQCcA8WAh8CaGQCcQ8WAh8CaGQCcg8WAh8CaGQCcw8WAh8CaGQCdA8WAh8CaGQCdQ8WAh8CaGQCdg8WAh8CaGQCdw8WAh8CaGQCeA8WAh8CaGQCeQ8WAh8CaGQCeg8WAh8CaGQCew8WAh8CaGQCfA8WAh8CaGQCfQ8WAh8CaGQCfg8WAh8CaGQCfw8WAh8CaGQCgAEPFgIfAmhkAoEBDxYCHwJoZAKCAQ8WAh8CaGQCgwEPFgIfAmhkAoQBDxYCHwJoZAKGAQ8WAh8CaGQChwEPFgIfAmhkAogBDxYCHwJoZAKJAQ8WAh8CaGQCigEPFgIfAmhkAosBDxYCHwJoZAKMAQ8WAh8CaGQCjQEPFgIfAmhkAo4BDxYCHwJoZAKPAQ8WAh8CaGQCkAEPFgIfAmhkApEBDxYCHwJoZAKSAQ8WAh8CaGQClAEPFgIfAmhkApUBDxYCHwJoZAKWAQ8WAh8CaGQClwEPFgIfAmhkApgBDxYCHwJoZAKZAQ8WAh8CaGQCmgEPFgIfAmhkApsBDxYCHwJoZAKcAQ8WAh8CaGQCnQEPFgIfAmhkAp4BDxYCHwJoZAKfAQ8WAh8CaGQCoAEPFgIfAmhkAqEBDxYCHwJoZAKiAQ8WAh8CaGQCowEPFgIfAmhkAqQBDxYCHwJoZAKlAQ8WAh8CaGQCpgEPFgIfAmhkAqcBDxYCHwJoZAKoAQ8WAh8CaGQCqQEPFgIfAmhkAqoBDxYCHwJoZAKrAQ8WAh8CaGQCrAEPFgIfAmhkAq0BDxYCHwJoZAKuAQ8WAh8CaGQCrwEPFgIfAmhkArABDxYCHwJoZAKxAQ8WAh8CaGQCsgEPFgIfAmhkArMBDxYCHwJoZAK0AQ8WAh8CaGQCtQEPFgIfAmhkArYBDxYCHwJoZAK3AQ8WAh8CaGQCuAEPFgIfAmhkArkBDxYCHwJoZAK6AQ8WAh8CaGQCuwEPFgIfAmhkArwBDxYCHwJoZAK9AQ8WAh8CaGQCvgEPFgIfAmhkAr8BDxYCHwJoZALAAQ8WAh8CaGQCwQEPFgIfAmhkAsIBDxYCHwJoZALEAQ8WAh8CaGQCxQEPFgIfAmhkAsYBDxYCHwJoZALHAQ8WAh8CaGQCyAEPFgIfAmhkAskBDxYCHwJoZALKAQ8WAh8CaGQCywEPFgIfAmhkAswBDxYCHwJoZALNAQ8WAh8CaGQCzgEPFgIfAmdkAs8BDxYCHwJnZAIHDw8WAh8BaGRkAgIPZBYEAgEPZBYCAgEPZBYEAgMPZBYEAgEPZBYCAgEPZBYCZg8WAxQrAAJkZGQUKwEAZAIDD2QWBAIBD2QWAgIBDxQrAAgPFgQfAWgfCwUHcmlMYWJlbGQWBh8NGwAAAAAA4HVAAQAAAB8OBRFyaVRleHRCb3ggcmlIb3Zlch8PAoICFgYfDRsAAAAAAOB1QAEAAAAfDgURcmlUZXh0Qm94IHJpRXJyb3IfDwKCAhYGHw0bAAAAAADgdUABAAAAHw4FE3JpVGV4dEJveCByaUZvY3VzZWQfDwKCAhYGHw0bAAAAAADgdUABAAAAHw4FE3JpVGV4dEJveCByaUVuYWJsZWQfDwKCAhYGHw0bAAAAAADgdUABAAAAHw4FFHJpVGV4dEJveCByaURpc2FibGVkHw8CggIWBh8NGwAAAAAA4HVAAQAAAB8OBRFyaVRleHRCb3ggcmlFbXB0eR8PAoICFgYfDRsAAAAAAOB1QAEAAAAfDgUQcmlUZXh0Qm94IHJpUmVhZB8PAoICZAICD2QWBAIBDw8WAh8WaGRkAgMPDxYCHxZoZGQCBw88KwANAgAUKwACDxYKHgtFZGl0SW5kZXhlcxYAHgtfIUl0ZW1Db3VudAIBHwJnHgtfIURhdGFCb3VuZGcfAWhkFwEFD1NlbGVjdGVkSW5kZXhlcxYAARYCFgoPAgcUKwAHFCsABRYCHgRvaW5kAgJkZGQFDkNvbmZlcmVuY2VOYW1lFCsABRYCHxoCA2RkZAULaW1wYWN0X2ZsYWcUKwAFFgQeCERhdGFUeXBlGSsCHxoCBGRkZAUIbG9jYXRpb24UKwAFFgQfGxkrAh8aAgVkZGQFBGRhdGUUKwAFFgQfGxkrAR8aAgZkZGQFBHllYXIUKwAFFgIfGgIHZGRkBQ5UZW1wbGF0ZUNvbHVtbhQrAAUWAh8aAghkZGQFD2Fic3RyYWN0T3B0aW9uc2RlFCsAAAspeVRlbGVyaWsuV2ViLlVJLkdyaWRDaGlsZExvYWRNb2RlLCBUZWxlcmlrLldlYi5VSSwgVmVyc2lvbj0yMDEwLjIuOTI5LjM1LCBDdWx0dXJlPW5ldXRyYWwsIFB1YmxpY0tleVRva2VuPTEyMWZhZTc4MTY1YmEzZDQBPCsABwALKXRUZWxlcmlrLldlYi5VSS5HcmlkRWRpdE1vZGUsIFRlbGVyaWsuV2ViLlVJLCBWZXJzaW9uPTIwMTAuMi45MjkuMzUsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MTIxZmFlNzgxNjViYTNkNAFkZBYOHxlnHhRJc0JvdW5kVG9Gb3J3YXJkT25seWgeBV9xZWx0GSlnU3lzdGVtLkRhdGEuRGF0YVJvd1ZpZXcsIFN5c3RlbS5EYXRhLCBWZXJzaW9uPTQuMC4wLjAsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49Yjc3YTVjNTYxOTM0ZTA4OR4IRGF0YUtleXMWAB4OQ3VzdG9tUGFnZVNpemUCZB4FXyFDSVMXAB8YAhJmFgRmDxQrAANkZGRkAgEPFgQUKwACDxYOHxlnHxxoHx0ZKwcfHhYAHx8CZB8gFwAfGAISZBcEBQZfIURTSUMCEgUIXyFQQ291bnQCAQULXyFJdGVtQ291bnQCEgUQQ3VycmVudFBhZ2VJbmRleGYWAh4DX3NlFgIeAl9jZmQWB2RkZGRkZGQWAmYPZBZMZg9kFgZmD2QWAmYPZBYCZg9kFgJmD2QWBGYPZBYEZg8PFgQfFmgfAmhkZAIBDw8WAh8CaGRkAgEPZBYEZg8PFgQfFmgfAmhkZAIBDw8WAh8CaGRkAgEPDxYCHwJoZBYCZg8PFgIeCkNvbHVtblNwYW4CB2QWAmYPZBYCZg9kFgICAQ9kFghmD2QWBGYPDxYCHxZoZGQCAg8PFgIfFmhkZAIBD2QWAmYPDxYEHw4FDXJnQ3VycmVudFBhZ2UfDwICZGQCAg9kFgRmDw8WAh8WaGRkAgMPDxYCHxZoZGQCAw8PFgQfDgUQcmdXcmFwIHJnQWR2UGFydB8PAgJkFgICAQ8UKwACDxYSHhVFbmFibGVFbWJlZGRlZFNjcmlwdHNnHw8CgAIeGVJlZ2lzdGVyV2l0aFNjcmlwdE1hbmFnZXJnHhxFbmFibGVFbWJlZGRlZEJhc2VTdHlsZXNoZWV0Zx8ZZx4TRW5hYmxlRW1iZWRkZWRTa2luc2geHE9uQ2xpZW50U2VsZWN0ZWRJbmRleENoYW5nZWQFLlRlbGVyaWsuV2ViLlVJLkdyaWQuQ2hhbmdlUGFnZVNpemVDb21ib0hhbmRsZXIeE2NhY2hlZFNlbGVjdGVkVmFsdWVkHw0bAAAAAAAASkABAAAAZA8UKwAEFCsAAg8WBh8ABQIxMB8GBQIxMB4IU2VsZWN0ZWRoFgIeEG93bmVyVGFibGVWaWV3SWQFP0NvbnRlbnRQbGFjZWhvbGRlck1haW5fdGxnQ29uZmVyZW5jZVRyYWNrZXJfcmdDb25mZXJlbmNlc19jdGwwMGQUKwACDxYGHwAFAjIwHwYFAjIwHypoFgIfKwU/Q29udGVudFBsYWNlaG9sZGVyTWFpbl90bGdDb25mZXJlbmNlVHJhY2tlcl9yZ0NvbmZlcmVuY2VzX2N0bDAwZBQrAAIPFgYfAAUCNTAfBgUCNTAfKmgWAh8rBT9Db250ZW50UGxhY2Vob2xkZXJNYWluX3RsZ0NvbmZlcmVuY2VUcmFja2VyX3JnQ29uZmVyZW5jZXNfY3RsMDBkFCsAAg8WBh8ABQMxMDAfBgUDMTAwHypnFgIfKwU/Q29udGVudFBsYWNlaG9sZGVyTWFpbl90bGdDb25mZXJlbmNlVHJhY2tlcl9yZ0NvbmZlcmVuY2VzX2N0bDAwZA8UKwEEZmZmZhYBBXdUZWxlcmlrLldlYi5VSS5SYWRDb21ib0JveEl0ZW0sIFRlbGVyaWsuV2ViLlVJLCBWZXJzaW9uPTIwMTAuMi45MjkuMzUsIEN1bHR1cmU9bmV1dHJhbCwgUHVibGljS2V5VG9rZW49MTIxZmFlNzgxNjViYTNkNBYMZg8PFgQfDgUJcmNiSGVhZGVyHw8CAmRkAgEPDxYEHw4FCXJjYkZvb3Rlch8PAgJkZAICDw8WBh8ABQIxMB8GBQIxMB8qaBYCHysFP0NvbnRlbnRQbGFjZWhvbGRlck1haW5fdGxnQ29uZmVyZW5jZVRyYWNrZXJfcmdDb25mZXJlbmNlc19jdGwwMGQCAw8PFgYfAAUCMjAfBgUCMjAfKmgWAh8rBT9Db250ZW50UGxhY2Vob2xkZXJNYWluX3RsZ0NvbmZlcmVuY2VUcmFja2VyX3JnQ29uZmVyZW5jZXNfY3RsMDBkAgQPDxYGHwAFAjUwHwYFAjUwHypoFgIfKwU/Q29udGVudFBsYWNlaG9sZGVyTWFpbl90bGdDb25mZXJlbmNlVHJhY2tlcl9yZ0NvbmZlcmVuY2VzX2N0bDAwZAIFDw8WBh8ABQMxMDAfBgUDMTAwHypnFgIfKwU/Q29udGVudFBsYWNlaG9sZGVyTWFpbl90bGdDb25mZXJlbmNlVHJhY2tlcl9yZ0NvbmZlcmVuY2VzX2N0bDAwZAICD2QWBmYPDxYEHwAFBiZuYnNwOx8CaGRkAgEPDxYEHwAFBiZuYnNwOx8CaGRkAgcPDxYCHwBlZGQCAQ9kFgRmD2QWEmYPDxYCHwAFBiZuYnNwO2RkAgEPDxYCHwAFBiZuYnNwO2RkAgIPDxYCHwAFBiZuYnNwO2RkAgMPDxYCHwAFBiZuYnNwO2RkAgQPDxYCHwAFBiZuYnNwO2RkAgUPDxYCHwAFBiZuYnNwO2RkAgYPDxYCHwAFBiZuYnNwO2RkAgcPDxYCHwAFBiZuYnNwO2RkAggPDxYCHwAFBiZuYnNwO2RkAgEPZBYCZg8PFgIfIwIHZBYCZg9kFgJmD2QWAgIBD2QWCGYPZBYEZg8PFgIfFmhkZAICDw8WAh8WaGRkAgEPZBYCZg8PFgQfDgUNcmdDdXJyZW50UGFnZR8PAgJkZAICD2QWBGYPDxYCHxZoZGQCAw8PFgIfFmhkZAIDDw8WBB8OBRByZ1dyYXAgcmdBZHZQYXJ0Hw8CAmQWAgIBDxQrAAIPFhgfJGcfDwKAAh8lZx8ABQMxMDAfJmcfCgUGTGFydm9sHxlnHydoHygFLlRlbGVyaWsuV2ViLlVJLkdyaWQuQ2hhbmdlUGFnZVNpemVDb21ib0hhbmRsZXIfAWgfKWQfDRsAAAAAAABKQAEAAABkDxQrAAQUKwACDxYGHwAFAjEwHwYFAjEwHypoFgIfKwU/Q29udGVudFBsYWNlaG9sZGVyTWFpbl90bGdDb25mZXJlbmNlVHJhY2tlcl9yZ0NvbmZlcmVuY2VzX2N0bDAwZBQrAAIPFgYfAAUCMjAfBgUCMjAfKmgWAh8rBT9Db250ZW50UGxhY2Vob2xkZXJNYWluX3RsZ0NvbmZlcmVuY2VUcmFja2VyX3JnQ29uZmVyZW5jZXNfY3RsMDBkFCsAAg8WBh8ABQI1MB8GBQI1MB8qaBYCHysFP0NvbnRlbnRQbGFjZWhvbGRlck1haW5fdGxnQ29uZmVyZW5jZVRyYWNrZXJfcmdDb25mZXJlbmNlc19jdGwwMGQUKwACDxYGHwAFAzEwMB8GBQMxMDAfKmcWAh8rBT9Db250ZW50UGxhY2Vob2xkZXJNYWluX3RsZ0NvbmZlcmVuY2VUcmFja2VyX3JnQ29uZmVyZW5jZXNfY3RsMDBkDxQrAQRmZmZmFgEFd1RlbGVyaWsuV2ViLlVJLlJhZENvbWJvQm94SXRlbSwgVGVsZXJpay5XZWIuVUksIFZlcnNpb249MjAxMC4yLjkyOS4zNSwgQ3VsdHVyZT1uZXV0cmFsLCBQdWJsaWNLZXlUb2tlbj0xMjFmYWU3ODE2NWJhM2Q0FgxmDw8WBB8OBQlyY2JIZWFkZXIfDwICZGQCAQ8PFgQfDgUJcmNiRm9vdGVyHw8CAmRkAgIPDxYGHwAFAjEwHwYFAjEwHypoFgIfKwU/Q29udGVudFBsYWNlaG9sZGVyTWFpbl90bGdDb25mZXJlbmNlVHJhY2tlcl9yZ0NvbmZlcmVuY2VzX2N0bDAwZAIDDw8WBh8ABQIyMB8GBQIyMB8qaBYCHysFP0NvbnRlbnRQbGFjZWhvbGRlck1haW5fdGxnQ29uZmVyZW5jZVRyYWNrZXJfcmdDb25mZXJlbmNlc19jdGwwMGQCBA8PFgYfAAUCNTAfBgUCNTAfKmgWAh8rBT9Db250ZW50UGxhY2Vob2xkZXJNYWluX3RsZ0NvbmZlcmVuY2VUcmFja2VyX3JnQ29uZmVyZW5jZXNfY3RsMDBkAgUPDxYGHwAFAzEwMB8GBQMxMDAfKmcWAh8rBT9Db250ZW50UGxhY2Vob2xkZXJNYWluX3RsZ0NvbmZlcmVuY2VUcmFja2VyX3JnQ29uZmVyZW5jZXNfY3RsMDBkAgIPDxYGHw4FGnJnUm93ICBwYXNzRGF0ZUNvbmZlcmVuY2UgHgRfaWloBQEwHw8CAmQWEmYPDxYCHwJoZBYCZg8PFgIfFmhkZAIBDw8WBB8ABQYmbmJzcDsfAmhkZAICDw8WAh8ABbABDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBzdHlsZT0iaGVpZ2h0OjE4cHg7IG92ZXJmbG93OmhpZGRlbjsiPg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+DQogICAgICAgICAgICAgICAgICAgICAgICBkZAIDDw8WAh8A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ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+DQogICAgICAgICAgICAgICAgICAgICAgICBkZAIDDw8WAh8AZWRkAgQPDxYCHwAFEUJhbmdrb2ssIFRoYWlsYW5kZGQCBQ8PFgIfAAUHRGVjIDUtOGRkAgYPDxYCHwAFBDIwMTJkZAIHDw8WAh8AZWQWAmYPFQIGQ2xvc2VkAS1kAggPDxYCHwBlZBYCAgEPFgIfLWVkAhMPZBYCZg8PFgIfAmhkZAIUDw8WBh8OBQlyZ0FsdFJvdyAfLAUBOR8PAgJkFhJmDw8WAh8CaGQWAmYPDxYCHxZoZGQCAQ8PFgQfAAUGJm5ic3A7HwJoZGQCAg8PFgIfAAWwAQ0KICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxkaXYgc3R5bGU9ImhlaWdodDoxOHB4OyBvdmVyZmxvdzpoaWRkZW47Ij4NCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIA0KICAgICAgICAgICAgICAgICAgICAgICAgICAgIDwvZGl2Pg0KICAgICAgICAgICAgICAgICAgICAgICAgZGQCAw8PFgIfAGVkZAIEDw8WAh8ABRJIb2xseXdvb2QsIEZMLCBVU0FkZAIFDw8WAh8ABQlEZWMgMTMtMTVkZAIGDw8WAh8ABQQyMDEyZGQCBw8PFgIfAGVkFgJmDxUCBkNsb3NlZAEtZAIIDw8WAh8AZWQWAgIBDxYCHy1lZAIVD2QWAmYPDxYCHwJoZGQCFg8PFgYfDgUGcmdSb3cgHywFAjEwHw8CAmQWEmYPDxYCHwJoZBYCZg8PFgIfFmhkZAIBDw8WBB8ABQYmbmJzcDsfAmhkZAICDw8WAh8ABbABDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgPGRpdiBzdHlsZT0iaGVpZ2h0OjE4cHg7IG92ZXJmbG93OmhpZGRlbjsiPg0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgDQogICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+DQogICAgICAgICAgICAgICAgICAgICAg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dGVudFBsYWNlaG9sZGVyTWFpbiR0aGVNYWluQ29udGVudCR0aGVTdGFydERhdGUkY2FsZW5kYXIFQWN0bDAwJENvbnRlbnRQbGFjZWhvbGRlck1haW4kdGhlTWFpbkNvbnRlbnQkdGhlU3RhcnREYXRlJGNhbGVuZGFyBTZjdGwwMCRDb250ZW50UGxhY2Vob2xkZXJNYWluJHRoZU1haW5Db250ZW50JHRoZUVuZERhdGUFP2N0bDAwJENvbnRlbnRQbGFjZWhvbGRlck1haW4kdGhlTWFpbkNvbnRlbnQkdGhlRW5kRGF0ZSRjYWxlbmRhcgU/Y3RsMDAkQ29udGVudFBsYWNlaG9sZGVyTWFpbiR0aGVNYWluQ29udGVudCR0aGVFbmREYXRlJGNhbGVuZGFyBUZjdGwwMCRDb250ZW50UGxhY2Vob2xkZXJNYWluJHRoZU1haW5Db250ZW50JGRkbEFkdmFuY2VkSGlnaGxpZ2h0U3RhdHVzBT9jdGwwMCRDb250ZW50UGxhY2Vob2xkZXJNYWluJHRsZ0NvbmZlcmVuY2VUcmFja2VyJHJnQ29uZmVyZW5jZXMFYmN0bDAwJENvbnRlbnRQbGFjZWhvbGRlck1haW4kdGxnQ29uZmVyZW5jZVRyYWNrZXIkcmdDb25mZXJlbmNlcyRjdGwwMCRjdGwwMyRjdGwwMSRQYWdlU2l6ZUNvbWJvQm94BWJjdGwwMCRDb250ZW50UGxhY2Vob2xkZXJNYWluJHRsZ0NvbmZlcmVuY2VUcmFja2VyJHJnQ29uZmVyZW5jZXMkY3RsMDAkY3RsMDMkY3RsMDEkUGFnZVNpemVDb21ib0JveA8UKwACBQMxMDAFAzEwMGQFYmN0bDAwJENvbnRlbnRQbGFjZWhvbGRlck1haW4kdGxnQ29uZmVyZW5jZVRyYWNrZXIkcmdDb25mZXJlbmNlcyRjdGwwMCRjdGwwMiRjdGwwMSRQYWdlU2l6ZUNvbWJvQm94DxQrAAJlBQMxMDBk4O5rhmcDSIpL7uD/ix2iLPVQxuIEd/vqmjuWstW65ZE=" type="hidden">
</div>

<script type="text/javascript">
//<![CDATA[
var theForm = document.forms['form1'];
if (!theForm) {
    theForm = document.form1;
}
function __doPostBack(eventTarget, eventArgument) {
    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
        theForm.__EVENTTARGET.value = eventTarget;
        theForm.__EVENTARGUMENT.value = eventArgument;
        theForm.submit();
    }
}
//]]>
</script>


<script src="webresource.axd" type="text/javascript"></script>


<script src="scriptresource.axd" type="text/javascript"></script>
<script src="scriptresource_001.axd" type="text/javascript"></script>
<script src="scriptresource_002.axd" type="text/javascript"></script>
<script src="scriptresource_003.axd" type="text/javascript"></script>
<script src="scriptresource_004.axd" type="text/javascript"></script>
<script src="scriptresource_005.axd" type="text/javascript"></script>
<script src="scriptresource_006.axd" type="text/javascript"></script>
<script src="scriptresource_007.axd" type="text/javascript"></script>
<script src="scriptresource_008.axd" type="text/javascript"></script>
<script src="scriptresource_009.axd" type="text/javascript"></script>
<script src="scriptresource_010.axd" type="text/javascript"></script>
<script src="scriptresource_011.axd" type="text/javascript"></script>
<script src="scriptresource_012.axd" type="text/javascript"></script>
<script src="scriptresource_013.axd" type="text/javascript"></script>
<script src="scriptresource_014.axd" type="text/javascript"></script>
<script src="scriptresource_015.axd" type="text/javascript"></script>
<script src="scriptresource_016.axd" type="text/javascript"></script>
<script src="scriptresource_017.axd" type="text/javascript"></script>
<script src="scriptresource_018.axd" type="text/javascript"></script>
<script src="scriptresource_019.axd" type="text/javascript"></script>
<div class="aspNetHidden">

	<input name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEWIQLo0ZLACgKY+KukCAK73dSuDQLH/of4BwKcs7bICAKZs8rLCAKbs/bLCAKBs/bLCAK/8rGcDwK44JaCCgLgqumnCAK2/aezDgLRuPOkBALSo9iKBAL+g+lZAprTsRUC0+yorQ4CzbOalQ4C7rHryA0Cqc2mtwICuczu0wMC1LWM6Q0C756q/gcCiojIkwICzaf3/goCmcr88A8Cz6zssAwCg/qyqQ8Ci7mNrQIC8M/vlwgCzti8mAsCrbDArA8CkseilwVccZziV1vog3sy3u2KcjcZZNDAuHMdN0rN8HzgdUduOg==" type="hidden">
</div>
        
        <script type="text/javascript">
//<![CDATA[
Sys.WebForms.PageRequestManager._initialize('ctl00$ScriptManager1', 'form1', ['tctl00$ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferencesPanel','ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferencesPanel','tctl00$ContentPlaceholderMain$ctl00$ContentPlaceholderMain$pnlLoginPanel','ContentPlaceholderMain_ctl00$ContentPlaceholderMain$pnlLoginPanel','tctl00$ContentPlaceholderMain$ctl00$ContentPlaceholderMain$RadAjaxPanel1Panel','ContentPlaceholderMain_ctl00$ContentPlaceholderMain$RadAjaxPanel1Panel','tctl00$RadAjaxManager1SU','RadAjaxManager1SU'], ['ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences','ContentPlaceholderMain_tlgConferenceTracker_rgConferences'], [], 500, 'ctl00');
//]]>
</script>

        
        <!-- 2010.2.929.35 --><div style="display: none;" id="RadAjaxManager1SU">
	<span id="RadAjaxManager1" style="display: none;"></span>
</div>
        
        




   
 	    
<div id="topBg" style="min-width: 830px;">
    <div id="topWrapper">

        
	    <div>
	    
            <div id="topLogo"><input name="ctl00$theHeader$ibLogo" id="theHeader_ibLogo" src="larvol_delta_logo_sep08.jpg" alt="Larvol Insight" type="image"></div><!-- // id="topLogo" -->
             
             
             <div id="topButtons">
                <span id="theHeader_lbUserLoggedText" style="position: relative; top: 32px; margin-right: 60px; vertical-align: top;">Logged in as vinod.tk@larvol.com</span>
                <br>
			    <a id="theHeader_lnkChagePassword" href="http://www.larvolinsight.com/AccountManager/ChangePassword.aspx" style="font-size: 9px; margin-right: 5px; position: relative; top: 5px;">Change Password</a>
    			
    			
			    <input name="ctl00$theHeader$TopButtons$imgButtonLogOut" id="theHeader_TopButtons_imgButtonLogOut" src="button_logout.gif" alt="Log Out" style="margin-top: 20px;" type="image">
<a href="http://www.larvolinsight.com/ContactUs/Default.aspx" id="theHeader_TopButtons_A1" style="display: none;"><img id="theHeader_TopButtons_imgButtonContactUs" src="button_contact_us.gif" alt="Contact Us"></a>
    		
            </div><!-- // id="topButtons" -->
        
        </div>
        <div class="clear"></div>
		
        <div id="topNav">
		
	        <div id="theHeader_TopNav_rmClientNav" class="RadMenu RadMenu_Larvol rmSized" style="width: 100%; margin-bottom: 15px; z-index: 850;">
	<ul class="rmRootGroup rmHorizontal">

	</ul><input autocomplete="off" id="theHeader_TopNav_rmClientNav_ClientState" name="theHeader_TopNav_rmClientNav_ClientState" type="hidden">
</div>


		
        </div>
        
       
	
    </div><!-- // id="topWrapper" -->
</div><!-- // id="topBg" -->


        
        <div id="wrapper">
	
            <div id="singleColumnMain" style="width: 97%;">
	            <div class="padMainContentBottomOnly">
        		    
        		    
    
    <div id="ContentPlaceholderMain_divDateRange" style="float: right; margin-top: 8px; font-size: 12px; color: Black; text-align: right;">
        
        <div>
           <b><div id="lblDateRange">Oct 09 - Oct 15</div></b>
           <b>Note: Based on public sources only</b>
        </div>
    
        <div style="margin-top: 6px;">
            For content clarification or elaboration: <a href="mailto:questions@larvol.com">questions@larvol.com</a>
        </div>    
    </div>
    

    <div>
    <span id="ContentPlaceholderMain_lblAreas" style="font-size: x-large; font-weight: bold; margin-left: 0px; color: rgb(83, 55, 130); height: 45px; text-align: center; display: block;">BI Inflammatory Bowel Disease</span>
    </div>
    <div id="ContentPlaceholderMain_divHeaderNote">
    <span id="ContentPlaceholderMain_lblHeaderNote" style="font-size: 13px; margin-left: 0px; color: rgb(104, 172, 181); font-weight: bold; height: 19px; margin-top: -12px; margin-bottom: 42px; text-align: center; display: block;">Pre-Conference Edition: American College of Gastroenterology 2012, Annual Meeting and Postgraduate Course (ACG 2012)</span>
    </div>
    
    <div id="ContentPlaceholderMain_rtsCRTabsTabs" class="RadTabStrip RadTabStrip_Default RadTabStripTop_Default" style="margin-top: -21px; border-bottom: 1px solid silver;">
	<div class="rtsLevel rtsLevel1">
		<ul class="rtsUL">
			<li class="rtsLI rtsFirst"><a class="rtsLink" href="#"><span class="rtsOut"><span class="rtsIn"><span class="rtsTxt">News Tracker</span></span></span></a></li>
			<li class="rtsLI"><a class="rtsLink rtsBefore" href="#"><span class="rtsOut"><span class="rtsIn"><span class="rtsTxt"><span style="color: Red;"></span> Conferences</span></span></span></a></li>
			<li class="rtsLI"><a class="rtsLink rtsSelected" href="#"><span class="rtsOut"><span class="rtsIn"><span class="rtsTxt"><span style="color: Red;"></span> LI View</span></span></span></a></li>
			<li class="rtsLI rtsLast"><a class="rtsLink rtsAfter" href="#"><span class="rtsOut"><span class="rtsIn"><span class="rtsTxt"><span style="color: Red;">(Beta)</span> Heatmap</span></span></span></a></li>
		</ul>
	</div>
	<input value="{&quot;selectedIndexes&quot;:[&quot;2&quot;],&quot;logEntries&quot;:[],&quot;scrollState&quot;:{}}" autocomplete="off" id="ContentPlaceholderMain_rtsCRTabsTabs_ClientState" name="ContentPlaceholderMain_rtsCRTabsTabs_ClientState" type="hidden">
</div>
    <div id="ContentPlaceholderMain_rtsCRTabsPages" style="height: 100%; width: 100%; margin-top: 20px; border-bottom: 1px solid rgb(192, 192, 192);">
	<div class="rmpHiddenView" id="ContentPlaceholderMain_rpvCR" style="height: 100%; margin: -30px auto auto; width: 90%; min-width: 800px; max-width: 1350px; display: none;">
		
            
            <div id="wordExportIconWithTooltip" style="width: 100px; height: 30px; font-size: 10px; position: relative; left: 1005px; top: 56px;">
                <div id="wordExportIcon" class="wordExport wordexporticon">
                    <input name="ctl00$ContentPlaceholderMain$btnWordExport" id="ContentPlaceholderMain_btnWordExport" src="worddocumentdownload.jpg" style="height: 25px; width: 25px; vertical-align: middle;" type="image">
                        <span>Export</span>
                </div>
                <div class="wordExportTooltip">
                    <h4 style="font-size: 12px; font-weight: normal;">Export to Microsoft Word</h4>
                </div>
            </div>
            
            &nbsp;
            
            <div style="display: block;" id="ContentPlaceholderMain_ctl00$ContentPlaceholderMain$pnlLoginPanel">
			<div id="ContentPlaceholderMain_pnlLogin">
				
                



<script type="text/javascript">

function boldProduct(){
 
    // Gets left column cells
    var productsNames = $(".ProductCell b");
    
    $.each(productsNames, function(index, product) {
    
        // Gets all product rows
        var idParent = $(product).parent().parent(".ProductRow").attr('id');
      
        // Gets the product name span from the news summary
        var productNews = $("#" + idParent + " .NewsItemCell .NewsItemSummaryProduct");
      
        $.each(productNews, function(i, val) {
        
            // Splits its main name from its generic name
            var productSummary = val.innerHTML;
            var productSummaryParts = productSummary.split(product.innerHTML);
        
            // Sets its main name to bold
            if (productSummaryParts.length > 1)
            {
                val.innerHTML = '';
                val.innerHTML = "<span>" + productSummaryParts[0] + "</span><b>" + product.innerHTML + "</b><span>" + productSummaryParts[1]+ "</span>";
            }
        });
    });
}
</script>

<table class="filterTable" style="max-width: 950px ! important;">
    <tbody><tr valign="top">
        <td>
            <table>
                <tbody><tr id="ContentPlaceholderMain_theMainContent_dateDropDownList" style="display: block; height: 35px;">
					<td style="padding-left: 5px;">
                        <div width="85" style="float: left; padding: 5px 3px 0px 0px;">
                            <span id="ContentPlaceholderMain_theMainContent_lbDateRange">Date Range:</span></div>
                        <div width="150" style="float: left;">
                            <select name="ctl00$ContentPlaceholderMain$theMainContent$ddlDateRange" id="ContentPlaceholderMain_theMainContent_ddlDateRange" style="width: 150px;">
						<option value="6">Last 7 Days</option>
						<option value="15">Last 15 Days</option>
						<option value="30">Last 30 Days</option>
						<option value="90">Last 90 Days</option>
						<option value="180">Last 6 Months</option>
						<option value="365">Last one year</option>

					</select>
                        </div>
                    </td>
				</tr>
				
 
                <tr id="ContentPlaceholderMain_theMainContent_datePickers" style="display: block; height: 35px;">
					<td style="display: block; height: 32px; padding: 0px; margin: 0px;">
                        <table>
                            <tbody><tr>
                                <td>
                                    <span id="ContentPlaceholderMain_theMainContent_Label01"></span>
                                    <table id="ContentPlaceholderMain_theMainContent_tbStartDate">
						<tbody><tr>
							<td style="font-size: 11px; text-align: right; padding: 4px 2px 0px 3px; white-space: nowrap;">
                                                Start Date:
                                            </td>
							<td style="padding-left: 8px;">
                                                <div id="ContentPlaceholderMain_theMainContent_theStartDate_wrapper" class="RadPicker RadPicker_Default" style="display: -moz-inline-stack; height: 20px; width: 176px;">
								<input style="visibility: hidden; display: block; float: right; margin: 0px 0px -1px -1px; width: 1px; height: 1px; overflow: hidden; border: 0px none; padding: 0px;" id="ContentPlaceholderMain_theMainContent_theStartDate" name="ctl00$ContentPlaceholderMain$theMainContent$theStartDate" class="rdfd_" value="" type="text"><table class="rcTable" style="width: 176px;" cellspacing="0">
									<tbody><tr>
										<td class="rcInputCell" style="width: 100%;"><span id="ContentPlaceholderMain_theMainContent_theStartDate_dateInput_wrapper" class="RadInput RadInput_Default" style="display: block;"><input value="" id="ContentPlaceholderMain_theMainContent_theStartDate_dateInput_text" name="ContentPlaceholderMain_theMainContent_theStartDate_dateInput_text" class="riTextBox riEnabled" style="width: 100%;" type="text"><input style="visibility: hidden; float: right; margin: -18px 0px 0px -1px; width: 1px; height: 1px; overflow: hidden; border: 0px none; padding: 0px;" id="ContentPlaceholderMain_theMainContent_theStartDate_dateInput" name="ctl00$ContentPlaceholderMain$theMainContent$theStartDate$dateInput" class="rdfd_" value="" type="text"><input autocomplete="off" id="ContentPlaceholderMain_theMainContent_theStartDate_dateInput_ClientState" name="ContentPlaceholderMain_theMainContent_theStartDate_dateInput_ClientState" type="hidden"></span></td><td><a title="Open the calendar popup." href="#" id="ContentPlaceholderMain_theMainContent_theStartDate_popupButton" class="rcCalPopup">Open the calendar popup.</a><div id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_wrapper" style="display: none;"><table id="ContentPlaceholderMain_theMainContent_theStartDate_calendar" summary="Calendar" class="RadCalendar RadCalendar_Default" cellspacing="0">
											<thead>
												<tr>
													<td class="rcTitlebar"><table summary="title and navigation" cellspacing="0">
														<tbody><tr>
															<td><a id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_FNP" class="rcFastPrev" title="<<" href="http://www.larvolinsight.com/CR/#">&lt;&lt;</a></td><td><a id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_NP" class="rcPrev" title="<" href="http://www.larvolinsight.com/CR/#">&lt;</a></td><td id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Title" class="rcTitle">October 2012</td><td><a id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_NN" class="rcNext" title=">" href="http://www.larvolinsight.com/CR/#">&gt;</a></td><td><a id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_FNN" class="rcFastNext" title=">>" href="http://www.larvolinsight.com/CR/#">&gt;&gt;</a></td>
														</tr>
													</tbody></table></td>
												</tr>
											</thead><tbody>
	<tr>
		<td class="rcMain"><table id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top" class="rcMainTable" summary="October 2012" cellspacing="0">
	<thead>
		<tr class="rcWeek">
			<th class="rcViewSel">&nbsp;</th><th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_cs_1" title="Sunday" abbr="Sun" scope="col">S</th><th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_cs_2" title="Monday" abbr="Mon" scope="col">M</th><th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_cs_3" title="Tuesday" abbr="Tue" scope="col">T</th><th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_cs_4" title="Wednesday" abbr="Wed" scope="col">W</th><th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_cs_5" title="Thursday" abbr="Thu" scope="col">T</th><th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_cs_6" title="Friday" abbr="Fri" scope="col">F</th><th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_cs_7" title="Saturday" abbr="Sat" scope="col">S</th>
		</tr>
	</thead><tbody>
		<tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_rs_1" scope="row">40</th><td class="rcOtherMonth" title="Sunday, September 30, 2012"><a href="#">30</a></td><td title="Monday, October 01, 2012"><a href="#">1</a></td><td title="Tuesday, October 02, 2012"><a href="#">2</a></td><td title="Wednesday, October 03, 2012"><a href="#">3</a></td><td title="Thursday, October 04, 2012"><a href="#">4</a></td><td title="Friday, October 05, 2012"><a href="#">5</a></td><td class="rcWeekend" title="Saturday, October 06, 2012"><a href="#">6</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_rs_2" scope="row">41</th><td class="rcWeekend" title="Sunday, October 07, 2012"><a href="#">7</a></td><td title="Monday, October 08, 2012"><a href="#">8</a></td><td title="Tuesday, October 09, 2012"><a href="#">9</a></td><td title="Wednesday, October 10, 2012"><a href="#">10</a></td><td title="Thursday, October 11, 2012"><a href="#">11</a></td><td title="Friday, October 12, 2012"><a href="#">12</a></td><td class="rcWeekend" title="Saturday, October 13, 2012"><a href="#">13</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_rs_3" scope="row">42</th><td class="rcWeekend" title="Sunday, October 14, 2012"><a href="#">14</a></td><td title="Monday, October 15, 2012"><a href="#">15</a></td><td title="Tuesday, October 16, 2012"><a href="#">16</a></td><td title="Wednesday, October 17, 2012"><a href="#">17</a></td><td title="Thursday, October 18, 2012"><a href="#">18</a></td><td title="Friday, October 19, 2012"><a href="#">19</a></td><td class="rcWeekend" title="Saturday, October 20, 2012"><a href="#">20</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_rs_4" scope="row">43</th><td class="rcWeekend" title="Sunday, October 21, 2012"><a href="#">21</a></td><td title="Monday, October 22, 2012"><a href="#">22</a></td><td title="Tuesday, October 23, 2012"><a href="#">23</a></td><td title="Wednesday, October 24, 2012"><a href="#">24</a></td><td title="Thursday, October 25, 2012"><a href="#">25</a></td><td title="Friday, October 26, 2012"><a href="#">26</a></td><td class="rcWeekend" title="Saturday, October 27, 2012"><a href="#">27</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_rs_5" scope="row">44</th><td class="rcWeekend" title="Sunday, October 28, 2012"><a href="#">28</a></td><td title="Monday, October 29, 2012"><a href="#">29</a></td><td title="Tuesday, October 30, 2012"><a href="#">30</a></td><td title="Wednesday, October 31, 2012"><a href="#">31</a></td><td class="rcOtherMonth" title="Thursday, November 01, 2012"><a href="#">1</a></td><td class="rcOtherMonth" title="Friday, November 02, 2012"><a href="#">2</a></td><td class="rcOtherMonth" title="Saturday, November 03, 2012"><a href="#">3</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top_rs_6" scope="row">45</th><td class="rcOtherMonth" title="Sunday, November 04, 2012"><a href="#">4</a></td><td class="rcOtherMonth" title="Monday, November 05, 2012"><a href="#">5</a></td><td class="rcOtherMonth" title="Tuesday, November 06, 2012"><a href="#">6</a></td><td class="rcOtherMonth" title="Wednesday, November 07, 2012"><a href="#">7</a></td><td class="rcOtherMonth" title="Thursday, November 08, 2012"><a href="#">8</a></td><td class="rcOtherMonth" title="Friday, November 09, 2012"><a href="#">9</a></td><td class="rcOtherMonth" title="Saturday, November 10, 2012"><a href="#">10</a></td>
		</tr>
	</tbody>
</table></td>
	</tr>
</tbody>
										</table><input name="ContentPlaceholderMain_theMainContent_theStartDate_calendar_SD" id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_SD" value="[]" type="hidden"><input name="ContentPlaceholderMain_theMainContent_theStartDate_calendar_AD" id="ContentPlaceholderMain_theMainContent_theStartDate_calendar_AD" value="[[1980,1,1],[2099,12,30],[2012,10,15]]" type="hidden"></div></td>
									</tr>
								</tbody></table><input autocomplete="off" id="ContentPlaceholderMain_theMainContent_theStartDate_ClientState" name="ContentPlaceholderMain_theMainContent_theStartDate_ClientState" type="hidden">
							</div>
                                            </td>
						</tr>
					</tbody></table>
					
                                </td>
                                <td colspan="2">
                                    <table id="ContentPlaceholderMain_theMainContent_tbEndDate">
						<tbody><tr>
							<td style="font-size: 11px; text-align: right; padding: 4px 2px 0px 0px; white-space: nowrap;">
                                                End Date:
                                            </td>
							<td>
                                                <div id="ContentPlaceholderMain_theMainContent_theEndDate_wrapper" class="RadPicker RadPicker_Default" style="display: -moz-inline-stack; height: 20px; width: 176px;">
								<input style="visibility: hidden; display: block; float: right; margin: 0px 0px -1px -1px; width: 1px; height: 1px; overflow: hidden; border: 0px none; padding: 0px;" id="ContentPlaceholderMain_theMainContent_theEndDate" name="ctl00$ContentPlaceholderMain$theMainContent$theEndDate" class="rdfd_" value="" type="text"><table class="rcTable" style="width: 176px;" cellspacing="0">
									<tbody><tr>
										<td class="rcInputCell" style="width: 100%;"><span id="ContentPlaceholderMain_theMainContent_theEndDate_dateInput_wrapper" class="RadInput RadInput_Default" style="display: block;"><input value="" id="ContentPlaceholderMain_theMainContent_theEndDate_dateInput_text" name="ContentPlaceholderMain_theMainContent_theEndDate_dateInput_text" class="riTextBox riEnabled" style="width: 100%;" type="text"><input style="visibility: hidden; float: right; margin: -18px 0px 0px -1px; width: 1px; height: 1px; overflow: hidden; border: 0px none; padding: 0px;" id="ContentPlaceholderMain_theMainContent_theEndDate_dateInput" name="ctl00$ContentPlaceholderMain$theMainContent$theEndDate$dateInput" class="rdfd_" value="" type="text"><input autocomplete="off" id="ContentPlaceholderMain_theMainContent_theEndDate_dateInput_ClientState" name="ContentPlaceholderMain_theMainContent_theEndDate_dateInput_ClientState" type="hidden"></span></td><td><a title="Open the calendar popup." href="#" id="ContentPlaceholderMain_theMainContent_theEndDate_popupButton" class="rcCalPopup">Open the calendar popup.</a><div id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_wrapper" style="display: none;"><table id="ContentPlaceholderMain_theMainContent_theEndDate_calendar" summary="Calendar" class="RadCalendar RadCalendar_Default" cellspacing="0">
											<thead>
												<tr>
													<td class="rcTitlebar"><table summary="title and navigation" cellspacing="0">
														<tbody><tr>
															<td><a id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_FNP" class="rcFastPrev" title="<<" href="http://www.larvolinsight.com/CR/#">&lt;&lt;</a></td><td><a id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_NP" class="rcPrev" title="<" href="http://www.larvolinsight.com/CR/#">&lt;</a></td><td id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Title" class="rcTitle">October 2012</td><td><a id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_NN" class="rcNext" title=">" href="http://www.larvolinsight.com/CR/#">&gt;</a></td><td><a id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_FNN" class="rcFastNext" title=">>" href="http://www.larvolinsight.com/CR/#">&gt;&gt;</a></td>
														</tr>
													</tbody></table></td>
												</tr>
											</thead><tbody>
	<tr>
		<td class="rcMain"><table id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top" class="rcMainTable" summary="October 2012" cellspacing="0">
	<thead>
		<tr class="rcWeek">
			<th class="rcViewSel">&nbsp;</th><th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_cs_1" title="Sunday" abbr="Sun" scope="col">S</th><th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_cs_2" title="Monday" abbr="Mon" scope="col">M</th><th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_cs_3" title="Tuesday" abbr="Tue" scope="col">T</th><th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_cs_4" title="Wednesday" abbr="Wed" scope="col">W</th><th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_cs_5" title="Thursday" abbr="Thu" scope="col">T</th><th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_cs_6" title="Friday" abbr="Fri" scope="col">F</th><th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_cs_7" title="Saturday" abbr="Sat" scope="col">S</th>
		</tr>
	</thead><tbody>
		<tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_rs_1" scope="row">40</th><td class="rcOtherMonth" title="Sunday, September 30, 2012"><a href="#">30</a></td><td title="Monday, October 01, 2012"><a href="#">1</a></td><td title="Tuesday, October 02, 2012"><a href="#">2</a></td><td title="Wednesday, October 03, 2012"><a href="#">3</a></td><td title="Thursday, October 04, 2012"><a href="#">4</a></td><td title="Friday, October 05, 2012"><a href="#">5</a></td><td class="rcWeekend" title="Saturday, October 06, 2012"><a href="#">6</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_rs_2" scope="row">41</th><td class="rcWeekend" title="Sunday, October 07, 2012"><a href="#">7</a></td><td title="Monday, October 08, 2012"><a href="#">8</a></td><td title="Tuesday, October 09, 2012"><a href="#">9</a></td><td title="Wednesday, October 10, 2012"><a href="#">10</a></td><td title="Thursday, October 11, 2012"><a href="#">11</a></td><td title="Friday, October 12, 2012"><a href="#">12</a></td><td class="rcWeekend" title="Saturday, October 13, 2012"><a href="#">13</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_rs_3" scope="row">42</th><td class="rcWeekend" title="Sunday, October 14, 2012"><a href="#">14</a></td><td title="Monday, October 15, 2012"><a href="#">15</a></td><td title="Tuesday, October 16, 2012"><a href="#">16</a></td><td title="Wednesday, October 17, 2012"><a href="#">17</a></td><td title="Thursday, October 18, 2012"><a href="#">18</a></td><td title="Friday, October 19, 2012"><a href="#">19</a></td><td class="rcWeekend" title="Saturday, October 20, 2012"><a href="#">20</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_rs_4" scope="row">43</th><td class="rcWeekend" title="Sunday, October 21, 2012"><a href="#">21</a></td><td title="Monday, October 22, 2012"><a href="#">22</a></td><td title="Tuesday, October 23, 2012"><a href="#">23</a></td><td title="Wednesday, October 24, 2012"><a href="#">24</a></td><td title="Thursday, October 25, 2012"><a href="#">25</a></td><td title="Friday, October 26, 2012"><a href="#">26</a></td><td class="rcWeekend" title="Saturday, October 27, 2012"><a href="#">27</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_rs_5" scope="row">44</th><td class="rcWeekend" title="Sunday, October 28, 2012"><a href="#">28</a></td><td title="Monday, October 29, 2012"><a href="#">29</a></td><td title="Tuesday, October 30, 2012"><a href="#">30</a></td><td title="Wednesday, October 31, 2012"><a href="#">31</a></td><td class="rcOtherMonth" title="Thursday, November 01, 2012"><a href="#">1</a></td><td class="rcOtherMonth" title="Friday, November 02, 2012"><a href="#">2</a></td><td class="rcOtherMonth" title="Saturday, November 03, 2012"><a href="#">3</a></td>
		</tr><tr class="rcRow">
			<th id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top_rs_6" scope="row">45</th><td class="rcOtherMonth" title="Sunday, November 04, 2012"><a href="#">4</a></td><td class="rcOtherMonth" title="Monday, November 05, 2012"><a href="#">5</a></td><td class="rcOtherMonth" title="Tuesday, November 06, 2012"><a href="#">6</a></td><td class="rcOtherMonth" title="Wednesday, November 07, 2012"><a href="#">7</a></td><td class="rcOtherMonth" title="Thursday, November 08, 2012"><a href="#">8</a></td><td class="rcOtherMonth" title="Friday, November 09, 2012"><a href="#">9</a></td><td class="rcOtherMonth" title="Saturday, November 10, 2012"><a href="#">10</a></td>
		</tr>
	</tbody>
</table></td>
	</tr>
</tbody>
										</table><input name="ContentPlaceholderMain_theMainContent_theEndDate_calendar_SD" id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_SD" value="[]" type="hidden"><input name="ContentPlaceholderMain_theMainContent_theEndDate_calendar_AD" id="ContentPlaceholderMain_theMainContent_theEndDate_calendar_AD" value="[[1980,1,1],[2099,12,30],[2012,10,15]]" type="hidden"></div></td>
									</tr>
								</tbody></table><input autocomplete="off" id="ContentPlaceholderMain_theMainContent_theEndDate_ClientState" name="ContentPlaceholderMain_theMainContent_theEndDate_ClientState" type="hidden">
							</div>
                                                
                                            </td>
						</tr>
					</tbody></table>
					
                                </td>
                            </tr>
                        </tbody></table>
                        
                    </td>
				</tr>
				
                
                <tr style="display: block; height: 35px;">
                    <td colspan="3">
                        <table>
                            <tbody><tr>
                                <td style="width: 60px; text-align: left; padding: 5px 3px 0px 5px;" width="85">
                                    <span id="ContentPlaceholderMain_theMainContent_lbHighlightStatus">Importance:</span>
                                </td>
                                <td>
                                        <div id="ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus" class="RadSlider RadSlider_Default rsImportanceClass" style="height: 35px; float: left; width: 300px;">
					<input autocomplete="off" value="{&quot;value&quot;:0,&quot;selectionStart&quot;:0,&quot;selectionEnd&quot;:0,&quot;isSelectionRangeEnabled&quot;:false,&quot;orientation&quot;:0,&quot;smallChange&quot;:1,&quot;largeChange&quot;:0,&quot;trackMouseWheel&quot;:true,&quot;showDragHandle&quot;:true,&quot;showDecreaseHandle&quot;:true,&quot;showIncreaseHandle&quot;:true,&quot;width&quot;:&quot;300px&quot;,&quot;height&quot;:&quot;35px&quot;,&quot;animationDuration&quot;:100,&quot;minimumValue&quot;:0,&quot;maximumValue&quot;:20,&quot;trackPosition&quot;:2,&quot;liveDrag&quot;:true,&quot;dragText&quot;:&quot;Drag&quot;,&quot;thumbsInteractionMode&quot;:1}" id="ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus_ClientState" name="ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus_ClientState" type="hidden">
				<div class="rslHorizontal rslTop" style="width: 300px; height: 35px;" unselectable="on" id="RadSliderWrapper_ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus"><a title="Decrease" class="rslHandle rslDecrease" href="#" id="RadSliderDecrease_ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus"><span>Decrease</span></a><ul class="rslItemsWrapper"><li style="width: 24px; height: 21px;" unselectable="on" class="rslItem rslItemFirst rslItemSelected"><span>1</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem"><span>2</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem"><span>3</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem"><span>4</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem"><span>5</span></li><li style="width: 24px; height: 21px;" unselectable="on" class="rslItem"><span>6</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem"><span>7</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem"><span>8</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem"><span>9</span></li><li style="width: 25px; height: 21px;" unselectable="on" class="rslItem rslItemLast"><span>10</span></li></ul><div style="width: 248px; height: 6px;" class="rslTrack" id="RadSliderTrack_ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus" unselectable="on"><div style="width: 12px;" class="rslSelectedregion" id="RadSliderSelected_ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus" unselectable="on"><!-- --></div><a style="cursor: pointer; left: 8px;" title="Drag" class="rslDraghandle" href="#" id="RadSliderDrag_ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus"><span>Drag</span></a></div><a title="Increase" class="rslHandle rslIncrease" href="#" id="RadSliderIncrease_ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus"><span>Increase</span></a></div></div>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
 
            </tbody></table>
        </td>
        <td>
            <table style="">
                <tbody><tr>
                    <td style="font-size: 11px; text-align: right; padding: 5px 0px 0px; white-space: nowrap;"></td>
                    <td style="width: 100%;">
                        <span id="ContentPlaceholderMain_theMainContent_rcbTextSearch_wrapper" class="RadInput RadInput_Default" style="white-space: nowrap;"><input value="Search by keyword or phrase, e.g., Avastin" size="20" id="ContentPlaceholderMain_theMainContent_rcbTextSearch_text" name="ContentPlaceholderMain_theMainContent_rcbTextSearch_text" class="riTextBox riEmpty" style="width: 270px; margin-top: 0px;" type="text"><input id="ContentPlaceholderMain_theMainContent_rcbTextSearch" name="ctl00$ContentPlaceholderMain$theMainContent$rcbTextSearch" class="rdfd_" style="visibility: hidden; margin: -18px 0px 0px -1px; width: 1px; height: 1px; overflow: hidden; border: 0px none; padding: 0px;" value="" type="text"><input autocomplete="off" value="{&quot;enabled&quot;:true,&quot;emptyMessage&quot;:&quot;Search by keyword or phrase, e.g., Avastin&quot;}" id="ContentPlaceholderMain_theMainContent_rcbTextSearch_ClientState" name="ContentPlaceholderMain_theMainContent_rcbTextSearch_ClientState" type="hidden"></span>&nbsp;
                       
                    </td>
                    
                    <td id="infoStop">
                     <img id="ContentPlaceholderMain_theMainContent_Image1" class="imgKeywordSearchInfo" src="info.png" style="height: 25px; width: 25px; vertical-align: middle;">
                        <div class="keywordTooltip">
                            <h5>
                                Keyword Search Instructions</h5>
                            <p>
                                Enter your search term or phrase, and click "Search." The search results will contain
                                items where the term of interest was identified in a news summary, excerpt, news
                                source or red tag.</p>
                        </div>
                    </td>
                    <td>
                         <input name="ctl00$ContentPlaceholderMain$theMainContent$btnSubmit" value="Search" onclick="javascript:__doPostBack('ctl00$ContentPlaceholderMain$theMainContent$btnSubmit','')" id="ContentPlaceholderMain_theMainContent_btnSubmit" class="btnSubmitNewsTracker" style="height: 25px; font-weight: bold; color: rgb(255, 255, 255); background-color: rgb(82, 55, 129); border-style: none;" type="button">
                    
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 11px; padding: 8px 0px 0px; font-weight: bold;">
                        <span id="ContentPlaceholderMain_theMainContent_lblNewsItemCount">61 News Items returned in this search.</span>
                    </td>
                </tr>
                               
                <tr>
                    <td colspan="3" style="padding: 20px 0px 0px; white-space: nowrap; font-size: 13px;">
                        <span style="float: left;">Show products with no news items?: </span>
                        <table id="ContentPlaceholderMain_theMainContent_rblEmptyProducts" style="float: left; margin-top: -5px;">
					<tbody><tr>
						<td><input id="ContentPlaceholderMain_theMainContent_rblEmptyProducts_0" name="ctl00$ContentPlaceholderMain$theMainContent$rblEmptyProducts" value="true" type="radio"><label for="ContentPlaceholderMain_theMainContent_rblEmptyProducts_0">Yes</label></td><td><input id="ContentPlaceholderMain_theMainContent_rblEmptyProducts_1" name="ctl00$ContentPlaceholderMain$theMainContent$rblEmptyProducts" value="false" checked="checked" type="radio"><label for="ContentPlaceholderMain_theMainContent_rblEmptyProducts_1">No</label></td>
					</tr>
				</tbody></table>
                       
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
<table id="ContentPlaceholderMain_theMainContent_tblOnlineProductTable" class="optTable">
					<tbody><tr id="ContentPlaceholderMain_theMainContent_a78c6aaf76e646e4b144b1abb84031f3">
						<td colspan="4" class="Section">Marketed</td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_fccaea26-31e7-4e0a-bf76-1cb6f90ed9fa_a78c6aaf-76e6-46e4-b144-b1abb84031f3" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Cimzia </b> (certolizumab pegol)<br><i>UCB</i><br><br>TNF? inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Subcutaneous</td>
						<td class="CommentCell" valign="top">Marketed: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="2379318c-2787-4bd7-a63a-c0edc8fd2a15"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('2379318c-2787-4bd7-a63a-c0edc8fd2a15')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=2379318c-2787-4bd7-a63a-c0edc8fd2a15&amp;ts=634858687123941250" target="_top">Certolizumab pegol plasma concentrations and endoscopic and clinical outcomes in Crohn's Disease: A post hoc analysis of the MUSIC Trial</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Cimzia </b><span>(certolizumab pegol) - UCB)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P3b, N=89; NCT00297648; �Study identifies an association between endoscopic response and remission and clinical remission and higher plasma concentrations of CZP following standard induction therapy�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="cfcfe1e5-1553-428f-b142-e15cf5295bba"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('cfcfe1e5-1553-428f-b142-e15cf5295bba')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=cfcfe1e5-1553-428f-b142-e15cf5295bba&amp;ts=634858687123941250" target="_top">Corticosteroid avoidance in patients with Crohn's disease who are newly initiated to therapy with an anti-TNF versus azathioprine</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(Remicade (infliximab) - J&amp;J/Janssen Biotech, Merck; </span><b>Cimzia </b><span>(certolizumab pegol) - UCB; Humira (adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=2,241; "All anti-TNF agents showed statistically higher rates of CS avoidance compared with AZA (range, p&lt;0.0001-0.0260) (Table). There were no statistical differences in CS avoidance at 6 and 12 months for pts initiated on CZP compared with IFX (p=0.5600 and p=0.7500) or ADA (p=0.6900 and p=0.9000), respectively."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="46a2b3f6-d154-4ca3-8656-a8c1b9e0d73c"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lll<font class="greyColor">lllllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('46a2b3f6-d154-4ca3-8656-a8c1b9e0d73c')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=46a2b3f6-d154-4ca3-8656-a8c1b9e0d73c&amp;ts=634858687123941250" target="_top">Efficacy of and factors contributing to dose adjustment in treatment with certolizumab for Crohn's disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Cimzia </b><span>(certolizumab pegol) - UCB)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM - 7:00 PM; P=NA, N=107; CZP dose change, specifically split dosing, provides a tool to improve response &amp; drug persistence; Certain pt characteristics may signal who is more likely to require a dose change or stop therapy if this dose change occurs, &amp; further study is warranted</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="12c7f16e-a386-449a-8fa5-c88d6876b60e"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lll<font class="greyColor">lllllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('12c7f16e-a386-449a-8fa5-c88d6876b60e')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=12c7f16e-a386-449a-8fa5-c88d6876b60e&amp;ts=634858687123941250" target="_top">Outcomes of pregnancy in subjects exposed to certolizumab pegol</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Cimzia </b><span>(certolizumab pegol) - UCB)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM ; N=294; �103 of 139 pregnancies resulted in live births and the median gestational age was 38.3 weeks (data available for 40 births). 21 pregnancies ended in spontaneous miscarriage. 15 pregnancies resulted in elective termination. These results are similar to those reported in the general population in the U.S.�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_b9512304-70a7-42bf-9913-379abee204fe_a78c6aaf-76e6-46e4-b144-b1abb84031f3" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Humira </b> (adalimumab)<br><i>Abbott</i><br><br>TNF? inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Subcutaneous</td>
						<td class="CommentCell" valign="top">Marketed: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="80845ff1-d61d-4206-87a8-44bb65fb2c0c"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('80845ff1-d61d-4206-87a8-44bb65fb2c0c')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=80845ff1-d61d-4206-87a8-44bb65fb2c0c&amp;ts=634858687123941250" target="_top">Adalimumab induction dose reduces the risk of hospitalizations and colectomies in patients with ulcerative colitis during the first 8 weeks of therapy</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P3, N=939; ULTRA 1, ULTRA 2; "Significant reductions in the risk of all-cause (44%), UC-related (53%), and UC- or drug-related (50%) hospitalizations were observed in the ADA group compared with PBO (table, P&lt;.05 for all). Although not statistically significant, the relative risk for colectomy was lower (34%) in the ADA group compared with PBO."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="ebda02d3-0cc7-4ce2-b59f-51d5f4bf0c0f"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('ebda02d3-0cc7-4ce2-b59f-51d5f4bf0c0f')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('ebda02d3-0cc7-4ce2-b59f-51d5f4bf0c0f')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=ebda02d3-0cc7-4ce2-b59f-51d5f4bf0c0f&amp;ts=634858687123941250" target="_top">Reduced steroid usage in ulcerative colitis patients with week 8 response to adalimumab: Subanalysis of ULTRA 2</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P3, N=290; ULTRA 2; "In pts with moderately to severely active UC who used CS at BL in ULTRA 2, clinically meaningful long-term CS-free remission and CS-sparing efficacy with ADA was seen at wk52 in pts with wk8 response by full or partial Mayo score. ADA treatment resulted in clinically meaningful reductions in CS doses."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="83b01455-259e-403b-97eb-5beab21c9d07"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('83b01455-259e-403b-97eb-5beab21c9d07')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('83b01455-259e-403b-97eb-5beab21c9d07')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=83b01455-259e-403b-97eb-5beab21c9d07&amp;ts=634858687123941250" target="_top">Mucosal healing in ulcerative colitis patients with week 8 response to adalimumab: Subanalysis of ULTRA 2</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P3, N=248; ULTRA 2; After 8 weeks, 50.4% (125/248) of ADA-treated pts responded per FMS, and 49.6% (123/248) responded per PMS; Significantly more patients treated with ADA vs. PBO achieved mucosal healing at wk 52, for both FMS and PMS responders.</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="c4ea41a5-8161-4780-b9f3-8a2d8154973a"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('c4ea41a5-8161-4780-b9f3-8a2d8154973a')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=c4ea41a5-8161-4780-b9f3-8a2d8154973a&amp;ts=634858687123941250" target="_top">Rate of and response to dose escalation in patients treated with adalimumab for moderately to severely active ulcerative colitis: Subanalysis of ULTRA 2</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 10:30 AM � 4:00 PM; P3, N=248; ULTRA 2; "123 of 248 ADA-treated patients (49.6%) responded to ADA at wk8 per PMS. Of the wk8 responders, 20 (16.3%) moved to weekly dosing during the study; 6/20 (30.0%) had previous anti-TNF exposure. Of the 125 wk8 non-responders, 48 (38.4%) moved to weekly dosing; 26/48 (54.2%) had previous anti-TNF exposure."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">1</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="038cbb0c-703d-4cec-a29d-9fd1e5035bfe"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('038cbb0c-703d-4cec-a29d-9fd1e5035bfe')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('038cbb0c-703d-4cec-a29d-9fd1e5035bfe')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=038cbb0c-703d-4cec-a29d-9fd1e5035bfe&amp;ts=634858687123941250" target="_top">Time-in-remission analysis of adalimumab vs. placebo for the treatment of ulcerative colitis</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P3, N=494; ULTRA 2; "During the double-blind period, ADA-treated patients spent significantly more days in clinical remission (61% more days), clinical response (42% more days), and IBDQ remission (32% more days) as well as significantly more SAE-adjusted days in clinical remission (68% more days) than did PBO-treated patients."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="a7f92038-814e-4a61-a256-bf11c7d9ac9a"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('a7f92038-814e-4a61-a256-bf11c7d9ac9a')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=a7f92038-814e-4a61-a256-bf11c7d9ac9a&amp;ts=634858687123941250" target="_top">Adalimumab therapy reduces hospitalization and colectomy rates in patients with ulcerative colitis among initial responders</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P3, N=939; ULTRA 1, ULTRA 2; "35% and 36% reductions in the number of patients hospitalized and number of hospitalizations...respectively, were observed with ADA therapy vs. PBO (Table, P&lt;.05 for both comparisons). When UC-related hospitalizations were compared, reductions for rate (55%) and number (56%) of hospitalizations were both statistically significant, too."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">1</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="41c95852-ccfa-4969-bc25-33d4e54cdb1a"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllll<font class="greyColor">llll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('41c95852-ccfa-4969-bc25-33d4e54cdb1a')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">Pricing;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('41c95852-ccfa-4969-bc25-33d4e54cdb1a')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=41c95852-ccfa-4969-bc25-33d4e54cdb1a&amp;ts=634858687123941250" target="_top">Cost-effectiveness of adalimumab in moderately to severely active ulcerative colitis</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; "ADA is cost-effective with a 5-year time frame for the treatment of patients with moderately to severely active UC compared with standard care, given a threshold value of �30,000/QALY"</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="1d059a9d-af73-487c-8931-8ffd6baca9cd"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllll<font class="greyColor">llll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('1d059a9d-af73-487c-8931-8ffd6baca9cd')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('1d059a9d-af73-487c-8931-8ffd6baca9cd')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=1d059a9d-af73-487c-8931-8ffd6baca9cd&amp;ts=634858687123941250" target="_top">Benefit-risk assessment of adalimumab as maintenance treatment for ulcerative colitis: NEAR analysis of week 8 responders in ULTRA 2</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P3, N=NA; ULTRA 2; "This NEAR analysis demonstrates that adalimumab has a favorable benefit/risk profile as maintenance treatment through 52 weeks for moderate to severe UC patients who achieve clinical response at week 8"</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">2</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="6a933d72-f948-452b-9764-2d71bb612ee1"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('6a933d72-f948-452b-9764-2d71bb612ee1')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=6a933d72-f948-452b-9764-2d71bb612ee1&amp;ts=634858687123941250" target="_top">Efficacy of adalimumab and infliximab for the treatment of moderate to severe ulcerative colitis: number needed to treat analysis of randomized controlled trials</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(Remicade (infliximab) - J&amp;J/Janssen Biotech, Merck; </span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=858; Clinical remission for ADA &amp; IFX are reported; The number needed to treat (NNT) for ADA for clinical remission was 10 for week 8 and 10 for week 52; The NNT for IFX for clinical remission was 4 for week 8 &amp; 5 for week 54</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="055f9def-76a0-4457-a867-4a4a57d83068"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('055f9def-76a0-4457-a867-4a4a57d83068')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=055f9def-76a0-4457-a867-4a4a57d83068&amp;ts=634858687123941250" target="_top">Comparative colorectal cancer risk in patients with ulcerative colitis treated with adalimumab versus conventional therapy</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=23,867; "After adjusting for baseline factors, ADA-treated patients were approximately 1.36 times less likely to develop CRC compared with those treated with conventional therapy at Year 2 after initiation of therapy (hazard ratio=0.735, 95% CI: 0.101:5.373, P=0.762); however, this result was not statistically significant."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="ddcca924-e4dc-45fc-a700-4d8f457c0a23"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('ddcca924-e4dc-45fc-a700-4d8f457c0a23')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=ddcca924-e4dc-45fc-a700-4d8f457c0a23&amp;ts=634858687123941250" target="_top">Long-term efficacy of adalimumab for treatment of moderately to severely active ulcerative colitis</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=992; "The observed mean PMS at day of first dose of ADA was 5.9 (n=992), and decreased over time through 112 weeks of treatment to 1.8 (N=444, Table). Of the 588 ITT patients from the lead-in studies who enrolled into the OL extension, 351 (59.7%, LOCF) achieved clinical remission per PMS at week 60 of the OL extension. No new safety signals were observed."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="cfcfe1e5-1553-428f-b142-e15cf5295bba"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('cfcfe1e5-1553-428f-b142-e15cf5295bba')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=cfcfe1e5-1553-428f-b142-e15cf5295bba&amp;ts=634858687123941250" target="_top">Corticosteroid avoidance in patients with Crohn's disease who are newly initiated to therapy with an anti-TNF versus azathioprine</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(Remicade (infliximab) - J&amp;J/Janssen Biotech, Merck; Cimzia (certolizumab pegol) - UCB; </span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=2,241; "All anti-TNF agents showed statistically higher rates of CS avoidance compared with AZA (range, p&lt;0.0001-0.0260) (Table). There were no statistical differences in CS avoidance at 6 and 12 months for pts initiated on CZP compared with IFX (p=0.5600 and p=0.7500) or ADA (p=0.6900 and p=0.9000), respectively."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="ac20bb01-e1c6-4a0a-9821-53880f5ecf79"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lll<font class="greyColor">lllllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('ac20bb01-e1c6-4a0a-9821-53880f5ecf79')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=ac20bb01-e1c6-4a0a-9821-53880f5ecf79&amp;ts=634858687123941250" target="_top">Risk of malignancy, infection, serious infection, and acute health care use in patients with Crohn's disease treated with adalimumab vs. immunosuppressants</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Humira </b><span>(adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; �One-year rates of events for ADA and IS were as follows: 2.6% and 3.2% for malignancy (P=0.267), 14.1% and 11.8% for infection (P=0.001), 5.7% and 4.4% for serious infection (P=0.004), 39.9% and 36.9% for acute health care use (P=0.142).�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_bdac0484-bc7f-4d23-a63d-1cc4c274bc2e_a78c6aaf-76e6-46e4-b144-b1abb84031f3" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Lialda </b> (mesalazine CR, Mesalazine MMX, Mesavance, Mezavant XL, MMX Mesalamine)<br><i>Shire, Takeda</i><br><br>Lipoxygenase cyclooxygenase inhibitor&nbsp;/&nbsp;Small Molecule&nbsp;/&nbsp;Oral</td>
						<td class="CommentCell" valign="top">Marketed: UC, Maintenance of remission of UC</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="b8ae6c0d-c24a-464b-8ab9-6c0343be5c0e"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P4 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('b8ae6c0d-c24a-464b-8ab9-6c0343be5c0e')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=b8ae6c0d-c24a-464b-8ab9-6c0343be5c0e&amp;ts=634858687123941250" target="_top">The effect of ulcerative colitis (UC) remission status after induction with MMX Mesalamine on Long-term Maintenance Therapy Outcomes (MOMENTUM Study): Induction phase results</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Lialda </b><span>(mesalazine CR, Mesalazine MMX, Mesavance, Mezavant XL, MMX Mesalamine) - Shire, Takeda)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 10:30 AM � 4:00 PM; P4, N=672; NCT01124149; �At Week 3, symptom improvement (=1-point reduction from baseline) was observed in 43.1%, 38.9%, and 26.3% of patients for rectal bleeding, stool frequency, or both, respectively; at Week 8, these proportions increased to 63.4%, 62.2%, and 48.0%, respectively. Complete or partial remission was achieved by 27.9% and 42.2% of patients at Week 8, and complete mucosal healing (endoscopic subscore of 0) was achieved by 33.3%...The most common treatment-emergent adverse events during the induction phase were inefficacy of drug (6.5%), headache (1.8%), and fever (1.8%).�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="84f597bf-523b-40f0-a5da-530a506df007"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P1 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('84f597bf-523b-40f0-a5da-530a506df007')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=84f597bf-523b-40f0-a5da-530a506df007&amp;ts=634858687123941250" target="_top">Effect of MMX mesalamine coadministration on the pharmacokinetics of ciprofloxacin XR</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Lialda </b><span>(mesalazine CR, Mesalazine MMX, Mesavance, Mezavant XL, MMX Mesalamine) - Shire, Takeda)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 10:30 AM � 4:00 PM; P1, N=30; NCT01402947; "No statistically significant effects on ciprofloxacin pharmacokinetic parameters were observed following treatment with MMX mesalamine in combination with ciprofloxacin XR. Ciprofloxacin 500 mg and the combination of ciprofloxacin 500 mg with MMX mesalamine 4.8 g were generally well tolerated."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="50a828cf-a35a-4e04-ab2e-5cc846f617ec"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('50a828cf-a35a-4e04-ab2e-5cc846f617ec')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P1 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('50a828cf-a35a-4e04-ab2e-5cc846f617ec')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=50a828cf-a35a-4e04-ab2e-5cc846f617ec&amp;ts=634858687123941250" target="_top">Effects of MMX mesalamine coadministration on the pharmacokinetics of metronidazole</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Lialda </b><span>(mesalazine CR, Mesalazine MMX, Mesavance, Mezavant XL, MMX Mesalamine) - Shire, Takeda)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 10:30 AM � 4:00 PM; P1, N=29; NCT01418365; "...Metronidazole 750 mg and the combination of metronidazole 750mg with MMX mesalamine 4.8g were generally well tolerated, regardless of treatment period."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_2a72ecfa-c039-465e-b626-08fc17ff9536_a78c6aaf-76e6-46e4-b144-b1abb84031f3" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Prograf, Advagraf, Graceptor </b> (tacrolimus)<br><i>Astellas</i><br><br>Calcineurin inhibitor&nbsp;/&nbsp;Small Molecule&nbsp;/&nbsp;IV, Oral</td>
						<td class="CommentCell" valign="top">Marketed: UC (Japan)</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="24a5cacc-5bc1-408f-8d4b-b69403e97084"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('24a5cacc-5bc1-408f-8d4b-b69403e97084')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=24a5cacc-5bc1-408f-8d4b-b69403e97084&amp;ts=634858687123941250" target="_top">Prognostic factors for colectomy in refractory ulcerative colitis treated with calcineurin inhibitors</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Exp Ther Med)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Prograf, Advagraf, Graceptor </b><span>(tacrolimus) - Astellas)</span></span>&nbsp;-&nbsp;</span><span>Oct 13, 2012 - <span class="NewsItemSummaryText">P=NA, N=59; "The risk factors for CNI non-responsiveness were: i) more than 10,000 mg of prednisolone used prior to CNI treatment; and ii) positivity for cytomegalovirus antigenemia (C7-HRP). The factors affecting the rate of colectomy were: i) CNI non-responsiveness; ii) more than 10,000 mg of prednisolone used prior to the initiation of CNI treatment; and iii) positivity for C7-HRP."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_0537757b-b0d8-4c12-8143-02d82a66ff5c_a78c6aaf-76e6-46e4-b144-b1abb84031f3" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Remicade </b> (infliximab)<br><i>J&amp;J/Janssen Biotech, Merck</i><br><br>TNF-? inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;IV</td>
						<td class="CommentCell" valign="top">Marketed: UC, CD; P3: Pediatric UC (Japan)</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="d0fd7e09-ca22-4626-9e7e-1f414ca60e69"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllll<font class="greyColor">llll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('d0fd7e09-ca22-4626-9e7e-1f414ca60e69')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=d0fd7e09-ca22-4626-9e7e-1f414ca60e69&amp;ts=634858687123785000" target="_top">The use of Human Anti-Chimeric Antibody (HACA) and infliximab levels in the management of inflammatory bowel disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 10:30 AM � 4:00 PM; P=NA, N=50; "Only 57% of patients (8/14) with a true positive HACA serology had an appropriate change in management, which induced remission in 75% (6/8) of patients...21% of providers (3/14) increased IFX dose in the setting of a subtherapeutic IFX value...HACA negative patients with therapeutic IFX levels, 50% (6/12) responded to increasing IFX dose while 67% (4/6) responded to a change to another anti-TNF agent."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">1</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="a41a86a6-26b1-4d1c-8ef8-7a992fdab1d8"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllll<font class="greyColor">llll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('a41a86a6-26b1-4d1c-8ef8-7a992fdab1d8')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=a41a86a6-26b1-4d1c-8ef8-7a992fdab1d8&amp;ts=634858687123785000" target="_top">Immunization status in patients with inflammatory bowel diseases and rheumatologic disorders receiving infliximab infusions: Results of a patient survey in a tertiary care center</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM - 4:00 PM; P=NA, N=40; Pts with IBD &amp; rheumatologic disorders have low prevalence of immunization; A large percentage of rheumatologists &amp; gastroenterologists did not discuss vaccination &amp; a very small percentage provided vaccinations to these pts; Pts had poor understanding on safety of vaccinations &amp; many were under immunized; Efforts to increase awareness of both physicians &amp; pts to safety profile &amp; importance of vaccinations is needed</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="d154b4e5-2c5b-430a-9ada-2a64c976f05b"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllll<font class="greyColor">llll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('d154b4e5-2c5b-430a-9ada-2a64c976f05b')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=d154b4e5-2c5b-430a-9ada-2a64c976f05b&amp;ts=634858687123785000" target="_top">A prospective analysis of the incidence of and risk factors for opportunistic infections in patients with inflammatory bowel disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(J Gastroenterol)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 12, 2012 - <span class="NewsItemSummaryText">P=NA, N=570; "The incidence of opportunistic infections in patients aged 50 years or over was significantly higher than that in the other age groups (p = 0.01). The use of steroids (p = 0.02), thiopurine (p &lt; 0.01), and immunosuppressant combination therapy (p &lt; 0.01) was associated with an increased rate of opportunistic infections. However, the use of infliximab was not associated with an increased rate of opportunistic infections (p = 0.62)."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="ef5c1b0c-613e-4a73-b73c-410af1febffa"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('ef5c1b0c-613e-4a73-b73c-410af1febffa')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=ef5c1b0c-613e-4a73-b73c-410af1febffa&amp;ts=634858687123785000" target="_top">IL-15R? expression in inflammatory bowel disease patients before and after normalization of inflammation with infliximab</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Immunology)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 9, 2012 - <span class="NewsItemSummaryText">P=NA, N=NA; "Mucosal expression of IL-15R? is increased in UC and CD patients as compared to controls and it remains elevated after IFX therapy in both responder and non-responder patients. The concentration of sIL-15R? in serum is also increased in UC patients when compared to controls and does not differ between responders and non-responders both before and after IFX"</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="b62187b8-8e22-43c7-81a0-1ffdb712c54d"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('b62187b8-8e22-43c7-81a0-1ffdb712c54d')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=b62187b8-8e22-43c7-81a0-1ffdb712c54d&amp;ts=634858687123785000" target="_top">Crohn's disease genotypes of patients in remission vs relapses after infliximab discontinuation</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(World J Gastroenterol)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">P=NA, N=48; "There was no significant increase in frequency of the NOD2/CARD15 polymorphisms (R702W, G908R and L1007fs) and the IBD5 polymorphisms (IGR2060a1 and IGR3081a1) in either group of patients; those whose disease relapsed rapidly or those who remained in sustained long term remission following the discontinuation of infliximab."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="6a933d72-f948-452b-9764-2d71bb612ee1"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('6a933d72-f948-452b-9764-2d71bb612ee1')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=6a933d72-f948-452b-9764-2d71bb612ee1&amp;ts=634858687123785000" target="_top">Efficacy of adalimumab and infliximab for the treatment of moderate to severe ulcerative colitis: number needed to treat analysis of randomized controlled trials</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck; Humira (adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=858; Clinical remission for ADA &amp; IFX are reported; The number needed to treat (NNT) for ADA for clinical remission was 10 for week 8 and 10 for week 52; The NNT for IFX for clinical remission was 4 for week 8 &amp; 5 for week 54</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="c1cee344-6667-4e0c-8d5d-6de47e59eada"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('c1cee344-6667-4e0c-8d5d-6de47e59eada')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=c1cee344-6667-4e0c-8d5d-6de47e59eada&amp;ts=634858687123785000" target="_top">Obesity is linked to higher rates of arthritis and failure to biologics in IBD patients</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P=NA, N=792; BMI range of 30 was associated with an increased prevalence of failure of response to infliximab and EIM such as arthritis</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="278bef5f-a8e8-452c-980e-a5c2f7db15a6"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('278bef5f-a8e8-452c-980e-a5c2f7db15a6')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=278bef5f-a8e8-452c-980e-a5c2f7db15a6&amp;ts=634858687123785000" target="_top">Comparison of techniques for monitoring infliximab and antibodies to infliximab in Crohn's disease patients with infliximab treatment failure</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 10:30 AM � 4:00 PM; P=NA, N=67; "All assays showed a good correlation for serum IFX levels, however, larger discrepancies were seen when comparing ATI measurements. Liquid phase assays seem to perform better in general compared to solid phase assays"</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="2cd102b7-ffbb-4679-ac78-af0716ba0625"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('2cd102b7-ffbb-4679-ac78-af0716ba0625')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=2cd102b7-ffbb-4679-ac78-af0716ba0625&amp;ts=634858687123785000" target="_top">Detection of anti infliximab antibodies in patients with inflammatory bowel disease (IBD) in the presence of infliximab by homogeneous liquid phase anti infliximab mobility shift assay</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time:  Monday, Oct 22, 10:30 AM � 4:00 PM; P=NA, N=90; "The agreement for the outcome positive ADA measured at week 4 versus week 8 yields a Cohen's kappa of 0,80, with a correlation of t = 0,651 (p=0.001). ADA occurred most frequently in patients with non-detectable or very low TL."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="1ff00a50-d415-4f6f-8569-334dfd7090b5"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('1ff00a50-d415-4f6f-8569-334dfd7090b5')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=1ff00a50-d415-4f6f-8569-334dfd7090b5&amp;ts=634858687123785000" target="_top">Comparison of standard dose azathioprine versus low dose azathioprine when used as adjuvant therapy with infliximab in patients with inflammatory bowel disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck; 6 Mercaptopurine (6-MP, Azathioprine) - Teva)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P=NA, N=77; IBD flares occurred during 21.3% of low dose semesters &amp; 9.8% of standard dose semesters (p=0.03); No variable independently predicted a higher likelihood of low vs. standard dosing of AZA for any given semester (p&gt;0.10); Mean TPMT activity in the standard dose subjects was 22.0 units/mL (SD 3.2) &amp; in the low dose subjects was 21.1 units/mL (SD 4.1) (p=0.08)</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="0bd3daf1-da3a-45e9-ad75-3a29e1577a56"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('0bd3daf1-da3a-45e9-ad75-3a29e1577a56')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=0bd3daf1-da3a-45e9-ad75-3a29e1577a56&amp;ts=634858687123785000" target="_top">Infliximab dosing patterns among individuals with Crohn's disease: Results from a mid-Atlantic healthplan</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; N=500; �32% (n=164) of the individuals were treated with IFX...Among the individuals who received IFX, a total of 891 IFX infusions were captured for a mean of 5.5 infusions per patient. The mean IFX dose and IFX interval was 5.4 mg/kg and 62 days (8.8 weeks), respectively. Seventy-seven percent of patients using IFX began and maintained treatment with IFX at a dose of 5 mg/kg.�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="9153e954-ff82-4055-8538-50224f81c38e"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('9153e954-ff82-4055-8538-50224f81c38e')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=9153e954-ff82-4055-8538-50224f81c38e&amp;ts=634858687123785000" target="_top">The risks of post-operative complications following pre-operative infliximab therapy for Crohn's disease in patients undergoing abdominal surgery: A systematic review and meta-analysis</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=1,159; No statistically significant difference in the major complication rate (p=0.15), minor complication rates (p=0.11), reoperation (p=0.52) &amp; 30 day mortality (p=0.13) was observed between the infliximab treated group vs. control group</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="20750113-7f24-4de8-a705-a1ea2bcdc798"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('20750113-7f24-4de8-a705-a1ea2bcdc798')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=20750113-7f24-4de8-a705-a1ea2bcdc798&amp;ts=634858687123941250" target="_top">Clinical implications of measuring infliximab levels and human anti-chimeric antibodies in patients with inflammatory bowel disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=40; "Our study suggests that in IBD patients with loss of response to infliximab, measurement of infliximab level and HACA can be considered. Clinical improvement may occur upon intensification of infliximab therapy in patients with either subtherapeutic serum concentration or presence of antibodies."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="87d899c9-184c-4c8a-92e7-a252642f30f2"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('87d899c9-184c-4c8a-92e7-a252642f30f2')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=87d899c9-184c-4c8a-92e7-a252642f30f2&amp;ts=634858687123941250" target="_top">Assessment of infliximab utilization among patients with inflammatory bowel disease across different sites of care</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; N=1,233; �IFX dose (mg per infusion) among IBD patients is similar regardless of the site of care in which the patient receives the infusion, but intervals between infusions are longer for patients treated in an HOPD or ASOC setting than for patients treated in an IOI setting."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="59c63712-9456-4aa0-9ae1-c0549903d56f"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('59c63712-9456-4aa0-9ae1-c0549903d56f')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=59c63712-9456-4aa0-9ae1-c0549903d56f&amp;ts=634858687123941250" target="_top">Clinical experience with measurement of serum infliximab and antibodies to infliximab using a new homogenous mobility shift assay: Results of a multi-center observational study</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 10:30 AM � 4:00 PM; P=NA, N=48; �Among ATI-positive patients, 86% had IFX concentrations &lt; 3 �g/mL, whereas only 9% of ATI-negative patients had IFX concentrations &lt; 3 �g/mL (Odds Ratio = 0.02; p &lt;&lt;0.0001, Fisher's Exact test). Median IFX concentrations were 1 �g/mL and 20 �g/mL in ATI-positive and ATI-negative patients, respectively.�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="0361333b-61c2-46c3-9fee-c344cd0b00b1"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Review;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('0361333b-61c2-46c3-9fee-c344cd0b00b1')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=0361333b-61c2-46c3-9fee-c344cd0b00b1&amp;ts=634858687123941250" target="_top">Smoking and infliximab response in Crohn's disease: A meta-analysis</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; �The relative risk (RR) for response to IFX among smokers was 0.99 (95% CI: 0.88 to 1.11) (t2 = 0.0143, between-study variance), with a high degree of heterogeneity (Q = 19.02, P &lt; 0.0081)...Though smoking worsens CD, this meta-analysis does not show a negative effect of smoking on initial response to IFX.�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="2c5f8cfc-4b7d-4db8-9f1d-cff867c7c9e7"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('2c5f8cfc-4b7d-4db8-9f1d-cff867c7c9e7')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=2c5f8cfc-4b7d-4db8-9f1d-cff867c7c9e7&amp;ts=634858687123941250" target="_top">Azathioprine versus methotrexate as adjuvant therapy with infliximab in biologic na�ve patients: equivalent responses over three-year follow-up</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck; 6 Mercaptopurine (6-MP, Azathioprine) - Teva)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P=NA, N=116; "After adjustment for covariates, there remained no significant difference between the groups (adjusted HR = 1.08, P = 0.86). On univariate analysis, there were no differences between subjects on AZA or MTX in regard to an earlier need to switch anti-TNF agents (HR = 0.92, P = 0.90), require corticosteroids (HR 1.38, P = 0.57), undergo surgery (HR = 1.01, P = 0.99) or be hospitalized (HR 1.44, P = 0.58)."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="cfcfe1e5-1553-428f-b142-e15cf5295bba"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('cfcfe1e5-1553-428f-b142-e15cf5295bba')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=cfcfe1e5-1553-428f-b142-e15cf5295bba&amp;ts=634858687123941250" target="_top">Corticosteroid avoidance in patients with Crohn's disease who are newly initiated to therapy with an anti-TNF versus azathioprine</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck; Cimzia (certolizumab pegol) - UCB; Humira (adalimumab) - Abbott)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P=NA, N=2,241; "All anti-TNF agents showed statistically higher rates of CS avoidance compared with AZA (range, p&lt;0.0001-0.0260) (Table). There were no statistical differences in CS avoidance at 6 and 12 months for pts initiated on CZP compared with IFX (p=0.5600 and p=0.7500) or ADA (p=0.6900 and p=0.9000), respectively."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="568fa29a-241f-478d-b1a4-de4d1e308e2c"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lll<font class="greyColor">lllllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('568fa29a-241f-478d-b1a4-de4d1e308e2c')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=568fa29a-241f-478d-b1a4-de4d1e308e2c&amp;ts=634858687123941250" target="_top">Infection rates with infliximab in inflammatory bowel disease compared to rheumatologic diseases: A single center experience</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Remicade </b><span>(infliximab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; N=120; �Study demonstrates a higher overall risk of development of infections with the use of infliximab in RA and psoriasis patients as compared with IBD patients but with a higher risk of serious infections in the IBD patient population. Older age, greater use of concomitant immunomodulators and narcotics agents among rheumatologic patients may be associated with this observation�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_177e2a52f3ba43fd92975cc6e60ce7a7">
						<td colspan="4" class="Section">Filed</td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_411eb49c-b254-42e7-b19a-9fec4dc57b0f_177e2a52-f3ba-43fd-9297-5cc6e60ce7a7" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Simponi </b> (golimumab)<br><i>J&amp;J/Janssen Biotech, Merck</i><br><br>TNF-? inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Subcutaneous, IV<br><span class="keyProduct"><b>Premium coverage</b></span></td>
						<td class="CommentCell" valign="top">Filed: UC (US and EU)</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="47861340-8e60-47e8-8262-418862a16689"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('47861340-8e60-47e8-8262-418862a16689')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('47861340-8e60-47e8-8262-418862a16689')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=47861340-8e60-47e8-8262-418862a16689&amp;ts=634858687123941250" target="_top">A phase 3 randomized, placebo-controlled, double-blind study to evaluate the safety and efficacy of subcutaneous golimumab maintenance therapy in patients with moderately to severely active ulcerative colitis: PURSUIT-maintenance</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Simponi </b><span>(golimumab) - J&amp;J/Janssen Biotech, Merck)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 3:15 PM � 3:25 PM; P3, N=464; PURSUIT-IV, PURSUIT-SC; "Greater proportions of patients receiving GLM 50mg (47%) or GLM 100mg (51%) were in clinical response through wk54 vs PBO (31%; p=0.01 and p&lt;0.001, respectively). Clinical remission at both wk 30 and wk 54 for PBO, GLM 50mg, and GLM 100mg was 15%, 24% (p=0.091), and 29% (p=0.003), mucosal healing at both wk 30 and wk 54 was 27%, 42%, and 44% (p=0.001)."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_c11a9fc4e3e54233bfbf31db91386dfa">
						<td colspan="4" class="Section">Phase 3</td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_8d979a26-e68a-40af-8116-fad04d4af783_c11a9fc4-e3e5-4233-bfbf-31db91386dfa" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Cx601</b><br><i>Tigenix</i><i>, Cellerix</i><br><br>Stem cell stimulant&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Intralesional</td>
						<td class="CommentCell" valign="top">P3: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="c88c0f7d-6189-440f-8873-df85e273d614"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllll<font class="greyColor">lll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Anticipated P3 data; P1/2 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('c88c0f7d-6189-440f-8873-df85e273d614')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=c88c0f7d-6189-440f-8873-df85e273d614&amp;ts=634858687123941250" target="_top">TiGenix announces publication of Cx601 phase I/IIa study in International Journal of Colorectal Disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(TiGenix)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Cx601</b><span> - Tigenix)</span></span>&nbsp;-&nbsp;</span><span>Oct 9, 2012 - <span class="NewsItemSummaryText">P1/2, N=24; NCT01372969; "...the full analysis of efficacy data at week 24 showed 69.2% of the patients with a reduction in the number of draining fistulas, while 56.3% of the patients achieved complete closure of the treated fistula, and 30% of the cases presented complete closure of all existing fistula tracts."; P3, N=278; ADMIRE-CD; Anticipated P3 data in H2 2014</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">1</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_276e854b-426f-4938-bd0c-df4df1e699c1_c11a9fc4-e3e5-4233-bfbf-31db91386dfa" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Orencia </b> (abatacept)<br><i>Ono, BMS</i><br><br>CD80 inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;IV, Subcutaneous<br><span class="keyProduct"><b>Premium coverage</b></span></td>
						<td class="CommentCell" valign="top">P3: UC</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="1af7db0e-3ebd-48ec-814e-da69970d7bb7"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllll<font class="greyColor">lll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Financial analyst; Sales projection;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('1af7db0e-3ebd-48ec-814e-da69970d7bb7')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=1af7db0e-3ebd-48ec-814e-da69970d7bb7&amp;ts=634858687123941250" target="_top">Orencia sales projection: $1.65B in 2017</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Cowen and Company)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Orencia </b><span>(abatacept) - Ono, BMS)</span></span>&nbsp;-&nbsp;</span><span>Oct 9, 2012 - <span class="NewsItemSummaryText">A subscription to Thomson One is required to gain full access to Report 20834128</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_bf41437e-72e3-414d-896b-dca3650029b6_c11a9fc4-e3e5-4233-bfbf-31db91386dfa" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Prochymal </b> (remestemcel-L, JR-031, Provacel)<br><i>Osiris</i><br><br>Stem cell stimulant&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;IV<br><span class="keyProduct"><b>Premium coverage</b></span></td>
						<td class="CommentCell" valign="top">P3: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="e32051f2-8a51-4338-b10c-ed4e7e899f8e"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Clinical data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('e32051f2-8a51-4338-b10c-ed4e7e899f8e')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=e32051f2-8a51-4338-b10c-ed4e7e899f8e&amp;ts=634858687123941250" target="_top">Remestemcel-L therapy is effective treatment in patients with refractory Crohn's Disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Prochymal </b><span>(remestemcel-L, JR-031, Provacel) - Osiris)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P=NA, N=6; �In the compassionate, open label trial 4/6 had CDAI decrease of &gt;100.1/6 had little response in CDAI, but improved clinically and 1/6 had little response. Pt.001 had complete healing of Pyoderma gangrenosum. No related adverse effects were reported�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_2d89adee-5dd1-498c-a09f-730775ea9aa0_c11a9fc4-e3e5-4233-bfbf-31db91386dfa" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Stelara </b> (ustekinumab)<br><i>J&amp;J/Centocor Ortho Biotech, BMS/Medarex</i><br><br>IL-12 &amp; IL-23 inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Subcutaneous<br><span class="keyProduct"><b>Premium coverage</b></span></td>
						<td class="CommentCell" valign="top">P3: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="6045da24-9994-4cac-99ae-2ea48ec3424e"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllll<font class="greyColor">lll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Commercial; Financial analyst; Sales projection;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('6045da24-9994-4cac-99ae-2ea48ec3424e')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=6045da24-9994-4cac-99ae-2ea48ec3424e&amp;ts=634858687123941250" target="_top">Stelara sales projection: $995M (+35%) in 2012, $1,195M (+20%) in 2013, and $1,925M in 2017; Stelara analyst opinion: cardiovascular safety issue may blunt Stelara�s 2014-17 sales estimates</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Cowen and Company)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Stelara </b><span>(ustekinumab) - J&amp;J/Centocor Ortho Biotech, BMS/Medarex)</span></span>&nbsp;-&nbsp;</span><span>Oct 9, 2012 - <span class="NewsItemSummaryText">A subscription to Thomson One is required to gain full access to Report 20834128</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_8de1488c-79d4-495f-b747-0a6cc064e3ff_c11a9fc4-e3e5-4233-bfbf-31db91386dfa" class="ProductRow">
						<td class="ProductCell" valign="top"><b>tetomilast </b> (OPC-6535)<br><i>Otsuka</i><br><br>Type 4 cyclic nucleotide phosphodiesterase  inhibitor&nbsp;/&nbsp;Small Molecule&nbsp;/&nbsp;Oral<br><span class="keyProduct"><b>Premium coverage</b></span></td>
						<td class="CommentCell" valign="top">P2/3: CD (Japan, South Korea)</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="8da670b7-c225-4d15-9929-d9945e15ad01"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lll<font class="greyColor">lllllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Review;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('8da670b7-c225-4d15-9929-d9945e15ad01')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=8da670b7-c225-4d15-9929-d9945e15ad01&amp;ts=634858687123941250" target="_top">Tetomilast: new promise for phosphodiesterase-4 inhibitors?</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Expert Opin Investig Drugs)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>tetomilast </b><span>(OPC-6535) - Otsuka)</span></span>&nbsp;-&nbsp;</span><span>Oct 10, 2012 - <span class="NewsItemSummaryText">"...the authors review the pharmacology of the drug, and offer critical review of the available data for use of tetomilast in the treatment of IBD...Expert opinion: Tetomilast may be beneficial in IBD. Small differences in molecules and in recombinant proteins can translate into substantial differences in clinical effects and toxicity in IBD."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_88e8a398-45ed-4a6b-a5d9-5acec6c5f719_c11a9fc4-e3e5-4233-bfbf-31db91386dfa" class="ProductRow">
						<td class="ProductCell" valign="top"><b>tofacitinib, tasocitinib </b> (CP-690550)<br><i>Pfizer</i><br><br>JAK3 Inhibitor&nbsp;/&nbsp;Small Molecule&nbsp;/&nbsp;Oral, Topical</td>
						<td class="CommentCell" valign="top">P3: UC; P2: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="381b5c12-e8e4-4585-971b-2b7068c5501b"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllll<font class="greyColor">lll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Sales projection; Financial analyst;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('381b5c12-e8e4-4585-971b-2b7068c5501b')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=381b5c12-e8e4-4585-971b-2b7068c5501b&amp;ts=634858687123941250" target="_top">Tofacitinib sales projection: $100M in 2012, $300M in 2013, and $1.50B in 2017</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Cowen and Company)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>tofacitinib, tasocitinib </b><span>(CP-690550) - Pfizer)</span></span>&nbsp;-&nbsp;</span><span>Oct 9, 2012 - <span class="NewsItemSummaryText">A subscription to Thomson One is required to gain full access to Report 20834128</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">1</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="52f345bb-34fa-433d-bf37-8c31b18eda81"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllll<font class="greyColor">lll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Financial analyst; Sales projection;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('52f345bb-34fa-433d-bf37-8c31b18eda81')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=52f345bb-34fa-433d-bf37-8c31b18eda81&amp;ts=634858687123941250" target="_top">Tofacitinib sales projection: &gt;$1.4B by 2015</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(BMO CAPITAL MARKETS U.S.)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>tofacitinib, tasocitinib </b><span>(CP-690550) - Pfizer)</span></span>&nbsp;-&nbsp;</span><span>Oct 9, 2012 - <span class="NewsItemSummaryText">A subscription to Thomson One is required to gain full access to Report 20826489</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">3</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_b669d068-18bb-4807-9647-bc33c93f16f8_c11a9fc4-e3e5-4233-bfbf-31db91386dfa" class="ProductRow">
						<td class="ProductCell" valign="top"><b>vedolizumab </b> (LDP 02, MLN 0002, MLN02)<br><i>Takeda</i><br><br>?4 ?7 integrin antagonist&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;IV<br><span class="keyProduct"><b>Premium coverage</b></span></td>
						<td class="CommentCell" valign="top">P3: CD, UC</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="98f189f9-a6a2-465c-9bd1-a688bd259b5e"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('98f189f9-a6a2-465c-9bd1-a688bd259b5e')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('98f189f9-a6a2-465c-9bd1-a688bd259b5e')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=98f189f9-a6a2-465c-9bd1-a688bd259b5e&amp;ts=634858687123941250" target="_top">Vedolizumab maintenance therapy for ulcerative colitis: Results of GEMINI I, a randomized, placebo-controlled, double-blind, multicenter phase 3 trial</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>vedolizumab </b><span>(LDP 02, MLN 0002, MLN02) - Takeda)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Monday, Oct 22, 8:40 AM � 8:50 AM; P3, N=895; GEMINI I; A significantly greater proportion of VDZ-treated pts than PBO-treated pts achieved clinical remission, mucosal healing &amp; CS-free remission at 52 weeks &amp; durable response &amp; remission; 32% of the ITT population had prior anti-TNFa failure; Clinical remission &amp; durable clinical response rates were greater in VDZ than PBO pts regardless of prior anti-TNF treatment status</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">3</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="bd13ef6e-b134-42d0-b35e-edb2928517cb"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('bd13ef6e-b134-42d0-b35e-edb2928517cb')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('bd13ef6e-b134-42d0-b35e-edb2928517cb')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=bd13ef6e-b134-42d0-b35e-edb2928517cb&amp;ts=634858687123941250" target="_top">Vedolizumab induction and maintenance therapy for Crohn�s disease: Results of Gemini II, two randomized, placebo-controlled, double-blind, multicenter phase 3 trials</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>vedolizumab </b><span>(LDP 02, MLN 0002, MLN02) - Takeda)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 3:05 PM � 3:15 PM; P3, N=1,115; Gemini II; A significantly greater proportion of vedolizumab (VDZ)-treated pts than PBO-treated pts had clinical remission, enhanced response &amp; CS free remission at 52 wks</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">6</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="5b0f4898-c292-44d0-a086-6b922d6dffd6"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllll<font class="greyColor">lll</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('5b0f4898-c292-44d0-a086-6b922d6dffd6')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P3 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('5b0f4898-c292-44d0-a086-6b922d6dffd6')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=5b0f4898-c292-44d0-a086-6b922d6dffd6&amp;ts=634858687123941250" target="_top">Vedolizumab induction therapy for Crohn's disease: Results of Gemini II, a randomized, placebo-controlled, double-blind, multicenter phase 3 trial</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>vedolizumab </b><span>(LDP 02, MLN 0002, MLN02) - Takeda)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; P3, N=368; Gemini II; A significantly greater proportion of vedolizumab than PBO pts achieved clinical remission at 6 weeks; At the 6 week timepoint, no significant difference was observed in rates of enhanced clinical response or change in CRP between vedolizumab &amp; PBO groups</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">1</span>&nbsp;View(s)&nbsp;</span></span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="842dfb82-6430-4860-80a9-ee56da9c1ea5"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Review;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('842dfb82-6430-4860-80a9-ee56da9c1ea5')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=842dfb82-6430-4860-80a9-ee56da9c1ea5&amp;ts=634858687123941250" target="_top">Vedolizumab for the treatment of ulcerative colitis and Crohn's disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Immunotherapy)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>vedolizumab </b><span>(LDP 02, MLN 0002, MLN02) - Takeda)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Vedolizumab targets a subset of the cell adhesion molecules (CAMs) blocked by natalizumab &amp; is currently in P3 trials to study its efficacy &amp; safety in pts with inflammatory bowel disease</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_80dd6b33cd4647ea90593d5c62f00be5">
						<td colspan="4" class="Section">Phase 2</td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_932a5102-fb1c-43cc-827a-ec83eb65f00f_80dd6b33-cd46-47ea-9059-3d5c62f00be5" class="ProductRow">
						<td class="ProductCell" valign="top"><b>6 Mercaptopurine </b> (6-MP, Azathioprine)<br><i>Teva</i><br><br>Undefined mechanism&nbsp;/&nbsp;Small Molecule&nbsp;/&nbsp;Oral</td>
						<td class="CommentCell" valign="top">P1/2: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="1ff00a50-d415-4f6f-8569-334dfd7090b5"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('1ff00a50-d415-4f6f-8569-334dfd7090b5')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=1ff00a50-d415-4f6f-8569-334dfd7090b5&amp;ts=634858687123941250" target="_top">Comparison of standard dose azathioprine versus low dose azathioprine when used as adjuvant therapy with infliximab in patients with inflammatory bowel disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(Remicade (infliximab) - J&amp;J/Janssen Biotech, Merck; </span><b>6 Mercaptopurine </b><span>(6-MP, Azathioprine) - Teva)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P=NA, N=77; IBD flares occurred during 21.3% of low dose semesters &amp; 9.8% of standard dose semesters (p=0.03); No variable independently predicted a higher likelihood of low vs. standard dosing of AZA for any given semester (p&gt;0.10); Mean TPMT activity in the standard dose subjects was 22.0 units/mL (SD 3.2) &amp; in the low dose subjects was 21.1 units/mL (SD 4.1) (p=0.08)</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li><li><span class="NewsItemSummaryText" newsitemid="2c5f8cfc-4b7d-4db8-9f1d-cff867c7c9e7"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llll<font class="greyColor">llllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Retrospective data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('2c5f8cfc-4b7d-4db8-9f1d-cff867c7c9e7')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=2c5f8cfc-4b7d-4db8-9f1d-cff867c7c9e7&amp;ts=634858687123941250" target="_top">Azathioprine versus methotrexate as adjuvant therapy with infliximab in biologic na�ve patients: equivalent responses over three-year follow-up</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(Remicade (infliximab) - J&amp;J/Janssen Biotech, Merck; </span><b>6 Mercaptopurine </b><span>(6-MP, Azathioprine) - Teva)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM � 4:00 PM; P=NA, N=116; "After adjustment for covariates, there remained no significant difference between the groups (adjusted HR = 1.08, P = 0.86). On univariate analysis, there were no differences between subjects on AZA or MTX in regard to an earlier need to switch anti-TNF agents (HR = 0.92, P = 0.90), require corticosteroids (HR 1.38, P = 0.57), undergo surgery (HR = 1.01, P = 0.99) or be hospitalized (HR 1.44, P = 0.58)."</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_dbd2958a-e30f-40b1-98db-16eebeb3afcb_80dd6b33-cd46-47ea-9059-3d5c62f00be5" class="ProductRow">
						<td class="ProductCell" valign="top"><b>Cenplacel-L </b> (human placental derived stem cell therapy, HPDSC, PDA-001)<br><i>Celgene</i><br><br>Stem cell stimulant&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Undefined RoA</td>
						<td class="CommentCell" valign="top">P2: CD; Preclinical: UC</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="02dd320b-273a-45f8-a864-45b100d36e64"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P1/2 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('02dd320b-273a-45f8-a864-45b100d36e64')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=02dd320b-273a-45f8-a864-45b100d36e64&amp;ts=634858687123941250" target="_top">Human Placenta-Derived Cells (PDA001) for the treatment of moderate-to-severe Crohn's disease: Results of a phase 1b/2a study</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>Cenplacel-L </b><span>(human placental derived stem cell therapy, HPDSC, PDA-001) - Celgene)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM - 4:00 PM; P1/2, N=50; A two-infusion regimen of PDA001 can induce clinical response in pts with moderate-to-severe Crohn's disease</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_69613933-4e1d-433a-b43e-0c978e9b649b_80dd6b33-cd46-47ea-9059-3d5c62f00be5" class="ProductRow">
						<td class="ProductCell" valign="top"><b>HMPL-004</b><br><i>Hutchinson Medipharma</i><br><br>TNF-? inhibitor, NF-?B inhibitor, IL-1? inhibitor, IL-6 inhibitor&nbsp;/&nbsp;Small Molecule&nbsp;/&nbsp;Oral<br><span class="keyProduct"><b>Premium coverage</b></span></td>
						<td class="CommentCell" valign="top">P2: CD, UC</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="f0374f76-dbbb-406b-98ce-00fee03e62c0"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllll<font class="greyColor">lll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">P2 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('f0374f76-dbbb-406b-98ce-00fee03e62c0')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=f0374f76-dbbb-406b-98ce-00fee03e62c0&amp;ts=634858687123941250" target="_top">Andrographis paniculata extract (HMPL-004) for active ulcerative colitis</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Am J Gastroenterol)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>HMPL-004</b><span> - Hutchinson Medipharma)</span></span>&nbsp;-&nbsp;</span><span>Oct 10, 2012 - <span class="NewsItemSummaryText">P2, N=224; NCT00659802; 45% of pts receiving HMPL-004 1,200mg (p=0.5924) &amp; 60% of pts receiving 1,800mg HMPL-004 (p=0.0183) daily, were in clinical response at wk 8 vs. 40% of pts receiving PBO; 34% of pts receiving HMPL-004 1,200mg (p=0.2582) &amp; 38% of pts receiving 1,800mg (p=0.1011) daily dose were in clinical remission at wk 8 vs. 25% pts receiving PBO</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount">&nbsp;<span class="ClickNumber">3</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_190138a4-dbdf-40e1-875b-83c2c68247c2_80dd6b33-cd46-47ea-9059-3d5c62f00be5" class="ProductRow">
						<td class="ProductCell" valign="top"><b>TNF-? kinoid </b> (TNF kinoid)<br><i>Neovacs</i><i>Stellar, Debiopharm</i><br><br>Tumor necrosis factor alpha inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Intramuscular</td>
						<td class="CommentCell" valign="top">P2: CD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="cb4a28a5-4330-4102-bec3-173d42369e6e"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllll<font class="greyColor">lllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Anticipated P2 data;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('cb4a28a5-4330-4102-bec3-173d42369e6e')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=cb4a28a5-4330-4102-bec3-173d42369e6e&amp;ts=634858687123941250" target="_top">NEOVACS: Phase IIa study results in rheumatoid arthritis patients selected for oral presentation at the 25th Annual Meeting of the French Society of Rheumatology</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(Reuters)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>TNF-? kinoid </b><span>(TNF kinoid) - Neovacs)</span></span>&nbsp;-&nbsp;</span><span>Oct 12, 2012 - <span class="NewsItemSummaryText">"A second phase II study involving TNF-Kinoid is currently ongoing in patients with moderate to severe Crohn�s Disease. Top-line results were released in June and full results are expected during Q4, 2012"</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_e2e5703795b94bcb8bf2ed999e17b4da">
						<td colspan="4" class="Section">Phase 1</td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_c4c8fbeebf404bcabb61772a62a8286c">
						<td colspan="4" class="Section">Preclinical</td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_31082f3d-413e-41c4-ae12-71c54cc5001f_c4c8fbee-bf40-4bca-bb61-772a62a8286c" class="ProductRow">
						<td class="ProductCell" valign="top"><b>AVX-470</b><br><i>Avaxia Biologics</i><br><br>TNF inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Oral</td>
						<td class="CommentCell" valign="top">Preclinical: IBD</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="b98799db-3d19-412a-9535-ae91a428bf5b"><span><span class="ImportanceBarBg"><span class="ImportanceBar">ll<font class="greyColor">llllllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Preclinical;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('b98799db-3d19-412a-9535-ae91a428bf5b')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=b98799db-3d19-412a-9535-ae91a428bf5b&amp;ts=634858687123941250" target="_top">Oral administration of AVX-470m, a novel anti-TNF antibody, suppresses inflammation in a murine model of inflammatory bowel disease</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>AVX-470</b><span> - Avaxia Biologics)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Tuesday, Oct 23, 10:30 AM - 4:00 PM; AVX-470m reduced colonic expression of TNF-mediated pathways, including mRNA &amp; protein levels of inflammatory mediators &amp; cell markers, in a murine model of IBD; These results support the therapeutic potential of an oral anti-TNF antibody for treatment of IBD</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr id="ContentPlaceholderMain_theMainContent_071916af-5132-4606-a972-b475ea62024a_c4c8fbee-bf40-4bca-bb61-772a62a8286c" class="ProductRow">
						<td class="ProductCell" valign="top"><b>SP-333</b><br><i>Callisto, Synergy</i><br><br>Guanylate cyclase-coupled receptor agonist, Sodium-bile acid cotransporter-inhibitor&nbsp;/&nbsp;Biologics&nbsp;/&nbsp;Oral</td>
						<td class="CommentCell" valign="top">Preclinical: UC</td>
						<td colspan="2" class="NewsItemCell" valign="top"><ul><li><span class="NewsItemSummaryText" newsitemid="db7f7994-b8c6-4a8f-8ae3-2c422217428f"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lll<font class="greyColor">lllllll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">Preclinical;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('db7f7994-b8c6-4a8f-8ae3-2c422217428f')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=db7f7994-b8c6-4a8f-8ae3-2c422217428f&amp;ts=634858687123941250" target="_top">SP-333, a proteolysis-resistant agonist of guanylate cyclase-c, inhibits activation of NF-kB and suppresses production of inflammatory cytokines to ameliorate DSS-induced colitis in mice</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span><span class="NewsItemSummaryProduct"><span>(</span><b>SP-333</b><span> - Callisto, Synergy)</span></span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM � 7:00 PM; �Oral treatment with SP-333 ameliorated DSS-induced colitis in mice. In T84 cells, treatment with SP-333 reduced levels of p-NF-?B-p65 in the nuclear fraction and increased levels of cytosolic I?B.�</span>.&nbsp;</span><span class="socialMedia" style="margin: 0px 0px 0px 10px ! important; float: none ! important;"><span class="NewsItemSummarySocialMedia ClicksCount" style="display: none;">&nbsp;<span class="ClickNumber">0</span>&nbsp;View(s)&nbsp;</span></span></span></li></ul></td>
					</tr>
					<tr class="ProductRow">
						<td colspan="4" class="Section">General News</td>
					</tr>
					<tr class="ProductRow">
						<td colspan="4" class="NewsItemCell"><ul><li><span class="NewsItemSummaryText" newsitemid="dd9a2215-93cc-4e6b-bb54-1d3ff0958523"><span><span class="ImportanceBarBg"><span class="ImportanceBar">llllllll<font class="greyColor">ll</font></span></span>&nbsp;&nbsp;</span><span></span><span><span class="NewsItemSummaryRedTags">NICE;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('dd9a2215-93cc-4e6b-bb54-1d3ff0958523')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=dd9a2215-93cc-4e6b-bb54-1d3ff0958523&amp;ts=634858687125191250" target="_top">Crohn's disease: Management in adults, children and young people</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(NICE)</span>&nbsp;-&nbsp;</span><span>Oct 10, 2012 - <span class="NewsItemSummaryText">"This clinical guideline (published October 2012) offers evidence-based advice on the management of Crohn's disease in adults, children and young people"</span>.&nbsp;</span></span><span><br></span></li><li><span class="NewsItemSummaryText" newsitemid="1e6e09f0-c7d6-4e57-afa3-bae5bf88951c"><span><span class="ImportanceBarBg"><span class="ImportanceBar">lllllllll<font class="greyColor">l</font></span></span>&nbsp;&nbsp;</span><span><span style="color: Green; font-weight: bold; font-size: 15px;" onclick="bigEventHandler('1e6e09f0-c7d6-4e57-afa3-bae5bf88951c')">(+)&nbsp;</span></span><span><span class="NewsItemSummaryRedTags">P2 data; New molecule;</span>&nbsp;</span><span><span><a class="NewsItemSummaryLink" onclick="newsItemClickHandler('1e6e09f0-c7d6-4e57-afa3-bae5bf88951c')" href="http://www.larvolinsight.com/NewsItem/Default.aspx?NewsItemID=1e6e09f0-c7d6-4e57-afa3-bae5bf88951c&amp;ts=634858687125191250" target="_top">Novel STAT3 selective inhibitor Natura-a shows great promises in treating moderate-to-severe ulcerative colitis in a randomized, double-blind, placebo-controlled phase II clinical trial</a>&nbsp;</span></span><span><span class="NewsItemSummaryNewsSource">(ACG 2012)</span>&nbsp;-&nbsp;</span><span>Oct 11, 2012 - <span class="NewsItemSummaryText">Presentation time: Sunday, Oct 21, 3:30 PM  7:00 PM; P2, N=70; "Clinical response was 86.4%, 95.0%, and 36.4%, clinical remission 81.8%, 45.0% and 9.1% in 10 mg, 20 mg Natura-a and placebo group, respectively, all statistically significantly different"</span>.&nbsp;</span></span><span><br></span></li></ul></td>
					</tr>
				</tbody></table>
				
<span id="ContentPlaceholderMain_theMainContent_lblTest"></span>


    <script type="text/javascript">

        /*        var exportButton = $("#wordExportIconWithTooltip").clone();
        $("#wordExportIconWithTooltip").css('display', 'none');
        exportButton.css('display', 'block'); 
        exportButton.appendTo("#wordExportSpot");
        
        */

        $("#wordExportIconWithTooltip").find('.wordexporticon').tooltip({ effect: 'slide', delay: 50, offset: [-260, -100] });


        $(function () {

           // alert($(".filterTable").offset().left);
           // alert($(".filterTable").width());

            var exportToWordLeft = $(".filterTable").offset().left + 997 /* $(".filterTable").width()*/ + 8;
            var exportToWordTop = $(".imgKeywordSearchInfo").offset().top; ; //+ 40+30;

            $("#wordExportIconWithTooltip").offset({ top: exportToWordTop, left: exportToWordLeft });

        });

        //$("#wordExportIconWithTooltip").css("left", ""); // ({ top: exportToWordTop, left: exportToWordLeft });

        //$('selector').position().left - $(window).scrollLeft();

        $("#lblDateRange").text("Oct 09 - Oct 15");
        
        boldProduct();
        loading=false;


       
        function OnKeyPressEnter(sender, eventArgs) 
        { 
            var KeyID = eventArgs.get_keyCode();
            if (KeyID == 13) 
            { 
                 eventArgs.cancelBubble = true;
                eventArgs.returnValue = false;
                if (eventArgs.preventDefault) eventArgs.preventDefault();
                if (eventArgs.stopPropagation) eventArgs.stopPropagation();
                eventArgs.set_cancel(true);
            }     
            
        } 
    </script>




            
			</div>
		</div>
            <div id="ContentPlaceholderMain_RadAjaxLoadingPanel1" class="RadAjax RadAjax_Larvol" style="display: none; padding: 25px 0px 0px;">
			<div class="raDiv raTop">
				
            
			</div><div class="raColor raTransp">

			</div>
		</div>
            

                <script type="text/javascript">

                  
                //    $('.wordexporticon').tooltip({ effect: 'slide', delay: 50, offset: [160, 0] });
                           
                    var baseUrl = 'http://www.LarvolInsight.com/';
                    var isLarvolUser = 'True';

                    $(function() {

                        $(".ImageFlag").live("click", function() {

                            $("body").mask("Waiting...");

                            var currentImage = $(this);

                            $.ajax({
                                type: "POST",
                                url: baseUrl + "CR/Default.aspx/ChangeFlag",
                                dataType: "json",
                                contentType: "application/json; charset=utf-8", // content type sent to server
                                data: '{ newsItemId:"' + $(this).attr("newsItemId") + '", flagTypeId: "' + $(this).attr("flagTypeId") + '"}',

                                success: function(data) {
                                    $(currentImage).attr("flagTypeId", data.d.Item1.FlagTypeId);
                                    $(currentImage).attr("src", data.d.Item2);

                                    $("body").unmask();
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    $("body").unmask();
                                    var errorObject = ErrorManager.getErrorObject();
                                    errorObject.errorMessage = thrownError;
                                    ErrorManager.logError(errorObject);
                                }
                            });

                        });

                        $(".AnalyticsImageFlag").live("click", function() {

                            $("body").mask("Waiting...");

                            var currentImage = $(this);

                            $.ajax({
                                type: "POST",
                                url: baseUrl + "CR/Default.aspx/ChangeAnalyticFlag",
                                dataType: "json",
                                contentType: "application/json; charset=utf-8", // content type sent to server
                                data: '{ newsItemId:"' + $(this).attr("newsItemId") + '", flagTypeId: "' + $(this).attr("flagTypeId") + '"}',

                                success: function(data) {
                                    $(currentImage).attr("flagTypeId", data.d.Item1.FlagTypeId);
                                    $(currentImage).attr("src", data.d.Item2);

                                    $("body").unmask();
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    $("body").unmask();
                                    var errorObject = ErrorManager.getErrorObject();
                                    errorObject.errorMessage = thrownError;
                                    ErrorManager.logError(errorObject);
                                }
                            });

                        });
                    });

                    function loadComments(obj, event) {

                        var sourceElement = obj.originalTarget ? obj.originalTarget : obj.srcElement;

                        var newsItemId = $(sourceElement).attr("newsItemId");

                        if (newsItemId) {
                            var imgElement = $(obj.relatedTarget).find("a img[newsItemId='" + newsItemId + "']");
                            //var newsItemId = $(imgElement).attr("newsItemId");
                            var tooltipDiv = $(imgElement).parent().parent().find('.tipBody');

                            if ($(tooltipDiv).find("ul").length == 0) {

                                $(tooltipDiv).html("<ul><li>Loading...</li></ul>");

                                $.ajax({
                                    type: "POST",
                                    url: baseUrl + 'CR/Default.aspx/GetComments',
                                    dataType: "json",
                                    contentType: "application/json; charset=utf-8", // content type sent to server
                                    data: '{ entityId:"' + newsItemId + '", entityTable: "NewsItems"}',
                                    success: function(data) {
                                        $(tooltipDiv).html(data.d);
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                        var errorObject = ErrorManager.getErrorObject();
                                        errorObject.errorMessage = thrownError;
                                        ErrorManager.logError(errorObject);
                                    }
                                });
                            }
                        }
                    }

                    function newsItemClickHandler(newsItemId) {

                        if (isLarvolUser != "True") {

                            var clickSpan = $('.NewsItemSummaryText[newsitemid = "' + newsItemId + '"] .ClicksCount');

                            var clickNumberSpan = $(clickSpan).find(".ClickNumber");

                            if (clickNumberSpan.length > 0) {

                                var clickCount = parseInt($(clickNumberSpan)[0].innerHTML, 10);

                                clickCount++;

                                $(clickNumberSpan).text(clickCount);
                            }

                            $(clickSpan).show();
                        }
                    }
        
                </script>

            
        
	</div><div id="ContentPlaceholderMain_rpvOCT" class="rmpHiddenView" style="height: 100%; margin-top: -10px;">
		
            <div style="display: block;" id="ContentPlaceholderMain_ctl00$ContentPlaceholderMain$RadAjaxPanel1Panel">
			<div id="ContentPlaceholderMain_RadAjaxPanel1">
				
                




    
    
   




<div style="margin-bottom: 5px;" class="centeredTable">
    <table cellspacing="10px">
        
        <tbody><tr id="ContentPlaceholderMain_tlgConferenceTracker_trSearchByName">
					<td style="vertical-align: middle;"><label for="ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter" id="ContentPlaceholderMain_tlgConferenceTracker_lblSearchByName">Conference name: </label></td>
					<td> <span id="ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter_wrapper" class="RadInput RadInput_Default" style="white-space: nowrap;"><input value="Search..." size="20" id="ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter_text" name="ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter_text" class="riTextBox riEmpty" style="width: 350px; color: rgb(51, 51, 51);" type="text"><input id="ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter" name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$rcbConferenceNameFilter" class="rdfd_" style="visibility: hidden; margin: -18px 0px 0px -1px; width: 1px; height: 1px; overflow: hidden; border: 0px none; padding: 0px;" value="" type="text"><input autocomplete="off" value="{&quot;enabled&quot;:true,&quot;emptyMessage&quot;:&quot;Search...&quot;}" id="ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter_ClientState" name="ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter_ClientState" type="hidden"></span></td>
					<td> 
                <input name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$btnSearch" value="Search" onclick="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$btnSearch','')" id="ContentPlaceholderMain_tlgConferenceTracker_btnSearch" class="btnOCTTrackerSubmit octButtons" style="font-weight: bold; color: rgb(255, 255, 255); background-color: rgb(82, 55, 129); border-style: none;" type="button">
                <input name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$btnReset" value="Reset" onclick="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$btnReset','')" id="ContentPlaceholderMain_tlgConferenceTracker_btnReset" class="octButtons" style="font-weight: bold; color: rgb(255, 255, 255); background-color: rgb(82, 55, 129); border-style: none;" type="button">
            </td>
				</tr>
				
        <tr>
          
        </tr>
    </tbody></table>    
</div>


<!--
<div class="conferenceTracker" style="width: 110px;height: 20px;">
    <div style="width: 38px; height:16px; background-color:#ab9dc2;color: black;float: left;padding: 1px 0 0px 5px;"> </div>
    <div style="float:left;margin-left: 5px;height: 16px;padding-top: 1px;">High Impact</div>
</div>
-->




<table id="ContentPlaceholderMain_tlgConferenceTracker_theMessageDisplay_theMessageTable" class="MessageTable">
				</table>
				




<div id="centeredTable_id" class="centeredTable">
    <div style="display: block;" id="ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferencesPanel">
					<div tabindex="0" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences" class="RadGrid RadGrid_Larvol" enableajax="True" style="border-color: rgb(95, 73, 122); border-width: 2px; border-style: solid; width: 100%;">

					<table class="rgMasterTable" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00" style="width: 100%; table-layout: auto; empty-cells: show;" cellspacing="0">
	<colgroup>
		<col style="width: 470px;">
		<col style="width: 50px;">
		<col style="width: 180px;">
		<col style="width: 100px;">
		<col style="width: 35px;">
		<col style="width: 135px;">
		<col style="width: 115px;">
	</colgroup>
<thead>
		<tr class="rgCommandRow" style="height: 20px;">
			<td class="rgCommandCell" colspan="7"><table class="rgCommandTable" style="width: 100%;">
				<tbody><tr>
					<td align="left"></td><td align="right"></td>
				</tr>
			</tbody></table></td>
		</tr><tr>
			<th scope="col" class="rgHeader" style="font-weight: bold; text-align: left;"><a title="Click here to sort" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$ctl00','')">Conference Name</a></th><th scope="col" class="rgHeader" style="font-weight: bold; text-align: center;"><a title="Click here to sort" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$ctl01','')">Impact</a></th><th scope="col" class="rgHeader" style="font-weight: bold; text-align: left;"><a title="Click here to sort" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$ctl02','')">Location</a></th><th scope="col" class="rgHeader" style="font-weight: bold; text-align: left;"><a title="Click here to sort" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$ctl03','')">Date</a></th><th scope="col" class="rgHeader" style="font-weight: bold; text-align: left;"><a title="Click here to sort" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$ctl04','')">Year</a></th><th scope="col" class="rgHeader" style="font-weight: bold; text-align: center;">
                            <table id="Table1" style="width: 100%;" class="myTable" cellspacing="0">
                                <tbody><tr>
                                    <td colspan="2" align="center">
                                        <b style="text-decoration: underline;">Abstract Deadlines</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;">
                                        <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl02_ctl02_lblRegular" title="Sort by Regular" class="Button" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$lblRegular','')" style="font-weight: normal;">Regular</a></td>
                                    
                                    <td style="width: 50%;">
                                         <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl02_ctl02_lblLate" title="Sort by Late" class="Button" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$lblLate','')" style="font-weight: normal;">Late</a>
                                    </td>
                                </tr>
                            </tbody></table>
                          
                        </th><th scope="col" class="rgHeader" style="font-weight: bold; text-align: center;"><a title="Click here to sort" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl02$ctl02$ctl06','')">Abstracts</a></th>
		</tr>
	</thead><tfoot>
		<tr class="rgPager">
			<td colspan="7"><table style="width: 100%;" cellspacing="0">
				<tbody><tr>
					<td class="rgStatus"><div id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_statusPanel" style="visibility: hidden;">
						&nbsp;
					</div></td><td class="rgPagerCell NextPrevAndNumeric"><div class="rgWrap rgArrPart1">
						<input name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl02" value=" " onclick="return false;__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl02','')" title="First Page" class="rgPageFirst" type="button"> <input name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl03" value=" " onclick="return false;__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl03','')" title="Previous Page" class="rgPagePrev" type="button">
					</div><div class="rgWrap rgNumPart">
						<a onclick="return false;" class="rgCurrentPage" href="javascript:__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl05','')"><span>1</span></a>
					</div><div class="rgWrap rgArrPart2">
						<input name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl08" value=" " onclick="return false;__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl08','')" title="Next Page" class="rgPageNext" type="button">  <input name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl09" value=" " onclick="return false;__doPostBack('ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$ctl09','')" title="Last Page" class="rgPageLast" type="button">
					</div><div class="rgWrap rgAdvPart">
						<span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_ChangePageSizeLabel" class="rgPagerLabel">Page size:</span><div id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox" class="RadComboBox RadComboBox_Larvol" style="width: 52px;">
							<table summary="combobox" style="border-width: 0px; border-collapse: collapse;">
								<tbody><tr class="rcbReadOnly">
									<td style="width: 100%;" class="rcbInputCell rcbInputCellLeft"><input autocomplete="off" name="ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$PageSizeComboBox" class="rcbInput" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox_Input" value="100" readonly="readonly" type="text"></td>
									<td class="rcbArrowCell rcbArrowCellRight"><a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox_Arrow" style="overflow: hidden;display: block;position: relative;outline: none;">select</a></td>
								</tr>
							</tbody></table>
							<div class="rcbSlide" style="z-index: 6000;"><div id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox_DropDown" class="RadComboBoxDropDown RadComboBoxDropDown_Larvol " style="display: none;"><div class="rcbScroll rcbWidth" style="width: 100%;"><ul class="rcbList" style="list-style: none outside none; margin: 0px; padding: 0px;"><li class="rcbItem ">10</li><li class="rcbItem ">20</li><li class="rcbItem ">50</li><li class="rcbItem ">100</li></ul></div></div></div><input value="{&quot;logEntries&quot;:[],&quot;value&quot;:&quot;100&quot;,&quot;text&quot;:&quot;100&quot;,&quot;enabled&quot;:true}" autocomplete="off" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox_ClientState" name="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox_ClientState" type="hidden">
						</div>
					</div><div class="rgWrap rgInfoPart">
						 &nbsp;<strong>18</strong> items in <strong>1</strong> pages
					</div></td>
				</tr>
			</tbody></table></td>
		</tr>
	</tfoot><tbody>
	<tr class="rgRow  passDateConference " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__0" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.scripps.org/events/new-advances-in-inflammatory-bowel-disease" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl04_lnkConferenceName" target="_top" title="New Advances in Inflammatory Bowel Disease, 2012" class="conferenceLink">New Advances in Inflammatory Bowel Disease, 2012</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl04_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">La Jolla, CA, USA</td><td align="left">Sep 8-9</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl04_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow  passDateConference " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__1" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.escp.eu.com/vienna" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl06_lnkConferenceName" target="_top" title="7th Scientific and Annual Meeting of the European Society of Coloproctology" class="conferenceLink"><b>ESCP 2012 /</b> 7th Scientific and Annual Meeting of the European Society of Coloproctology</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl06_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">Vienna, Austria</td><td align="left">Sep 26-28</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl06_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow  passDateConference " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__2" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.jddw.jp/jddw2012/en/index.html" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl08_lnkConferenceName" target="_top" title="Japan Digestive Disease Week 2012" class="conferenceLink"><b>JDD 2012 /</b> Japan Digestive Disease Week 2012</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl08_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Kobe, Japan</td><td align="left">Oct 10-13</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl08_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow  oldNewConferenceSeparation" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__3" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.agw.org.au/" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl10_lnkConferenceName" target="_top" title="Australian Gastroenterology Week 2012" class="conferenceLink"><b>AGW 2012 /</b> Australian Gastroenterology Week 2012</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl10_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Adelaide, Australia</td><td align="left">Oct 16-19</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a href="http://onlinelibrary.wiley.com/doi/10.1111/jgh.2012.27.issue-s4/issuetoc" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl10_reportLink" target="_top">Released</a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__4" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.naspghan.org/wmspage.cfm?parm1=491" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl12_lnkConferenceName" target="_top" title="2012 NASPGHAN Annual Meeting &amp; Postgraduate Course" class="conferenceLink"><b>NASPGHAN 2012 /</b> 2012 NASPGHAN Annual Meeting &amp; Postgraduate Course</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl12_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Salt Lake City, UT, USA</td><td align="left">Oct 18-21</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a href="http://www.naspghan.org/wmspage.cfm?parm1=723" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl12_reportLink" target="_top"><span style="color: red;">Released</span></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__5" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://acgmeetings.gi.org/" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl14_lnkConferenceName" target="_top" title="American College of Gastroenterology 2012, Annual Meeting and Postgraduate Course" class="conferenceLink"><b>ACG 2012 /</b> American College of Gastroenterology 2012, Annual Meeting and Postgraduate Course</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl14_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">Las Vegas, NV, USA</td><td align="left">Oct 19-24</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a href="http://www.eventscribe.com/2012/acg/aaSearchByPosterDaySession.asp" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl14_reportLink" target="_top"><span style="color: red;">Released</span></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__6" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://uegw12.uegf.org/" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl16_lnkConferenceName" target="_top" title="20th United European Gastroenterology Week 2012" class="conferenceLink"><b>UEGW 2012 /</b> 20th United European Gastroenterology Week 2012</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl16_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">Amsterdam, The Netherlands</td><td align="left">Oct 20-24</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a href="http://tinyurl.com/8fnez8v" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl16_reportLink" target="_top"><span style="color: red;">Released</span></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__7" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.wcpghan2012.com/Guideline.php" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl18_lnkConferenceName" target="_top" title="4th World Congress of Pediatric Gastroenterology, Hepatology and Nutrition" class="conferenceLink"><b>WCPGHAN 2012 /</b> 4th World Congress of Pediatric Gastroenterology, Hepatology and Nutrition</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl18_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Taipei, Taiwan</td><td align="left">Nov 14-18</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl18_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__8" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.iasgo2012.org/main/design/1/1" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl20_lnkConferenceName" target="_top" title="22nd World Congress of the International Association of Surgeons, Gastroenterologists and Oncologists 2012" class="conferenceLink"><b>IASGO 2012 /</b> 22nd World Congress of the International Association of Surgeons, Gastroenterologists and Oncologists 2012</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl20_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Bangkok, Thailand</td><td align="left">Dec 5-8</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl20_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__9" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.advancesinibd.com/2012/index.asp" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl22_lnkConferenceName" target="_top" title="Advances in Inflammatory Bowel Diseases, Crohn�s &amp; Colitis Foundation�s Clinical &amp; Research Conference" class="conferenceLink">Advances in Inflammatory Bowel Diseases, Crohn�s &amp; Colitis Foundation�s Clinical &amp; Research Conference</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl22_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Hollywood, FL, USA</td><td align="left">Dec 13-15</td><td align="left">2012</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        Closed
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl22_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__10" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://https//www.ecco-ibd.eu/" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl24_lnkConferenceName" target="_top" title="8th Congress of ECCO-Inflammatory Bowel Diseases 2013" class="conferenceLink"><b>ECCO-IBD 2013 /</b> 8th Congress of ECCO-Inflammatory Bowel Diseases 2013</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl24_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">Vienna, Austria</td><td align="left">Feb 14-16</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        11/05/12
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        12/07/12
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl24_reportLink" target="_blank">2nd week of Feb</a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__11" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.belgianweek.be/BelgianWeek_WEB/UK/Home.awp" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl26_lnkConferenceName" target="_top" title="Belgian Week of Gastroenterology 25th Meeting" class="conferenceLink"><b>BWG 2013 /</b> Belgian Week of Gastroenterology 25th Meeting</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl26_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Antwerp, Belgium</td><td align="left">Feb 28-Mar 2</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        12/01/12
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl26_reportLink" target="_blank">1st week of Mar</a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__12" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.cag-acg.org/program-and-registration" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl28_lnkConferenceName" target="_top" title="Canadian Digestive Diseases Week 2013" class="conferenceLink"><b>CDDW 2013 /</b> Canadian Digestive Diseases Week 2013</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl28_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Victoria, Canada</td><td align="left">Mar 1-4</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        10/15/12
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl28_reportLink" target="_blank">1st week of Jan</a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__13" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.fascrs.org/annual_meeting/" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl30_lnkConferenceName" target="_top" title="2013 Annual Meeting of the American Society of Colon and Rectal Surgeons" class="conferenceLink"><b>ASCRS 2013 /</b> 2013 Annual Meeting of the American Society of Colon and Rectal Surgeons</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl30_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Phoenix, AZ, USA</td><td align="left">Apr 27-May 1</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        11/21/12
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl30_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__14" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.ddw.org/" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl32_lnkConferenceName" target="_top" title="2013 Digestive Disease Week" class="conferenceLink"><b>DDW 2013 /</b> 2013 Digestive Disease Week</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl32_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">Orlando, FL, USA</td><td align="left">May 18-21</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        12/01/12
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl32_reportLink" target="_blank">4th week of Apr</a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__15" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.bsg.org.uk/events/bsg-annual-meeting-2013.html" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl34_lnkConferenceName" target="_top" title="British Society of Gastroenterology Annual Meeting 2013" class="conferenceLink"><b>BSG 2013 /</b> British Society of Gastroenterology Annual Meeting 2013</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl34_lblImpact" style="font-weight: bold;"></span>
                        </td><td align="left">Glasgow, Scotland</td><td align="left">Jun 24-27</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl34_reportLink" target="_blank">1st week of Jun</a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__16" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://www.escp.eu.com/site/main/news/latest-news/article/escp-belgrade-2013-first-announcement" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl36_lnkConferenceName" target="_top" title="8th Scientific and Annual Meeting of the European Society of Coloproctology" class="conferenceLink"><b>ESCP 2013 /</b> 8th Scientific and Annual Meeting of the European Society of Coloproctology&nbsp;<span style="color: red;">(New)</span></a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl36_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">Belgrade, Serbia</td><td align="left">Sep 25-27</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        05/10/13
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl36_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr><tr class="rgAltRow " id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00__17" style="text-align: left;">
		<td align="left"><div class="conferenceNameCellContainer"><a href="http://gi.org/education-and-meetings/acg-annual-meeting-and-postgraduate-course/" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl38_lnkConferenceName" target="_top" title="American College of Gastroenterology Annual Meeting and Postgraduate Course" class="conferenceLink"><b>ACG 2013 /</b> American College of Gastroenterology Annual Meeting and Postgraduate Course</a></div></td><td align="center">
                            <span id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl38_lblImpact" style="font-weight: bold;">High</span>
                        </td><td align="left">San Diego, CA, USA</td><td align="left">Oct 11-16</td><td align="left">2013</td><td align="center">
                            <table class="myTable" cellspacing="0" width="100%">
                                <tbody><tr>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                        
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        -
                                    </td>
                                </tr>
                            </tbody></table>
                        </td><td align="center">
                                    <div style="width: 50%; text-align: center;">
                                           <a id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl38_reportLink" target="_blank"></a>
                                           
                                    </div>
                        </td>
	</tr>
	</tbody>

</table><input autocomplete="off" id="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ClientState" name="ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ClientState" type="hidden">
						</div>

				</div>
</div>



<script type="text/javascript">


    function createTooltips() {
      //  $('.conferenceLink').tooltip({ effect: 'slide', predelay: 500, delay: 50, offset: [10, 0] });
       // $('.tipBody *').css('color', 'white');
    }

	var deviceAgent = navigator.userAgent.toLowerCase();
	var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
    if (agentID) {
	 document.getElementById("centeredTable_id").className+=" class-ipad"
   	}

    function refreshGrid(arg) {


        if(!arg)
        {

            __doPostBack("ContentPlaceholderMain_tlgConferenceTracker_rgConferences", "Rebind");   
       
        }
        else
        {
            window["ContentPlaceholderMain_tlgConferenceTracker_RadAjaxManagerProxy1"].ajaxRequest("RebindAndNavigate");
        }
        
    } 

//-->
</script>




    
    <script type="text/javascript">
        loading=false;
        
        function OnKeyPress(sender, eventArgs) {

           var c = eventArgs.get_keyCode();
           if (c == 13) {

                eventArgs.cancelBubble = true;
                eventArgs.returnValue = false;
                if (eventArgs.preventDefault) eventArgs.preventDefault();
                if (eventArgs.stopPropagation) eventArgs.stopPropagation();
                eventArgs.set_cancel(true);
            }     
            
        } 

    </script>
    

            
			</div>
		</div>
            <div id="ContentPlaceholderMain_RadAjaxLoadingPanel3" class="RadAjax RadAjax_Larvol" style="display: none; padding: 25px 0px 0px;">
			<div class="raDiv raTop">
				
            
			</div><div class="raColor raTransp">

			</div>
		</div>
            
        
	</div>
	<div id="ContentPlaceholderMain_rpvTrialTracker" class="" style="height: 100%; display: block;">
		
            <iframe id="ContentPlaceholderMain_iframeLarvolTracker" style="border: 0px none; margin: 0px; padding: 0px; height: 407px;" src="<? echo $tmpfname; ?>" frameborder="0" height="50" width="100%"></iframe>
        
	</div><div id="ContentPlaceholderMain_http://larvoltrials.com/online_heatmap.php?id=179" class="rmpHiddenView">

	</div><input value="{&quot;selectedIndex&quot;:3,&quot;changeLog&quot;:[]}" autocomplete="off" id="ContentPlaceholderMain_rtsCRTabsPages_ClientState" name="ContentPlaceholderMain_rtsCRTabsPages_ClientState" type="hidden">
</div>
    
    

    


    <script type="text/javascript">
    
    
            var selectedTab = 0;
        function OnSelected(sender, args)
        {
            selectedTab = (sender.get_selectedTab().get_index());
        }
   
   
    document.onkeyup = KeyCheck;   
    var loading = false;
    function KeyCheck(e)
    {
       var KeyID = (window.event) ? event.keyCode : e.keyCode;
       switch(KeyID)
       {
         
          case 13:
          if(loading) return;
          if(selectedTab==0)
          {
             $(".btnSubmitNewsTracker").click();
             loading = true;
          }
          if(selectedTab==1)
          {
             $(".btnOCTTrackerSubmit").click();
             loading = true;
          }

          
          break;
       }
       return false;
    }
    
    function fixIframeHeight()
    {
        var height = $(window).height() - $("#topBg").height() - 130 - $(".RunningEnvironmentHeader").height();
        $(".heatmapIframe").css("height", height);
    }

    var iFrameId = 'ContentPlaceholderMain_iframeLarvolTracker';
    var label;
    var height = $(window).height() - $("#topBg").height() - 130 - $(".RunningEnvironmentHeader").height();
    $("#" + iFrameId).css("height", height);
    
    $(window).resize(function() {
        var height = $(window).height() - $("#topBg").height() - 130 - $(".RunningEnvironmentHeader").height();
        $("#" + iFrameId).css("height", height);
        $(".heatmapIframe").css("height", height);
    });
    var height = $(window).height() - $("#topBg").height() - 130 - $(".RunningEnvironmentHeader").height();
    $("#" + iFrameId).css("height", height);

    $(function () {
        //var exportToWordLeft = $(".imgKeywordSearchInfo").offset().left+40;


        
       


    });   
 
    
</script>

<!--[if IE]>
<script type="text/javascript">

    var heatmapHeight = $(".heatmapIframe").height();

    $(".heatmapIframe").css("height", heatmapHeight - 20);
    
    var iFrameId = 'ContentPlaceholderMain_iframeLarvolTracker';
    
    var height = $(window).height() - $("#topBg").height() - 150 - $(".RunningEnvironmentHeader").height();
    
    $("#" + iFrameId).css("height", height);

</script>
<![endif]-->






    
    <script type="text/javascript">
        loading=false;
    </script>
    





        		    
	            </div><!-- // class="padMainContentBottomOnly" -->
	            
            </div><!-- // id="singleColumnMain" -->
        <img id="liCookie_imgLTCookie" src="b.php">	
        </div><!-- // id="wrapper" -->
        
        

<script type="text/javascript">
//<![CDATA[
fixIframeHeight();setTimeout(function(){$('.htmltooltip').tooltip({effect: 'slide',delay: 50,offset: [10, 0],position:'top right'});}, 0);setTimeout(function(){$('.imgKeywordSearchInfo').tooltip({effect: 'slide',delay: 50,offset: [240, 0],position:'top left'});}, 0);setTimeout(function(){$('.commenttooltip').tooltip({ effect: 'slide', delay: 50, offset: [10, 0],position:'top left', onBeforeShow: loadComments });}, 0);setTimeout(function(){$('.tipBody *').css('color', 'white')}, 0);setTimeout(function(){createTooltips();}, 0);Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadAjaxManager, {"_updatePanels":"","ajaxSettings":[{InitControlID : "ContentPlaceholderMain_tlgConferenceTracker_rgConferences",UpdatedControls : [{ControlID:"ContentPlaceholderMain_tlgConferenceTracker_rgConferences",PanelID:""}]}],"clientEvents":{OnRequestStart:"",OnResponseEnd:""},"defaultLoadingPanelID":"","enableAJAX":true,"enableHistory":false,"links":[],"styles":[],"uniqueID":"ctl00$RadAjaxManager1","updatePanelsRenderMode":0}, null, null, $get("RadAjaxManager1"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadMenu, {"_childListElementCssClass":null,"_skin":"Larvol","attributes":{},"clientStateFieldID":"theHeader_TopNav_rmClientNav_ClientState","collapseAnimation":"{\"duration\":450}","expandAnimation":"{\"duration\":450}","itemData":[]}, null, null, $get("theHeader_TopNav_rmClientNav"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadTabStrip, {"_selectedIndex":0,"_skin":"Default","attributes":{},"clientStateFieldID":"ContentPlaceholderMain_rtsCRTabsTabs_ClientState","multiPageID":"ContentPlaceholderMain_rtsCRTabsPages","selectedIndexes":["0"],"tabData":[{"_implPageViewID":"ContentPlaceholderMain_rpvCR"},{"value":"OCT","_implPageViewID":"ContentPlaceholderMain_rpvOCT"},{"value":"LarvolTracker","_implPageViewID":"ContentPlaceholderMain_rpvTrialTracker"},{"_implPageViewID":"ContentPlaceholderMain_http://larvoltrials.com/online_heatmap.php?id=179"}]}, {"tabSelected":OnSelected}, null, $get("ContentPlaceholderMain_rtsCRTabsTabs"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadDateInput, {"_focused":false,"_originalValue":"","_postBackEventReferenceScript":"__doPostBack(\u0027ctl00$ContentPlaceholderMain$theMainContent$theStartDate\u0027,\u0027\u0027)","_skin":"Default","clientStateFieldID":"ContentPlaceholderMain_theMainContent_theStartDate_dateInput_ClientState","dateFormat":"M/d/yyyy","dateFormatInfo":{"DayNames":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"MonthNames":["January","February","March","April","May","June","July","August","September","October","November","December",""],"AbbreviatedDayNames":["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],"AbbreviatedMonthNames":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",""],"AMDesignator":"AM","PMDesignator":"PM","DateSeparator":"/","TimeSeparator":":","FirstDayOfWeek":0,"DateSlots":{"Month":0,"Day":1,"Year":2},"ShortYearCenturyEnd":2029,"TimeInputOnly":false},"displayDateFormat":"M/d/yyyy","enabled":true,"incrementSettings":{InterceptArrowKeys:true,InterceptMouseWheel:true,Step:1},"styles":{HoveredStyle: ["width:100%;", "riTextBox riHover"],InvalidStyle: ["width:100%;", "riTextBox riError"],DisabledStyle: ["width:100%;", "riTextBox riDisabled"],FocusedStyle: ["width:100%;", "riTextBox riFocused"],EmptyMessageStyle: ["width:100%;", "riTextBox riEmpty"],ReadOnlyStyle: ["width:100%;", "riTextBox riRead"],EnabledStyle: ["width:100%;", "riTextBox riEnabled"]}}, {"keyPress":OnKeyPressEnter}, null, $get("ContentPlaceholderMain_theMainContent_theStartDate_dateInput"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadCalendar, {"_DayRenderChangedDays":{},"_FormatInfoArray":[["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],["January","February","March","April","May","June","July","August","September","October","November","December",""],["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",""],"dddd, MMMM dd, yyyy h:mm:ss tt","dddd, MMMM dd, yyyy","h:mm:ss tt","MMMM dd","ddd, dd MMM yyyy HH\u0027:\u0027mm\u0027:\u0027ss \u0027GMT\u0027","M/d/yyyy","h:mm tt","yyyy\u0027-\u0027MM\u0027-\u0027dd\u0027T\u0027HH\u0027:\u0027mm\u0027:\u0027ss","yyyy\u0027-\u0027MM\u0027-\u0027dd HH\u0027:\u0027mm\u0027:\u0027ss\u0027Z\u0027","MMMM, yyyy","AM","PM","/",":",0],"_ViewRepeatableDays":{},"_ViewsHash":{"ContentPlaceholderMain_theMainContent_theStartDate_calendar_Top" : [[2012,10,1], 1]},"_calendarWeekRule":0,"_culture":"en-US","_enableKeyboardNavigation":false,"_enableViewSelector":false,"_firstDayOfWeek":7,"_postBackCall":"__doPostBack(\u0027ctl00$ContentPlaceholderMain$theMainContent$theStartDate$calendar\u0027,\u0027@@\u0027)","clientStateFieldID":"ContentPlaceholderMain_theMainContent_theStartDate_calendar_ClientState","enableMultiSelect":false,"enabled":true,"monthYearNavigationSettings":["Today","OK","Cancel","Date is out of range.","False","True","300","1","300","1"],"skin":"Default","specialDaysArray":[],"stylesHash":{"DayStyle": ["", ""],"CalendarTableStyle": ["", "rcMainTable"],"OtherMonthDayStyle": ["", "rcOtherMonth"],"TitleStyle": ["", ""],"SelectedDayStyle": ["", "rcSelected"],"SelectorStyle": ["", ""],"DisabledDayStyle": ["", "rcDisabled"],"OutOfRangeDayStyle": ["", "rcOutOfRange"],"WeekendDayStyle": ["", "rcWeekend"],"DayOverStyle": ["", "rcHover"],"FastNavigationStyle": ["", "RadCalendarMonthView RadCalendarMonthView_Default"],"ViewSelectorStyle": ["", "rcViewSel"]},"useColumnHeadersAsSelectors":false,"useRowHeadersAsSelectors":false}, null, null, $get("ContentPlaceholderMain_theMainContent_theStartDate_calendar"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadDatePicker, {"_PopupButtonSettings":{ ResolvedImageUrl : "", ResolvedHoverImageUrl : ""},"_animationSettings":{ShowAnimationDuration:300,ShowAnimationType:1,HideAnimationDuration:300,HideAnimationType:1},"_popupControlID":"ContentPlaceholderMain_theMainContent_theStartDate_popupButton","clientStateFieldID":"ContentPlaceholderMain_theMainContent_theStartDate_ClientState","focusedDate":"2012-10-15-00-00-00"}, null, {"calendar":"ContentPlaceholderMain_theMainContent_theStartDate_calendar","dateInput":"ContentPlaceholderMain_theMainContent_theStartDate_dateInput"}, $get("ContentPlaceholderMain_theMainContent_theStartDate"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadDateInput, {"_focused":false,"_originalValue":"","_postBackEventReferenceScript":"__doPostBack(\u0027ctl00$ContentPlaceholderMain$theMainContent$theEndDate\u0027,\u0027\u0027)","_skin":"Default","clientStateFieldID":"ContentPlaceholderMain_theMainContent_theEndDate_dateInput_ClientState","dateFormat":"M/d/yyyy","dateFormatInfo":{"DayNames":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"MonthNames":["January","February","March","April","May","June","July","August","September","October","November","December",""],"AbbreviatedDayNames":["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],"AbbreviatedMonthNames":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",""],"AMDesignator":"AM","PMDesignator":"PM","DateSeparator":"/","TimeSeparator":":","FirstDayOfWeek":0,"DateSlots":{"Month":0,"Day":1,"Year":2},"ShortYearCenturyEnd":2029,"TimeInputOnly":false},"displayDateFormat":"M/d/yyyy","enabled":true,"incrementSettings":{InterceptArrowKeys:true,InterceptMouseWheel:true,Step:1},"styles":{HoveredStyle: ["width:100%;", "riTextBox riHover"],InvalidStyle: ["width:100%;", "riTextBox riError"],DisabledStyle: ["width:100%;", "riTextBox riDisabled"],FocusedStyle: ["width:100%;", "riTextBox riFocused"],EmptyMessageStyle: ["width:100%;", "riTextBox riEmpty"],ReadOnlyStyle: ["width:100%;", "riTextBox riRead"],EnabledStyle: ["width:100%;", "riTextBox riEnabled"]}}, {"keyPress":OnKeyPressEnter}, null, $get("ContentPlaceholderMain_theMainContent_theEndDate_dateInput"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadCalendar, {"_DayRenderChangedDays":{},"_FormatInfoArray":[["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],["January","February","March","April","May","June","July","August","September","October","November","December",""],["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec",""],"dddd, MMMM dd, yyyy h:mm:ss tt","dddd, MMMM dd, yyyy","h:mm:ss tt","MMMM dd","ddd, dd MMM yyyy HH\u0027:\u0027mm\u0027:\u0027ss \u0027GMT\u0027","M/d/yyyy","h:mm tt","yyyy\u0027-\u0027MM\u0027-\u0027dd\u0027T\u0027HH\u0027:\u0027mm\u0027:\u0027ss","yyyy\u0027-\u0027MM\u0027-\u0027dd HH\u0027:\u0027mm\u0027:\u0027ss\u0027Z\u0027","MMMM, yyyy","AM","PM","/",":",0],"_ViewRepeatableDays":{},"_ViewsHash":{"ContentPlaceholderMain_theMainContent_theEndDate_calendar_Top" : [[2012,10,1], 1]},"_calendarWeekRule":0,"_culture":"en-US","_enableKeyboardNavigation":false,"_enableViewSelector":false,"_firstDayOfWeek":7,"_postBackCall":"__doPostBack(\u0027ctl00$ContentPlaceholderMain$theMainContent$theEndDate$calendar\u0027,\u0027@@\u0027)","clientStateFieldID":"ContentPlaceholderMain_theMainContent_theEndDate_calendar_ClientState","enableMultiSelect":false,"enabled":true,"monthYearNavigationSettings":["Today","OK","Cancel","Date is out of range.","False","True","300","1","300","1"],"skin":"Default","specialDaysArray":[],"stylesHash":{"DayStyle": ["", ""],"CalendarTableStyle": ["", "rcMainTable"],"OtherMonthDayStyle": ["", "rcOtherMonth"],"TitleStyle": ["", ""],"SelectedDayStyle": ["", "rcSelected"],"SelectorStyle": ["", ""],"DisabledDayStyle": ["", "rcDisabled"],"OutOfRangeDayStyle": ["", "rcOutOfRange"],"WeekendDayStyle": ["", "rcWeekend"],"DayOverStyle": ["", "rcHover"],"FastNavigationStyle": ["", "RadCalendarMonthView RadCalendarMonthView_Default"],"ViewSelectorStyle": ["", "rcViewSel"]},"useColumnHeadersAsSelectors":false,"useRowHeadersAsSelectors":false}, null, null, $get("ContentPlaceholderMain_theMainContent_theEndDate_calendar"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadDatePicker, {"_PopupButtonSettings":{ ResolvedImageUrl : "", ResolvedHoverImageUrl : ""},"_animationSettings":{ShowAnimationDuration:300,ShowAnimationType:1,HideAnimationDuration:300,HideAnimationType:1},"_popupControlID":"ContentPlaceholderMain_theMainContent_theEndDate_popupButton","clientStateFieldID":"ContentPlaceholderMain_theMainContent_theEndDate_ClientState","focusedDate":"2012-10-15-00-00-00"}, null, {"calendar":"ContentPlaceholderMain_theMainContent_theEndDate_calendar","dateInput":"ContentPlaceholderMain_theMainContent_theEndDate_dateInput"}, $get("ContentPlaceholderMain_theMainContent_theEndDate"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadSlider, {"_height":"35px","_skin":"Default","_uniqueID":"ctl00$ContentPlaceholderMain$theMainContent$ddlAdvancedHighlightStatus","_width":"300px","clientStateFieldID":"ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus_ClientState","itemData":[{"text":"1","value":"1"},{"text":"2","value":"2"},{"text":"3","value":"3"},{"text":"4","value":"4"},{"text":"5","value":"5"},{"text":"6","value":"6"},{"text":"7","value":"7"},{"text":"8","value":"8"},{"text":"9","value":"9"},{"text":"10","value":"10"}],"itemType":2,"maximumValue":20,"trackPosition":2}, null, null, $get("ContentPlaceholderMain_theMainContent_ddlAdvancedHighlightStatus"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadTextBox, {"_focused":false,"_postBackEventReferenceScript":"setTimeout(\"__doPostBack(\\\u0027ctl00$ContentPlaceholderMain$theMainContent$rcbTextSearch\\\u0027,\\\u0027\\\u0027)\", 0)","_skin":"Default","clientStateFieldID":"ContentPlaceholderMain_theMainContent_rcbTextSearch_ClientState","emptyMessage":"Search by keyword or phrase, e.g., Avastin","enabled":true,"styles":{HoveredStyle: ["width:270px;margin-top:0px;", "riTextBox riHover"],InvalidStyle: ["width:270px;margin-top:0px;", "riTextBox riError"],DisabledStyle: ["width:270px;margin-top:0px;", "riTextBox riDisabled"],FocusedStyle: ["width:270px;margin-top:0px;", "riTextBox riFocused"],EmptyMessageStyle: ["width:270px;margin-top:0px;", "riTextBox riEmpty"],ReadOnlyStyle: ["width:270px;margin-top:0px;", "riTextBox riRead"],EnabledStyle: ["width:270px;margin-top:0px;", "riTextBox riEnabled"]}}, {"keyPress":OnKeyPressEnter}, null, $get("ContentPlaceholderMain_theMainContent_rcbTextSearch"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadAjaxPanel, {"clientEvents":{OnRequestStart:"",OnResponseEnd:""},"enableAJAX":true,"enableHistory":false,"links":[],"loadingPanelID":"ContentPlaceholderMain_RadAjaxLoadingPanel1","styles":[],"uniqueID":"ctl00$ContentPlaceholderMain$pnlLogin"}, null, null, $get("ContentPlaceholderMain_pnlLogin"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadAjaxLoadingPanel, {"initialDelayTime":0,"isSticky":false,"minDisplayTime":0,"skin":"Larvol","transparency":0,"uniqueID":"ctl00$ContentPlaceholderMain$RadAjaxLoadingPanel1","zIndex":90000}, null, null, $get("ContentPlaceholderMain_RadAjaxLoadingPanel1"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadTextBox, {"_focused":false,"_postBackEventReferenceScript":"setTimeout(\"__doPostBack(\\\u0027ctl00$ContentPlaceholderMain$tlgConferenceTracker$rcbConferenceNameFilter\\\u0027,\\\u0027\\\u0027)\", 0)","_skin":"Default","clientStateFieldID":"ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter_ClientState","emptyMessage":"Search...","enabled":true,"styles":{HoveredStyle: ["width:350px;color:#333;", "riTextBox riHover"],InvalidStyle: ["width:350px;color:#333;", "riTextBox riError"],DisabledStyle: ["width:350px;color:#333;", "riTextBox riDisabled"],FocusedStyle: ["width:350px;color:#333;", "riTextBox riFocused"],EmptyMessageStyle: ["width:350px;color:#333;", "riTextBox riEmpty"],ReadOnlyStyle: ["width:350px;color:#333;", "riTextBox riRead"],EnabledStyle: ["width:350px;color:#333;", "riTextBox riEnabled"]}}, {"keyPress":OnKeyPress}, null, $get("ContentPlaceholderMain_tlgConferenceTracker_rcbConferenceNameFilter"));
});

WebForm_InitCallback();Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadComboBox, {"_dropDownWidth":0,"_height":0,"_skin":"Larvol","_text":"100","_uniqueId":"ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00$ctl03$ctl01$PageSizeComboBox","_value":"100","clientStateFieldID":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox_ClientState","collapseAnimation":"{\"duration\":450}","expandAnimation":"{\"duration\":450}","itemData":[{"value":"10","attributes":{"ownerTableViewId":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00"}},{"value":"20","attributes":{"ownerTableViewId":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00"}},{"value":"50","attributes":{"ownerTableViewId":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00"}},{"value":"100","selected":true,"attributes":{"ownerTableViewId":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00"}}],"selectedIndex":3}, {"selectedIndexChanged":Telerik.Web.UI.Grid.ChangePageSizeComboHandler}, null, $get("ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_PageSizeComboBox"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadGrid, {"ClientID":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences","ClientSettings":{"AllowAutoScrollOnDragDrop":true,"ShouldCreateRows":true,"DataBinding":{},"Selecting":{},"Scrolling":{},"Resizing":{},"ClientMessages":{},"KeyboardNavigationSettings":{"AllowActiveRowCycle":false,"EnableKeyboardShortcuts":true,"FocusKey":89,"InitInsertKey":73,"RebindKey":82,"ExitEditInsertModeKey":27,"UpdateInsertItemKey":13,"DeleteActiveRow":127},"Animation":{}},"Skin":"Larvol","UniqueID":"ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences","_activeRowIndex":"","_controlToFocus":"","_currentPageIndex":0,"_editIndexes":"[]","_embeddedSkin":false,"_gridTableViewsData":"[{\"ClientID\":\"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00\",\"UniqueID\":\"ctl00$ContentPlaceholderMain$tlgConferenceTracker$rgConferences$ctl00\",\"PageSize\":100,\"PageCount\":1,\"EditMode\":\"EditForms\",\"CurrentPageIndex\":0,\"VirtualItemCount\":0,\"AllowMultiColumnSorting\":false,\"AllowNaturalSort\":true,\"AllowFilteringByColumn\":false,\"IsItemInserted\":false,\"clientDataKeyNames\":[],\"_dataBindTemplates\":false,\"_selectedItemStyle\":\"\",\"_selectedItemStyleClass\":\"rgSelectedRow\",\"_columnsData\":[{\"UniqueName\":\"ConferenceName\",\"Resizable\":true,\"Reorderable\":true,\"Groupable\":true,\"ColumnType\":\"GridTemplateColumn\",\"Display\":true},{\"UniqueName\":\"impact_flag\",\"Resizable\":true,\"Reorderable\":true,\"Groupable\":true,\"ColumnType\":\"GridTemplateColumn\",\"Display\":true},{\"UniqueName\":\"location\",\"Resizable\":true,\"Reorderable\":true,\"Groupable\":true,\"ColumnType\":\"GridBoundColumn\",\"Display\":true},{\"UniqueName\":\"date\",\"Resizable\":true,\"Reorderable\":true,\"Groupable\":true,\"ColumnType\":\"GridBoundColumn\",\"Display\":true},{\"UniqueName\":\"year\",\"Resizable\":true,\"Reorderable\":true,\"Groupable\":true,\"ColumnType\":\"GridBoundColumn\",\"Display\":true},{\"UniqueName\":\"TemplateColumn\",\"Resizable\":true,\"Reorderable\":true,\"Groupable\":true,\"ColumnType\":\"GridTemplateColumn\",\"Display\":true},{\"UniqueName\":\"abstractOptions\",\"Resizable\":true,\"Reorderable\":true,\"Groupable\":true,\"ColumnType\":\"GridTemplateColumn\",\"Display\":true}]}]","_loadingText":"Loading...","_masterClientID":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00","_readyText":"Ready","_shouldFocusOnPage":false,"_statusLabelID":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ctl00_ctl03_ctl01_statusPanel","allowMultiRowSelection":false,"clientStateFieldID":"ContentPlaceholderMain_tlgConferenceTracker_rgConferences_ClientState"}, null, null, $get("ContentPlaceholderMain_tlgConferenceTracker_rgConferences"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadAjaxPanel, {"clientEvents":{OnRequestStart:"",OnResponseEnd:""},"enableAJAX":true,"enableHistory":false,"links":[],"loadingPanelID":"ContentPlaceholderMain_RadAjaxLoadingPanel1","styles":[],"uniqueID":"ctl00$ContentPlaceholderMain$RadAjaxPanel1"}, null, null, $get("ContentPlaceholderMain_RadAjaxPanel1"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadAjaxLoadingPanel, {"initialDelayTime":0,"isSticky":false,"minDisplayTime":0,"skin":"Larvol","transparency":0,"uniqueID":"ctl00$ContentPlaceholderMain$RadAjaxLoadingPanel3","zIndex":90000}, null, null, $get("ContentPlaceholderMain_RadAjaxLoadingPanel3"));
});
Sys.Application.add_init(function() {
    $create(Telerik.Web.UI.RadMultiPage, {"clientStateFieldID":"ContentPlaceholderMain_rtsCRTabsPages_ClientState","pageViewData":[{"id":"ContentPlaceholderMain_rpvCR"},{"id":"ContentPlaceholderMain_rpvFinancialAnaystNews"},{"id":"ContentPlaceholderMain_rpvOCT"},{"id":"ContentPlaceholderMain_rpvTrialTracker"},{"id":"ContentPlaceholderMain_http://larvoltrials.com/online_heatmap.php?id=179"}],"selectedIndex":0}, null, null, $get("ContentPlaceholderMain_rtsCRTabsPages"));
});
//]]>
</script>
</form>
        
    
    


<div style="display: none;" id="radControlsElementContainer"></div></body>
</html>
