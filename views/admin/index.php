<div id="pageMesgDiv" class="defaultFont">
<?php if ($cur_page <= $tot_no_pages):?>
	<?php echo $page_message;?>
<?php endif;?>
</div>
<div id="moviesTableDiv">
    <div id="tableTitleList">
        <div class="id" style="border-right:#06f 1px solid; font-weight:bold;"><!-- --></div>
        <div class="title defaultFont" style="border-right:#06f 1px solid; font-weight:bold; color:#000000;">Title</div>
        <div class="genre defaultFont" style="border-right:#06f 1px solid; font-weight:bold;">Genre</div>                                        
        <div class="date_uploaded defaultFont" style="border-right:#06f 1px solid; font-weight:bold;">Date Uploaded</div>
        <div class="hit_count defaultFont" style="border-right:#06f 1px solid; font-weight:bold;">Hit Count</div>                                        
        <div class="additional_functions defaultFont" style="font-weight:bold;">Edit / Delete</div>                                                            
    </div>
    <div id="moviesTableContentList" class="defaultFont"> 
        	<?php 
            if ($cur_page <= $tot_no_pages){
			
				$count = count($all_movies);
				$i = 0;
				while ($count > 0){
			?>	
        <div class="movieSingleRowContent defaultFont">            
            <div class="id" style="border-right:#06f 1px solid; font-weight:bold;"><?php echo $i+$start_record_no;?></div>
            <div class="title defaultFont" style="border-right:#06f 1px solid;"><?php echo $all_movies[$i]['movie_name'];?></div>
            <div class="genre defaultFont" style="border-right:#06f 1px solid;"><?php echo $all_movies[$i]['genre'];?></div>                                        
            <div class="date_uploaded defaultFont" style="border-right:#06f 1px solid;"><?php echo $all_movies[$i]['movie_uploaded'];?></div>
            <div class="hit_count defaultFont" style="border-right:#06f 1px solid;"><?php echo $all_movies[$i]['hit_count'];?></div>                                        
            <div class="additional_functions defaultFont" style="font-weight:bold;"><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/admin.php?cntrl=admin&view=edit&mov=<?php echo $all_movies[$i]['id'];?>&page=<?php echo $_GET['page'];?>"><img src="<?php echo $public_src;?>images/b_edit.png" style="border:1px solid #000; padding:1px;" /></a>&nbsp;&nbsp;&nbsp;<a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/admin.php?cntrl=admin&view=index&action=delete&mov=<?php echo $all_movies[$i]['id'];?>&page=<?php echo $_GET['page'];?>" onclick="return confirm('Are you sure you want to delete?')"><img src="<?php echo $public_src;?>images/b_drop.png" style="border:1px solid #000; padding:1px;" /></a></div>                                                                                	
        </div>                          
			<?php
					$i++;
                    $count--;					
				}
			}else{	            
			?>	
            <div id="movNotExistError">
                <span style="color:#f00;">No movies found in this page : This page dose not exist !</span>                                
                <span style="color:#06f; font-size:12px;"><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>/drelb/admin.php?cntrl=admin&view=index&page=1" class="return_index">Return to the Main Page</a></span>                                                
            </div>    
			<?php } ?>            
    </div>
</div>
<div id="paginationDiv">
<?php if ($cur_page <= $tot_no_pages):?>
	<?php echo $pagination;?>
<?php endif;?>
</div>