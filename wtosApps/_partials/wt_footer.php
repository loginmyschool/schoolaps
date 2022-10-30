<?
global $os, $site, $footer_menu;

?>
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-lg-4 col-md-6">
          <h4>About Us</h4>
          <div class="divider mb-5"></div>
          <p>The aim of our School is to help our students to grow and become responsible citizens who are capable to
            face the challenges of the present world. Our school is established with vision of offering quality
            education. A school is a place where students begin to learn lessons of life and we help learn lessons of
          life and we help them for their all round Development.</p>
        </div>

        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Quick Links</h4>
          <div class="divider mb-5"></div>
          <ul>
            <?
            foreach ($footer_menu as $page){
              $pageSeoLink=($page['externalLink']=='')?$os->sefu->l($page['seoId']):$pageSeoLink=$page['externalLink'];
              $_target=($page['openNewTab']<1)?'':'target="_blank"';
              $parenpageId = $page['pagecontentId'];
              if(($page['login_access']==1 && $os->isLogin()) || ($page['login_access']==2 && !$os->isLogin()) || $page['login_access']==0){

                ?>
                <li><i class="bx bx-chevron-right"></i>
                  <a  title="<? echo $page['title'] ?>"  <?php echo $_target ?> href="<? echo $pageSeoLink ?>">
                    <? echo $page['title'] ?>
                  </a>
                </li>
              <? }
            };
            ?>
          </ul>
        </div>

        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Useful Link</h4>
          <div class="divider mb-5"></div>
          <ul>
            <?
            foreach ($footer_menu as $page){
              $pageSeoLink=($page['externalLink']=='')?$os->sefu->l($page['seoId']):$pageSeoLink=$page['externalLink'];
              $_target=($page['openNewTab']<1)?'':'target="_blank"';
              $parenpageId = $page['pagecontentId'];
              if(($page['login_access']==1 && $os->isLogin()) || ($page['login_access']==2 && !$os->isLogin()) || $page['login_access']==0){

                ?>
                <li><i class="bx bx-chevron-right"></i>
                  <a  title="<? echo $page['title'] ?>"  <?php echo $_target ?> href="<? echo $pageSeoLink ?>">
                    <? echo $page['title'] ?>
                  </a>
                </li>
              <? }
            };
            ?>
          </ul>
        </div>

        <div class="col-lg-4 col-md-6 footer-newsletter">
          <h4>Get in Touch</h4>
          <div class="divider mb-5"></div>
          <p>Call : 8617369044</p>
          <p>Email : apsjangipur2021@gmail.com</p>
          <p>Address : VIll- Hapania, P.O- Dafahat,
            Dist- Murshidabad,<br/>
          WEST BENGAL, 742224</p>

        </div>

      </div>
    </div>
  </div>

  <div class="container">
    <div class="copyright">
      © 2022 APS All Rights Reserved
    </div>

  </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
  class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<? echo $site['themePath']?>assets/vendor/aos/aos.js"></script>
  <script src="<? echo $site['themePath']?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<? echo $site['themePath']?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<? echo $site['themePath']?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<? echo $site['themePath']?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<? echo $site['themePath']?>assets/vendor/purecounter/purecounter.js"></script>
  <script src="<? echo $site['themePath']?>assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<? echo $site['themePath']?>assets/js/main.js"></script>

</body>

</html>