<?
global $os, $site, $school_setting_data;
$menu_links = $os->mq("SELECT pagecontentId, seoId, title, onBottom, onHead, openNewTab,externalLink, parentPage, login_access FROM pagecontent WHERE active='1' ORDER BY priority ASC");
$header_menu = [];
$footer_menu = [];
$child_menu = [];
while ($link = $os->mfa($menu_links)) {
    if ($link["parentPage"] > 0) {
        $child_menu[$link["parentPage"]][] = $link;
    }
    if ($link["parentPage"] < 1 && $link["onHead"] == 1) {
        $header_menu[$link['pagecontentId']] = $link;
    }
    if ($link["onBottom"] == 1) {
        $footer_menu[$link['pagecontentId']] = $link;
    }
}
?>
<?php
$currentPage='';
if(isset($pageVar['segment'][1])) {
     $currentPage=$pageVar['segment'][1];
}
foreach($header_menu as $page){
   $pageSeoLink=($page['externalLink']=='')?$os->sefu->l($page['seoId']):$pageSeoLink=$page['externalLink'];
    $_target=($page['openNewTab']<1)?'':'target="_blank"';
    $parenpageId = $page['pagecontentId'];
    $nav_link_cls='nav-link scrollto';
    if($page['seoId']=='login'){
        $nav_link_cls='getstarted scrollto';
    }

    ?>
    <li>
        <a class="<?echo $nav_link_cls?> <? if($page['seoId'] == $currentPage){ ?> active <? } ?>" title="<? echo $page['title'] ?>"  <?php echo $_target ?> href="<? echo $pageSeoLink ?>"  >
            <? echo $page['title'] ?>
        </a>

        <? if (is_array($os->val($child_menu, $parenpageId))) {
            ?>
            <ul>
                <? foreach ($os->val($child_menu, $parenpageId) as $subPages){
                    if (is_array($subPages)) {
                        $pageSeoLink=($subPages['externalLink']=='')?$os->sefu->l($subPages['seoId']):$pageSeoLink=$subPages['externalLink'];
                        ?>
                        <li><a href="<? echo $pageSeoLink ?>" <? echo $subPages['title'] ?> <?php echo $_target ?>><? echo $subPages['title'] ?></a></li>
                    <? }?>
                    <?}
                    ?>
                </ul>
            <? } ?>
        </li>
    <? }?>
