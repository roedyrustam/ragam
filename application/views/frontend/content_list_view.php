<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('frontend/common/head_view');
$this->load->view('frontend/common/header_view');

if (isset($_GET['category']))
{
	$category = $_GET['category'];
}
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
                                <li class="bread_crumb-item active"> <?php echo $this->lang->line("Content List"); ?></li>
                            </ul>
                            <h1><?php echo $this->lang->line("Content List"); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- categories -->
        <section class="doctor type_category">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 padding_zero">
                        <div class="item">
                            <ul id="category-slider">
                                <?php
								if(isset($subCategoriesList)) {
									
									foreach ($subCategoriesList as $category) {
									?>
										<div onclick="location.href='<?php echo base_url()."Web/content_list/?category=$category->category_id&title=$category->category_title"; ?>';">
											<div style="margin-left: 6px; margin-right: 6px; margin-top: 6px; text-align: center">
												<img class="" width="25%" height="auto" src="<?php echo base_url()."assets/upload/category/".$category->category_image; ?>" class="img-circle" alt="<?php echo $category->category_title ?>">
											</div>
											<p class="text-center" style="padding-top: 10px; color: black;"><?php echo $category->category_title ?></p>
										</div>
									<?php
									}
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
		
		<section class="blog_grid">
               <div class="container">
					<div class="row">
				  
						<?php
						if (empty($contentList) & empty($subCategoriesList))
							echo "<p style='margin-bottom: 150px;'>".$this->lang->line("Nothing Found...")."</p>";

						if (empty($contentList) & !empty($subCategoriesList))
							echo "<p style='margin-bottom: 150px;'>".$this->lang->line("Please select above sub categories.")."</p>";

						foreach ($contentList as $content)
						{
						?>
						
							 <div class="col-lg-4 col-md-4 col-sm-12">
								<div class="blog_box type_two <?php if ($this->lang->line("app_direction") == "rtl") echo "rtl"; ?>">
								   <div class="image_box">
									  <img src="<?php echo base_url().'assets/upload/content/thumbnail/'.$content->content_image; ?>" class="img-fluid" alt="img">
									  <!--<div class="overlay ">
										 <a href="https://www.youtube.com/watch?v=nfP5N9Yc72A&amp;t=28s " data-fancybox="gallery " data-caption=" ">
										 <span class="flaticon-video-camera"></span>
										 </a>
									  </div>-->
								   </div>
								   <div class="content_box">
									  <a href="#" class="category "><?php echo $content->category_title; ?></a>
									  <div class="title_box ">
										 <div class="post-date ">
                                            <p><span class="fa fa-clock-o"></span><?php if ($this->lang->line("date-format-ago") == "default") echo timespan($content->content_publish_date, now(), 2)." ".$this->lang->line("ago").""; elseif($this->lang->line("date-format-ago") == "jdf") echo timespan($content->content_publish_date, now(), 2)." ".$this->lang->line("ago").""; else echo timespan($content->content_publish_date, now(), 2)." ".$this->lang->line("ago"); ?></p>
										 </div>
                                        <h2><a href="<?php echo base_url()."Web/content/$content->content_id/$content->content_slug" ?>"><?php echo character_limiter($content->content_title, 28); ?></a></h2>
									  </div>
									  <p><?php echo character_limiter($content->content_description, 60); ?></p>
                                      <a href="<?php echo base_url()."Web/content/$content->content_id/$content->content_slug" ?>" class="read_more tp_two "><?php echo $this->lang->line("Read More"); ?><span class="flaticon-arrow"></span></a>
								   </div>
								</div>
							 </div>

						<?php
						}
						?>
					
					</div>
				  
				  
                  <div class="row">
                     <div class="col-lg-12 text-center pagination_column">
                        <?php
						{
						//Show Pagination
						echo $Links;
						}
						?>
                     </div>
                  </div>
               </div>
            </section>
		


    </main>

<?php
$this->load->view('frontend/common/footer_view');
?>
