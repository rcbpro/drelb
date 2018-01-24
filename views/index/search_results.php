<tr>
    <td class="con-up"></td>
  </tr>
  <tr>
    <td align="center" valign="top" class="con-middle">&nbsp;</td>
  </tr>                                    
  <tr>
    <td align="center" valign="top" class="con-middle">
        <?php if ($current_page <= $totPages):?>                    
            <span style="color:#06f; font-size:12px;"><?php echo $page_message;?></span>
        <?php endif;?>    
    </td>
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
            <td align="center" valign="top">
            <div class="thumbnails">            
                <?php
                    if ($current_page <= $totPages){				
				?>
                <span style="color:#06f; font-size:12px;"><?php echo $searchResultMsg;?></span><br /><br />                        
                <?php                	
		                echo "<ul>";                           
                        $count = count($searchedContent_with_img_paths);
                        $i = 0;
                        while ($count > 0){
                ?>            
                    <li><img src="<?php echo $searchedContent_with_img_paths[$i]['img_path'];?>" />
                            <strong><?php echo $searchedContent_with_img_paths[$i]['title'];?></strong>
                            <p>Cetagory: <?php echo $searchedContent_with_img_paths[$i]['genre'];?></p>
                            <p><?php echo $searchedContent_with_img_paths[$i]['hit_count'];?> views</p>
                            <span><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/index.php?cntrl=index&view=index&page=<?php echo $current_page."&mov=".$searchedContent_with_img_paths[$i]['id'];?>"></a></span>
                    </li>
                <?php		
                            $i++;
                            $count--;
                        }	                              
                        echo "</ul>";                           
					}else{	
                ?>   
                <span style="color:#f00; font-size:12px;"><?php echo $searchResultMsg;?></span>                        
                <?php
					}
				?>
               </div> 
            </td>
          </tr>
          <tr>
            <td align="center" valign="top">
            <?php if ($current_page <= $totPages): ?>
                <div id="pagination"><?php echo $pagination;?></div>
            <?php else: ?>
                <br />
                <span style="color:#06f; font-size:12px;"><a href="<?php echo WEBSITE;?>" class="return_index">Return to the Main Page</a></span>                                
            <?php endif;?>                                                
            </td>
          </tr>                          
          <tr>
            <td align="center" valign="top">&nbsp;</td>
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