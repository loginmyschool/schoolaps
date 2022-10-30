<?php
global $os,$site;
class templateClass{

    function __construct($folder_name='default')
    {
        global $os,$site;
        $this->folder= $folder_name;
        $this->os = $os;
        $this->site= $site;
        $this->template_root=$site['root-wtos'].'wtos_template/'.$this->folder.'/';
        $this->template_url=$site['url-wtos'].'wtos_template/'.$this->folder.'/';

        $this->default_template= array(
            'IdentyCard' => 'icard_template_1.php',
            'FeesReceipt' => 'print_receipt_template_1.php'
        );

        $this->template=array ( 'name' => '', 'type' => ''  );
        $this->active_setting=array();
        $this->type= '';


        //school settings
        $schoolQ="select * from school_setting limit 1";
        $school_setting_rs =$this->os->mq($schoolQ);
        $school_setting =$this->os->mfa($school_setting_rs);
        $this->school_setting=$school_setting;


    }

    function render_design($global_template, $template_keys_data=array()){
        global $os;
        $template = $global_template["template_content"];

        //values
        if(sizeof($template_keys_data)==0){
            $template_keys_data = $this->get_all_demo_data($global_template["type"]);
        }
        //school details
        $template_keys_data['__logo__']=$this->site['url'].$this->school_setting['logoimage'];
        $template_keys_data['__schoolName__']=$this->school_setting['school_name'];
        $template_keys_data['__schoolAddress__']=$this->school_setting['address'];
        $template_keys_data['__schoolContact__']=$this->school_setting['contact'];
        //get background
        if($os->val($global_template,'backgroundImage')) {
            $template_keys_data['__background__'] = $this->site['url'] . $os->val($global_template,'backgroundImage');
        } else {
            $template_keys_data['__background__']=$this->template_url.$global_template["type"].'/'.$global_template['template_page'].'.backgroud.jpg';
        }
        //override style
        if(isset($global_template["style_override"])) {
            $style_override = (array)json_decode($global_template["style_override"]);
            if (is_array($style_override)) {
                foreach ($style_override as $attribute => $styles) {
                    $style_str = "";
                    foreach ($styles as $style_key => $style_val) {
                        $style_str .= ($style_key . ":" . $style_val . " !important;");
                    }
                    $template_keys_data["{{" . $attribute . "}}"] = $style_str;
                }
            }
        }
        return $this->os->replace_template_value($template_keys_data, $template);
    }

    function get_active_template($type)
    {


        $global_templateQ="select * from global_template where type='$type' and active_status='Active' limit 1";
        $global_templateQ_rs =$this->os->mq($global_templateQ);
        $global_template =$this->os->mfa($global_templateQ_rs);
        $this->active_setting=$global_template;


        return $global_template;


    }
    function get_template_str($file,$type)
    {
        //$type=IdentyCard/FeesReceipt
        $this->type=$type;
        $template_root= $this->template_root.$type.'/';
        $template_url= $this->template_url.$type.'/';
        $from='file';
        $contents='';

        if($file!='')
        {
            $filename =$template_root.$file;
            $contents=$this->get_str($filename);

        }
        else
        {
            $activetemplate=$this->get_active_template($type);
            if(isset($activetemplate['template_content']))
            {
                $contents = $this->render_design($activetemplate);//$activetemplate['template_content'];
                $file=$activetemplate['template_page'];
                $from='table';
            }

            if(trim($contents)=='')
            {
                $file=$this->default_template[$type];
                $filename =$template_root.$file;
                $contents=$this->get_str($filename);

            }

        }

        $this->template['name']=$file;
        $this->template['type']=$type;
        $this->template['from']=$from;
        $this->template['contents']=$contents;


        return $contents;
    }
    function get_template_file_str($file,$type)
    {
        $template_root= $this->template_root.$type.'/';
        $template_url= $this->template_url.$type.'/';
        $filename =$template_root.$file;
        $contents=$this->get_str($filename);

        return $contents;
    }
    function get_str($file_with_full_path)
    {


        $handle = fopen($file_with_full_path, "r");
        $contents = fread($handle, filesize($file_with_full_path));
        fclose($handle);
        return $contents;
    }
    function manage_default_value($data)
    {









        return $data;

    }
    function render_icard($historyData, $template='')//$template='icard_template_1.php'
    {
        $active_template=$this->get_active_template("IdentyCard");
        return $this->render_design($active_template, $historyData);
    }
    function render_marksheet($examData,$template='')//$template='marksheet_template_1.php'
    {
        $active_template = $this->get_active_template("MarkSheet");
        return $this->render_design($active_template, $examData);
    }
    function render_certificate($certificate_data,$template='')//$template='certificate_data_template_1.php'
    {
        $active_template = $this->get_active_template("Certificate");
        return $this->render_design($active_template, $certificate_data);
    }
    function render_fees_payment_receipt($fees_info_block,$fees_block,$student_info_block,$school_setting,$template='')//$template='icard_template_1.php'
    {
        $active_template = $this->get_active_template("FeesReceipt");
        $data['__fees_block__']=$fees_block;
        $data['__student_info_block__']=$student_info_block;
        $data['__fees_info_block__']=$fees_info_block;
        $data = $this->manage_default_value($data);
        return $this->render_design($active_template, $data);
    }

