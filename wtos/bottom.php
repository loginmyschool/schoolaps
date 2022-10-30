</div>

<div class="poweredBy" style="display:none;">
    <a href="http://webtrackers.co.in/" title="Powered By Webtrackers4u" target="_blank">
        <img src="<?php echo $site['url-wtos'] ?>images/poweredBywebtrackers4u.png" alt="" height="25" style="margin:0 0 0 5px; border:none;" /></a>
    Copyright &copy; <?php echo $os->today('Y'); ?> www.webtrackers.co.in - All Rights Reserved.
    <script>
        os.viewCalender('wtDateClass', '<? echo $os->dateFormatJs; ?>');
    </script>

    <script>
        $("table").each(function() {
            $(this).removeClass("container");
        });
        //override alert
        /* window.alert = function (message, status = null) {
             if(status!==null){
                 UIkit.notification({message: message, pos: 'top-center', status: status,timeout: 1000});
             } else {
                 UIkit.notification({message: message, pos: 'top-center' , status: 'default',timeout: 1000});
             }

         }*/
        //

        $(document).ready(function() {
            jQuery.curCSS = function(element, prop, val) {
                return jQuery(element).css(prop, val);
            };
            //datetimepicker
            $('.datetimepicker,.wtDateClass').each(function() {
                $(this).datetimepicker("destroy");
                $(this).datetimepicker({
                    format: 'Y-m-d H:i',
                    dateFormat: 'Y-m-d',
                    timeFormat: 'H:i',
                    interval: 1,
                    minuteInterval: 60,
                    step: 1
                });
            });
            //datepicker
            $('.datepicker,.wtDateClass').each(function() {
                $(this).datetimepicker("destroy"); //destroys the previous settings.
                $(this).datetimepicker({
                    timepicker: false,
                    format: 'Y-m-d'
                });
            });
            //select2
            $('.select2').each(function() {

                if ($(this).data('select2')) {
                    $(this).select2("destroy"); //destroys the previous settings.
                }

                $(this).select2();
            });

            //trigger

            (function($) {
                var originalVal = $.fn.val;
                $.fn.val = function() {
                    var result = originalVal.apply(this, arguments);
                    if (arguments.length > 0)
                        $(this).trigger("change"); // OR with custom event $(this).trigger('value-changed');
                    return result;
                };
            })(jQuery);


        });

        window['after_ajax_functions'].push(
            function() {
                //datetimepicker
                $('.datetimepicker').each(function() {
                    $(this).datetimepicker("destroy");
                    $(this).datetimepicker({
                        format: 'Y-m-d H:i',
                        dateFormat: 'Y-m-d',
                        timeFormat: 'H:i',
                        interval: 1,
                        minuteInterval: 60,
                        step: 1
                    });
                });
                //datepicker
                $('.datepicker,.wtDateClass').each(function() {
                    $(this).datetimepicker("destroy"); //destroys the previous settings.
                    $(this).datetimepicker({
                        timepicker: false,
                        format: 'Y-m-d'
                    });
                });
                //select2
                $('.select2').each(function() {
                    if ($(this).data('select2')) {
                        $(this).select2("destroy"); //destroys the previous settings.
                    }
                    $(this).select2();
                });
            }
        )

        $(document).ajaxComplete(function() {
            if(window['after_ajax_functions']){
                window['after_ajax_functions'].forEach(func=>func());
            }
        });
    </script>
    <style>
        #branch_code_s {
            width: 250px;
        }
        .select2-container{
            z-index: 1010;
        }
    </style>



    <? include($site['root-wtos'] . 'new_php_script.php');  ?>

</div>
</body>

</html>