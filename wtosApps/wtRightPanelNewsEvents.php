 <section id="testimonials" class="testimonials">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <p>Events & News</p>
      <div class="divider"></div>
    </div>
    <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper-wrapper">
       
        <div class="swiper-slide">
		 <?
        $where=" status ='Active'";
        $latestNews = $os->getTable("" ,"news",$where,' priority','');
        $i=0;
        while( $val=$os->mfa($latestNews)){          
        ?>
          <div class="card">
            <img class="card-img-top" src="<?php echo $site['url'];?><? echo $val['newsImage']; ?>" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title"><? echo $val['title']; ?></h5>
              <p class="card-text"><? echo substr($val['briefDescription'],0,100) ?>...</p>
            </div>
          </div>
		  
		  
		   <? $i++;}?>
        </div>
       
		
      </div>
      <div class="swiper-pagination"></div>
    </div>

  </div>
</section>