    function  get_global_template_list($type)
    {


        $folder=$this->os->global_template_folder[$type];
        $folder_root=$this->template_root. $folder.'/';
        $folder_url=$this->template_url. $folder.'/';

        $files = scandir($folder_root);
        $templates=array();

        foreach($files as $file)
        {

            $ext = substr($file, -4);

            if(strpos($file,'.php')==true  &&  $ext=='.php' )
            {
                $templates[$file]['name']=$file;
                $templates[$file]['full_path']=$folder_root.$file;
                $templates[$file]['thumbnail_path']=$folder_url.$file.'.jpg';
                $templates[$file]['type']=$type;
                $templates[$file]['folder_root']=$folder_root;
                $templates[$file]['folder_url']=$folder_url;
            }


        }

        return $templates;


    }

    function preview_select_template($templates)
    {


        ?>
        <div class="uk-width-auto uk-height-1-1">
            <div class="uk-height-1-1 uk-background-muted">
            <? foreach($templates as $val)
            {


                ?>
                <a class="uk-width-1-1 uk-padding-small"
                     onclick="WT_view_template_preview('<? echo $val['type'] ?>','<? echo $val['name'] ?>')"  >
                    <img src="<? echo $val['thumbnail_path'] ?>" class="uk-width-small "/>
                </a>

            <? } ?>
            </div>
        </div>
        <div class="uk-width-expand uk-height-1-1">
            <div id="WT_view_template_preview_DIV" class="uk-overflow-auto uk-height-1-1">
                <!----3333333--->
            </div>
        </div>


        <?
    }

    function template_ajax_php()
    {
        if($this->os->get('WT_global_template_list_from_store')=='OK' && $this->os->get('WT_global_template_list_from_store')=='OK')
        {

            $type=$this->os->post('type');

            $templates=$this->get_global_template_list($type);
            echo '##--get_global_template_list--##';


            if($type!='')
            {
                $this->preview_select_template($templates);
            }
            echo '##--get_global_template_list--##';
            exit();
        }
        if($this->os->get('WT_view_template_preview')=='OK' && $this->os->get('WT_view_template_preview')=='OK')
        {
            $type=$this->os->post('type');
            $name=$this->os->post('name');
            $template_str= $this->get_template_str($name, $type);

            $template = array(
                "template_content" => $template_str,
                "type" => $type,
                "template_page" =>$name
            );


            echo '##--WT_view_template_preview_DIV--##';

            ?>
            <input type="button" class="button_select_template"  value="SELECT TEMPLATE" onclick="select_template_to_edit('<? echo $name; ?>')" />

            <div class="uk-padding-small">
            <?
            echo   $this->render_design($template, array());
            echo '##--WT_view_template_preview_DIV--##';
            ?>
            </div>
            <?
            exit();
        }


    }

