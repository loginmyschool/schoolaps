<?
global $os, $site, $pageBody;
$ajaxFilePath =$site['url'].'wtosApps/wtAjax.php';
?>
<? echo stripslashes($os->wtospage['pageCss']); ?>
<!-- ======= Hero Section ======= -->
<section id="hero">
  <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

    <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

    <div class="carousel-inner" role="listbox">
      <?
      $bannerImageQuery="select * from bannerimage where bannerImageId>0  and active='Active'  order by priority  ";
      $bannerImageMq=$os->mq($bannerImageQuery);
      $banner_count=0;
      while($bannerImageData=$os->mfa($bannerImageMq)){
        ?>
        <div class="carousel-item <?if($banner_count==0){?>active<?}?>" style="background-image: url(<? echo $site['url']?><? echo $bannerImageData['image'];  ?>">
          <div class="carousel-container">
           <!--  <div class="container">
              <h4 class="animate__animated animate__fadeInDown">Welcome To Our School</h4>
              <h2 class="animate__animated animate__fadeInDown">Our School</h2>
              <p class="animate__animated animate__fadeInUp">Health Education and Welfare Trust</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div> -->
			<? echo $bannerImageData['htmlText'];  ?>
			<img src="<? echo $site['url']?><? echo $bannerImageData['image'];?>" style="width:80%; " >
            
          </div>
        </div>
        <?$banner_count++;}?>
        

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
        <? echo $pageBody;?>
      </div>
    </section><!-- End About Section -->
	
 <!-- chair person -->
 	<section class="section-bg">

      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6">
            <div class="section-title">
              <p>Chief Patron's Desk</p>
              <div class="divider"></div>
            </div>

            <img src="<? echo $site['themePath']?>assets/img/chiefpatronDesk.jpeg" class="rounded-circle mb-4"  height="300" width="300" />

            <p class="text-justify">
              It was my long-cherished disposition to light the torch of knowledge in the hearts of the innocent tender-
              aged learners. For the purpose of materializing my dormant dream English oriental academy was inaugurated
              in 2006 on 5th May at Aurangabad where the culture of English is rarely found for the sheer lack Of
              opportunity. Most of the tiny-tots are bound to go to other schools to mitigate their profound craze for
              learning and speaking English fluently. It is irksome and trouble-some long travel to Farakka. Undoubtedly
              this institute is benediction to the students of our educationally backward locality. But I yearn the
              grace of the omniscient God and solemn cooperation of the conscious parents, teachers well- wishers and
              the elite to meleriorate the academic standard of the school.
            </p>

            <p class="text-left"><span
              style="display: block;font-family: 'Sofia', cursive; font-style: italic; font-size: 18px; font-weight: bold;">Jakir
            Hossain</span><span style="display: block;">Chief Patron</span><span style="display: block;"
            class="schoolName">English Oriental Academy</span></p>


          </div>

          <div class="col-lg-6">
            <div class="section-title">
              <p>Chairperson's Desk </p>
              <div class="divider"></div>
            </div>

            <img src="<? echo $site['themePath']?>assets/img/chairpersonDesk.jpeg" class="rounded-circle mb-4"  height="300" width="280" />


            <p class="text-justify">
              With profound benediction of the omnipotent God I have shouldered the responsibility of propelling the
              cargo of education of the young learns genuine craze for education ignites my heart and I come forward to
              create prolific English environment in the school campus with an eye to promote literacy Activities and
              creative thinking amongst the budding generation. The students of English Oriental Academy will be
              ambassadors of cultural and intellectual legacy. It is my earnest appeal to the teachers, taughts, and
              non-teaching staff to perform their respective duties properly with a view to brightening the lives of the
              immortal fire. It is my firm belief that our school will flourish in all over West Bengal with its name,
              Fame and brilliant results of the learners, it is now C.B.S.E affiliated and upgraded upto H/S Humanities
              And science, course. My warm wishes to all.




            </p>

            <p class="text-right"><span
              style="display: block;font-family: 'Sofia', cursive; font-style: italic; font-size: 18px; font-weight: bold;">Mira
            Bibi</span><span style="display: block;">Chairperson</span><span style="display: block;"
            class="schoolName">English Oriental Academy</span></p>

          </div>


        </div>

      </div>


    </section>
