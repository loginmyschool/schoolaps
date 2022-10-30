<?

global $pageVar;
global $os;

if(isset($pageVar['segment'][2]))
{

    $newsId =  $pageVar['segment'][2];

    $q = "select * from news where newsId = '$newsId' and status='active'  ";
    $rs = $os->mq($q);
    while( $val=$os->mfa($rs))
    {



        ?>
        <div class="newse_block">
            <div style="padding:2px 0px 7px 0px;">
                <a href="<? echo $site['url'] ?>news">Back</a>
            </div>



            <div class="events-details">
                <h2 class="uk-margin-remove-adjsecondary uk-text-bold uk-margin-small-bottom">
                    <? echo $val['title']; ?>   <span  style="color:#FF0000" ><?  if($val['eventsType']!=''){   echo $val['eventsType']   ;   }?>  </span> </h2>

                <p class="uk-article-meta">

                    <span data-uk-icon="icon: calendar" class="uk-icon"></span> <? echo $os->showDate($val['publicationDate']); ?> <span class="uk-margin-small-right uk-margin-small-left">|</span>
                    <span data-uk-icon="icon: future" class="uk-icon"></span> <? echo $val['fromTime'] ?>-<? echo $val['toTime'] ?> <span class="uk-margin-small-right uk-margin-small-left">|</span>
                    <em class="uk-text-small"><span data-uk-icon="icon: location" class="uk-icon"></span> <? echo $val['venue'] ?></em>
                </p>

                <!--<div class="event-location">
                    <i class="fa fa-map-marker"></i> <span> <? echo $val['venue'] ?></span>
                </div>

                <div class="event-meta">

                    <div class="event-time">

                        <i class="fa fa-clock-o"></i>

                        <span> <? echo $val['fromTime'] ?>-<? echo $val['toTime'] ?></span>

                    </div>

                    <div class="event-date">

                        <i class="fa fa-calendar"></i>

                        <span><? echo $os->showDate($val['publicationDate']); ?></span>

                    </div>-->

            </div>

            <? if(isset($val['newsImage'])){ ?>
                <div class="image">
                <a href="<? echo $site['url'].$val['newsImage'] ?>" class="uk-block" >
                    <img src="<? echo $site['url'].$val['newsImage'] ?>" alt="" class="uk-width-1-1"/>
                </a>
                </div>
            <? } ?>

            <p class="dec">
                <? echo $val['briefDescription'] ?>
            </p>


            <p class="dec">
                <? echo $val['fullDescription'] ?>
            </p>



        </div>
        </div>


        <?

    }

}else
{

    $q = "select * from news where   status='active' order by priority asc ";
    $rs = $os->mq($q);
    ?>
    <div>
        <?
        while( $val=$os->mfa($rs))
        {
            ?>

            <div class="p-xl border-xxs uk-margin  uk-border-rounded uk-position-relative"  style="border-color: #e5e5e5; background-color: #fafafa">

                <div class="uk-grid" uk-grid>
                    <div class="uk-width-expand">

                        <? if(isset($val['newsImage'])){ ?>
                            <div class="uk-hidden@s uk-margin">
                                <img class="uk-border-rounded uk-width-1-1" src="<? echo $site['url'].$val['newsImage'] ?>" alt=""/>
                            </div>
                        <? } ?>


                        <p class="text-xl uk-margin-remove" style="color: #000"><? echo $val['title']; ?></p>
                        <div class="uk-text-muted text-s m-bottom-m ">

                            <span data-uk-icon="icon: calendar; ratio:0.7" class="uk-icon"></span> <? echo $os->showDate($val['publicationDate']); ?> <span class="uk-margin-small-right uk-margin-small-left">|</span>
                            <span data-uk-icon="icon: future; ratio:0.7" class="uk-icon"></span> <? echo $val['fromTime'] ?>-<? echo $val['toTime'] ?> <span class="uk-margin-small-right uk-margin-small-left">|</span>
                            <em class="uk-text-nowrap">
                                <span data-uk-icon="icon: location; ratio:0.7" class="uk-icon"></span> <? echo $val['venue'] ?>
                            </em>
                        </div>
                        <div class="text-m uk-text-muted uk-overflow-hidden ">
                            <? echo $val['briefDescription'] ?>
                        </div>
                        <a href="<? echo $site['url'] ?>news/<? echo $val['newsId']  ?>"
                           class="uk-link">
                            READ MORE
                        </a>

                        <? if($val['eventsType']!=''){ ?>
                            <div class="uk-position-absolute uk-position-top-left  p-xxs p-left-m p-right-m " style="clip-path: polygon(39% 10%, 100% 0, 91% 32%, 100% 100%, 62% 85%, 0 100%, 12% 61%, 0 0);top:-8px; left:-8px;background-color: red; color: white">
                                <small><?=  $val['eventsType'] ?></small>
                            </div>
                        <? } ?>
                    </div>
                    <? if(isset($val['newsImage'])){ ?>
                        <div class="uk-visible@s">
                            <img class="uk-border-rounded news-pic" src="<? echo $site['url'].$val['newsImage'] ?>" alt=""/>
                        </div>
                    <? } ?>
                </div>
            </div>

            <?
        }
        ?>
    </div>
    <?
}
?>
<style>
    .news-pic{
        object-fit: cover;object-position: center
        height: 45px;
        width: 45px;
    }
    @media(min-width: 600px){
        .news-pic{
            height: 90px;
            width: 90px;
        }
    }
</style>