    function template_ajax_script_html()
    {
        global $loadingImage,$ajaxFilePath;
        ?>
        <script>
            function selectTemplateFromStore()
            {

                WT_global_template_list_from_store()

            }
            function WT_global_template_list_from_store()
            {
                var formdata = new FormData();
                var  type =os.getVal('type');
                if(type==''){ alert('Select type'); return false;}
                formdata.append('type',type );
                formdata.append('WT_global_template_list_from_store','OK' );
                var url='<? echo $ajaxFilePath ?>?WT_global_template_list_from_store=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_global_template_list_from_store_Results',url,formdata);



            }
            function WT_global_template_list_from_store_Results(data)
            {
                var content_data=	getData(data,'##--get_global_template_list--##');
                os.setHtml('templateStore_DIV',content_data);
                UIkit.modal("#templateStore_DIV_modal").show()

            }
            function WT_view_template_preview(type,name)
            {
                var formdata = new FormData();
                formdata.append('type',type );
                formdata.append('name',name );
                formdata.append('WT_view_template_preview','OK' );
                var url='<? echo $ajaxFilePath ?>?WT_view_template_preview=OK&';
                os.animateMe.div='div_busy';
                os.animateMe.html='<div class="loadImage"><img  src="<? echo $loadingImage?>"  /> <div class="loadText">&nbsp;Please wait. Working...</div></div>';
                os.setAjaxFunc('WT_view_template_preview_Results',url,formdata);

            }
            function WT_view_template_preview_Results(data)
            {

                var content_data=	getData(data,'##--WT_view_template_preview_DIV--##');
                os.setHtml('WT_view_template_preview_DIV',content_data);
            }
            function select_template_to_edit(name)
            {
                os.setVal('template_page',name);
                UIkit.modal("#templateStore_DIV_modal").hide()
            }

            // template script  end
        </script>
        <div id="templateStore_DIV_modal" class="uk-modal-container" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div id="templateStore_DIV" class="uk-grid uk-grid-collapse" uk-grid style="height: 550px"></div>
            </div>

        </div>


        <style>
            .template_list_thumbnail{ width:200px;  height:200px;  border:1px solid  green; margin:5px; padding:1px; border-radius:5px; cursor:pointer;}
            .template_list{ overflow-y:scroll; width:230px; float:left; height:100%;border-radius:5px;}
            .template_list_preview{ overflow-y:scroll; width:830px; float:left; padding:5px; border:1px solid #0099CC;height:99%; margin:5px; border-radius:5px; }
        </style>
        <?

    }

    function dataDEmo()
    {



        $student_info_block='<table   >
 <tr>
    <td style="width:100px;"  > Name:  </td>
    <td>TANIA NAJRIN  </td>
  </tr>
   
  
  <tr>
    <td  > Class:  </td>
    <td>5 2020</td>
  </tr>
  <tr>
    <td>Sec Roll</td>
    <td>A  0</td>
  </tr>
   
  
  <tr>
    <td>DOB</td>
    <td>01-01-2005</td>
  </tr>
  <tr>
    <td>Father Name</td>
    <td>iy78y7</td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td>8017477871</td>
  </tr>';

        $fees_info_block='<table  class="">
 <tr>
    <td  > ID-835:  </td>
    <td> <img src="http://localhost/school.com/studentfees/barCode/835-ean13.jpg" class="barcode_pic" style="height:15px;"  />  </td>
  </tr>
 <tr>
    <td style="width:100px;"   > Paid Date:  </td>
    <td>20-03-2020  </td>
  </tr>
   
  <tr>
    <td>Receipt No</td>
    <td>1827</td>
  </tr>
  <tr>
    <td>Paid By</td>
    <td>34</td>
  </tr>
  
  <tr>
    <td>Paid Amount</td>
    <td>14000.00</td>
  </tr>
  
   
   
</table>';


        $fees_block='<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td>Title</td>
    
    <td align="right">Amount</td>
  </tr>
  
 


				
	<tr class="row_data">
    <td>Admission Fees  March 2020</td>     
    <td align="right">300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  March 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  April 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  May 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  June 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  July 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  August 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  September 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  October 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  November 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  December 2020</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  January 2021</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
					
	<tr class="row_data">
    <td>Monthly Fees  February 2021</td>     
    <td align="right">1300.00</td>
  </tr>		 
			   
	
 <tr class="total_row">
    <td>Total Payble<span class="inwordtext">   Fifteen Thousand Nine Hundred   only</span> </td>
    <td align="right">15900 </td>
  </tr>
  
  
  
   <tr class="total_row">
    <td>Paid <span class="inwordtext">   Fouteen Thousand   only</span></td>
    <td align="right">14000.00  </td>
  </tr>
  
    <tr class="total_row">
    <td>Due <span class="inwordtext">   One Thousand Nine Hundred   only</span></td>
    <td align="right">1900.00  </td>
  </tr>
  
   
  
</table>';
        $return['student_info_block']=$student_info_block;
        $return['fees_info_block']=$fees_info_block;
        $return['fees_block']=$fees_block;

        return  $return;
    }


