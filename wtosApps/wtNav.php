<?
$and_login_access=' and login_access=0 ';
if($os->isLogin() )
{
    $and_login_access='';
}
?>

<div class="">
    <div class="uk-flex uk-flex-right uk-flex-middle uk-visible@m">
        <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
            <div class="uk-navbar-right ">
                <ul class="uk-navbar-nav ">
                    <?php
                    $currentPage='';
                    if(isset($pageVar['segment'][1])) {
                        $currentPage=$pageVar['segment'][1];
                    }

                    foreach($header_menu as $page)

                    {


                        $pageSeoLink=($page['externalLink']=='')?$os->sefu->l($page['seoId']):$pageSeoLink=$page['externalLink'];
                        $_target=($page['openNewTab']<1)?'':'target="_blank"';
                        $parenpageId = $page['pagecontentId'];


                        if(($page['login_access']==1 && $os->isLogin()) || ($page['login_access']==2 && !$os->isLogin()) || $page['login_access']==0){
                        ?>
                        <li>
                            <a  <? if($page['seoId'] == $currentPage){ ?>class="active"<? } ?> title="<? echo $page['title'] ?>"  <?php echo $_target ?> href="<? echo $pageSeoLink ?>"  >
                                <? echo $page['title'] ?>
                                <? if(is_array($os->val($child_menu, $parenpageId))){?>
                                    <i class="las la-angle-down"></i>
                                <?} ?>
                            </a>

                            <?

                            if (is_array($os->val($child_menu, $parenpageId))) {
                                ?>
                                <div class="uk-navbar-dropdown">
                                    <ul class="uk-nav uk-navbar-dropdown-nav">
                                        <? foreach ($os->val($child_menu, $parenpageId) as $subPages){
                                            if (is_array($subPages)) {
                                                $pageSeoLink=($subPages['externalLink']=='')?$os->sefu->l($subPages['seoId']):$pageSeoLink=$subPages['externalLink'];
                                                ?>
                                                <li><a href="<? echo $pageSeoLink ?>" <? echo $subPages['title'] ?> <?php echo $_target ?>><? echo $subPages['title'] ?></a></li>
                                            <? }?>
                                        <?}
                                        ?>
                                    </ul>
                                </div>
                            <? } ?>
                        </li>
                    <? }
                    }?>
                </ul>
            </div>
        </nav>
    </div>
    <div id="offcanvas-nav" uk-offcanvas="overlay: true;">
        <div class="uk-offcanvas-bar">

            <div class="uk-margin uk-text-center">
                <img class="uk-width-small " src="<? echo $site['url']?><? echo $school_setting_data['logoimage']?>" alt="<? echo $school_setting_data['school_name'];  ?>"/>
            </div>

            <ul class="uk-nav uk-nav-default uk-nav-parent-icon" uk-nav>
                <?php
                $currentPage='';
                if(isset($pageVar['segment'][1])) {
                    $currentPage=$pageVar['segment'][1];
                }

                foreach($header_menu as $page)

                {
                    $pageSeoLink=($page['externalLink']=='')?$os->sefu->l($page['seoId']):$pageSeoLink=$page['externalLink'];
                    $_target=($page['openNewTab']<1)?'':'target="_blank"';
                    $parenpageId = $page['pagecontentId'];
                    if(($page['login_access']==1 && $os->isLogin()) || ($page['login_access']==2 && !$os->isLogin()) || $page['login_access']==0){

                        ?>
                        <li class="<? if(is_array($os->val($child_menu, $parenpageId))){?>uk-parent<? }?>">
                            <a  <? if($page['seoId'] == $currentPage){ ?>class="active"<? } ?> title="<? echo $page['title'] ?>"  <?php echo $_target ?> href="<? echo $pageSeoLink ?>"  >
                                <? echo $page['title'] ?>
                            </a>

                            <?

                            if (is_array($os->val($child_menu, $parenpageId))) {
                                ?>


                                <ul class="uk-nav-sub">
                                    <? foreach ($os->val($child_menu, $parenpageId) as $subPages){
                                        if (is_array($subPages)) {
                                            $pageSeoLink=($subPages['externalLink']=='')?$os->sefu->l($subPages['seoId']):$pageSeoLink=$subPages['externalLink'];
                                            ?>
                                            <li><a <? if($subPages['seoId'] == $currentPage){ ?>class="active"<? } ?>  href="<? echo $pageSeoLink ?>" <? echo $subPages['title'] ?> <?php echo $_target ?>><? echo $subPages['title'] ?></a></li>
                                        <? }?>
                                    <?}
                                    ?>
                                </ul>
                            <? } ?>
                        </li>
                        <li class="uk-nav-divider"></li>
                        <?
                    }
                } ?>
            </ul>
        </div>
    </div>
</div>


