<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="password_reset.php">
 * </description>
 **********************************************************************************************************************/
?>
<!--Blog start-->
<section class="blogSection">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <h2 class="commentTitle">Send a Message</h2>
        <div class="commentForm">
          <form action="#" method="post" id="contactForm">
            <div class="row">
              <div class="col-lg-6 formmargin">
                <input type="text" placeholder="Name" name="con_name" id="con_name" class="required">
                <input type="email" placeholder="Email" name="con_email" id="con_email"
                       class="required">
                <input type="url" placeholder="Website" name="con_url" id="con_url" class="required">
              </div>
              <div class="col-lg-6">
                                <textarea placeholder="Message" id="con_message" name="con_message"
                                          class="required"></textarea>
              </div>
              <div class="col-lg-12">
                <button type="submit" class="blogReadmore" id="con_submit">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="contactInfo">
          <h2 class="commentTitle">Contact Info</h2>
          <div class="contAddress">
            <div class="singleContadds">
              <i class="fa fa-map-marker"></i>
              <p>
                107727 Santa Monica Boulevard Los Angeles,
                California 90025-4718 United States of America
              </p>
            </div>
            <div class="singleContadds phone">
              <i class="fa fa-phone"></i>
              <p>
                0251 542 52 54 - <span>Office</span>
              </p>
              <p>
                0251 542 52 20 - <span>Mobile</span>
              </p>
            </div>
            <div class="singleContadds">
              <i class="fa fa-envelope"></i>
              <a href="mailto:contact@pithreepress.com">contact@pithreepress.com</a>
              <a href="mailto:support@pithreepress.com">support@pithreepress.com</a>
            </div>
            <div class="contactSocial">
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-google-plus"></i></a>
              <a href="#"><i class="fa fa-pinterest-p"></i></a>
              <a href="#"><i class="fa fa-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Blog End-->
<div class="row clearfix f-space10"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">

      <div class="page-title">
        <h2><?= $this->pageTitle ?></h2>
      </div>

    </div><!--End:Col -->
  </div><!--End:Row -->
  <div class="row clearfix f-space10"></div>
  <div class="row">
    <div class="col-md-12">

      <div class="form">
        <p><?= Yii::t('main', 'Теперь вы можете ввести ваш новый пароль') ?>:</p>
        <form method="POST">
          <input name="UserForm[password]" type="password" class="input3"/>
          <input name="UserForm[password2]" type="password" class="input3"/>
          <input name="UserForm[doGo]" type="submit" class="btn btn-success"
                 value="<?= Yii::t('main', 'Сохранить') ?>"/>
        </form>
      </div>

    </div><!--End:Col -->
  </div><!--End:Row -->
</div><!--End:Container -->
<div class="row clearfix f-space10"></div>