<style>
    .icardCanvas{ 9cm; display: flex; align-items: center; width:6cm; border-radius:10px; border:3px groove #e5e5e5; padding:5px; background-image:url(__background__); background-size:cover; background-position: center;  font-size:10px; }
    .icardCanvas.*{
        font-family:inherit;
    }
    .icardCanvas .logo img{ height:60px;  }
    .icardCanvas .Image img{ height:85px;   object-fit: cover; object-position: center  }
    .icardCanvas .logo{ text-align:center; }
    .icardCanvas .schoolName{ text-align:center; font-size:18px; font-weight:bold; }
    .icardCanvas .schoolAddress{ text-align:center;  }
    .icardCanvas .schoolContact{ text-align:center; }
    .icardCanvas .Image{ text-align:center; }
    .icardCanvas .barcode{ text-align:center; }
    .icardCanvas .Name{ text-align:center; font-weight:bold; font-size:12px; }
    .icard_table{ line-height:12px; margin: auto}
</style>




<div class="icardTemplate"   >
    <div class="icardCanvas" style="{{content}}">
        <div>
            <div class="logo"><img src="__logo__" alt="logo"/></div>
            <div class="schoolName" style="{{school_title}}">__schoolName__</div>
            <div class="schoolAddress"  >__schoolAddress__</div>
            <div class="schoolContact" >__schoolContact__</div>
            <div class="Image"><img src="__Image__"  style="{{image}}" alt="Image"/></div>
            <div class="barcode"><img src="__barcode__" alt="Barcode" style="height:15px;" /></div>
            <div class="Name">__Name__ </div>
            <table  class="icard_table">
                <tr>
                    <td style="width:70px; {{details_label}}">Class-Year</td>
                    <td style="{{details_value}}">__class__</td>
                </tr>
                <tr>
                    <td style="{{details_label}}">DOB</td>
                    <td style="{{details_value}}">__DOB__</td>
                </tr>
                <tr>
                    <td style="{{details_label}}">Father</td>
                    <td style="{{details_value}}">__Father__</td>
                </tr>
                <tr>
                    <td style="{{details_label}}">Mother</td>
                    <td style="{{details_value}}">__Mother__</td>
                </tr>
                <tr>
                    <td style="{{details_label}}">Phone No</td>
                    <td style="{{details_value}}">__PhoneNo__</td>
                </tr>
                <tr>
                    <td style="{{details_label}}">Address</td>
                    <td style="{{details_value}}">__Address__</td>
                </tr>

            </table>
        </div>
    </div>
</div>
<!--
@OVERRIDE@
[
  {
      "attribute" : "content",
      "title" : "Content",
      "style" : [
        "font-size",
        "font-family",
        "font-style",
        "color",
        "font-weight",
        "border-width",
        "border-style",
        "border-color",
        "border-radius",
        "height",
        "width",
        "padding"
      ]
  },{
      "attribute" : "school_title",
      "title" : "School Name",
      "style" : [
        "font-size",
        "font-family",
        "font-style",
        "color",
        "font-weight",
        "margin",
        "padding"
      ]
  },{
      "attribute" : "image",
      "title" : "Image",
      "style" : [
        "height",
        "width",
        "margin",
        "border-radius"
      ]
  },{
      "attribute" : "details_label",
      "title" : "Details Label",
      "style" : [
        "font-size",
        "font-family",
        "font-style",
        "color",
        "font-weight"
      ]
  }, {
      "attribute" : "details_value",
      "title" : "Details Value",
      "style" : [
        "font-size",
        "font-family",
        "font-style",
        "color",
        "font-weight"
      ]
  }

]
@OVERRIDE@

@DEFAULT@


-->
