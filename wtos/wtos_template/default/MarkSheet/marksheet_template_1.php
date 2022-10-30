<style>
    .pritTemplate{
        height:auto;
        max-width:1100px;
        min-width: 700px;
        border-radius:10px;
        padding:60px;
        background-image:url(__background__);
        background-position: center;
        background-repeat: no-repeat;
        background-size:cover;
        font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; letter-spacing:1px;
    position: relative}

    .pritTemplate *{
        box-sizing: border-box;;
    }
    .header{
        text-align: center;
        position: relative;
        min-height: 150px;
    }
    h1.school_name{
        font-size: 30px;
        text-align: center;
        margin-top: 10px;
    }
    img.logo{
        height: 110px;
    }

    .exam_block{
        text-align: center;
        background-color: rgba(0,0,0,0.03);
        color: #0A246A;
        font-size: 14px;
        margin: 20px 0;
    }

    .student_info_block table{
        border-collapse: collapse;
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



    .result_block{
        margin: 20px 0;
    }
    .result_block table{
        border-collapse: collapse;
    }
    .result_block th, .result_block td{
        border:1px solid #000;
        padding: 2px 3px;
    }
    .result_block thead{
        background-color: #e5e5e5;
        text-align: left;
        font-weight: bold;
    }

    .result_block table{
        width: 100%;
    }
    .result_card_title{
        margin-top: 15px;
        color: red;
        font-size: 16px;
    }

    .note-block{
        margin-bottom: 20px;
    }


    .grade_block{
        margin-bottom: 20px;
    }
    .grade_block table{
        border-collapse: collapse;
    }
  .grade_block table th{
      background-color: #e5e5e5;
  }
    .grade_block table td, .grade_block table th{
        border: 1px solid #000000;
        padding: 1px 4px;
        text-align: left;
    }


    .top_left_border{
        top:5px;
        left: 5px;
    }
    .top_right_border{
        top:5px;
        right: 5px;
    }

    .bottom_left_border{
        bottom:5px;
        left: 5px;
    }
    .bottom_right_border{
        bottom:5px;
        right: 5px;
    }
    .top_left_border, .top_right_border, .bottom_left_border, .bottom_right_border{
        position:absolute;
        height:200px;
        width:200px;
        z-index: 50;
    }
</style>




<div class="pritTemplate" style="{{content}}">


    <svg class="top_left_border" xmlns="http://www.w3.org/2000/svg" width="447.42" height="454.736" viewBox="0 0 447.42 454.736">
        <g id="Top_Left" data-name="Top Left" transform="translate(77.289 669.512)">
            <path id="Path_23" data-name="Path 23" d="M121.945-602.762S-8.4-587.839-39.062-596.645-10.29-658.662-.7-631.868c6.963,19.452,0,146.239,0,146.239h0S2.516-612.543-8.934-627.168s-44.8,14.4-25.773,24.406,156.652,0,156.652,0" transform="translate(-12 -14)" fill="rgba(77,58,0,0.58)"/>
            <path id="Path_24" data-name="Path 24" d="M399.652-595.106s-161.767,13.981-222.388,16.688c-103.746,1.963-200.329-5.219-214.5-9.291-37.078-10.649,34.8-75,46.394-42.6,8.42,23.524,8.613,179.325,8.613,179.325L9.153-184.6S13.04-606.934-.806-624.62-54.978-607.2-31.973-595.106s431.626,0,431.626,0" transform="translate(-29.521 -30.172)" fill="#dead1b"/>
        </g>
    </svg>


    <svg class="top_right_border" id="Top_Right" data-name="Top Right" xmlns="http://www.w3.org/2000/svg" width="447.42" height="454.736" viewBox="0 0 447.42 454.736">
        <path id="Path_23" data-name="Path 23" d="M-47.768-602.762s130.347,14.923,161.008,6.117-28.773-62.017-38.364-35.224c-6.963,19.452,0,146.239,0,146.239h0s-3.214-126.914,8.235-141.539,44.8,14.4,25.773,24.406-156.652,0-156.652,0" transform="translate(307.954 655.512)" fill="rgba(77,58,0,0.58)"/>
        <path id="Path_24" data-name="Path 24" d="M-47.768-595.106S114-581.125,174.62-578.417c103.746,1.963,200.329-5.219,214.5-9.291,37.078-10.649-34.8-75-46.394-42.6-8.42,23.524-8.613,179.325-8.613,179.325L342.731-184.6s-3.887-422.331,9.959-440.017,54.173,17.417,31.168,29.515-431.626,0-431.626,0" transform="translate(47.768 639.34)" fill="#dead1b"/>
    </svg>



    <div class="header">
        <table style="width: 100%">
            <tr>
                <td style="text-align: left; vertical-align: top">
                    <img style="{{logo}}" class="logo" src="__logo__" />
                </td>
                <td>
                    <h1 class="school_name" style="{{school_name}}">__schoolName__</h1>
                    <div>
                        <p class="schoolAddress" style="{{school_address}}">__schoolAddress__</p>
                        <p class="schoolContact" style="{{school_contact}}">__schoolContact__</p>
                    </div>

                    <h2 class="result_card_title" style=" {{result_card_title}}">RESULT CARD</h2>

                </td>
                <td style="text-align: right;vertical-align: top">
                    <img src="__Image__" style="width: 80px"><br>
                    <img src="__barcode__" style="width: 80px; margin-top: 5px; height: 20px">
                </td>
            </tr>
        </table>
    </div>

    <div class="student_info_block">
        <table>
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
    <div class="exam_block">__exam_info__</div>
    <div class="result_block">__result_block__</div>

    <div class="note-block">
    __note_block__
    </div>

    <div class="grade_block">
        __grade_block__
    </div>

    <div class="signature_block">
        <table style="width: 100%">
            <tr>
                <td style="text-align: left">
                    <div style="text-align: center; float: left; vertical-align: bottom">
                        <img style="width: 100px"  src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Franz_Schubert_Signature.svg/1200px-Franz_Schubert_Signature.svg.png"><br>
                        ______________________<br>
                        Class Teacher
                    </div>
                </td>
                <td style="text-align: right">
                    <div style="text-align: center; float: right; vertical-align: bottom">
                        <img style="width: 100px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Sergei_Loznitsa_Signature.svg/1024px-Sergei_Loznitsa_Signature.svg.png"><br>
                        ______________________<br>
                        Head of the institute/Principal
                    </div>
                </td>
            </tr>
        </table>
    </div>


    <svg class="bottom_left_border" id="Bottom_Left" data-name="Bottom Left" xmlns="http://www.w3.org/2000/svg" width="447.42" height="454.736" viewBox="0 0 447.42 454.736">
        <path id="Path_23" data-name="Path 23" d="M121.945-522.207S-8.4-537.13-39.062-528.324-10.29-466.307-.7-493.1c6.963-19.452,0-146.239,0-146.239h0S2.516-512.426-8.934-497.8s-44.8-14.4-25.773-24.406,156.652,0,156.652,0" transform="translate(65.289 924.193)" fill="rgba(77,58,0,0.58)"/>
        <path id="Path_24" data-name="Path 24" d="M399.652-228.837s-161.767-13.981-222.388-16.688c-103.746-1.963-200.329,5.219-214.5,9.291-37.078,10.649,34.8,75,46.394,42.6,8.42-23.524,8.613-179.325,8.613-179.325L9.153-639.34S13.04-217.009-.806-199.323s-54.173-17.417-31.168-29.515,431.626,0,431.626,0" transform="translate(47.768 639.34)" fill="#dead1b"/>
    </svg>



    <svg class="bottom_right_border" id="Bottom_Right" data-name="Bottom Right" xmlns="http://www.w3.org/2000/svg" width="447.42" height="454.736" viewBox="0 0 447.42 454.736">
        <path id="Path_23" data-name="Path 23" d="M-47.768-522.207S82.579-537.13,113.24-528.324,84.467-466.307,74.876-493.1c-6.963-19.452,0-146.239,0-146.239h0S71.662-512.426,83.111-497.8s44.8-14.4,25.773-24.406-156.652,0-156.652,0" transform="translate(307.953 924.193)" fill="rgba(77,58,0,0.58)"/>
        <path id="Path_24" data-name="Path 24" d="M-47.768-228.837S114-242.818,174.62-245.526c103.746-1.963,200.329,5.219,214.5,9.291,37.078,10.649-34.8,75-46.394,42.6-8.42-23.524-8.613-179.325-8.613-179.325l8.613-266.376s-3.887,422.331,9.959,440.017,54.173-17.417,31.168-29.515-431.626,0-431.626,0" transform="translate(47.768 639.34)" fill="#dead1b"/>
    </svg>




</div>


<!--
@OVERRIDE@
[
  {
      "attribute" : "content",
      "title" : "Content",
      "style" : [
        "font-size",
        "color",
        "padding"
      ]
  },
{
      "attribute" : "logo",
      "title" : "Logo",
      "style" : [
        "height",
        "width"
      ]
  },
  {
      "attribute" : "school_name",
      "title" : "School Name",
      "style" : [
        "color",
        "font-size",
        "font-family",
        "font-weight",
        "font-style"
      ]
  },
  {
      "attribute" : "school_address",
      "title" : "School Address",
      "style" : [
        "color",
        "font-size",
        "font-family",
        "font-weight",
        "font-style"
      ]
  },
  {
      "attribute" : "school_contact",
      "title" : "School Contact",
      "style" : [
        "color",
        "font-size",
        "font-family",
        "font-weight",
        "font-style"
      ]
  },
  {
      "attribute" : "result_card_title",
      "title" : "Result card title",
      "style" : [
        "color",
        "font-size",
        "font-family",
        "font-weight",
        "font-style"
      ]
  },
  {
      "attribute" : "students_details_label",
      "title" : "Student Details Label",
      "style" : [
        "color",
        "font-size",
        "font-family",
        "font-weight",
        "font-style"
      ]
  },
  {
      "attribute" : "students_details_value",
      "title" : "Student Details",
      "style" : [
        "color",
        "font-size",
        "font-family",
        "font-weight",
        "font-style"
      ]
  }

]
@OVERRIDE@

@DEFAULT@
-->
