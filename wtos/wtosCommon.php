<?
if (session_id() === "") { session_start(); }
global $site, $os;
error_reporting($site['environment']);
include($site['root-wtos'].'wtos.php');
include $site["root"].'/vendor/autoload.php';
$os->userDetails = $os->session($os->loginKey,'logedUser');
$os->site_settings = $os->getSettings();
$os->mq("SET sql_mode=''");

/*****
 * Maintenance
 */

if($os->val($os->site_settings, "Deactivate Backend")=="1" &&
    $os->userDetails["adminType"]!=="Super Admin"){
    ?>
    <html lang="en-gb">
    <head>
        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.10/dist/css/uikit.min.css" />
        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.10/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.10/dist/js/uikit-icons.min.js"></script>
        <title>This site is temporarily under construction</title>
    </head>
    <body class="uk-flex-middle uk-flex-center uk-flex uk-height-1-1">
    <div class="deactivateMessage">
        <?= $os->val($os->site_settings, "Deactivate Message")?>
    </div>
    </body>
    </html>
    <? exit();
}

if($os->session($os->loginKey,'logedUser','active')!='Active')
{
    $os->Logout();
}

// -- added instant access

$adminId_loggeed=$os->val($os->userDetails,'adminId');
$userDetails=$os->rowByField('','admin',$fld='adminId',$fldVal=$adminId_loggeed,$where='',$orderby='');
$os->userDetails= $userDetails;
// _d($os->userDetails);
if($os->val($userDetails,'active')!='Active')
{
    $os->Logout();
}

if($os->get('logout')=="logout")
{
    $os->Logout();
    session_destroy();
}

if($os->CurrentPageName()!='index.php')
{
    if(!$os->isLogin())  {	 ?>
        <script type="text/javascript" language="javascript">
            window.location="<?= $site['url']?>";
        </script>
        <?
        exit();  }
}

function get_menu($branch_code=''){

    global $os;
    //
    $branches = [];
    $b_q = $os->mq("SELECT * FROM branch");
    while($b = $os->mfa($b_q)){
        $branches[] = $b['branch_code'];
    }
    //

    $adminType = $os->userDetails['adminType'];
    $menu = [];
    $query = $os->mq("SELECT * FROM admin_menu WHERE active_status='Active'");
    while($item = $os->mfa($query)){
        $menu[$item['admin_menu_id']] = $item;
    }

    $branch_menu = [];
    $all_menu = [];

    if($adminType=='Super Admin') {
        foreach ($branches as $branch) {
            foreach ($menu as $item) {
                $branch_menu[$branch][$item['parent_admin_menu_id']][$item['admin_menu_id']] = $item;
                $all_menu[$item['parent_admin_menu_id']][$item['admin_menu_id']] = $item;


            }
        }
    }
    else
        {
        $accesses = (array)(@json_decode($os->userDetails['access']));
        foreach ($accesses as $branch => $access) {
            foreach ($menu as $item) {


                if($item["only_super_admin"]=="Yes"){
                    continue;
                }
                $access_key = $item['access_key'];
                if (in_array($access_key, $access)) {
                    $branch_menu[$branch][$item['parent_admin_menu_id']][$item['admin_menu_id']] = $item;
                }

                $all_menu[$item['parent_admin_menu_id']][$item['admin_menu_id']] = $item;
            }
        }
    }


    return $branch_code==""?$branch_menu:($branch_code=="all"?$all_menu:$branch_menu[$branch_code]);
}

function get_branches($option=false, $for_current_user=false){
    global $os;
    $branches = [];
    $b_q = $os->mq("SELECT * FROM branch");
    $accesses = (array)(@json_decode($os->userDetails['access']));
    $adminType = $os->userDetails['adminType'];
    while($b = $os->mfa($b_q)){
        if($adminType=="Super Admin" || array_key_exists($b['branch_code'], $accesses)) {
            $branches[$b['branch_code']] = $option ? $b['branch_name'] : $b;
        }
    }
    return $branches;
}





