<?
global $os,$pageVar;

$galleryId = $pageVar['segment'][2];
//$photogalleryRs = $os->get_photogallery('',"status='Active' and galleryCatagoryId = $galleryId","",'','');
$listingQuery=" select * from photogallery where status='Active' and galleryCatagoryId = $galleryId order by priority , photoGalleryId ASC";
##  fetch row
$resource=$os->pagingQuery($listingQuery,21,true);
$records=$resource['resource'];
$photogalleryRs=$records;
	

?>
<style>
.selected{ color:#6B6B6B; font-weight:bold; font-size:24px;}
</style>
<!-- <img src="<? echo $site['themePath']?><?php echo $site['themePath']?><? echo $site['url'].$photogallery['name'] ?>"> -->

	<div> <?php  echo $resource['links'];?></div>
	<div class="gallery_page">
    	<div class="row">
            <ul class="thumbnails clearfix">
			 
			
            <?
            	while($photogallery=$os->mfa($photogalleryRs))		
					 
				{

            ?>
                
                <li class="col-md-4 col-sm-3 col-xs-4 box">
                    <a class="thumbnail group4" rel="example_group" href="<? echo $site['url'].$photogallery['name'] ?>"><img class="group1" src="<? echo $site['url'].$photogallery['name'] ?>" title="" alt="" /></a>
                </li> <!--end thumb -->
                
                
                
                <? } ?>
                
            </ul>
        </div>
    </div>
<div> <?php  echo $resource['links'];?></div>