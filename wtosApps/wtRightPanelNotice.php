<?
$notice=$os->get_noticeboard('',"status='Active' order by priority");
?>
<div class="col-lg-4 offset-1">
    <div class="card p-lg-5 notice_board">
      <div class="section-title">
        <p>Notice Board</p>
        <div class="divider"></div>
    </div>
    <div>

        <marquee onmouseover="this.stop();" scrollamount="3" onmouseout="this.start();" direction="up"
        height="220px">
        <ul class="notice">
            <? while(  $record=$os->mfa($notice )){
                $link=$record['link'];
                    if($record['file']!='') {
                        $link=$site['url'].$record['file'];
                    }
                    if($record['link']!='')
                    {
                        $link=$record['link'];
                    }
                    $statusNew=$record['statusNew'];
                    $publisherDate=$os->showDate($record['publisherDate']);
            ?>
            <li>
              <p><i class="bi bi-subtract" style="color: #2155CD"></i> &nbsp;&nbsp;<? echo $record['title'] ?></p>
              <a href="<? echo $site['url']?>Notice/<?php echo $record['noticeboardId'];?>"><? echo substr($record['description'],0,100) ?>...</a>
          </li>
          <?}?>
  </ul>
</marquee>
</div>
</div>

</div>