<?
global $os,$pageVar;
$galleryId = $pageVar['segment'][2];
//$photogalleryRs = $os->get_photogallery('',"status='Active' and galleryCatagoryId = $galleryId","",'','');


$listingQuery=" select * from photogallery where status='Active' and galleryCatagoryId = $galleryId order by priority , photoGalleryId ASC";
$resource=$os->pagingQuery($listingQuery,21,true);
$records=$resource['resource'];
$photogalleryRs = $records;

$gallery = [];
while ($photogallery = $os->mfa($photogalleryRs)) {

    $gallery[] = $photogallery;
}
?>

<div class="uk-child-width-1-2@s uk-child-width-1-3@m  uk-grid-small" uk-grid="masonry:true" uk-lightbox="animation: slide">
    <?
    foreach($gallery as $photogallery)
    {?>
        <div>
            <a class="uk-display-block" href="<? echo $site['url'].$photogallery['name'] ?>" data-caption="<?=$photogallery['name'] ?>">
                <img alt="" class="uk-width-1-1" src="<? echo $site['url'].$photogallery['name'] ?>">
            </a>
        </div>
    <? } ?>
</div>




<div class="pagenation"> <?php  echo $resource['links'];?></div>


