<?
global $os,$pageVar;
$listingQuery=" select * from video where video_id>0 and active_status='active'  order by view_order ASC";
$resource=$os->pagingQuery($listingQuery,10,true);
$records=$resource['resource'];
$photogalleryRs = $records;
$gallery = [];
while ($photogallery = $os->mfa($photogalleryRs)) {
    $gallery[] = $photogallery;
}
// _d($gallery);
?>

<div class="uk-child-width-1-2@s uk-child-width-1-3@m  uk-grid-small" uk-grid="masonry:true" uk-lightbox="animation: slide">
    <?
    foreach($gallery as $video_gallery)
    {?>
        <div>
            <!-- <h4 style="margin: auto;width: 100px"><?=$video_gallery['title']?></h4> -->
             <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="width: 100%" height="300" type="text/html" src="<? echo $video_gallery['youtubeLink'] ?>?autoplay=0&fs=0&iv_load_policy=3&showinfo=0&rel=0&cc_load_policy=0&start=0&end=0"></iframe>
        </div>
    <? } ?>
</div>
<div class="pagenation"> <?php  echo $resource['links'];?></div>