<section class="section-bg">

      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6">
            <div class="section-title">
              <p>Rector's Desk</p>
              <div class="divider"></div>
            </div>

            <img src="<? echo $site['themePath']?>assets/img/rectorDesk.png" class="rounded-circle mb-4"  height="300" width="285" />

            <p class="text-justify">
             I am extremely pleased for obtaining C.B.S.E Affiliation having No 2430171 and its upgradation up to H/S ( Humanities and science stream) . This English Medium Institute is entirely fostered, monitored, financed and Frequently visited by our hon'ble state labour minister shree Jakir Hossain. As education spells success, growth, prestige, power and glamour, we do Not want to miss the bus of purified, magnified and dignified education and have pinned our hopes to arrange effective coaching for joint Entrance Exam in near future. Let us implore that blessings of God may shower upon us so that the solemn oaths do not remain untouched .
            </p>

            <p class="text-left"><span
              style="display: block;font-family: 'Sofia', cursive; font-style: italic; font-size: 18px; font-weight: bold;">Aftabuddin Ahamed</span><span style="display: block;">Rector</span><span style="display: block;"
            class="schoolName">English Oriental Academy</span></p>


          </div>

          <div class="col-lg-6">
            <div class="section-title">
              <p>Principal's Desk </p>
              <div class="divider"></div>
            </div>

            <img src="<? echo $site['themePath']?>assets/img/principleDesk.png" class="rounded-circle mb-4"  height="300" width="300" />


            <p class="text-justify">
The aim of our School is to help our students to grow and become responsible citizens who are capable to face the challenges of the present world. Our school is established with vision of offering quality education. A school is a place where students begin to learn lessons of life and we help learn lessons of life and we help them for their all round Development. The biggest challenge we all face today is to prepare our students for a globalized world. We always encourage each child to develop in their special field of interest. It is the need of the time to focus on the intellects of our rising buds. Albert Einstein once said that intellectual growth should commence at birth and Cease only at death. I would like to thank the management for their support and co-operation.



            </p>

            <p class="text-right"><span
              style="display: block;font-family: 'Sofia', cursive; font-style: italic; font-size: 18px; font-weight: bold;">Partha Sengupta</span><span style="display: block;">Principal</span><span style="display: block;"
            class="schoolName">English Oriental Academy</span></p>

          </div>


        </div>

      </div>


    </section>
    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container" data-aos="fade-up">

        <div class="row no-gutters">
          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="fa-solid fa-graduation-cap"></i>
              <span data-purecounter-start="0" data-purecounter-end="1232" data-purecounter-duration="1"
              class="purecounter"></span>
              <p>Students</p>

            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="fa-solid fa-graduation-cap"></i>
              <span data-purecounter-start="0" data-purecounter-end="89" data-purecounter-duration="1"
              class="purecounter"></span>
              <p>Teacher</p>

            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="fa-solid fa-graduation-cap"></i>
              <span data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="1"
              class="purecounter"></span>
              <p>HS Topper</p>

            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="fa-solid fa-graduation-cap"></i>
              <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1"
              class="purecounter"></span>
              <p>Madhyamik</p>

            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->


    <!-- Our Vission - Mission Start -->

    <section class="section-bg">

      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-7">
            <div class="section-title">
              <p>Our Vission</p>
              <div class="divider"></div>
            </div>

            <p class="text-justify">
              The strength of the education system at EOA is the presence of creative and innovative atmosphere Nurtured
              by the self â€“ exploration to enquire, to experiment and to find the truth in the best sprit of
              Comradeship and indomitable will.

            </p>

            <div class="section-title">
              <p>Our Mission</p>
              <div class="divider"></div>
            </div>

            <p class="text-justify">
              The school is managed by shivam education and welfare trust (Regd), Aurangabad Murshidabad.The society
              aims at the overall development of the public of Aurangabad, Murshidabad , W.B. and Surrounding places .
              Our focus on modern system of education aswellas new career requirements Moved them into the right
              direction and strengthen a culture of academic excellence.

            </p>
          </div>          
          <?php include('wtRightPanelNotice.php'); ?>
        </div>

      </div>


    </section>

    <!-- END Vission - Mission -->


    <!-- ======= Testimonials Section ======= -->
    <?php  include('wtRightPanelNewsEvents.php'); ?>
    

    <?php //include('album-page.php'); ?>


    <!-- ======= Contact Section ======= -->
  <!--   <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <p>Contact Us</p>
          <div class="divider"></div>
        </div>
        <div class="row">

          <div class="col-lg-6">

            <div class="row">
              <div class="col-md-12">
                <div class="info-box">
                  <i class="bx bx-map"></i>
                  <h3>Our Address</h3>
                  <p>Vill- Hapania, P.O- Dafahat, Dist- Murshidabad, W.B- 742224</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box mt-4">
                  <i class="bx bx-envelope"></i>
                  <h3>Email Us</h3>
                  <p>office.englishoriental@gmail.com</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box mt-4">
                  <i class="bx bx-phone-call"></i>
                  <h3>Call Us</h3>
                  <p>8918724606</p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End Contact Section -->

  </main><!-- End #main -->