    function get_all_demo_data($type){
        $template_keys_data = [];
        //school details
        $school_setting = $this->os->school_setting();
        $template_keys_data['__logo__']=$this->site['url'].$school_setting['logoimage'];
        $template_keys_data['__schoolName__']=$school_setting['school_name'];
        $template_keys_data['__schoolAddress__']=$school_setting['address'];
        $template_keys_data['__schoolContact__']=$school_setting['contact'];


        //student details
        $template_keys_data['__barcode__']= $this->site['url-wtos']."images/demo_barcode.png";
        $template_keys_data['__Image__']=$this->site['url-wtos']."images/demo_user.png";
        $template_keys_data['__Name__']= "John Doe";
        $template_keys_data['__roll__']= "23001317054";
        $template_keys_data['__class__']= "XX X 0000";
        $template_keys_data['__DOB__']= "00-00-0000";
        $template_keys_data['__Father__']="Steve Jobs";
        $template_keys_data['__Mother__']= "Angelina Jolie";
        $template_keys_data['__PhoneNo__']= "9876543210";
        $template_keys_data['__Address__']="Berhampore, Murshidabad, 742405";

        //certificate
        $template_keys_data['__certificate_head__'] = "Certificate";
        $template_keys_data['__certificatebody__'] = "This is to certify that NAFISH AHMED, son of ABUL KALAM AZAD, of MAJHIRA GOBINDAPUR BERHAMPORE MURSHIDABAD WEST BENGAL , was a bonafied student of our school in the year. He was then reading in class XII Comm. . his date of birth ad recorded in the Admission Register is 27-02-1998 . To the best of my knowledge, He bears a good moral character.";
        $template_keys_data["__student_info_block__"] = '<table   >
 <tr>
    <td style="width:100px;"  > Name:  </td>
    <td>TANIA NAJRIN  </td>
  </tr>
   
  
  <tr>
    <td  > Class:  </td>
    <td>5 2020</td>
  </tr>
  <tr>
    <td>Sec Roll</td>
    <td>A  0</td>
  </tr>
   
  
  <tr>
    <td>DOB</td>
    <td>01-01-2005</td>
  </tr>
  <tr>
    <td>Father Name</td>
    <td>iy78y7</td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td>8017477871</td>
  </tr></table>';
        $template_keys_data["__exam_info__"] = '1st MID TERM  2020';
        $template_keys_data["__result_block__"] = '<table>
<thead>
<tr>
            <td> Subject </td>
            <td> Total </td>
            <td>Written </td>
            <td> Viva  </td>
            <td> Practical  </td>
            <td>  Total Obtain </td>
            <td> Grade </td>
            <td>  %</td>
        </tr>
        </thead>
        <tbody>

                    <tr>
                <td>BENGALI   </td>
                <td>100   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0%  </td>
                <td> </td>
            </tr>
                    <tr>
                <td>HINDI   </td>
                <td>100   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0%  </td>
                <td> </td>
            </tr>
                    <tr>
                <td>ENGLISH   </td>
                <td>100   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0%  </td>
                <td> </td>
            </tr>
                    <tr>
                <td>AMADER PARIBESH   </td>
                <td>100   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0   </td>
                <td>0%  </td>
                <td> </td>
            </tr>
        

    </tbody></table>';
        $template_keys_data['__note_block__']= '<ul><li>This is note</li><li>This is note</li><li>This is note</li></ul>';
        $template_keys_data['__grade_block__'] = '<table>
            <thead>
            <tr>
                <th>Marks Scale</th>
                <th>Grade</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>90 - 100</td>
                <td>AA</td>
                <td>Outstanding</td>
            </tr>
            <tr>
                <td>80 - 89</td>
                <td>A+</td>
                <td>Excelent</td>
            </tr>
            <tr>
                <td>60 - 79</td>
                <td>A</td>
                <td>Very Good</td>
            </tr>
            <tr>
                <td>45 - 59</td>
                <td>B+</td>
                <td>Good</td>
            </tr>
            <tr>
                <td>35 - 44</td>
                <td>B</td>
                <td>Satisfactory</td>
            </tr>
            <tr>
                <td>25 - 34</td>
                <td>C</td>
                <td>Marginal</td>
            </tr>
            <tr>
                <td>Below 25</td>
                <td>D</td>
                <td>Disqualified</td>
            </tr>

            </tbody>
        </table>';
        return $template_keys_data;
    }

    function he_or_she($gender){
        switch ($gender){
            case "Male":
                return "He";
                break;
            case "Female":
                return "She";
                break;
        }
    }

}
?>
