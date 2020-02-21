<?php $__env->startSection('title'); ?>
Careers
<?php $__env->stopSection(); ?>
<?php $__env->startSection('includes'); ?>
     <meta property="og:title" content="The Grand Venice Mall | Careers">
    <meta property="og:description" content="Come To Work At Indias Venice">
    <meta property="og:image" content="<?php echo e(asset('public/images/GV03.jpg')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 <section id="hero2">
       <div class="title">CAREERS</div>
        
    </section><!-- #hero -->

<section class="hero careers">

<div class="container">
    <div class="row">
      <div class="col-md-12" style="margin-top: 20px;">
        <h2 class="section-title" style="color: #EF9E11;text-align: center;">Come To Work At India's Venice </h2>

<p>At The Grand Venice mall we are offering you a chance to be a part of  true landmark. We understand that a job should be just more than work.  This is why we ask you to come and be part of  a landmark and a monumental achievement in retail industry.</p>  

<p>Join us to help the visitors enjoy the most out of their visit at this modern wonder.  With opportunities in various avenues,  you can help them have an unmatched shopping and tourism experience. </p> 

 <p>We are looking for passionate people who can go get their best and bring their unparalleled experience on the table. Get in touch to know more.</p> 
         <hr />
      </div>

    
                   

                     <div class="col-12">
                        <a name="packs"></a>
                          
                    <div class="col-md-12" role="listbox">

                        <?php foreach ($db as $key => $value): ?>

                            <h3 class="job_title"><?= $value->job_title ?></h3>
                            <p><?= $value->job_description ?></p>

                            <strong>Gender: </strong> <?= $value->gender ?><br />
                            <strong>Desired Age Group: </strong> <?= $value->age_group ?><br />
                            <strong>Education: </strong> <?= $value->education ?><br />
                              <strong>Experience: </strong> <?= $value->experience ?><br />
                              <strong>Location: </strong> <?= $value->location ?><br />
                              <strong>Mobility: </strong> <?= $value->mobility ?><br />
                               <strong>Desired Skills: </strong> <?= $value->skills ?><br /><br />
                                <div class="col-md-12" style="text-align: right;"><a href="#applicationform"><button class="applynow btn" type="button">Apply Now</button></a></div>
                               <hr/>
                               <br />



                        <?php endforeach; ?>

                    

                  </div>
                  <div class="col-md-12">
                    <div class="col-md-6" style="float:none;margin:auto;">
                         <a name="applicationform"></a>
                        <form action="<?php echo e(URL::to('applynow')); ?>" method="post"  enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                               <?php if(session('error')): ?>
                            <div class="alert alert-danger" role="alert">
                            <?php echo e(session('error')); ?>

                           </div>
                          
                           <?php endif; ?>
                            <?php if(session('status')): ?>
                           <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                           </div>
                           <?php endif; ?>
                       
                         <div class="form-group" style="text-align: center;">
                           <h3>Application Form</h3>
                        </div>
                        <div class="form-group">
                            <label>Name<span style="color: red;">*</span></label>
                            <input type="text" name="name" class="form-control" required="required">
                        </div>
                         <div class="form-group">
                            <label>Email<span style="color: red;">*</span></label>
                            <input type="text" name="email" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Phone<span style="color: red;">*</span></label>
                            <input type="text" name="phone" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Select Job<span style="color: red;">*</span></label>
                           <select class="form-control" name="job">
                            <?php foreach($db as $key => $value): ?>
                            <option value="<?= $value->id ?>"><?= $value->job_title ?></option>
                             <?php endforeach; ?>
                               
                           </select>
                        </div>
                        <div class="form-group">
                            <label>Upload CV<span style="color: red;">*</span></label>
                            <input type="file" name="myfile" class="form-control" required="required" accept=
"application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf">
                            
                        </div>
                        <div class="form-group">
                          <div class="g-recaptcha" data-sitekey="6LcynKQUAAAAACaCtqaFWb28znlAQgquBKMKcUQv"></div>
                        </div>
                        <div class="form-group" style="text-align: center;">
                            
                            <input type="submit" name="submit" value="Submit" class="applynow btn">
                        </div>
                        </form>
                    </div>
                      
                  </div>

                     </div>


                </div>
                
            </div>
        </section>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style type="text/css">
    p {
        text-align: justify;
    }
     .job_title {
           color: #EF9E11;
    }
    .applynow {
        background-color: #EF9E11;
    width: 150px;
    padding: 10px;
    color: #fff;
    font-weight: bold;
    border-radius: 5px;
    }
    html{
        scroll-behavior:smooth;
    }
    #hero2 {
  width: 100%;
  height: 346px;
  background: url(<?= asset('public/images/banner.jpg') ?>) no-repeat;
  background-position: center;
  position: relative;
  top: -100px;
  background-size: contain;


}
  #hero2 div.title {
    text-align: center;
    top: 120px;
    position: relative;
    font-size: 70px;
    color: #000;
    width: 500px;
    margin: 0 auto;


}
@media (max-width: 425px) {
 #hero2 {
    width: 100%;
    height: 230px;
    background-position: center;
    position: relative;
    top: -0px;
    background: url(<?= asset('public/images/careerm.jpg') ?>);
        background-size: contain;
    background-repeat: no-repeat;

}
#hero2 div.title {
    text-align: center;
    top: 20px;
    position: relative;
    font-size: 50px;
    color: #000;
    width: 100%;
    margin: 0 auto;
    display: none !important;
}
.careermobile {


}

}
</style>

<?php echo $__env->make('include/subfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/careers/index.blade.php ENDPATH**/ ?>