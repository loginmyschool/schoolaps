<style>

    .pritTemplate{ height:100vh; width:100vw;
        border-radius:10px;
        padding:0px 35px;
        background-image:url(__background__);
        background-size: 100% 100%;
        font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; letter-spacing:1px;
    }
    .pritTemplate h2{ text-align:center;}
    .pritTemplate .logo img{ height:120px;  }
    .pritTemplate .Image img{ height:75px; width:65px; }
    .pritTemplate .logo{ text-align:center; }
    .pritTemplate .schoolName{ text-align:center; font-size:18px; font-weight:bold; }
    .pritTemplate .schoolAddress{ text-align:center;  }
    .pritTemplate .schoolContact{ text-align:center; }
    .pritTemplate .Image{ text-align:center; }
    .pritTemplate .Name{ text-align:center; font-weight:bold; font-size:12px; }

    .student_info_block{
        margin-top: 10px;
        border-collapse: collapse;
        font-size: 11px;

    }
    .student_info_block table td:nth-child(1),
    .student_info_block table td:nth-child(4)
    {
        width: 150px;
        white-space: nowrap;

    }
    .student_info_block table td:nth-child(4){
        padding-left: 30px;
    }
    .student_info_block table td:nth-child(3),
    .student_info_block table td:nth-child(6)
    {
        color: #0A246A;
        white-space: nowrap;

    }
    .student_info_block table td:nth-child(2),
    .student_info_block table td:nth-child(5)
    {
        width: 20px !important;
        padding: 0 10px;

    }




    .certificate_block{
        margin-top: 20px; text-align: center; height:150px;
    }


    .signature_block{
        margin-top: 10px;
    }

    @page {
        size: A4 landscape;
    }

</style>




<div class="pritTemplate">

    <div class="header_class" style="__headerdisplay_" >
        <h2>&nbsp;  </h2>

        <div class="logo"><img src="__logo__" /></div>
        <div class="schoolName">__schoolName__</div>
        <div class="schoolAddress">__schoolAddress__</div>
        <div class="schoolContact">__schoolContact__</div>
    </div>
    <div style="height:20px;"> </div>
    <h2>__certificate_head__</h2>

    <div class="student_info_block" >
        <table style="display:none;">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="width:100px; {{students_details_label}}" > Name</td>
                            <td style="width: 10px ;{{students_details_label}}">:</td>
                            <td style="{{students_details_value}}">__Name__</td>
                        </tr>
                        <tr>
                            <td  style="{{students_details_label}}"> Class  </td>
                            <td style="{{students_details_label}}">:</td>
                            <td style="{{students_details_value}}">__class__</td>

                            <td style="{{students_details_label}}">Sec Roll </td>
                            <td style="{{students_details_label}}">:</td>
                            <td style="{{students_details_value}}">__sec__ __roll__</td>
                        </tr>
                        <tr>
                            <td style="{{students_details_label}}">DOB  </td>
                            <td style="{{students_details_label}}">:</td>
                            <td style="{{students_details_value}}">__DOB__</td>

                            <td style="{{students_details_label}}">Father Name  </td>
                            <td style="{{students_details_label}}">:</td>
                            <td style="{{students_details_value}}">__Father__</td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>

    </div>

    <div class="certificate_block" contenteditable="true"> __certificatebody__ </div>

    <div class="signature_block">
        <table style="width: 100%">
            <tr>
                <td style="text-align: left">
                    <div style="text-align: center; float: left; vertical-align: bottom">
                        <img style="width: 80px"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Franz_Schubert_Signature.svg/1200px-Franz_Schubert_Signature.svg.png"><br>
                        ___________________<br>
                        Class Teacher
                    </div>
                </td>
                <td style="text-align: right">
                    <div style="text-align: center; float: right; vertical-align: bottom">
                        <img style="width: 80px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Sergei_Loznitsa_Signature.svg/1024px-Sergei_Loznitsa_Signature.svg.png"><br>
                        ___________________<br>
                        Head of the institute/Principal
                    </div>
                </td>
            </tr>
        </table>
    </div>


    <div class="footer_class" style="__footerdisplay_" >


    </div>


</div>
