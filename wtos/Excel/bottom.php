
</div>

<div class="poweredBy" style="display:none;">
<a href="http://webtrackers.co.in/" title="Powered By Webtrackers4u" target="_blank">
<img src="<?php echo $site['url-wtos'] ?>images/poweredBywebtrackers4u.png" alt=""   height="25"  style="margin:0 0 0 5px; border:none;"/></a>
Copyright &copy; <?php echo $os->today('Y');?> www.webtrackers.co.in - All Rights Reserved.
<script>os.viewCalender('wtDateClass','<? echo $os->dateFormatJs; ?>');</script>

    <link rel="stylesheet" type="text/less" href="<?php echo $site['url-wtos']?>css/common.less"/>
    <script>
        $("table").each(function () {
            $(this).removeClass("container");
        });

        function change_graphics(size) {
            // Create new link Element
            let link = document.querySelector("link[title=graphics]");

            link.href = "<?php echo $site['url-wtos']?>css/graphics/"+size+".css";
            localStorage.graphics = size;


        }

        if(localStorage.graphics){
            change_graphics(localStorage.graphics);
            document.querySelector("#graphics_changer_select_box").value =localStorage.graphics;
        } else {
            change_graphics("medium");
            document.querySelector("#graphics_changer_select_box").value = "medium";

        }

        //override alert
        window.alert = function (message, status = null) {
            if(status!==null){
                UIkit.notification({message: message, pos: 'top-center', status: status});
            } else {
                UIkit.notification({message: message, pos: 'top-center' , status: 'default'});
            }

        }
    </script>

<?  include($site['root-wtos'].'new_php_script.php');  ?>

</div>
</body>
</html>
