
<div class="side-nav uk-margin uk-card uk-card-small uk-card-default border-radius-m">
    <div class="uk-card-header">
        <h3 class="uk-card-title">Photo Gallery</h3>
    </div>
    <div class="uk-card-body">

        <div>
            <ul class=" uk-grid uk-grid-small uk-child-width-1-2" uk-grid="masonry:true" uk-margin>
                <?

                // $photogallerycatRs = $os->get_gallerycatagory('',"active='Active'",'priority',' limit 0,4 ','');

                $photoquery=" select gc.*,pg.name from gallerycatagory gc    LEFT JOIN photogallery pg on(pg.galleryCatagoryId=gc.galleryCatagoryId) 
				where  gc.active='Active' and pg.name!='' group  by gc.galleryCatagoryId  order by gc.priority  asc limit 4 ";

                $photogallerycatRs = $os->mq($photoquery);

                $c=1;
                while($photogallerycat=$os->mfa($photogallerycatRs))
                {

                    // _d($photogallerycat);

                    $divId="home-gallery-".$c;
                    $galleryId = $photogallerycat['galleryCatagoryId'];
                    $where ="and status='Active'";
                    //  $photoDetails = $os->rowByField('','photogallery','galleryCatagoryId',$galleryId,$where);
                    //  if(is_array($photoDetails)){
                    ?>
                    <li id="<? echo $divId?>">
                        <a class="uk-width-1-1"   href="javascript:void(0);" onclick="gogallerycategory('<? echo $photogallerycat['galleryCatagoryId']; ?>')">
                            <img src="<? echo $site['url'].$photogallerycat['name']; ?>" class="uk-width-1-1 uk-border-rounded" alt="">
                        </a>
                    </li>
                    <?
                    // }
                    $c++;
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="uk-card-footer">
        <a href="javascript:void(0);" onclick="gogallerycategory('')">View more</a>
    </div>
</div>


<script type="text/javascript">

    function gogallerycategory(gogallerycategory)
    {
        if(gogallerycategory==''){
            window.location="<?php echo $site['url'].'Album'?>";
        }else
        {
            window.location="<?php echo $site['url'].'Gallery'?>/"+gogallerycategory;
        }

    }

</script>




<div class="side-nav uk-margin uk-card uk-card-small uk-card-default border-radius-m">
    <div class="uk-card-header">
        <h3 class="uk-card-title">Video Gallery</h3>
    </div>
    <div class="uk-card-body">

        <div>
            <?
            $video="select * from video where active_status='Active'";

            $video_rs=$os->mq($video);

            while($record=$os->mfa( $video_rs))
            {
                ?>
                <video style="width: 100%"  src="<?= $record['youtubeLink'] ?>" controls></video>
				<!--<iframe id="ytplayer" type="text/html" width="640" height="360"
  src="<?= $record['youtubeLink'] ?>?autoplay=1&origin=https://webtrackers.co.in"
  frameborder="0"></iframe>-->
                <?

            }

            ?>
        </div>
    </div>
    <div class="uk-card-footer">
        <a href="<?php echo $site['url'].'video-gallery'?>">View more</a>
    </div>
</div>

