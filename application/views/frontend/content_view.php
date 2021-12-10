<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('frontend/common/head_view');
$this->load->view('frontend/common/header_view');

if ($ratingAverage == 0.5) $ratingAverage = "<span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 1) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 1.5) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 2) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 2.5) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 3) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 3.5) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 4) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
if ($ratingAverage == 4.5) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span>";
if ($ratingAverage == 5) $ratingAverage = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span>";

//Check bookmark status
$isBookmarked = 0;
if(isset($_SESSION['user_id']))
	{
		$user_id = $_SESSION['user_id'];
		$q = $this->db->query("Select *
					   FROM bookmark_table
					   WHERE (bookmark_user_id = $user_id AND bookmark_content_id = $contentDetail->content_id);");
		if ($q->num_rows() > 0)
			$isBookmarked = 1;
	}

$user_id = 0;
if(isset($_SESSION['user_id']))
	$user_id = $_SESSION['user_id'];
?>

    <!------main-content------>
    <main class="main-content">

        <section class="page_title">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 d-flex">
                        <div class="content_box">
                            <ul class="bread_crumb text-center">
                                <li class="bread_crumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="bread_crumb-item active"> <?php echo $this->lang->line("Show Content"); ?></li>
                            </ul>
                            <h1 style="font-size: 38px;"><?php echo $contentDetail->content_title; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <div class="single_blog_box">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="blog_side_bar_left <?php if ($this->lang->line("app_direction") == "rtl") echo "rtl"; ?>">

                            <!----search-box---->
                            <div class="search_bar">
                                <h2 class="sub_head"><?php echo $this->lang->line("Search"); ?></h2>
                                <form method="get" action="<?php echo base_url()."Web/content_list/?" ?>">
                                    <div class="srch_input">
                                        <input type="text" name="keyword" id="keyword" placeholder="<?php echo $this->lang->line("Search for..."); ?>" autocomplete="off" />
                                        <button type="submit" class="search"><span class="flaticon-search"></span></button>
                                    </div>
                                </form>
                            </div>
                            <!----search-box---->

                            <div class="text-center">
								<a data-toggle="modal" data-target="#modalAds" href="#"><img class="banner_ads_300_250" src="<?php echo base_url()."assets/frontend/images/300-250.png"; ?>"></a>
                            </div>
                            <br><br>

                            <?php
                            if ($contentDetail->content_type_id == 11)
								echo "";//Video & Movie

							if ($contentDetail->content_type_id == 12)
								echo "";//Music & Audio

                            if ($contentDetail->content_type_id == 13)
                                echo "";//HTML5 Game

                            if ($contentDetail->content_type_id == 14)
                                echo "";//Text & Article

							if ($contentDetail->content_type_id == 15)
								echo "";//PDF Reader

							if ($contentDetail->content_type_id == 16)
								echo "";//News

                            if ($contentDetail->content_type_id == 17)
                                echo "";//Product

							if ($contentDetail->content_type_id == 18)
								echo "";//Buy & Sell

							if ($contentDetail->content_type_id == 19)
								echo "";//City Guide

							if ($contentDetail->content_type_id == 20)
								echo "";//Download

							if ($contentDetail->content_type_id == 21)
								echo "";//Hyperlink

							if ($contentDetail->content_type_id == 22)
								echo "";//Images Gallery



							if ($contentDetail->content_type_id == 17 || $contentDetail->content_type_id == 18 || $contentDetail->content_type_id == 19)
							{
                            ?>
                                <div class="categories">
                                <h2 class="sub_head"><?php echo $this->lang->line("Details"); ?></h2>
                                <ul>
									<?php
									if($contentDetail->content_price != 0) {
									?>
                                    <li><strong><?php echo $this->lang->line("Price :"); ?></strong> <?php echo $this->lang->line("currency_prefix"); ?> <?php echo $contentDetail->content_price; ?> <?php echo $this->lang->line("currency_suffix"); ?></li>
									<?php
									}
									?>
                                    <li><strong><?php echo $this->lang->line("Phone :"); ?></strong> <?php echo $contentDetail->content_phone; ?><span></span></li>
                                    <li><strong><?php echo $this->lang->line("Email :"); ?></strong> <?php echo $contentDetail->content_email; ?><span></span></li>
                                    <li><a target="_blank" href="https://www.latlong.net/c/?lat=<?php echo $contentDetail->content_latitude ?>&long=<?php echo $contentDetail->content_longitude ?>"><strong><?php echo $this->lang->line("Location on the map"); ?></strong></a><span></span></li>
                                </ul>
                                </div>
                            <?php
                            }
                            ?>


                            <!----Main Categories---->
                            <div class="categories">
                                <h2 class="sub_head"><?php echo $this->lang->line("Main Categories"); ?></h2>
                                <ul>
                                    <?php
                                    foreach ($categoriesList as $category)
                                    {
                                    ?>
                                        <li><a href="<?php echo base_url().'Web/content_list/?category='.$category->category_id.'&title='.$category->category_title; ?>"><?php echo $category->category_title ?><span></span></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>

                            <div class="text-center">
								<a data-toggle="modal" data-target="#modalAds" href="#"><img class="banner_ads_300_600" src="<?php echo base_url()."assets/frontend/images/300-600.png"; ?>"></a>
                            </div>
                            <br><br>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <!--------list-of categories-------->
                        <div class="blog_details_content <?php if ($this->lang->line("app_direction") == "rtl") echo "rtl"; ?>">
                            <div class="image_box">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="owl-carousel one_items">
                                            <div class="image">
                                                <?php
                                                if ($contentDetail->content_type_id != 11 AND $contentDetail->content_type_id != 12) //Video
                                                {
                                                ?>
                                                    <img src="<?php echo base_url() . 'assets/upload/content/' . $contentDetail->content_image; ?>" class="img-fluid" alt="img"/>
                                                <?php
												}else{
                                                    //Check video player type
                                                    if ($contentDetail->content_player_type_id == 4 OR $contentDetail->content_player_type_id == 5) {
                                                        //echo "YouTube";
                                                        echo "<iframe width='100%' height='450' src='https://www.youtube.com/embed/$contentDetail->content_url' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                                                    }

                                                    else if ($contentDetail->content_player_type_id == 6) {
                                                        //echo "Vimeo";
                                                        echo "<iframe src='https://player.vimeo.com/video/$contentDetail->content_url' width='100%' height='450' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";
                                                    }

                                                    else {
                                                        //HTML5 Player
														if($contentDetail->content_type_id == 12)
															echo "<video width='100%' height='100' controls><source src='$contentDetail->content_url' type='video/mp4'><source src='$contentDetail->content_url' type='video/ogg'>Your browser does not support the video tag.</video>";
														else
															echo "<video width='100%' height='450' controls poster='base_url().'assets/upload/content/'.$contentDetail->content_image'><source src='$contentDetail->content_url' type='video/mp4'><source src='$contentDetail->content_url' type='video/ogg'>Your browser does not support the video tag.</video>";
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="tags_upper">
                                <li><a href="<?php echo base_url().'Web/content_list/?category='.$contentDetail->content_category_id; ?>" class="category"><?php echo $contentDetail->category_title; ?></a></li>
                                <li><a class="date"><span class="fa fa-clock-o"></span><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($contentDetail->content_publish_date, now(), 2)." ".$this->lang->line("ago")."";
                                        elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($contentDetail->content_publish_date, now(), 2)." ".$this->lang->line("ago")."";
                                        else echo timespan($contentDetail->content_publish_date, now(), 2)." ".$this->lang->line("ago"); ?></a></li>
								<?php
								if($isBookmarked == 0 AND $user_id != 0) {
								?>
								<li><a class="date" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('add-to-bookmark-form').submit();"><span class="fa fa-bookmark-o"></span> Add To Bookmark</a></li>
								<?php
								}elseif($isBookmarked == 1 AND $user_id != 0){
								?>
								<li><a class="date" style="cursor: pointer" onclick="event.preventDefault(); document.getElementById('remove-from-bookmark-form').submit();"><span class="fa fa-bookmark"></span> Remove From Bookmark</a></li>
								<?php
								}
								?>
                                <li><a class="date"><span class="fa fa-eye"></span> <?php echo $contentDetail->content_viewed; ?></a></li>
                            </ul>

							<?php
							//Add to bookmark
							if($user_id != 0)
							{
								$attributes = array('id' => 'add-to-bookmark-form', 'method' => 'post', 'style' => 'display: none');
								echo form_open(base_url()."Web/add_to_bookmark/", $attributes);
								?>
								<!--<form id="add-to-bookmark-form" action="<?php echo base_url()."Web/add_to_bookmark" ?>" method="POST" style="display: none;">-->
									<input type="text" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
									<input type="text" name="content_id" value="<?php echo $contentDetail->content_id; ?>" />
								</form>

								<?php
								//Remove from bookmark
								$attributes = array('id' => 'remove-from-bookmark-form', 'method' => 'post', 'style' => 'display: none');
								echo form_open(base_url()."Web/remove_from_bookmark/", $attributes);
								?>
								<!--<form id="add-to-bookmark-form" action="<?php echo base_url()."Web/add_to_bookmark" ?>" method="POST" style="display: none;">-->
								<input type="text" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
								<input type="text" name="content_id" value="<?php echo $contentDetail->content_id; ?>" />
								</form>
							<?php
							}
							?>


                            <h2 class="heading"><?php echo $contentDetail->content_title; ?></h2>
                            <p class="description"><?php echo $contentDetail->content_description; ?></p>

                            <?php
                            if ($contentDetail->content_type_id == 13) //HTML5 Game
                            {
                                //Game
                            ?>
                                <div class="text-center">
                                    <br>
                                    <a target="_blank" href="<?php echo $contentDetail->content_url; ?>" class="btn btn-success"><?php echo $this->lang->line("Play Game"); ?></a>
                                </div>
                            <?php
                            }
                            ?>

							<?php
							if ($contentDetail->content_type_id == 15) //PDF Reader
							{
								?>
								<div class="text-center">
									<br>
									<a target="_blank" href="<?php echo $contentDetail->content_url; ?>" class="btn btn-success"><?php echo $this->lang->line("Open PDF File"); ?></a>
								</div>
								<?php
							}
							?>

							<?php
							if ($contentDetail->content_type_id == 20) //Download
							{
								?>
								<div class="text-center">
									<br>
									<a target="_blank" href="<?php echo $contentDetail->content_url; ?>" class="btn btn-success"><?php echo $this->lang->line("Download Now"); ?></a>
								</div>
								<?php
							}
							?>

							<?php
							if ($contentDetail->content_type_id == 21) //Hyperlink
							{
								if($contentDetail->content_open_url_inside_app == 0)
								{
								?>
								<div class="text-center">
									<br>
									<a target="_blank" href="<?php echo $contentDetail->content_url; ?>" class="btn btn-success"><?php echo $this->lang->line("Open The URL"); ?></a>
								</div>
								<?php
								}else{
								?>
									<div class="text-center">
										<br>
										<a href="<?php echo $contentDetail->content_url; ?>" class="btn btn-success"><?php echo $this->lang->line("Open The URL"); ?></a>
									</div>
								<?php
								}
							}
							?>


                            <br><br>
                            <div class="blog_detail_comment">
                                <div class="comment_inner">
                                    <ul class="comment_heading">
                                        <li><?php echo $this->lang->line("Reviews"); ?> (<?php echo $reviewsCount; ?>)</li>
                                        <li><?php echo $ratingAverage; ?></li>
                                    </ul>
                                    <?php
                                    foreach ($reviews as $review)
                                    {
                                        if ($review->comment_rate == 0.5) $comment_rate = "<span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 1) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 1.5) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 2) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 2.5) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 3) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 3.5) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 4) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-o' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 4.5) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star-half-empty' style='color: #ff8800'></span>";
                                        if ($review->comment_rate == 5) $comment_rate = "<span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span><span class='fa fa-star' style='color: #ff8800'></span>";
                                    ?>
                                        <div class="comment_content_outer">
                                            <div class="comment_content_inner">
                                                <!--<div class="image">
                                                <img src="<?php echo base_url() . 'assets/upload/user/profile_img/avatar.png' ?>" class="img-fluid" alt="img"/>
                                            </div>-->
                                                <div class="content_text">
                                                    <ul>
                                                        <li class="first"><?php echo $review->user_username; ?></li>
                                                        <li><?php echo $comment_rate; ?></li>
                                                        <li><small><?php echo timespan($review->comment_time, now(), 2)." ".$this->lang->line("ago"); ?></small></li>
                                                    </ul>
                                                    <p style="line-height: 24px; padding-top: 5px"><?php echo $review->comment_text; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    if(empty($reviews)) echo $this->lang->line("Nothing Found...")."<br><br>";
                                    ?>
                                </div>
                                <div class="comment_reply">
                                    <h2 class="text-center"><?php echo $this->lang->line("Leave a review"); ?></h2>
                                    <!-- Alert after process start -->
                                    <?php
                                    $msg = $this->session->flashdata('msg');
                                    $msgType = $this->session->flashdata('msgType');
                                    if (isset($msg))
                                    {
                                        ?>
                                        <div class="alert alert-<?php echo $msgType; ?> alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <?php echo $msg; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <!-- ./Alert after process end -->
                                    <div class="form_inner">
                                        <?php
                                        $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                                        echo form_open(base_url()."Web/add_comment/", $attributes);
                                        //form_open_multipart//For Upload
                                        ?>
                                            <div class="row">
                                                <div class=" col-lg-4">
                                                    <div class="form-group">
                                                        <label for="sel1"><?php echo $this->lang->line("Rate"); ?> *</label>
                                                        <select class="form-control" name="comment_rate" id="comment_rate" required>
                                                            <option disabled selected><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                                            <option value="1">1 <?php echo $this->lang->line("star"); ?></option>
                                                            <option value="2">2 <?php echo $this->lang->line("star"); ?></option>
                                                            <option value="3">3 <?php echo $this->lang->line("star"); ?></option>
                                                            <option value="4">4 <?php echo $this->lang->line("star"); ?></option>
                                                            <option value="5">5 <?php echo $this->lang->line("star"); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group texta">
                                                        <label>Your Comment</label>
                                                        <textarea name="comment_text" id="comment_text" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row comment_reply-btn ">
                                                <div class=" col-lg-12">
                                                <?php
                                                if(isset($_SESSION['user_id'])) {
                                                    ?>
                                                    <input type="hidden" name="comment_user_id"
                                                           value="<?php echo $_SESSION['user_id']; ?>">
                                                    <input type="hidden" name="comment_content_id"
                                                           value="<?php echo $contentDetail->content_id; ?>">
                                                    <input type="hidden" name="comment_device_type_id" value="1">
                                                    <button type="submit"
                                                            class="theme_btn tp_one"><?php echo $this->lang->line("Submit Review"); ?></button>
                                                <?php
                                                }else{
                                                    echo $this->lang->line("To leave a review, please login to your account.");
                                                    $login_url = base_url()."dashboard";
                                                    echo " <a href='$login_url'>".$this->lang->line("Login")."</a>";
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

<?php
$this->load->view('frontend/common/footer_view');
?>
