<?
global $os,$pageVar;

$andnoticeboardId='';
if (isset ( $pageVar ['segment'] [2] ))
{
    $noticeboardId_get = $pageVar ['segment'] [2];
    $andnoticeboardId="and noticeboardId='$noticeboardId_get'";
}

$notice=$os->get_noticeboard('',"noticeboardId>0 $andnoticeboardId and status='Active' order by priority");
?>


<?
if(isset($pageVar ['segment'] [2])){
    ?>
    <? while(  $record=$os->mfa($notice )){
        $link=$record['link'];
        if($record['file']!='')
        {
            $link=$site['url'].$record['file'];

        }
        if($record['link']!='')
        {
            $link=$record['link'];

        }
        $statusNew=$record['statusNew'];
        $publisherDate=$os->showDate($record['publisherDate']);
        ?>

        <div class="  uk-position-relative">
            <p class="m-bottom-m text-xl" style="color: #000; margin-bottom: 0px !important;">
                <?php echo $record['title'] ?>
            </p>
            <span style="margin-bottom: 10px">
                <small>
                        <span>
                            <em>Published By</em>
                            <font class="uk-text-secondary"><? echo $record['publisherName'] ?></font>
                        </span>
                    <span class="uk-margin-small-right uk-margin-small-left">|</span>
                    <span data-uk-icon="icon: calendar; ratio:0.7" class="uk-icon"></span>
                    <?
                    $date=date_create($publisherDate);
                    echo date_format($date,"dS M, Y");
                    ?>
                </small>
            </span>
            <div class="text-m uk-text-muted uk-overflow-hidden uk-margin">
                <?php echo $record['description'] ?>
            </div>
        </div>
    <?}?>
    <?
} else {?>
    <div class="uk-grid uk-child-width-1-1" uk-grid>

        <? while(  $record=$os->mfa($notice )){
            $link=$record['link'];
            if($record['file']!='')
            {
                $link=$site['url'].$record['file'];

            }
            if($record['link']!='')
            {
                $link=$record['link'];

            }
            $statusNew=$record['statusNew'];

            $publisherDate=$os->showDate($record['publisherDate']);

            //$publisherDateArray=explode("-",$publisherDate);

            //_d($publisherDateArray);
            //echo $os->rentMonth[$publisherDateArray[1]];


            ?>



            <article class="uk-hidden">
                <header>

                    <h2 class="uk-margin-remove-adjsecondary uk-text-bold uk-margin-small-bottom">
                        <a title="<? echo $record['title'] ?> " class="uk-link-reset" href="<? echo $site['url'] ?>Notice/<? echo $record['noticeboardId'] ?> ">
                            <? echo $record['title'] ?>

                            <? if($statusNew){ ?>
                                <span class="label label-danger" style="color:#FF0000; font-size:14px; background-color:#FF0000; color:#FFFFFF; padding:1px 5px 0px 5px;"><?php if($statusNew) {?>New<? }?></span><? }?>

                        </a>
                    </h2>
                    <p class="uk-article-meta">
                        <em class="uk-text-small">Published By</em> <font class="uk-text-secondary"><? echo $record['publisherName'] ?></font>
                        <span class="uk-margin-small-right uk-margin-small-left">|</span>
                        <span data-uk-icon="icon: calendar" class="uk-icon"></span> <?echo $publisherDate;?>
                    </p>


                </header>
                <? if($andnoticeboardId!=''){ ?>
                    <p class="des"><? echo $record['description'] ?></p>
                    <? if($link){?>

                        <? if(strstr($link,'jpg')){ ?> <img src="<? echo $link ?>" /><br /> <? } ?>
                        <a href="<? echo $link ?>" target="_blank" title="Download" class="uk-button uk-border-roundeduk-border-rounded uk-button uk-border-roundeduk-border-rounded-default uk-button uk-border-roundeduk-border-rounded-small">View</a>
                    <? } ?>
                    <hr>
                <? } ?>
            </article>

            <div>
                <div class=" p-xl uk-margin  border-xxs uk-border-rounded uk-position-relative" style="border-color: #e5e5e5; background-color: #fafafa">

                    <p class="m-bottom-m text-xl uk-margin-remove" style="color: #000"><?php echo $record['title'] ?></p>
                    <div>
                        <small>
                        <span>
                            <em>Published By</em>
                            <font class="uk-text-secondary"><? echo $record['publisherName'] ?></font>
                        </span>
                            <span class="uk-margin-small-right uk-margin-small-left">|</span>
                            <span data-uk-icon="icon: calendar; ratio:0.7" class="uk-icon"></span>
                            <?
                            $date=date_create($publisherDate);
                            echo date_format($date,"dS M, Y");
                            ?>
                        </small>
                    </div>
                    <div class="text-m uk-text-muted uk-overflow-hidden uk-visible@s uk-position-relative"
                         style="max-height: 90px;">
                        <?php echo $record['description'] ?>
                        <div class="uk-position-absolute uk-position-bottom uk-width-1-1 p-l "
                             style="background: linear-gradient(180deg, rgba(255,255,255,0) 25%, rgba(250,250,250,1) 100%);"></div>
                    </div>

                    <div class="m-top-m">
                        <a href="<?php echo $site['url']?>Notice/<?php echo $record['noticeboardId']; ?>"
                           class="uk-link  ">Read More</a>
                    </div>
                    <?php if ($statusNew) {?>
                        <div class="uk-position-absolute uk-position-top-left  p-xxs p-left-m p-right-m " style="clip-path: polygon(39% 10%, 100% 0, 91% 32%, 100% 100%, 62% 85%, 0 100%, 12% 61%, 0 0);top:-8px; left:-8px;background-color: red; color: white">
                            <small>New</small>
                        </div>
                    <?} ?>
                </div>
            </div>

        <?}?>

    </div>
<?} ?>

