<tr>
    <td class="con-up"></td>
  </tr>
  <tr>
    <td align="center" valign="top" class="con-middle">&nbsp;</td>
  </tr>                                    
  <tr>
    <td align="center" valign="top" class="con-middle"><span style="color:#06f; font-size:12px;">
        <?php if ($cur_page <= $tot_no_pages):?>                    
            <?php echo $page_message;?></span>
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
            <td align="center" valign="top"><div class="thumbnails">
                <?php
                  echo "<ul>";
                    if ($cur_page <= $tot_no_pages){
                        $count = count($all_movies);
                        $i = 0;
                        while ($count > 0){
                ?>
                    <li><img src="<?php echo $all_movies_with_img_paths[$i]['img_path'];?>"/>
                            <strong><?php echo $all_movies_with_img_paths[$i]['movie_name'];?></strong>
                            <p>Cetagory: <?php echo $all_movies_with_img_paths[$i]['genre'];?></p>
                            <p><?php echo $all_movies_with_img_paths[$i]['hit_count'];?> views</p>
                            <span><a href="<?php echo $ex_path_for_movie . "&mov=".$all_movies_with_img_paths[$i]['id'];?>"></a></span>
                    </li>
                <?php		
                            $i++;
                            $count--;
                        }	                              
                        echo "</ul>";                           
                    }else{
                ?>
                <span style="color:#f00; font-size:12px;">No movies found in this page : This page dose not exist !</span>                                
                <?php
                    }
                ?>
            </div></td>
          </tr>
          <tr>
            <td align="center" valign="top">
            <?php if ($cur_page <= $tot_no_pages): ?>
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