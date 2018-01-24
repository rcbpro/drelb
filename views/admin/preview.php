<?php 
	session_start();
	if (isset($_SESSION['adminMovAdd'])){ 
		$_SESSION['preview']['Title'] = $_SESSION['adminMovAdd']['movie_Title'];
		$_SESSION['preview']['Description'] = $_SESSION['adminMovAdd']['movie_description'];		
		$_SESSION['preview']['Genre'] = $_SESSION['adminMovAdd']['movie_genre'];
		unset($_SESSION['adminMovAdd']);		
		header("Refresh: 1; url=http://{$_SERVER['HTTP_HOST']}/drelb/views/admin/preview.php");																
	}	
	if (isset($_SESSION['adminEdit'])){ 
		$_SESSION['preview']['Title'] = $_SESSION['adminEdit']['movie_Title'];
		$_SESSION['preview']['Description'] = $_SESSION['adminEdit']['movie_description'];		
		$_SESSION['preview']['Genre'] = $_SESSION['adminEdit']['movie_genre'];
		//unset($_SESSION['adminEdit']);		
		header("Refresh: 2; url=http://{$_SERVER['HTTP_HOST']}/drelb/views/admin/preview.php");																
	}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Preview Page</title>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/public/stylesheets/admin.css" type="text/css" />
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/public/stylesheets/styles.css" type="text/css" />
</head>
<body>
<div style="width:400px; height:40px;"><!-- --></div>
<table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="con-up"></td>
      </tr>
      <tr>
        <td align="center" valign="top" class="con-middle">&nbsp;</td>
      </tr>                  
    <tr>
        <td align="center" valign="top" class="con-middle">
            <table width="513" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="30">&nbsp;</td>
            <td width="468"><table width="468" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top"><div class="thumbnails">
                   <ul>
                        <span style="font-size:12px; color:#06f;">Movie : </span><span class="mov_title" id="movieName"><?php echo @$_SESSION['preview']['Title'];?></span><br /><br />
                  </ul>
                </div></td>
              </tr>
              <tr>
                <td align="center" valign="top">
                                    <img src="<?php echo $_SESSION['preview_image_path'];?>" class="mov_large_img" style="margin-left:-10px;" />
                                    <br /><br />                                
                                    <span style="font-size:12px; color:#06f;">Genre : </span><span class="mov_title" id="movieGenre"><?php echo @$_SESSION['preview']['Genre'];?></span>                                                              
                </td>
              </tr>                          
              <tr>
                <td align="center" valign="top">&nbsp;</td>
              </tr>                                                                              
              <tr>
                <td align="center" valign="top" style="text-align:left;">
                    <span style="font-size:12px; color:#06f;">Description : </span><br /><span class="mov_title" id="movieDescription" style="color:#000000 !important;"><?php echo @$_SESSION['preview']['Description'];?></span><br /><br />                                                                                          
                </td>
              </tr>  
              <tr>
                <td align="center" valign="top">&nbsp;</td>
              </tr> 
              <tr>
                <td align="center" valign="top">
                </td>
              </tr>        
              <tr>
                <td align="center" valign="top" class="mov_title" style="color:#f00;">
                </td>
              </tr>                                                                                                   
              <tr>
                <td align="center" valign="top">&nbsp;</td>
              </tr>                                                                                                                             
              <tr>
                <td align="center" valign="top">&nbsp;</td>
              </tr>                                                                         
              <tr>
                <td align="center" valign="top"><a href="#" onclick="javascript:window.close()" class="popupWindowCloseLink">Close</a></td>                          
              </tr>                                                                                            
            </table></td>
            <td width="15">&nbsp;</td>
          </tr>
        </table>
        </td>
        </tr>
      <tr>
        <td class="con-down">&nbsp;</td>
      </tr>                    
</table>      
</body>
</html>