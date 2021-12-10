<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dashboard/common/head_view');
$this->load->view('dashboard/common/header_view');
//Show relevant sidebar
if ($_SESSION['user_type'] == 1)
    $this->load->view('dashboard/common/sidebar_view');
elseif ($_SESSION['user_type'] == 2)
    $this->load->view('dashboard/common/sidebar_user_view');
?>

<section class="content">
    <div class="container-fluid">
        <!--<div class="block-header">
                <h2>
                    <?php echo $this->lang->line("Add Content"); ?>
                </h2>
            </div>-->
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
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
                <div class="card">
                    <div class="header">
                        <h2>
                            <?php echo $this->lang->line("Add Content"); ?>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?php echo base_url()."dashboard/Dashboard"; ?>"><?php echo $this->lang->line("Dashboard"); ?></a></li>
                                    <li><a href="<?php echo base_url()."dashboard/Content/content_list"; ?>"><?php echo $this->lang->line("Content List"); ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <?php
                        $attributes = array('class' => 'form-horizontal', 'method' => 'post');
                        echo form_open_multipart(base_url()."dashboard/Content/add_content/", $attributes);
                        //form_open_multipart//For Upload
                        ?>

                        <div class="form-group">
                            <label for="content_title" class="col-sm-2 control-label"><?php echo $this->lang->line("Title"); ?> *</label>
                            <div class="col-sm-10">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="content_title" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content_description" class="col-sm-2 control-label"><?php echo $this->lang->line("Description"); ?> *</label>
                            <div class="col-sm-10">
                                <div class="">
                                    <textarea class="form-control" name="content_description" id="content_description" required><?php echo $this->lang->line("Write Something..."); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content_category_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Category"); ?> *</label>
                            <div class="col-sm-10">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="content_category_id" name="content_category_id" data-live-search="true" data-show-subtext="true" required>
                                        <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                        <?php
                                        foreach ($fetchCategories as $key) {
                                            ?>
                                            <option data-divider="true"></option>
                                            <option value="<?php echo $key->category_id ?>">◼ <?php echo $key->category_title; ?></option>
                                            <?php
                                            //To get sub category
                                            $subCategory = $this->db->get_where('category_table', array('category_parent_id' => $key->category_id))->result();
                                            foreach($subCategory as $sKey)
                                            {
                                                echo "<option data-subtext='($key->category_title)' value='$sKey->category_id'>&nbsp;&nbsp;&nbsp;&nbsp;◾&nbsp;$sKey->category_title</option>";
                                                //To get sub sub category
                                                $subSubCategory = $this->db->get_where('category_table', array('category_parent_id' => $sKey->category_id))->result();
                                                foreach($subSubCategory as $ssKey)
                                                {
													echo "<option data-subtext='($sKey->category_title)' class='subSubCategoryDropDown' value='$ssKey->category_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;◽&nbsp;$ssKey->category_title</option>";
													//To get sub sub sub category
													$subSubSubCategory = $this->db->get_where('category_table', array('category_parent_id' => $ssKey->category_id))->result();
													foreach($subSubSubCategory as $sssKey)
													{
														echo "<option data-subtext='($ssKey->category_title)' class='subSubCategoryDropDown' value='$sssKey->category_id'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;◽&nbsp;$sssKey->category_title</option>";
													}                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <!--<div class="form-group">
                                    <label for="content_access" class="col-sm-2 control-label"><?php echo $this->lang->line("Access to content"); ?> *</label>
                                    <div class="col-sm-10">
                                        <div class="form-line">
                                            <select class="form-control show-tick" id="content_access" name="content_access" required>
                                                <option selected value="1"><?php echo $this->lang->line("Indirect Access"); ?></option>
                                                <option value="2"><?php echo $this->lang->line("Direct Access"); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>-->

                        <div class="form-group">
                            <label for="content_type_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Content Type"); ?> *</label>
                            <div class="col-sm-10">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="content_type_id" name="content_type_id" required>
                                        <option selected="selected" disabled><?php echo $this->lang->line("--- Please Select ---"); ?></option>
                                        <?php
                                        foreach ($contentType as $key) {
                                            ?>
                                            <option data-subtext="(<?php echo $key->content_type_description ?>)" value="<?php echo $key->content_type_id; ?>"><?php echo $key->content_type_title ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <small class="col-pink"><?php echo $this->lang->line(""); ?></small>
                            </div>
                        </div>

                        <div style='display:none;' id='video'>
                            <div class="form-group">
                                <label for="content_player_type_id" class="col-sm-2 control-label"><?php echo $this->lang->line("Player"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="content_player_type_id" name="content_player_type_id" required>
                                            <?php
                                            foreach ($playerType as $key) {
                                                ?>
                                                <option data-subtext="(<?php echo $key->player_type_description ?>)" value="<?php echo $key->player_type_id; ?>"><?php echo $key->player_type_title ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line(""); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_duration" class="col-sm-2 control-label"><?php echo $this->lang->line("Duration"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" style="direction: ltr" class="form-control" name="content_duration" placeholder="02:15">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style='display:none;' id='product'>
                            <div class="form-group">
                                <label for="content_price" class="col-sm-2 control-label"><?php echo $this->lang->line("Price"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="number" style="direction: ltr" class="form-control" name="content_price" value="0">
                                    </div>
									<small class="col-pink"><?php echo $this->lang->line("Set 0 to disable."); ?></small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_phone" class="col-sm-2 control-label"><?php echo $this->lang->line("Phone"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="tel" style="direction: ltr" class="form-control" name="content_phone">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_email" class="col-sm-2 control-label"><?php echo $this->lang->line("Email"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="email" style="direction: ltr" class="form-control" name="content_email">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_latitude" class="col-sm-2 control-label"><?php echo $this->lang->line("Latitude"); ?></label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" style="direction: ltr" class="form-control" name="content_latitude">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content_longitude" class="col-sm-2 control-label"><?php echo $this->lang->line("Longitude"); ?></label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" style="direction: ltr" class="form-control" name="content_longitude">
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("You can use above website to generate map location: www.latlong.net"); ?></small>
                                </div>
                            </div>
                        </div>

                        <div style='display:none;' id='url'>
                            <div class="form-group">
                                <label for="content_url" class="col-sm-2 control-label"><span id="selected_name"></span> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="text" style="direction: ltr" class="form-control" name="content_url" placeholder="http://www.YourDomain.com">
                                    </div>
                                    <small class="col-pink"><span id="selected_url_guide"></span></small>
                                </div>
                            </div>
                        </div>

                        <div style='display:none;' id='open_url_inside'>
                            <div class="form-group">
                                <label for="content_open_url_inside_app" class="col-sm-2 control-label"><?php echo $this->lang->line("App or Browser"); ?></label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <input type="checkbox" class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_open_url_inside_app" name="content_open_url_inside_app">
                                        <label class="" for="content_open_url_inside_app"><?php echo $this->lang->line("Open URL inside application."); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style='display:none;' id='orientation'>
                            <div class="form-group">
                                <label for="content_orientation" class="col-sm-2 control-label"><?php echo $this->lang->line("Orientation"); ?> *</label>
                                <div class="col-sm-10">
                                    <div class="form-line">
                                        <select class="form-control show-tick" id="content_orientation" name="content_orientation" required>
                                            <option selected="selected" value="1"><?php echo $this->lang->line("It does not matter"); ?></option>
                                            <option data-subtext="(Portrait)" value="2"><?php echo $this->lang->line("Portrait"); ?></option>
                                            <option data-subtext="(Landscape)" value="3"><?php echo $this->lang->line("Landscape"); ?></option>
                                        </select>
                                    </div>
                                    <small class="col-pink"><?php echo $this->lang->line("Suitable for display on a mobile phone vertically or horizontally."); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content_user_role_id" class="col-sm-2 control-label"><?php echo $this->lang->line("User Role"); ?> *</label>
                            <div class="col-sm-10">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="content_user_role_id" name="content_user_role_id" data-show-subtext="true" required>
                                        <?php
                                        foreach ($userRole as $key) {
                                            ?>
                                            <option value="<?php echo $key->user_role_id; ?>"><?php echo $key->user_role_title ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <small class="col-pink"><?php echo $this->lang->line("Which user role can access to this content?"); ?></small>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="content_image" class="col-sm-2 control-label"><?php echo $this->lang->line("Cover Image"); ?></label>
                            <div class="col-sm-10">
                                <div class="form-line">
                                    <input type="file" name="content_image" multiple>
                                </div>
                                <small class="col-pink"><?php echo $this->lang->line("Best image ratio for content."); ?></small>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="content_cached" class="col-sm-2 control-label"><?php echo $this->lang->line("Cached Content"); ?></label>
                            <div class="col-sm-10">
                                <div class="form-line">
                                    <input type="checkbox" checked class="filled-in <?php echo $this->lang->line("chk-col-x"); ?>" id="content_cached" name="content_cached">
                                    <label class="" for="content_cached"><?php echo $this->lang->line("Enable cache for webview player to loading faster."); ?></label>
                                </div>
                            </div>
                        </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="hidden" class="form-control" name="send_push_notification" value="" readonly>
                                        <input type="hidden" class="form-control" name="content_featured" value="" readonly>
                                        <input type="hidden" class="form-control" name="content_special" value="" readonly>
                                        <input type="hidden" class="form-control" name="content_status" value="" readonly>
                                        <input type="hidden" class="form-control" name="content_user_id" value="<?php echo $_SESSION['user_id'] ?>" readonly>
                                        <input type="hidden" class="form-control" name="content_order" value="1" readonly>
                                        <input type="hidden" class="form-control" name="content_access" value="1" readonly>
                                        <button <?php if($_SESSION['user_role_id'] == 4) echo "disabled='disabled'"; ?> type="submit" class="btn <?php echo $this->lang->line("bg-x"); ?> m-t-15 waves-effect"><?php echo $this->lang->line("Add Content"); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>

<!-- TinyMCE -->
<script src="<?php echo base_url()."assets/dashboard/plugins/tinymce/tinymce.js"; ?>"></script>
<?php
$this->load->view('dashboard/common/footer_view');
?>
<script>
    tinymce.init({
        selector: '#content_description',
        height: 250,
        theme: 'modern',
		relative_urls : false,
		remove_script_host : false,
		document_base_url : "/",
		convert_urls : true,
        directionality: "<?php echo $this->lang->line('app_direction'); ?>",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste wordcount"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
        setup : function(ed)
        {
            ed.on('init', function()
            {
                this.getDoc().body.style.fontSize = '13px';
                this.getDoc().body.style.fontFamily = 'Tahoma';
            });
        },

    });
</script>

<!-- Hide Div -->
<script>
	$('#content_type_id').on('change', function () {
		if (this.value == '11') { //Video & Movie
			$("#video").show();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('<?php echo $this->lang->line("Video URL / ID"); ?>');
			$('#selected_url_guide').html('<?php echo $this->lang->line("Direct Video URL or YouTube and Vimeo Video ID"); ?>');
		}
		else if (this.value == '12') { //Music & Audio
			$("#video").show();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('Music URL');
			$('#selected_url_guide').html('');
		}
		else if (this.value == '13') { //HTML5 Game
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").show();
			$("#product").hide();
			$('#selected_name').html('Game URL');
			$('#selected_url_guide').html('<?php echo $this->lang->line("Direct HTML5 Games URL"); ?>');
		}
		else if (this.value == '14') { //Text & Article
			$("#video").hide();
			$("#url").hide();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('Text & Article');
			$('#selected_url_guide').html('');
		}
		else if (this.value == '15') { //PDF Reader
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('PDF File URL');
			$('#selected_url_guide').html('<?php echo $this->lang->line("Direct PDF File URL"); ?>');
		}
		else if (this.value == '16') { //News
			$("#video").hide();
			$("#url").hide();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('News');
			$('#selected_url_guide').html('');
		}
		else if (this.value == '17') { //Product
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").show();
			$('#selected_name').html('Link URL');
			$('#selected_url_guide').html('');
		}
		else if (this.value == '18') { //Buy & Sell
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").show();
			$('#selected_name').html('Link URL');
			$('#selected_url_guide').html('');
		}
		else if (this.value == '19') { //City Guide
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").show();
			$('#selected_name').html('Link URL');
			$('#selected_url_guide').html('');
		}
		else if (this.value == '20') { //Download
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('File URL');
			$('#selected_url_guide').html('<?php echo $this->lang->line("Direct File URL"); ?>');
		}
		else if (this.value == '21') { //Hyperlink
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").show();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('Link URL');
			$('#selected_url_guide').html('');

		}else if (this.value == '22') { //Images Gallery
			$("#video").hide();
			$("#url").show();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").show();
			$('#selected_name').html('Link URL');
			$('#selected_url_guide').html('');

		}else {
			$("#video").hide();
			$("#url").hide();
			$("#open_url_inside").hide();
			$("#orientation").hide();
			$("#product").hide();
			$('#selected_name').html('Content URL');
			$('#selected_url_guide').html('');
		}
	});
</script>
