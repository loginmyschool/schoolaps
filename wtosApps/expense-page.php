<?php
    global $os,$pageVar;
    $ajaxFilePath= 'expense-page_ajax.php';
    $loadingImage=$site['url-wtos'].'images/loadingwt.gif';

    $userId=$os->userDetails['studentId'];
?>

 <table class="container">
                <tr>
                     
              <td  class="middle" style="padding-left:5px;">
              <div class="listHeader" style="font-weight: bold;">Expense List &nbsp;&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="showAddDataDiv();" >Add New</a></div>


    <div  class="ajaxViewMainTableTDListData" id="WT_expense_list_detailsListDiv">&nbsp;</div>
              
              <!--  ggggggggggggggg   -->
              
              <div id="expenseDiv" style="display: none;">
              <table width="100%"  cellspacing="0" cellpadding="1" class="ajaxViewMainTable">
                <tr>
                    <td width="470" height="470" valign="top" class="ajaxViewMainTableTDForm">
                        <div class="formDiv">
                            <table width="100%" border="0" cellspacing="1" cellpadding="1" class="ajaxEditForm">    
                                                         
                                        <input type="hidden"  id="expense_list_id" value="0" />
                                        <input type="hidden"  id="expense_list_details_id" value="0" />
                                        <tr >
                                            <td>Reference no </td>
                                            <td><input value="" type="text" name="reference_no" id="reference_no" class="textboxxx  fWidth "/> </td>                      
                                        </tr>

                                        <tr >
                                            <td>Account</td>
                                            <td> <select name="parent_head_id" id="parent_head_id" class="textbox fWidth" ><option value="">Select Account</option><? $os->optionsHTML('','account_head_id','title','account_head','parent_head_id=0');?></select>
                                         </td>                     
                                        </tr>
                                        <tr >
                                            <td>Sub Account</td>
                                            <td><select name="account_head_id" id="account_head_id" class="textbox fWidth" ><option value="">Select Expense Purpose</option><? $os->optionsHTML('','account_head_id','title','account_head','parent_head_id!=0');?></td>                        
                                        </tr>
                                        <tr >
                                            <td>Dated </td>
                                            <td><input value="" type="text" name="dated" id="dated" class="wtDateClass textbox fWidth"/></td>                       
                                        </tr>
                                        <tr >
                                            <td>Description </td>
                                            <td><input value="" type="text" name="description" id="description" class="textboxxx  fWidth "/> </td>                      
                                        </tr>
                                        <tr >
                                            <td>Quantity </td>
                                            <td><input value="" type="text" name="quantity" id="quantity" class="textboxxx  fWidth "/> </td>                        
                                        </tr>
                                        <tr >
                                            <td>Unit </td>
                                            <td><select name="unit" id="unit" class="textbox fWidth" ><option value="">Select Unit</option> <? $os->onlyOption($os->unit);   ?></select>  </td>                      
                                        </tr>
                                        <tr >
                                            <td>Tax Percent </td>
                                            <td><input value="" type="text" name="tax_percent" id="tax_percent" class="textboxxx  fWidth "/> </td>                      
                                        </tr>
                                        <tr >
                                            <td>Total Incl Tax </td>
                                            <td><input value="" type="text" name="total_incl_tax" id="total_incl_tax" class="textboxxx  fWidth "/> </td>                        
                                        </tr>
                                        <tr >
                                            <td>Total Amount </td>
                                            <td><input value="" type="text" name="tax_amount" id="tax_amount" class="textboxxx  fWidth "/> </td>                        
                                        </tr>
                                        <tr >
                                            <td>Type </td>
                                            <td><select name="type" id="type" class="textbox fWidth" ><option value="">Select Type</option> <? $os->onlyOption($os->type);   ?></select>  </td>                      
                                        </tr>   
    </table>
    
    
    <div class="formDivButton">                        
            <? if($os->access('wtEdit')){ ?>
            <input type="button" value="Save" onclick="WT_expense_list_detailsEditAndSave();" /><? } ?>   
    </div> 
    </div>  
    </td>
    <td valign="top" class="ajaxViewMainTableTDList">
    
    &nbsp;</td>
  </tr>
</table>
</div>

        
                          
              <!--   ggggggggggggggg  -->
              
              </td>
              </tr>
            </table>
            
<script>

function showAddDataDiv(){
    os.show('expenseDiv');

}
        
function WT_expense_list_detailsListing(){
    var formdata = new FormData();
    var url='<?echo $site['url']?>wtosApps/<? echo $ajaxFilePath ?>?WT_expense_list_detailsListing=OK';
    os.animateMe.div='div_busy';
    os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
    os.setAjaxHtml('WT_expense_list_detailsListDiv',url,formdata);
}
WT_expense_list_detailsListing();
 
