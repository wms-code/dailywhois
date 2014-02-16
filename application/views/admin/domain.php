

<div class="well">
<div class="row-fluid">
<div class="span6">
<form class="form-search"  action="<?php echo base_url(); ?>" method="post">
  <fieldset>
	<input autocomplete="off" name="query"  style="width:200px; height:20px; font-size:1em;" placeholder="Search Domain name " type="text">
    
    <input type="submit" value="Search" class="btn">
  </fieldset>
</form>


</div>
<div class="span6">
<?php  echo "Whois information last updated ".$gettime ; ?><button class="btn btn-primary" type="button">Refresh Now</button>
</div>
</div>	
	 <h3>Domain Name: <?php echo $regrinfo['domain']['name']; ?></h3>
	<div class="row-fluid">
	<div class="span6"><h4>Registrar Info</h4>
<table class="table table-striped table-bordered">
<tbody>

        <tr>
    <th>Name</th>
    <td><?php echo $regyinfo['registrar']; ?></td>
    </tr>
            
            <tr>
    <th>Referral URL</th>
    <td><?php 
	
	 if (gettype($regyinfo['referrer'])=='array')
		{
			foreach ($regyinfo['referrer'] as $value)
			{
				
				echo $value . " <br/>" ;
			}
			
		}
		else
		{
		echo $regyinfo['referrer'];
		}
		
   
  
	
	
	 ?></td>
    </tr>
	<?php 
	if (!empty($regrinfo['domain']['sponsor'])) {  ?>
	<tr>
    <th>Service Provider</th>
    <td><?php echo $regrinfo['domain']['sponsor']; ?></td>
    </tr>
    <?php  }  ?>
            <tr>
    <th>Status</th>
    <td><?php 
	 if (gettype($regrinfo['domain']['status'])=='array')
		{
			foreach ($regrinfo['domain']['status'] as $value)
			{
				
				echo $value . " <br/>" ;
			}
			
		}
		else
		{	
		echo $regrinfo['domain']['status'];
		}	
		?></td>
    </tr>
    
    </tbody></table>
	</div>

  <div class="span6"> 
  <h4><?php echo $regrinfo['domain']['name']; ?> Owner Info</h4>
<table class="table table-striped table-bordered">
<tbody>

        <?php 
		if (!empty($regrinfo['admin']['name'])) {
		echo "<tr>    <th>Name :</th>    <td>";		
		echo $regrinfo['admin']['name']; 
		echo "</td>    </tr>";
		}
	?>
	
	<?php 
		if (!empty($regrinfo['admin']['email'])) {  ?>
            <tr>
    <th>Email Id :</th>
     <td><?php echo $regrinfo['admin']['email']; ?></td>
    </tr>
	<?php }  
	
	 
		if (!empty($regrinfo['admin']['organization'])) {  ?>
            <tr>
    <th> Organization:</th>
     <td><?php 		echo  $regrinfo['admin']['organization']; ?></td>
    </tr>
    <?php }  
	
	 
		if (!empty($regrinfo['admin']['address'])) {  ?>
            <tr>
    <th>Address</th>
   <td><?php 
   
   if (gettype($regrinfo['admin']['address'])=='array')
		{
			foreach ($regrinfo['admin']['address'] as $value)
			{
				
				echo $value . " <br/>" ;
			}
			
		}
		else
		{
		echo $regrinfo['admin']['address'];
		}
		
   
   
    ?></td>
    </tr>
    <?php  }  ?>
    </tbody></table>

  </div>
  </div>
	
	<div class="row-fluid">
	
	<div class="span6">
  
  	
		
		
		<h5>Name Servers</h5>
	<table class="table table-striped table-bordered">
    <tbody>
       <?php
	   foreach ($regrinfo['domain']['nserver'] as  $key => $value){
				echo"<tr>";
				echo "<td>";
				echo $key;
				echo "</td>";
				echo "<td>";
				echo $value;
				echo "</td>";
				echo "</tr>";
			}
	   
	   ?>
        </tbody></table>
		
  </div>
	
  <div class="span6">
  
  <h5>Important Dates</h5>
	<table class="table table-striped table-bordered">
    <tbody>
        <tr>
    <th>Expires On</th>
    <td><?php echo $regrinfo['domain']['expires']; ?></td>
    </tr>
            <tr>
    <th>Registered On</th>
    <td><?php echo $regrinfo['domain']['created']; ?></td>
    </tr>
            <tr>
    <th>Updated On</th>
    <td><?php echo $regrinfo['domain']['changed']; ?></td>
    </tr>
        </tbody></table>
	
  </div>
  
  
  
  <table class="table table-striped table-bordered">
		<tr>
		<td>		
		<?php 			
		foreach ($rawdata as  $key => $value){
		
		echo $value."<br />";
		
		}
		?>
		
		</td>
		</tr>
		</table>
  
  
</div>
	
	
	
	
	
</div>
