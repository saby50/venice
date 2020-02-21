  
<?php get_header( 'header' ); ?>
 

    <!--====== HEADER PART ENDS ======-->

    <!--====== SERVICES PART START ======-->

    
    <section id="service"  class="services-area" style="padding-top: 60px;text-align: left;">
        <div class="container">
        <div class="row">
                        
                         <div class="col-lg-4">
                              
                            <p><strong style="font-size: 20px;">Consumer Benefits Network's</strong> mission is to help people improve the quality of their daily lives through accessing the world’s largest selection of personally relevant benefits.
</p><br />
                             <strong style="font-size: 22px;line-height: 28px;">Over 300,000 Loyalty Discounts from the World’s Best Brands!</strong><br /><br />
                            <p>We offer our customer’s an easy-to-use benefits portal with a full range of benefits and rewards, website and a Mobile App.
</p><br />
                           
                           
                            
                        
                         

                </div> 
                        <div class="col-lg-8">
                              
                         <img src="<?php bloginfo('template_url'); ?>/assets/images/aboutus.jpg" style="margin-top: -60px;">
                           
                            
                        
                         

                </div>            
                        </div>
                    </div>
    </section>

    <!--====== SERVICES PART ENDS ======-->

    <!--====== PRICING PART START ======-->

    <section id="pricing" class="pricing-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center pb-10">
                        <h4 class="title">Our Pricing</h4>
                        <p class="text">Stop wasting time and money designing and managing a website that doesn’t get results. Happiness guaranteed!</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <?php 
               $product1 = wc_get_product('12');
               $product2 = wc_get_product('14');
               $product3 = wc_get_product('17');
            ?>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title"><?= $product1->get_name() ?></h5>
                            <span class="price">$ <?= $product1->get_price() ?></span>
                            <p class="year"><?= $product1->get_short_description() ?></p>
                        </div>
                        <div class="pricing-list">
                        <?= $product1->get_description() ?>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="<?php the_permalink() ?>?add-to-cart=<?= $product1->get_id() ?>">ADD TO CART</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-1{fill:#2bdbdc;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-1" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-1" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-1" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-1" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>
                
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing pro mt-40">
                        <div class="pricing-baloon">
                            <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/baloon.svg" alt="baloon">
                        </div>
                        <div class="pricing-header">
                            <h5 class="sub-title"><?= $product2->get_name() ?></h5>
                            <span class="price">$ <?= $product2->get_price() ?></span>
                            <p class="year"><?= $product2->get_short_description() ?></p>
                        </div>
                         <div class="pricing-list">
                        <?= $product2->get_description() ?>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="<?php the_permalink() ?>?add-to-cart=<?= $product2->get_id() ?>">ADD TO CART</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-2{fill:#0067f4;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-2" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-2" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-2" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-2" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>
                
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing enterprise mt-40">
                        <div class="pricing-flower">
                            <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/flower.svg" alt="flower">
                        </div>
                        <div class="pricing-header text-right">
                            <h5 class="sub-title"><?= $product3->get_name() ?></h5>
                            <span class="price">$ <?= $product3->get_price() ?></span>
                            <p class="year"><?= $product3->get_short_description() ?></p>
                        </div>
                        <div class="pricing-list">
                            <?= $product3->get_description() ?>
                        </div>
                        <div class="pricing-btn text-center">
                           <a class="main-btn" href="<?php the_permalink() ?>?add-to-cart=<?= $product3->get_id() ?>">ADD TO CART</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>
            </div> <!-- row -->
        </div> <!-- conteiner -->
    </section>

    <!--====== PRICING PART ENDS ======-->
    
     <!--====== CALL TO ACTION PART START ======-->

    <section id="call-to-action" class="call-to-action">
        <div class="call-action-image" style="background: #000 !important;">
           <div class="col-lg-6">
            <img src="http://167.71.237.20/wp-content/uploads/2019/09/videoicon1.jpg">
               
           </div>
              <div class="col-lg-6">
                <img src="http://167.71.237.20/wp-content/uploads/2019/09/videoicon2.jpg">
           </div>
             <div class="col-lg-6">
            <img src="http://167.71.237.20/wp-content/uploads/2019/09/videoicon3.jpg">
               
           </div>
              <div class="col-lg-6">
                <img src="http://167.71.237.20/wp-content/uploads/2019/09/videoicon4.jpg">
           </div>
        </div>
        
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-lg-6">
                    <div class="" style="padding: 30px;">
                        <h2 class="call-title">Why Consumer Benefits Network?</h2>
                       <ul class="benefits">
                        <li><i class="fa fa-check" aria-hidden="true"></i> All your benefits, in one place.</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> Easy to set up.</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> Incredible savings for our customers</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> Very reasonable and Affordable Plan’s</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> 700,000+ locations to save</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> Between 10% - 50% off on Deals</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> Avg. savings of 34% per transaction</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> Serving 100% of top U.S. markets</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> The most local in-store offers</li>
  <li><i class="fa fa-check" aria-hidden="true"></i> Over 900 popular national brands</li>
                       </ul>
                     <p>  <h4>Helping our Customers to enjoy more savings when they buy Every Day.
</h4></p>
<p>Over Few Years Consumer Benefits Network has created high-impact Discount and deals programs for our customers seeking to save money on their day to day spending, this has strengthen our connection to the people we serve. We network of over 350,000 nationwide retailers and serves nearly 18 million members
</p>
<p>We take discounts and Deals to the next level, we offer discount programs not just local to your area, but nationwide as well. Whether you are traveling or at home or on vacation anywhere in America, you can access our deals thru our website and mobile app. We offer 100% satisfaction guaranteed, else we will return you money in full, all are memberships are backed by 100% refund policy, so you are in good hands!

</p>
<p><h4>Our Mobile App Save’s You Big!</h4></p>
<p>Our Mobile App Save’s You Big! With Our Mobile app saves you money on the go! On the purchases you make every day just by showing your mobile. We offer Jaw dropping discounts at thousands of restaurants and retailers in your neighbourhood, near the office and thru out America whenever you travel. We are talking big saving up to 50% off on dining, travel, shopping, oil changes, Fashion and much more, just show your phone and save, so what are your waiting for get out there and start saving, call now 8668371551 and save BIG!!!!</p>

<p><h4>Our philosophy...</h4></p>
<p>Our Customers should feel like they are benefiting every day. So why not offer them benefits that help them with their everyday lives?</p>

<p><h4>How we do it...</h4></p>
<p>We provide our customers with an incredible benefits and savings platform designed to engage by offering them the widest variety of leisure, health and other benefits. Broad 14 categories choose from!</p>
                      
                    </div> <!-- slider-content -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== CALL TO ACTION PART ENDS ======-->
    <section id="testimonials" class="contact-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <br >
                   <marquee>
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll1.png">
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll2.png">
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll3.png">
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll4.png">
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll5.png">
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll6.png">
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll7.png">
                       <img src="<?php echo get_bloginfo('template_directory'); ?>/assets/images/scroll8.png">
                   </marquee>
                </div>
            </div> <!-- row -->
        </div> <!-- conteiner -->
    </section>
        <!--====== CALL TO ACTION PART ENDS ======-->
    <section id="logoarea" class="contact-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center pb-10">
                        
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <br >
                     <?php echo do_shortcode( '[slick-carousel-slider category="19" design-1 centermode="true"]' ) ?>
                </div>
            </div> <!-- row -->
        </div> <!-- conteiner -->
    </section>
    <!--====== CONTACT PART START ======-->

    <section id="contact" class="contact-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title text-center pb-10">
                        <h4 class="title">Contact Us!</h4>
                        <h5>We’d Love To Hear From You</h5>
                        <p class="text">Consumer Benefits Network needs the contact information you provide us to contact you about our products and services. By Checking the box you allow us to contact you via email, phone or sms. You may unsubscribe from these communications at anytime. For information on how to unsubscribe, as well as our privacy practices and commitment to protecting your privacy, check out our <a href="/privacy-policy/">Privacy Policy</a>.
</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form">
                        
                            
                                 <?php echo do_shortcode( '[contact-form-7 id="223" title="Contact form"]' ) ?>
                                
                           
                       
                    </div> <!-- row -->
                </div>
            </div> <!-- row -->
        </div> <!-- conteiner -->
    </section>
<?php get_footer( 'footer' ); ?>