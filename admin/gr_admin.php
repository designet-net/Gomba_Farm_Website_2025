<?php
	session_start();
	$_SESSION['CURRENT_PAGE'] = 'CONTACT';
?>
<?php include('headings.php');?>        
<div class="innerbanner" >                
	<img src="" alt="">        
</div>
<div class="container content-area">
    <div class="middle-align">
        <div class="site-main sitefull contactpanel">         
			<header class="entry-header">
				<h1 class="entry-title">Admin Page</h1>
			</header><!-- .entry-header -->         
			<div class="clear space40"></div>   
			<div class="one_half">
                <div class="m-add-info">			
                    <div class="m-addbox">					
                        <p style="font-size:18px;text-align:justify;">
                            <a href="gr_news_updates_admin.php">News Updates</a>
                        </p>
                    </div>
                </div>	
	        </div>  
            <div class="one_half">
                <div class="m-add-info">			
                    <div class="m-addbox">					
                        <p style="font-size:18px;text-align:justify;">
                            <a href="gr_testimonies_admin.php">Testimonies</a>
                        </p>
                    </div>
                </div>	
	        </div>            
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php include('foot.php');?>