<?php include('headings.php');?>        
<div class="innerbanner" >                
	<img src="" alt="">        
</div>
<div class="container content-area">
    <div class="middle-align">
        <div class="site-main sitefull contactpanel">         
			<header class="entry-header">
				<h1 class="entry-title">Dashboard</h1>
			</header><!-- .entry-header -->   
			<div class="one_half">
		<h2 class="section_title">Login Credentials</h2>
		<div class="m-add-info">				
				<div class="m-addbox">					
					<p>
                    
                    </p>
				</div>
		</div>        	
	</div>
		<div class="one_half last_column">
		<h2 class="section_title">Login</h2>
		<div class="main-form-area" id="contactform_main">		
			<form name="contactform" action="gr_admin_login_processing.php" method="post">
				<p style="font-size:18px;text-align:justify;">
				<input type="text" name="username" value="" placeholder="Username" 
                    style="width:100%"/></p>
                <div class="clear"></div>
                <p style="font-size:18px;text-align:justify;">
				<input type="password" name="password" value="" placeholder="Password" 
                    style="width:100%;height:50px;margin-bottom:10px;"/></p>
                <div class="clear"></div>
				<p class="sub">
					<input type="submit" name="login" value="Login" 
                    class="search-submit" />
				</p>
			</form>			
			</div>
		</div>              
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php include('foot.php');?>