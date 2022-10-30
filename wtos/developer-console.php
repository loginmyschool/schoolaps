<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('wtosConfigLocal.php');
global $os, $site;
include($site['root-wtos'].'top.php');
?>
<div class="title-bar border-color-grey">


</div>
<div>

    <div class="uk-section ">
        <div class="uk-container uk-container-small">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <h3>Settings</h3>
                </div>
                <div class="uk-card-body">
                    <?
                    $frontend_maintenance_mode = $os->val($os->site_settings,"Deactivate Site");
                    $backend_maintenance_mode = $os->val($os->site_settings,"Deactivate Backend");
                    ?>
                    <form>
                        <div class="uk-margin">
                            <div class="uk-grid uk-child-width-1-2@m" uk-grid>
                                <label class="text-l uk-text-right@m uk-width-medium@m">Frontend maintenance mode</label>
                                <div class="uk-width-expand">
                                    <div class="uk-switch text-m" >
                                        <input type="checkbox" name="test"
                                               id="frontend-maintenance-mode"
                                               onchange="wtosInlineEdit('frontend-maintenance-mode','settings','value','keyword','Deactivate Site','','','')"
                                               value="1" <?=$frontend_maintenance_mode==1?"checked ":"";?>>
                                        <label for="frontend-maintenance-mode"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <div class="uk-grid uk-child-width-1-2@m" uk-grid>
                                <label class="text-l uk-text-right@m uk-width-medium@m">Backend maintenance mode</label>
                                <div class="uk-width-expand">
                                    <div class="uk-switch text-m" >
                                        <input type="checkbox"
                                               name="test"
                                               id="backend-maintenance-mode"
                                               onchange="wtosInlineEdit('backend-maintenance-mode','settings','value','keyword','Deactivate Backend','','','')"
                                               value="1" value="1" <?=$backend_maintenance_mode==1?"checked ":"";?>>
                                        <label for="backend-maintenance-mode"></label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="uk-margin">
                            <div class="uk-grid uk-child-width-1-2@m" uk-grid>
                                <label class="text-l uk-text-right@m uk-width-medium@m">Maintenance Message</label>
                                <div class="uk-width-expand">
                                    <textarea class="uk-textarea uk-form-small summernote"
                                              id="maintenance_message"
                                              onchange="wtosInlineEdit('maintenance_message','settings','value','keyword','Deactivate Message','','','')"><?= $os->val($os->site_settings,"Deactivate Message"); ?></textarea>
                                </div>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.3/socket.io.js" integrity="sha512-Jr0UIR/Q8MUX+93zjDOhuDUKLqJZObtwpkLJQcR9qMaLgL0thet39IORuavUaZFkZ8a4ktrUsKPM9mf5LWMduA==" crossorigin="anonymous"></script>
<script>

</script>
<? include($site['root-wtos'].'bottom.php'); ?>
