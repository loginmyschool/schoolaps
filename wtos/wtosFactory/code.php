<? 
include('../../wtosConfig.php');
include($site['root-wtos'].'top.php');
include('functions.php');
?>

<table > <tr> <td>   <div style="height:450px; overflow-y:scroll; margin-left:100px; width:250px;">
	<? $tableList=tablesInDb();
	foreach( $tableList as $tableItem)
	{
	
	 $fieldsInTable=fieldsInTable($tableItem);
	  ?>
	  <b><input type="checkbox" name="table[]" value="<? echo $tableItem; ?>" /> <? echo $tableItem; ?></b><br />
	  <div style="padding-left:10px;" >
	  <? 
	
	foreach( $fieldsInTable as $fieldsItem)
	{
	
	 
	  ?>
	  P<input type="checkbox" name="primery[]" value="<? echo $fieldsItem; ?>" /> F<input type="checkbox" name="field[]" value="<? echo $fieldsItem; ?>" /><? echo $fieldsItem; ?><br />
	  
	  <? 
	
	
	
	}
	
	?>
	</div>
	
	<?
	
	}
	
	?>
	</div>    </td><td valign="top">   <textarea id="codecontainer" style="height:400px; width:700px;"></textarea>   <br />    <input type="button" value="TOS"  onclick="tos()" style="cursor:pointer;"/>
	        </td>  </tr>

	
	
	
	
	<script>
	 
	
		   
function tos(button) // get record by table primery id
{
	      
		  var table=getValuesFromCheckedBox('table[]');
			var field=getValuesFromCheckedBox('field[]');
			var primery=getValuesFromCheckedBox('primery[]');
		
		
		
		var formdata = new FormData();
	     
	    
		 
	formdata.append('table',table );
	formdata.append('field',field);
	formdata.append('primery',primery);
	 
	  
	
	formdata.append('tos_results','OK' );
	 
	
	var url='code_ajax.php?tos_results=OK&';
	os.animateMe.div='div_busy';
	os.animateMe.html='Loading';	
	os.setAjaxFunc('tos_results',url,formdata);
	 			
}

function tos_results(data)  // fill data form by JSON
{
    
    
   os.setVal('codecontainer',data);
    
  
}
	</script>