function WT_expense_list_detailsEditAndSave()  // collect data and send to save
{

        var formdata = new FormData();
        var reference_noVal= os.getVal('reference_no');
        var parent_head_idVal= os.getVal('parent_head_id');  
        var account_head_idVal= os.getVal('account_head_id'); 
        var datedVal= os.getVal('dated'); 

        var userId="<?php echo $userId;?>";
        formdata.append('reference_no',reference_noVal );
        formdata.append('parent_head_id',parent_head_idVal );
        formdata.append('account_head_id',account_head_idVal );
        formdata.append('dated',datedVal);
        formdata.append('user_id',userId);

        var descriptionVal= os.getVal('description'); 
        var quantityVal= os.getVal('quantity'); 
        var unitVal= os.getVal('unit'); 
        var tax_percentVal= os.getVal('tax_percent'); 
        var total_incl_taxVal= os.getVal('total_incl_tax'); 
        var tax_amountVal= os.getVal('tax_amount'); 
        var typeVal= os.getVal('type'); 
        formdata.append('description',descriptionVal );
        formdata.append('quantity',quantityVal );
        formdata.append('unit',unitVal );
        formdata.append('tax_percent',tax_percentVal );
        formdata.append('total_incl_tax',total_incl_taxVal );
        formdata.append('tax_amount',tax_amountVal );
        formdata.append('type',typeVal );
        var expense_list_idVal= os.getVal('expense_list_id'); 
        formdata.append('expense_list_id',expense_list_idVal );

        var expense_list_details_idVal= os.getVal('expense_list_details_id'); 
        formdata.append('expense_list_details_id',expense_list_details_idVal );

        var url='<?echo $site['url']?>wtosApps/<? echo $ajaxFilePath ?>?WT_expense_listEditAndSave=OK&';
        os.animateMe.div='div_busy';
        os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
        os.setAjaxFunc('WT_expense_list_detailsReLoadList',url,formdata);

}   

function WT_expense_list_detailsReLoadList(data) // after edit reload list
{
    var d=data.split('#-#');
    var expense_list_id=parseInt(d[0]);

    var expense_list_details_id=parseInt(d[2]);
    if(d[0]!='Error' && expense_list_id>0)
    {
      os.setVal('expense_list_id',expense_list_id);
      os.setVal('expense_list_details_id',expense_list_details_id);
    }   
    if(d[1]!=''){alert(d[1]);}
    WT_expense_list_detailsListing();
}
function WT_expense_listGetById(expense_list_id){
    showAddDataDiv();
    var formdata = new FormData();   
    formdata.append('expense_list_id',expense_list_id );
    var url='<?echo $site['url']?>wtosApps/<? echo $ajaxFilePath ?>?WT_expense_listGetById=OK&';
    os.animateMe.div='div_busy';
    os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
    os.setAjaxFunc('WT_expense_listFillData',url,formdata);
}
function WT_expense_listFillData(data){
        var objJSON = JSON.parse(data);
        os.setVal('expense_list_id',parseInt(objJSON.expense_list_id));
        os.setVal('expense_list_details_id',parseInt(objJSON.expense_list_details_id));
        os.setVal('reference_no',objJSON.reference_no); 
        os.setVal('parent_head_id',objJSON.parent_head_id); 
        os.setVal('account_head_id',objJSON.account_head_id); 
        os.setVal('dated',objJSON.dated);
        os.setVal('description',objJSON.description); 
        os.setVal('quantity',objJSON.quantity); 
        os.setVal('unit',objJSON.unit); 
        os.setVal('tax_percent',objJSON.tax_percent);  
        os.setVal('total_incl_tax',objJSON.total_incl_tax); 
        os.setVal('tax_amount',objJSON.tax_amount); 
        os.setVal('type',objJSON.type);  
}
function WT_expense_listDeleteRowById(expense_list_id) // delete record by table id
{
    var formdata = new FormData();   
    if(parseInt(expense_list_id)<1 || expense_list_id==''){  
    var  expense_list_id =os.getVal('expense_list_id');
    }
    
    if(parseInt(expense_list_id)<1){ alert('No record Selected'); return;}
    
    var p =confirm('Are you Sure? You want to delete this record forever.')
    if(p){
    
    formdata.append('expense_list_id',expense_list_id );
    
    var url='<?echo $site['url']?>wtosApps/<? echo $ajaxFilePath ?>?WT_expense_listDeleteRowById=OK&';
    os.animateMe.div='div_busy';
    os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>'; 
    os.setAjaxFunc('WT_expense_listDeleteRowByIdResults',url,formdata);
    }
}
function WT_expense_listDeleteRowByIdResults(data)
{
    alert(data);
    WT_expense_list_detailsListing();
} 

 



</script>