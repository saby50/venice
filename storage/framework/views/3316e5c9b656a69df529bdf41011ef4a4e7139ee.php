<?php 
$categories = Helper::get_menu();

$packs = Helper::get_packs();

?>
<!-- #gv -->
        <!--==========================
      Contact Section
    ============================-->
        <section id="contact">
            <div class="container wow fadeInUp">
                <div class="row justify-content-center">
                    <div class="col-md-3 col-12">
                        <h6>CONTACT DETAILS</h6>
                        <div class="info mt-4">
                            <p>ADDRESS :</p>
                            <p>Bhasin Infotech And Infrastructure Pvt Ltd<p> <br /> Plot No SH3, Site IV, Near Pari Chowk, Block B, <br /> Indutrial Area Surajpur Site 4, Greater Noida, <br /> Uttar Pradesh 201308
                            <p>EMAIL : info@veniceindia.com</p>
                            <p>PHONE : <a href="tel:8860666666" class="calltag">8860 666 666</a></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 service">
                        <h6>QUICK LINKS</h6>
                        <ul class="mt-4">
                            <?php foreach($categories as $key => $value): ?>
                                 <?php 
                          list($a,$b) = explode('_', $key);  
                         
                          ?>
                            <li><a href="<?= URL::to('booking/'.$value[0]->alias) ?>"><?= $a ?></a></li>
                            <?php endforeach; ?>

                            <?php foreach($packs as $key => $value): ?>
                                <?php 
                                    $alias = $value->alias;
                                ?>
                            <?php endforeach; ?>
                
                            <li><a href="<?= URL::to('packs/'.$alias) ?>">GV Packs</a></li>
                             <li><a href="<?= URL::to('commercial') ?>">Commercial Tower</a></li>
                              <li><a href="<?= URL::to('cinepolis') ?>">Cinepolis</a></li>
                             <li><a href="<?= URL::to('events/gudgudi-with-parvinder-singh') ?>">Events</a></li>
                            <li><a href="<?= URL::to('food-court') ?>">Food</a></li>
                           
                             <li><a href="<?= URL::to('shopping') ?>">Shopping</a></li>
                            
                              <li><a href="<?= URL::to('careers') ?>">Careers</a></li>
                           
                        </ul>
                    </div>
                    <div class="col-md-3 col-12 social">
                        <h6>SOCIAL</h6>
                        <ul class="mt-4">
                            <li><a href="https://www.facebook.com/GrandVenice/" target="_blank"><img src="<?php echo e(asset('public/images/Social-Icon-Facebook.png')); ?>">&nbsp;&nbsp; Facebook</a></li>
                            <li><a href="https://twitter.com/venice_grand/" target="_blank"><img src="<?php echo e(asset('public/images/Social-Icon-Twitter.png')); ?>">&nbsp;&nbsp; Twitter</a></li>
                            <li><a href="https://www.instagram.com/grandvenicemall/"><img src="<?php echo e(asset('public/images/Social-Icon-Instagram.png')); ?>">&nbsp;&nbsp; Instagram</a></li>
                            <li><a href="https://www.youtube.com/channel/UCnigkZG9wbheaIW36_AuP3Q" target="_blank"><img src="<?php echo e(asset('public/images/Social-Icon-Youtube.png')); ?>">&nbsp;&nbsp; Youtube</a></li>
                             <li><a href="<?= URL::to('privacy-policies') ?>">Privacy Policy</a></li>
                            <li><a href="<?= URL::to('terms-conditions') ?>">Terms & Conditions</a></li>
                            <li><a href="<?= URL::to('refund-cancellation-policy') ?>">Refund & Cancellation Policy</a></li>
                            
                        </ul>
                    </div>
                    <div class="col-md-3 col-12">
                        <h6>RATE US</h6>
                        <div class="TripAdvisor mt-4">
                            <img src="<?php echo e(asset('public/images/TripAdvisor.png')); ?>">
                            <p>Know better, Book better, Go better,</p>
                            <hr />
                            <strong><a target="_blank" href="https://www.tripadvisor.in/Attraction_Review-g2140594-d11914631-Reviews-The_Grand_Venice_Mall-Greater_Noida_Uttar_Pradesh.html">Review The Grand Venice Mall</a></strong>
                            <form action="https://www.tripadvisor.in/UserReview-g2140594-d11914631-The_Grand_Venice_Mall-Greater_Noida_Uttar_Pradesh.html" target="_blank" name="cdsWRLForm2214" id="cdsWRLForm2214" onsubmit="ta.cds.handleTALink(12097,this);return false;"> 
                                <input type="hidden" id="rating02214" value="(Click to rate)">
                                 <input type="hidden" id="rating12214" value="Terrible">
                                  <input type="hidden" id="rating22214" value="Poor"> 
                                  <input type="hidden" id="rating32214" value="Average">
                                   <input type="hidden" id="rating42214" value="Very Good"> 
                                   <input type="hidden" id="rating52214" value="Excellent">
                                    <input type="hidden" id="defaultTitle2214" value="Title your review - Describe your stay in one sentence or less. ">
                                     <input type="hidden" id="reviewTitle2214" name="ReviewTitle">
                                <div class="widWRLRating"> 
                                    <input type="hidden" name="qid10" id="qid102214" value="0"> <span class="widWRLRate ui_bubble_rating bubble_00" id="ratingSpan" onclick="return selectRating(this, event, true, 2214);" onmousemove="return selectRating(this, event, false, 2214);" onmouseout="return lastSetRating(this, 2214);"> </span> <span id="ratingText2214" class="widWRLRatingText">(Click to rate)</span>
                                     </div>
                                <div class="widWRLReview">
                                 <textarea id="taWRLTitle2214" onfocus="initTextArea(this);" rows="3" cols="30" onkeypress="limitLength(this, 120);">Title your review - Describe your stay in one sentence or less. </textarea>
                                  </div>
                                <div class="widWRLButton">
                                 <input type="submit" id="taWRLContinue2214" name="taWRLContinue2214" value="Continue" onclick="checkTextArea(2214);" style="background:url(https://static.tacdn.com/img2/sprites/yellow-button.png) 0 0 repeat-x #EA9523;"> 
                             </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #contact -->
    </main>
    <!--==========================
    Footer
  ============================-->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                &copy; 2019 The Grand Venice Mall, Venture of Bhasin Infotech & Infrastructure Private Limited
            </div>
        </div>
    </footer><!-- #footer -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- JavaScript Libraries -->


    <script src="<?php echo e(asset('public/lib/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/easing/easing.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/waypoints/waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/counterup/counterup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/superfish/hoverIntent.js')); ?>"></script>
    <script src="<?php echo e(asset('public/lib/superfish/superfish.min.js')); ?>"></script>
    <!-- Contact Form JavaScript File -->
    <!-- Template Main Javascript File -->
   
    <script type="text/javascript" src="<?php echo e(asset('public/js/bootstrap-pincode-input.js')); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/bootstrap-pincode-input.css')); ?>">
    <script type="text/javascript">

    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }


    });
    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    </script>
    <script type="text/javascript">
    $('#tab1').on('click', function(e) {
        e.preventDefault()
        $('#tab11').addClass('active');
        $('#tab22').removeClass('active');
        $('#tab1').addClass('active');
        $('#tab2').removeClass('active');
    })
    $('#tab2').on('click', function(e) {
        e.preventDefault()
        $('#tab11').removeClass('active');
        $('#tab22').addClass('active');
        $('#tab1').removeClass('active');
        $('#tab2').addClass('active');
    })
    </script>
    

<?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/layouts/footer.blade.php ENDPATH**/ ?>