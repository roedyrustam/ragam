<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="text-center">
	<a data-toggle="modal" data-target="#modalAds" href="#"><img class="banner_ads_728_90" src="<?php echo base_url()."assets/frontend/images/728-90.png"; ?>"></a>
    <br><br>
</div>

<!-----------footer----------------->
<section class="footer type_four <?php if ($this->lang->line("app_direction") == "rtl") echo "rtl"; ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                <div class="footer_widgets type_three">
                    <h3 class="widgets_title">
                        <?php echo $this->lang->line("app_name"); ?>
                    </h3>
                    <div class="inner_widgets">
                        <p><?php echo $this->lang->line("app_description_long"); ?></p>
                        <div class="social_media_icon">
                            <ul class="clearfix">
								<?php
								if (!empty($setting->setting_facebook))
								{
								?>
                                <li>
                                    <a target="_blank" href="https://www.facebook.com/<?php echo $setting->setting_facebook; ?>" class="has-tooltip">
                                        <span class="fa fa-facebook "></span>
                                        <div class="c-tooltip ">
                                            <div class="tooltip-inner ">Facebook</div>
                                        </div>
                                    </a>
                                </li>
								<?php
								}
								?>

								<?php
								if (!empty($setting->setting_twiiter))
								{
								?>
                                <li>
                                    <a target="_blank" href="https://www.twitter.com/<?php echo $setting->setting_twiiter; ?>" class="has-tooltip">
                                        <span class="fa fa-twitter "></span>
                                        <div class="c-tooltip ">
                                            <div class="tooltip-inner ">Twitter</div>
                                        </div>
                                    </a>
                                </li>
								<?php
								}
								?>

								<?php
								if (!empty($setting->setting_skype))
								{
								?>
                                <li>
                                    <a target="_blank" href="https://www.skype.com/en/<?php echo $setting->setting_skype; ?>" class="has-tooltip">
                                        <span class="fa fa-skype"></span>
                                        <div class="c-tooltip ">
                                            <div class="tooltip-inner ">Skype</div>
                                        </div>
                                    </a>
                                </li>
								<?php
								}
								?>

								<?php
								if (!empty($setting->setting_telegram))
								{
									?>
									<li>
										<a target="_blank" href="<?php echo "https://t.me/".$setting->setting_telegram; ?>" class="has-tooltip">
											T
											<div class="c-tooltip ">
												<div class="tooltip-inner">Telegram</div>
											</div>
										</a>
									</li>
									<?php
								}
								?>

								<?php
								if (!empty($setting->setting_whatsapp))
								{
									?>
									<li>
										<a target="_blank" href="<?php echo "https://wa.me/$setting->setting_whatsapp/?text="; ?>" class="has-tooltip">
											W
											<div class="c-tooltip ">
												<div class="tooltip-inner">WhatsApp</div>
											</div>
										</a>
									</li>
									<?php
								}
								?>

								<?php
								if (!empty($setting->setting_instagram))
								{
									?>
									<li>
										<a target="_blank" href="<?php echo "https://www.instagram.com/".$setting->setting_instagram; ?>" class="has-tooltip">
											<span class="fa fa-instagram"></span>
											<div class="c-tooltip ">
												<div class="tooltip-inner">Instagram</div>
											</div>
										</a>
									</li>
									<?php
								}
								?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 ">
                <div class="footer_widgets type_three ">
                    <h3 class="widgets_title "><?php echo $this->lang->line("Main Menu"); ?></h3>
                    <div class="inner_widgets ">
                        <ul class="links">
                            <li><a href="<?php echo base_url(); ?>"><?php echo $this->lang->line("Home"); ?></a></li>
                            <li><a data-toggle="modal" data-target="#modalAbout" href="#"><?php echo $this->lang->line("About Us"); ?></a></li>
                            <li><a data-toggle="modal" data-target="#modalAds" href="#"><?php echo $this->lang->line("Advertising"); ?></a></li>
                            <li><a data-toggle="modal" data-target="#modalTerms" href="#"><?php echo $this->lang->line("Terms Of Service"); ?></a></li>
                            <li><a data-toggle="modal" data-target="#modalPrivacy" href="#"><?php echo $this->lang->line("Privacy Policy"); ?></a></li>
                            <li><a data-toggle="modal" data-target="#modalGDPR" href="#"><?php echo $this->lang->line("GDPR Law"); ?></a></li>
                            <li><a data-toggle="modal" data-target="#modalContact" href="#"><?php echo $this->lang->line("Contact Us"); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                <div class="footer_widgets type_three ">
                    <h3 class="widgets_title "><?php echo $this->lang->line("Categories"); ?></h3>
                    <div class="inner_widgets ">
                        <ul class="links">
							<?php
							foreach ($categoriesLimit as $categoryLimit)
							{
							?>
                            <li><a href="<?php echo base_url()."Web/content_list/?category=$categoryLimit->category_id&title=$categoryLimit->category_slug"; ?>"><?php echo $categoryLimit->category_title ?></a></li>
							<?php
							}
							?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 ">
                <div class="footer_widgets tp_two ">
                    <h3 class="widgets_title "><?php echo $this->lang->line("Mobile App"); ?></h3>
                    <div class="inner_widgets">
                        <p class="sub_description "><?php echo $this->lang->line("Download and install our app for free. Choose your device:"); ?></p>
                    </div>
                    <a class="btn btn-block btn-success text-white" href="<?php echo base_url()."dl/multipurpose.apk" ?>"><i class="fa fa-android fa-lg"></i> &nbsp;&nbsp;Android Version</a>
                    <br>
                    <a class="btn btn-block btn-info text-white" onclick="alert('<?php echo $this->lang->line("Coming Soon..."); ?>');"><i class="fa fa-apple fa-lg"></i> &nbsp;&nbsp;iOS Version</a>
                </div>
            </div>
        </div>
        <div class="footer_last type_three ">
            <div class="row ">
                <div class="col-lg-12 text-center ">
                    <p>Copyright © <?php echo date('Y')." ".$setting->setting_app_name; ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-------------main-centent-end--------------->
