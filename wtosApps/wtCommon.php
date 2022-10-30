<?
global $site, $os;
error_reporting($site['environment']);
include($site['application'].'os.php');


$pageVar['segment']=array();
$os->wtospage=array();
$os->sefu()->setExtension('');//$os->sefu()->setExtension('.ijk');
$pagevar['defaultPage']='wtHome.php';//   to design home page seperately
$requestPage= $os->sefu->LoadPageName();
$pageVar['segment']=$os->sefu->getSegments();
$content = $pagevar['defaultPage'];
$os->site_settings = $os->getSettings();
$os->userDetails = $os->session($os->loginKey,'logedUser');
/*********
 * Global queries
 *********/
if($os->get('logout')=="logout")
{
    $os->Logout();
}


/*****
 * Maintenance
 */
if($os->val($os->site_settings, "Deactivate Site")=="1"){
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

/*******
 * Static Page
 *******/
$slug = $requestPage;
$page_file = __DIR__."/static-page-".$slug.".php";
if(file_exists($page_file)){
    include $page_file;
    exit();
}


$session_selected_get=date('Y');
if(isset($pageVar['segment'][2])){
    $session_selected_get=(int)$pageVar['segment'][2];
}
if($session_selected_get>2015 && $session_selected_get<2080   )
{
    $os->setSession($session_selected_get, 'session_selected');
}
$session_selected=$os->getSession( 'session_selected');






if($requestPage!="" && $requestPage!="home" )
{
    $os->wtospage =$os->rowByField('','pagecontent','seoId',$requestPage," and active=1  " ,'',' 1');
    if($os->wtospage['pagecontentId']>0)
    {
        $pageBody=preg_replace('/src=\".*?wtos-images/','src="'.$site['url']."wtos-images",stripslashes($os->wtospage['content']));
        $pageBody=$os->replaceWtBox($pageBody);
        $content='wtContent.php';

    }elseif(file_exists($site['application'].$requestPage.'.php'))

    {

        $content=$requestPage.'.php';

    }
    else
    {
        echo 'Error: Page Not Found.';
        exit();
    }
}else{
    $os->wtospage =$os->rowByField('','pagecontent','isHome','Yes'," and active=1  " ,'',' 1');
    $pageBody=preg_replace('/src=\".*?wtos-images/','src="'.$site['url']."wtos-images",stripslashes($os->wtospage['content']));
    $pageBody=$os->replaceWtBox($pageBody);
}


//check login
if($os->wtospage['login_access']==1 && !$os->isLogin()){
    $os->redirect($site["url"]);
    exit();
};


//$os->siteValidation();

$os->wtospage['ajax_path'] = $site['url']."ajax/".$os->wtospage["seoId"].".php";

/*******
 * Page Template
 *******/
$slug = $os->wtospage["seoId"];
$page_file = __DIR__."/page-".$slug.".php";
if(file_exists($page_file)){
    include $page_file;
    exit();
}



$pageName = "";
if (isset ( $pageVar ['segment'] [1] ))
{
    $pageName = $pageVar ['segment'] [1];
}