</main>
<!-------------pagewapper-end--------------->
</div>
<!--Scroll to top-->
<a href="# " id="scroll" class="default-bg green" style="display: inline;"><span class="fa fa-angle-up "></span></a>

<!---------mobile-navbar----->
<div class="bsnav-mobile ">
    <div class="bsnav-mobile-overlay"></div>
    <div class="navbar ">
        <button class="navbar-toggler toggler-spring mobile-toggler"><span class="fa fa-close "></span></button>
    </div>
</div>
<!---------mobile-navbar----->
<!-- /.side-menu__block -->
<div class="side-menu__block">
    <div class="side-menu__block-overlay custom-cursor__overlay">
        <div class="cursor"></div>
        <div class="cursor-follower"></div>
    </div>
    <!-- /.side-menu__block-overlay -->
</div>
<!-- /.side-menu__block -->

<!-- /.search-popup -->
<div class="search-popup">
    <div class="search-popup__overlay custom-cursor__overlay">
        <div class="cursor "></div>
        <div class="cursor-follower "></div>
    </div>
    <!-- /.search-popup__overlay -->
    <div class="search-popup__inner ">
        <form action="<?php echo base_url()."Web/content_list/?" ?>" method="get" class="search-popup__form">
            <input type="text" name="keyword" placeholder="<?php echo $this->lang->line("Search for..."); ?>">
            <button type="submit"><i class="flaticon-magnifying-glass"></i></button>
        </form>
    </div>
    <!-- /.search-popup__inner -->
</div>
<!-- /.search-popup -->
<!-----------------------------------script-------------------------------------->
<!--<script src="<?php echo base_url()."assets/frontend/js/jquery.js"; ?>"></script>-->
<script src="<?php echo base_url()."assets/frontend/js/popper.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/bootstrap.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/bsnav.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/jquery-ui.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/isotope.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/wow.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/owl.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/swiper.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/jquery.fancybox.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/odometer.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/TweenMax.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/validator.min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/appear.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/moment.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/jquery.flexslider-min.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/pagenav.js"; ?>"></script>
<script src="<?php echo base_url()."assets/frontend/js/custom.js"; ?>"></script>
</body>
</html>
