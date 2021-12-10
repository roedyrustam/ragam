<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller
{

    //============================ Main construct
    function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model("dashboard/Common_model");
        $this->load->model("dashboard/User_model");
        $this->load->model("Shared_model");
    }


    //============================ Hash password
    private function hash_password($user_password){
        //return password_hash($password, PASSWORD_BCRYPT);
        $salt_password = "dF$.50^&D10?#^dA2z";
        return $hash_password = sha1(md5($user_password.$salt_password));
    }


    //============================ Check user is login or not
    private function is_login() {
        if (!isset($_SESSION['user_username']) && !isset($_SESSION['user_type']))
        {
            redirect(base_url()."dashboard/Auth");
            die();
        }
    }


    //============================ Show dashboard
    public function index()
    {
        $data["pageTitle"] = $this->lang->line("app_name");
        $this->load->view('dashboard/dashboard_view', $data);
    }


    //============================ Show dashboard
    public function profile()
    {
        if(isset($_POST['profile_section']))
        {
            switch ($_POST['profile_section']) {
                
                case "user_role":
                    $this->form_validation->set_rules('user_role_id', 'user_role_id', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('user_duration', 'user_duration', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('user_credit', 'user_credit', 'trim|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        redirect(base_url() . "dashboard/User/profile/user_role");

                    }else{
                        $user_credit = $this->input->post('user_credit');
                        $user_duration = $this->input->post('user_duration');

                        //Explode user_role_id AND user_role_price
                        $user_role_id_price = explode("|",$this->input->post('user_role_id'));
                        $user_role_id = $user_role_id_price[0];
                        $user_role_price = $user_role_id_price[1];

                        if ($user_duration == 30) $user_role_price = $user_role_price; //Price for 30 days
                        elseif ($user_duration == 90) $user_role_price = $user_role_price*3; //Price for 90 days
                        elseif ($user_duration == 180) $user_role_price = $user_role_price*5; //Price for 180 days, 30 days discount
                        elseif ($user_duration == 360) $user_role_price = $user_role_price*10; //Price for 365 days, 60 days discount

                        if($user_role_price > $user_credit)
                        {
                            $msg = $this->lang->line("You have not enough credit to upgrade your account. Please add funds first.");
                            $this->session->set_flashdata('msg', $msg);
                            $this->session->set_flashdata('msgType', 'warning');
                            redirect(base_url() . "dashboard/User/profile/user_role");

                        }else{
                            $dataArray = array(
                                "user_role_id" => $user_role_id,
                                "user_duration" => $user_duration,
                            );
                            //Update user from $dataArray
                            $this->Common_model->data_update("user_table",$dataArray,array("user_id"=>$_SESSION['user_id']));

                            //Update user credit
                            $amount = $user_role_price;
                            $this->User_model->update_user_credit('user_table', $amount, $_SESSION['user_id'], "-");

                            //Insert data into transaction_table
                            $dataArrayT = array(
                                "transaction_user_id" => $_SESSION['user_id'],
                                "transaction_order_id" => 0,
                                "transaction_mobile" => $_SESSION['user_mobile'],
                                "transaction_email" => $_SESSION['user_email'],
                                "transaction_amount" => $amount,
                                "transaction_description" => $this->lang->line("User role has been upgraded."),
                                "transaction_date" => now(),
                                "transaction_userip" => $this->input->ip_address(),
                                "transaction_gateway" => 4, //Wallet gateway
                                "transaction_type" => 2, //Decrease Funds
                                "transaction_status" => 4, //Funds Deduction
                            );
                            //Insert $dataArray to DB
                            $this->Common_model->data_insert("transaction_table",$dataArrayT);

                            //Insert data into activity_table
                            $dataArray = array(
                                "activity_user_id" => $_SESSION['user_id'],
                                "activity_time" => now(),
                                "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                                "activity_ip" => $this->input->ip_address(),
                                "activity_desc" => $this->lang->line("User role has been upgraded."),
                            );
                            $this->Common_model->data_insert("activity_table",$dataArray);

                            //Set user_role_id session
                            $session_data = array(
                                'user_role_id' => $user_role_id,
                            );
                            $this->session->set_userdata($session_data);

                            //Send upgrade role email to user
                            $to = $_SESSION['user_email'];
                            $cc = false; //To send a copy of email
                            $subject = $this->lang->line("Upgrade User Role");
                            $message = $this->lang->line("Your account successfully upgraded.")
                                .$message = "<br>";
                            $this->Shared_model->send_email($to, $cc, $subject, $message);

                            $msg = $this->lang->line("Your account successfully upgraded.");
                            $this->session->set_flashdata('msg', $msg);
                            $this->session->set_flashdata('msgType', 'success');
                            redirect(base_url() . "dashboard/User/profile/user_role");
                        }

                    }
                    break;
                case "profile_settings":
                    //For uploading
                    $config['upload_path']          = 'assets/upload/user/profile_img/';
                    $config['allowed_types']        = 'gif|jpg|jpeg|png';
                    $config['remove_spaces'] = TRUE;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('user_image'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error);
                        $new_user_image = "avatar.png";

                    } else {
                        // [ Resize avatar image ]
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = 'assets/upload/user/profile_img/'.$this->upload->data()['file_name'];
                        $config['new_image'] = 'assets/upload/user/profile_img/'.$this->upload->data()['file_name'];
                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = 150;
                        $config['height'] = 150;
                        $config['overwrite'] = TRUE;
                        $this->load->library('image_lib',$config);
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        $data = array('upload_data' => $this->upload->data());
                        $new_user_image =  $this->upload->data()['file_name'];
                    }

                    $this->form_validation->set_rules('user_firstname', 'First Name', 'trim|required|xss_clean|min_length[1]|max_length[30]',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'min_length'      => $this->lang->line("must_be_minimum_characters"),
                            'max_length'      => $this->lang->line("must_be_maximum_characters")));
                    $this->form_validation->set_rules('user_lastname', 'Last Name', 'trim|required|xss_clean|min_length[1]|max_length[30]',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'min_length'      => $this->lang->line("must_be_minimum_characters"),
                            'max_length'      => $this->lang->line("must_be_maximum_characters")));
                    $this->form_validation->set_rules('user_email', 'Email', 'trim|required|xss_clean|valid_email|min_length[3]|max_length[60]',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'min_length'      => $this->lang->line("must_be_minimum_characters"),
                            'max_length'      => $this->lang->line("must_be_maximum_characters"),
                            'valid_email'     => $this->lang->line("is_not_valid_an_email_address")));
                    $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|xss_clean|required',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'min_length'      => $this->lang->line("must_be_minimum_characters"),
                            'max_length'      => $this->lang->line("must_be_maximum_characters")));
                    $this->form_validation->set_rules('user_phone', 'Phone', 'trim|xss_clean',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'min_length'      => $this->lang->line("must_be_minimum_characters"),
                            'max_length'      => $this->lang->line("must_be_maximum_characters")));
                    $this->form_validation->set_rules('user_note', $this->lang->line("Notes"), 'trim|xss_clean');
                    $this->form_validation->set_rules('user_image', 'Image', 'trim|xss_clean');
                    $this->form_validation->set_rules('old_user_image', 'Old Image', 'trim|xss_clean');

                    if ($this->form_validation->run() == FALSE) {
                        redirect(base_url() . "dashboard/User/profile".$_SESSION['user_id']);

                    }else{
                        //Check Email is exist or not
                        $user_email = $this->input->post('user_email');
                        $check_email = $this->User_model->check_email('user_table', $user_email);
                        if ($check_email == FALSE) {
                            if($user_email != $_SESSION['user_email'])
                            {
                                $msg = $user_email." ".$this->lang->line("is_exist_in_our_system");
                                $this->session->set_flashdata('msg',$msg);
                                $this->session->set_flashdata('msgType','danger');
                                redirect(base_url().'dashboard/User/profile/profile_settings');
                                $this->db->close();
                                die();
                            }
                        }
                        //Check Mobile is exist or not
                        $user_mobile = $this->Shared_model->number2english($this->input->post('user_mobile'));
                        $check_mobile = $this->User_model->check_mobile('user_table', $user_mobile);
                        if ($check_mobile == FALSE) {
                            if($user_mobile != $_SESSION['user_mobile'])
                            {
                                $msg = $user_mobile." ".$this->lang->line("is_exist_in_our_system");
                                $this->session->set_flashdata('msg',$msg);
                                $this->session->set_flashdata('msgType','danger');
                                redirect(base_url().'dashboard/User/profile/profile_settings');
                                $this->db->close();
                                die();
                            }
                        }
                        //Check if user_image submit or not
                        if ($new_user_image == "avatar.png")
                        {
                            $dataArray = array(
                                "user_firstname" => $this->input->post('user_firstname'),
                                "user_lastname" => $this->input->post('user_lastname'),
                                "user_email" => $this->input->post('user_email'),
                                "user_mobile" => $user_mobile,
                                "user_phone" => $this->Shared_model->number2english($this->input->post('user_phone')),
                                "user_note" => $this->input->post('user_note'),
                                //"user_image" => $new_user_image,
                            );

                        }else{
                            //Remove old user image from disk
                            if($this->input->post('old_user_image') != "avatar.png")
                            {
                                $old_user_image = "assets/upload/user/profile_img/".$this->input->post('old_user_image');
                                unlink($old_user_image);
                            }

                            $dataArray = array(
                                "user_firstname" => $this->input->post('user_firstname'),
                                "user_lastname" => $this->input->post('user_lastname'),
                                "user_email" => $this->input->post('user_email'),
                                "user_mobile" => $user_mobile,
                                "user_phone" => $this->Shared_model->number2english($this->input->post('user_phone')),
                                "user_note" => $this->input->post('user_note'),
                                "user_image" => $new_user_image,
                            );
                        }
                        //Set user_email user_mobile session
                        $session_data = array(
                            'user_email' => $this->input->post('user_email'),
                            'user_mobile' => $this->input->post('user_mobile'),
                        );
                        $this->session->set_userdata($session_data);
                        //Update user from $dataArray
                        $this->Common_model->data_update("user_table",$dataArray,array("user_id"=>$_SESSION['user_id']));
                        $msg = $this->lang->line("Data successfully updated.");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'info');
                        redirect(base_url() . "dashboard/User/profile/profile_settings");
                    }
                break;
                case "change_password_settings":
                    $this->form_validation->set_rules('old_password', $this->lang->line("Old Password"), 'trim|required|xss_clean|min_length[8]',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'min_length'      => $this->lang->line("must_be_minimum_characters")
                        ));
                    $this->form_validation->set_rules('new_password', $this->lang->line("New Password"), 'trim|required|xss_clean|min_length[8]',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'min_length'      => $this->lang->line("must_be_minimum_characters")
                        ));
                    $this->form_validation->set_rules('new_password_confirm', $this->lang->line("New Password (confirm)"), 'trim|required|xss_clean|matches[new_password]',
                        array(
                            'required'      => $this->lang->line("field_is_required"),
                            'matches'     => $this->lang->line("the_password_confirmation_field_does_not_match_the_password_field")
                        )
                    );

                    if ($this->form_validation->run() == FALSE) {
                        $msg = $this->lang->line("Error!");
                        $this->session->set_flashdata('msg', $msg);
                        $this->session->set_flashdata('msgType', 'danger');
                        redirect(base_url() . "dashboard/User/profile/change_password_settings");

                    }else{
                        $old_password = $this->input->post('old_password');
                        $new_password = $this->input->post('new_password');
                        if ($this->User_model->compare_old_new_password('user_table', $_SESSION['user_id'], $this->hash_password($old_password)) == true)
                        {
                            $dataArray = array(
                                "user_password" => $this->hash_password($new_password),
                            );
                            //Update password from $dataArray
                            $this->Common_model->data_update("user_table",$dataArray,array("user_id"=>$_SESSION['user_id']));

                            $msg = $this->lang->line("Data successfully updated.");
                            $this->session->set_flashdata('msg', $msg);
                            $this->session->set_flashdata('msgType', 'info');
                            redirect(base_url() . "dashboard/User/profile/change_password_settings");

                        }else{
                            $msg = $this->lang->line("Old password is incorrect.");
                            $this->session->set_flashdata('msg', $msg);
                            $this->session->set_flashdata('msgType', 'danger');
                            redirect(base_url() . "dashboard/User/profile/change_password_settings");
                        }


                    }
				case "withdrawal_coin_settings":
					$this->form_validation->set_rules('withdrawal_account_type', 'withdrawal_account_type', 'trim|required|xss_clean');
					$this->form_validation->set_rules('withdrawal_account_name', 'withdrawal_account_name', 'trim|required|xss_clean');
					$this->form_validation->set_rules('withdrawal_user_comment', 'withdrawal_user_comment', 'trim|xss_clean');
					$this->form_validation->set_rules('withdrawal_user_id', 'withdrawal_user_id', 'trim|required|xss_clean');
					$this->form_validation->set_rules('withdrawal_req_coin', 'withdrawal_req_coin', 'trim|required|xss_clean');
					$this->form_validation->set_rules('withdrawal_req_cash', 'withdrawal_req_cash', 'trim|required|xss_clean');
					$this->form_validation->set_rules('profile_section', 'profile_section', 'trim|required|xss_clean');

					if ($this->form_validation->run() == FALSE) {
						$msg = $this->lang->line("Error!");
						$this->session->set_flashdata('msg', $msg);
						$this->session->set_flashdata('msgType', 'danger');
						redirect(base_url() . "dashboard/User/profile/withdrawal_coin_settings");

					}else{
						$withdrawal_account_type = $this->input->post('withdrawal_account_type');
						$withdrawal_account_name = $this->input->post('withdrawal_account_name');
						$withdrawal_user_comment = $this->input->post('withdrawal_user_comment');
						$withdrawal_user_id = $this->input->post('withdrawal_user_id');
						$withdrawal_req_coin = $this->input->post('withdrawal_req_coin');
						//$withdrawal_req_cash = $this->input->post('withdrawal_req_cash');

						// Check enough coin to withdrawal
						$q = $this->db->query("Select reward_coin_withdrawal_coin_minimum_req, reward_coin_price_of_each_coin
                                        FROM reward_coin_table
                                        WHERE (reward_coin_id = 1);");
						$reward_coin_withdrawal_coin_minimum_req = $q->row()->reward_coin_withdrawal_coin_minimum_req;
						$reward_coin_price_of_each_coin = $q->row()->reward_coin_price_of_each_coin;

						if($reward_coin_withdrawal_coin_minimum_req >= $withdrawal_req_coin) {
							// You have not enough coin to withdrawal
							$msg = $this->lang->line("You have not enough coin to withdrawal.");
							$this->session->set_flashdata('msg', $msg);
							$this->session->set_flashdata('msgType', 'warning');
							redirect(base_url() . "dashboard/User/profile/withdrawal_coin_settings");

						}else {
							//Coin to Cash
							$withdrawal_req_cash = $withdrawal_req_coin * $reward_coin_price_of_each_coin;

							$dataArray = array(
								"withdrawal_user_id" => $withdrawal_user_id,
								"withdrawal_account_type" => $withdrawal_account_type,
								"withdrawal_account_name" => $withdrawal_account_name,
								"withdrawal_req_coin" => $withdrawal_req_coin,
								"withdrawal_req_cash" => $withdrawal_req_cash,
								"withdrawal_user_comment" => $withdrawal_user_comment,
								"withdrawal_req_date" => now(),
								"withdrawal_status" => 1, // 1: Pending | 2: Paid | 3. Cancel
							);

							if ($this->Common_model->data_insert("withdrawal_table", $dataArray)) {
								//Update user coin
								$this->db->query("UPDATE user_table SET user_coin = user_coin - '$withdrawal_req_coin' WHERE user_id = '$withdrawal_user_id'");

								$dataArrayUser = array(
									"activity_user_id" => $withdrawal_user_id,
									"activity_time" => now(),
									"activity_agent" => $_SERVER['HTTP_USER_AGENT'],
									"activity_ip" => $this->input->ip_address(),
									"activity_desc" => $this->lang->line("Withdrawal coin request received."),
								);
								$this->Common_model->data_insert("activity_table", $dataArrayUser);

								$msg = $this->lang->line("We received your request. Please wait for the review.");
								$this->session->set_flashdata('msg', $msg);
								$this->session->set_flashdata('msgType', 'success');
								redirect(base_url() . "dashboard/User/profile/withdrawal_coin_settings");
							}
						}
					}

                default:

            }
        }

        $data["userContent"] = $this->User_model->get_user_content('user_table', $_SESSION['user_id'])->result()[0];
		@$data["rewardCoinContent"] = $this->User_model->get_reward_coin_content('reward_coin_table', 1)->result()[0];
		$data["getWithdrawalAccountType"] = $this->User_model->get_withdrawal_account_type('withdrawal_account_type_table')->result();
        $data["totalUserReferral"] = $this->User_model->total_user_referral('user_table', $_SESSION['user_id']);
        $data["totalUserGames"] = $this->User_model->total_user_games('content_table', $_SESSION['user_id']);
        $data["userActivity"] = $this->User_model->get_user_activity('activity_table', $_SESSION['user_id'], 15)->result();
        $this->load->model("dashboard/Settings_model");
        $data["currencyContent"] = $this->Settings_model->get_currency_content('currency_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("Profile");
        $this->load->view('dashboard/user/profile_view', $data);
    }


    //============================ User's list
    public function users_list()
    {
        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["pageTitle"] = $this->lang->line("Users List");
        $this->load->view('dashboard/user/users_list_view', $data);
    }
	
	
	//============================ User's list
    public function users_list2()
    {
        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
		$data["usersList2"] = $this->User_model->get_users_list2('user_table')->result();
        $data["pageTitle"] = $this->lang->line("Users List");
        $this->load->view('dashboard/user/users_list2_view', $data);
    }


    //============================ Ajax User's list
    public function ajax_users_list()
    {
        $columns = array(
            0 =>'user_id',
            1 =>'user_username',
            2 =>'user_firstname',
            3 =>'user_lastname',
            4=> 'user_email',
            5=> 'device_type_title',
            6=> 'user_type_title',
            7=> 'user_role_title',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->User_model->all_users_count();

        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value']))
        {
            $users = $this->User_model->all_users($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value'];

            $users =  $this->User_model->users_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->User_model->users_search_count($search);
        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $key)
            {
                $nestedData['user_id'] = $key->user_id;
                $nestedData['user_username'] = $key->user_username;
                $nestedData['user_firstname'] = $key->user_firstname;
                $nestedData['user_lastname'] = $key->user_lastname;
                $nestedData['user_email'] = $key->user_email;
                $nestedData['device_type_title'] = $key->device_type_title;
                $nestedData['user_type_title'] = $key->user_type_title;
                $nestedData['user_role_title'] = $key->user_role_title;
                //$nestedData['body'] = substr(strip_tags($key->body),0,50)."...";
                //$nestedData['created_at'] = date('j M Y h:i a',strtotime($key->created_at));

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }


    //============================ Add user
    public function add_user()
    {
        if(isset($_POST['user_username']))
        {
            $this->form_validation->set_rules('user_username', $this->lang->line("Username"), 'trim|required|xss_clean|min_length[5]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")));
            $this->form_validation->set_rules('user_email', $this->lang->line("Email"), 'trim|required|xss_clean|valid_email',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'valid_email'     => $this->lang->line("is_not_valid_an_email_address"),
                ));
            $this->form_validation->set_rules('user_password', $this->lang->line("Password"), 'trim|required|xss_clean|min_length[8]',
                array(
                    'required'      => $this->lang->line("field_is_required"),
                    'min_length'      => $this->lang->line("must_be_minimum_characters")
                ));
            $this->form_validation->set_rules('user_referral', $this->lang->line("Referral ID"), 'trim|xss_clean');
            $this->form_validation->set_rules('user_type_id', $this->lang->line("Account Type"), 'trim|xss_clean');
            $this->form_validation->set_rules('user_role_id', $this->lang->line("User Role"), 'trim|xss_clean');
            $this->form_validation->set_rules('send_email', $this->lang->line("Send Email"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error

            } else {
                $user_password = $this->input->post('user_password');
                $dataArray = array(
                    "user_username" => $this->input->post('user_username'),
                    "user_email" => $this->input->post('user_email'),
                    "user_password" => $this->hash_password($user_password),
                    "user_referral" => $this->input->post('user_referral'),
                    "user_type" => $this->input->post('user_type_id'),
                    "user_role_id" => $this->input->post('user_role_id'),
                    "user_device_type_id" => 4,
                    "user_reg_date" => now(),
                );

                //Check Username is exist or not
                $user_username = $dataArray['user_username'];
                $check_username = $this->User_model->check_username('user_table', $user_username);
                if ($check_username == FALSE) {
                    $msg = $user_username." ".$this->lang->line("is_exist_in_our_system");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/User/add_user');
                    $this->db->close();
                    die();
                }
                //Check Email is exist or not
                $user_email = $dataArray['user_email'];
                $check_email = $this->User_model->check_email('user_table', $user_email);
                if ($check_email == FALSE) {
                    $msg = $user_email." ".$this->lang->line("is_exist_in_our_system");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/User/add_user');
                    $this->db->close();
                    die();
                }
                //Check Referral ID is exist or not
                $user_referral = $dataArray['user_referral'];
                if (!empty($user_referral))
                {
                    $check_referral = $this->User_model->check_referral('user_table', $user_referral);
                    if ($check_referral == FALSE) {
                        $msg = $this->lang->line("This Referral ID is not exist in our system: ").$user_referral;
                        $this->session->set_flashdata('msg',$msg);
                        $this->session->set_flashdata('msgType','warning');
                        redirect(base_url().'dashboard/User/add_user');
                        $this->db->close();
                        die();
                    }
                }

                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("user_table",$dataArray);
                if ($result == TRUE) {
                    if($this->input->post('send_email') == 'on')
                    {
                        //Send welcome email to new user
                        $user_username = $dataArray['user_username'];
                        $login_url = base_url()."dashboard/Auth";
                        $to = $user_email;
                        $cc = false; //To send a copy of email
                        $subject = $this->lang->line("New Account Information");
                        $message = $this->lang->line("email_new_account_information")
                            .$message = "- ".$this->lang->line("Login URL").": ".$login_url."<br>- ".$this->lang->line("Username").": ".$user_username."<br>- ".$this->lang->line("Password").": ".$user_password."<br><br>";
                        $this->Shared_model->send_email($to, $cc, $subject, $message);
                    }

                    //Insert data into activity_table
                    $this->db->select('user_id');
                    $q = $this->db->get_where('user_table', array('user_username'=> $user_username));
                    $last_id = $q->result()[0]->user_id;
                    $dataArray = array(
                        "activity_user_id" => $last_id,
                        "activity_time" => now(),
                        "activity_agent" => $_SERVER['HTTP_USER_AGENT'],
                        "activity_ip" => $this->input->ip_address(),
                        "activity_desc" => $this->lang->line("User joined from admin panel."),
                    );
                    $this->Common_model->data_insert("activity_table",$dataArray);

                    $msg = $this->lang->line("registration_successfully");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/User/add_user');

                } else {
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/User/add_user');
                }
            }
        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["userType"] = $this->User_model->get_user_type('user_type_table')->result();
        $user_type_id = null;
        $data["userRole"] = $this->User_model->get_user_role('user_role_table', $user_type_id)->result();
        $data["pageTitle"] = $this->lang->line("Add New User");
        $this->load->view('dashboard/user/add_user_view', $data);
    }


    //============================ Get role from type
    public function get_role_from_type()
    {
        if($this->input->post('user_type_id'))
        {
            echo $this->User_model->get_role_from_type($this->input->post('user_type_id'));
        }
        //echo $this->User_model->get_role_from_type(1);
    }


    //============================ Show dashboard
    public function show_user()
    {
        if(isset($_POST['profile_section']) AND $_POST['profile_section'] == "profile_settings") {
            if(isset($_POST['user_firstname']))
            {
                //For uploading
                $config['upload_path']          = 'assets/upload/user/profile_img/';
                $config['allowed_types']        = 'gif|jpg|jpeg|png';
                $config['remove_spaces'] = TRUE;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('user_image'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    //print_r($error);
                    $new_user_image = "avatar.png";

                } else {
                    // [ Resize avatar image ]
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = 'assets/upload/user/profile_img/'.$this->upload->data()['file_name'];
                    $config['new_image'] = 'assets/upload/user/profile_img/'.$this->upload->data()['file_name'];
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 150;
                    $config['height'] = 150;
                    $config['overwrite'] = TRUE;
                    $this->load->library('image_lib',$config);
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();

                    $data = array('upload_data' => $this->upload->data());
                    $new_user_image =  $this->upload->data()['file_name'];
                }

                $this->form_validation->set_rules('user_firstname', $this->lang->line("First Name"), 'trim|required|xss_clean|min_length[1]|max_length[30]',
                    array(
                        'required'      => $this->lang->line("field_is_required"),
                        'min_length'      => $this->lang->line("must_be_minimum_characters"),
                        'max_length'      => $this->lang->line("must_be_maximum_characters")));
                $this->form_validation->set_rules('user_lastname', $this->lang->line("Last Name"), 'trim|required|xss_clean|min_length[1]|max_length[30]',
                    array(
                        'required'      => $this->lang->line("field_is_required"),
                        'min_length'      => $this->lang->line("must_be_minimum_characters"),
                        'max_length'      => $this->lang->line("must_be_maximum_characters")));
                $this->form_validation->set_rules('user_email', $this->lang->line("Email"), 'trim|required|xss_clean|valid_email|min_length[5]|max_length[60]',
                    array(
                        'required'      => $this->lang->line("field_is_required"),
                        'min_length'      => $this->lang->line("must_be_minimum_characters"),
                        'max_length'      => $this->lang->line("must_be_maximum_characters"),
                        'valid_email'     => $this->lang->line("is_not_valid_an_email_address")));
                $this->form_validation->set_rules('user_mobile', $this->lang->line("Mobile"), 'trim|xss_clean|required',
                    array(
                        'required'      => $this->lang->line("field_is_required"),
                        'min_length'      => $this->lang->line("must_be_minimum_characters"),
                        'max_length'      => $this->lang->line("must_be_maximum_characters")));
                $this->form_validation->set_rules('user_phone', $this->lang->line("Phone"), 'trim|xss_clean',
                    array(
                        'required'      => $this->lang->line("field_is_required"),
                        'min_length'      => $this->lang->line("must_be_minimum_characters"),
                        'max_length'      => $this->lang->line("must_be_maximum_characters")));
                $this->form_validation->set_rules('user_coin', $this->lang->line("Coin(s)"), 'trim|xss_clean');
                $this->form_validation->set_rules('user_password', $this->lang->line("Password"), 'trim|xss_clean|min_length[8]',
                    array(
                        'required'      => $this->lang->line("field_is_required"),
                        'min_length'      => $this->lang->line("must_be_minimum_characters")
                    ));
                $this->form_validation->set_rules('user_type_id', $this->lang->line("Account Type"), 'trim|xss_clean|required',
                    array(
                        'required'      => $this->lang->line("field_is_required")));
                $this->form_validation->set_rules('user_role_id', $this->lang->line("Account Type"), 'trim|xss_clean|required',
                    array(
                        'required'      => $this->lang->line("field_is_required")));
                $this->form_validation->set_rules('user_note', $this->lang->line("Notes"), 'trim|xss_clean');
                $this->form_validation->set_rules('user_image', 'Image', 'trim|xss_clean');
                $this->form_validation->set_rules('old_user_image', 'Old Image', 'trim|xss_clean');
                $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean',
                    array(
                        'required'      => $this->lang->line("field_is_required")));
                $this->form_validation->set_rules('profile_section', 'profile_section', 'trim|required|xss_clean',
                    array(
                        'required'      => $this->lang->line("field_is_required")));
                $this->form_validation->set_rules('old_user_email', $this->lang->line("Email"), 'trim|xss_clean');
                $this->form_validation->set_rules('old_user_mobile', $this->lang->line("Mobile"), 'trim|xss_clean');
                $this->form_validation->set_rules('user_status', $this->lang->line("Status"), 'trim|xss_clean');

                if ($this->form_validation->run() == FALSE) {
                    redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_settings");

                }else{
                    if ($this->input->post('user_status') == 'on') $user_status = 1; else $user_status = 0;

                    //Check Email is exist or not
                    if($this->input->post('old_user_email') != $this->input->post('user_email'))
                    {
                        $user_email = $this->input->post('user_email');
                        $check_email = $this->User_model->check_email('user_table', $user_email);
                        if ($check_email == FALSE)
                        {
                            $msg = $user_email." ".$this->lang->line("is_exist_in_our_system");
                            $this->session->set_flashdata('msg',$msg);
                            $this->session->set_flashdata('msgType','danger');
                            redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_settings");
                            $this->db->close();
                            die();
                        }
                    }

                    //Check Mobile is exist or not
                    if($this->input->post('old_user_mobile') != $this->input->post('user_mobile'))
                    {
                        $user_mobile = $this->Shared_model->number2english($this->input->post('user_mobile'));
                        $check_mobile = $this->User_model->check_mobile('user_table', $user_mobile);
                        if ($check_mobile == FALSE)
                        {
                            $msg = $user_mobile." ".$this->lang->line("is_exist_in_our_system");
                            $this->session->set_flashdata('msg',$msg);
                            $this->session->set_flashdata('msgType','danger');
                            redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_settings");
                            $this->db->close();
                            die();
                        }
                    }

                    //Check if user_image submit or not
                    if ($new_user_image == "avatar.png")
                    {
                        if($this->input->post('user_password') != "") //Also change password
                        {
                            $dataArray = array(
                                "user_firstname" => $this->input->post('user_firstname'),
                                "user_lastname" => $this->input->post('user_lastname'),
                                "user_email" => $this->input->post('user_email'),
                                "user_mobile" => $this->Shared_model->number2english($this->input->post('user_mobile')),
                                "user_phone" => $this->Shared_model->number2english($this->input->post('user_phone')),
                                "user_coin" => $this->Shared_model->number2english($this->input->post('user_coin')),
                                "user_password" => $this->hash_password($this->input->post('user_password')),
                                "user_type" => $this->input->post('user_type_id'),
                                "user_role_id" => $this->input->post('user_role_id'),
                                "user_note" => $this->input->post('user_note'),
                                "user_status" => $user_status,
                                //"user_image" => $new_user_image,
                            );

                        }else{
                            $dataArray = array(
                                "user_firstname" => $this->input->post('user_firstname'),
                                "user_lastname" => $this->input->post('user_lastname'),
                                "user_email" => $this->input->post('user_email'),
                                "user_mobile" => $this->Shared_model->number2english($this->input->post('user_mobile')),
                                "user_phone" => $this->Shared_model->number2english($this->input->post('user_phone')),
                                "user_coin" => $this->Shared_model->number2english($this->input->post('user_coin')),
                                //"user_password" => $this->hash_password($this->input->post('user_password')),
                                "user_type" => $this->input->post('user_type_id'),
                                "user_role_id" => $this->input->post('user_role_id'),
                                "user_note" => $this->input->post('user_note'),
                                "user_status" => $user_status,
                                //"user_image" => $new_user_image,
                            );
                        }


                    }else{
                        //Remove old user image from disk
                        if($this->input->post('old_user_image') != "avatar.png")
                        {
                            $old_user_image = "assets/upload/user/profile_img/".$this->input->post('old_user_image');
                            unlink($old_user_image);
                        }

                        if($this->input->post('user_password') != "") //Also change password
                        {
                            $dataArray = array(
                                "user_firstname" => $this->input->post('user_firstname'),
                                "user_lastname" => $this->input->post('user_lastname'),
                                "user_email" => $this->input->post('user_email'),
                                "user_mobile" => $user_mobile,
                                "user_phone" => $this->Shared_model->number2english($this->input->post('user_phone')),
                                "user_coin" => $this->Shared_model->number2english($this->input->post('user_coin')),
                                "user_password" => $this->hash_password($this->input->post('user_password')),
                                "user_type" => $this->input->post('user_type_id'),
                                "user_role_id" => $this->input->post('user_role_id'),
                                "user_note" => $this->input->post('user_note'),
                                "user_image" => $new_user_image,
                            );

                        }else{
                            $dataArray = array(
                                "user_firstname" => $this->input->post('user_firstname'),
                                "user_lastname" => $this->input->post('user_lastname'),
                                "user_email" => $this->input->post('user_email'),
                                "user_mobile" => $user_mobile,
                                "user_phone" => $this->Shared_model->number2english($this->input->post('user_phone')),
                                "user_coin" => $this->Shared_model->number2english($this->input->post('user_coin')),
                                //"user_password" => $this->hash_password($this->input->post('user_password')),
                                "user_type" => $this->input->post('user_type_id'),
                                "user_role_id" => $this->input->post('user_role_id'),
                                "user_note" => $this->input->post('user_note'),
                                "user_image" => $new_user_image,
                            );
                        }

                    }
                    //Update user from $dataArray
                    $this->Common_model->data_update("user_table",$dataArray,array("user_id"=>$this->input->post('user_id')));
                    $msg = $this->lang->line("Data successfully updated.");
                    $this->session->set_flashdata('msg', $msg);
                    $this->session->set_flashdata('msgType', 'info');
                    redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_settings");
                }
            }

        }elseif(isset($_POST['profile_section']) AND $_POST['profile_section'] == "profile_ads"){
            $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_hide_banner_ad', 'user_hide_banner_ad', 'trim|xss_clean');
            $this->form_validation->set_rules('user_hide_interstitial_ad', 'user_hide_interstitial_ad', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_ads");

            }else{
                if ($this->input->post('user_hide_banner_ad') == 'on') $user_hide_banner_ad = 1; else $user_hide_banner_ad = 0;
                if ($this->input->post('user_hide_interstitial_ad') == 'on') $user_hide_interstitial_ad = 1; else $user_hide_interstitial_ad = 0;

                $dataArrayAds = array(
                    "user_hide_banner_ad" => $user_hide_banner_ad,
                    "user_hide_interstitial_ad" => $user_hide_interstitial_ad,
                );

                //Update user from $dataArray
                $this->Common_model->data_update("user_table",$dataArrayAds,array("user_id"=>$this->input->post('user_id')));
                $msg = $this->lang->line("Data successfully updated.");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'info');
                redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_ads");
            }

        }elseif(isset($_POST['profile_section']) AND $_POST['profile_section'] == "profile_verification"){
            $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_email_verified', 'user_email_verified', 'trim|xss_clean');
            $this->form_validation->set_rules('user_mobile_verified', 'user_mobile_verified', 'trim|xss_clean');
            $this->form_validation->set_rules('user_document_verified', 'user_document_verified', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_ads");

            }else{
                if ($this->input->post('user_email_verified') == 'on') $user_email_verified = 1; else $user_email_verified = 0;
                if ($this->input->post('user_mobile_verified') == 'on') $user_mobile_verified = 1; else $user_mobile_verified = 0;
                if ($this->input->post('user_document_verified') == 'on') $user_document_verified = 1; else $user_document_verified = 0;

                $dataArrayAds = array(
                    "user_email_verified" => $user_email_verified,
                    "user_mobile_verified" => $user_mobile_verified,
                    "user_document_verified" => $user_document_verified,
                );

                //Update user from $dataArray
                $this->Common_model->data_update("user_table",$dataArrayAds,array("user_id"=>$this->input->post('user_id')));
                $msg = $this->lang->line("Data successfully updated.");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'info');
                redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_verification");
            }

        }elseif(isset($_POST['profile_section']) AND $_POST['profile_section'] == "profile_push_notification"){
            $this->form_validation->set_rules('user_id', 'user_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('push_notification_title', 'push_notification_title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('push_notification_message', 'push_notification_message', 'trim|required|xss_clean');
            $this->form_validation->set_rules('push_notification_external_link', 'push_notification_external_link', 'trim|xss_clean');
            $this->form_validation->set_rules('user_onesignal_player_id', 'user_onesignal_player_id', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_push_notification");

            }else{
                //OneSignal Notification
                $push_notification_title = $this->input->post('push_notification_title');
                $push_notification_message = $this->input->post('push_notification_message');
                $push_notification_external_link = $this->input->post('push_notification_external_link');
                $user_onesignal_player_id = $this->input->post('user_onesignal_player_id');
                $push_notification_player_id = array("$user_onesignal_player_id");
                $response = $this->Shared_model->send_push_notification_one_signal_specific_user($push_notification_title, $push_notification_message, $push_notification_external_link, $push_notification_player_id);

                $return["allresponses"] = $response;
                $return = json_encode($return);

                $data = json_decode($response, true);
                //print_r($data);
                //$id = $data['id'];
                //print_r($id);

                //print("\n\nJSON received:\n");
                //print($return);
                //print("\n");
                //Total user that receive notification
                $recipients = $data['recipients'];
                if(empty($recipients))
                    $recipients = 0;
                $msg = $this->lang->line("Notification sent successfully to")." ".$recipients." ".$this->lang->line("user(s).");
                $this->session->set_flashdata('msg', $msg);
                $this->session->set_flashdata('msgType', 'success');
                redirect(base_url() . "dashboard/User/show_user/".$this->input->post('user_id')."/profile_push_notification");
            }
        }


        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["userType"] = $this->User_model->get_user_type('user_type_table')->result();
        $user_id = $this->uri->segment(4);
        $q = $this->db->query("Select user_table.user_type FROM user_table	WHERE user_id = '$user_id'");
        $user_type_id = $q->row()->user_type;
        $data["userRole"] = $this->User_model->get_user_role('user_role_table', $user_type_id)->result();
        $user_id = $this->uri->segment(4);
        @$data["userContent"] = $this->User_model->get_user_content('user_table', $user_id)->result()[0];
        @$data["rewardCoinContent"] = $this->User_model->get_reward_coin_content('reward_coin_table', 1)->result()[0];
        $data["totalUserReferral"] = $this->User_model->total_user_referral('user_table', $user_id);
        @$data["userActivity"] = $this->User_model->get_user_activity('activity_table', $user_id, 100)->result();
        $this->load->model("dashboard/Settings_model");
        $data["currencyContent"] = $this->Settings_model->get_currency_content('currency_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("User Details");
        $this->load->view('dashboard/user/show_user_view', $data);
    }


    //============================ Show dashboard
    public function delete_user(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['user_id'])) {
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|xss_clean',
                array(
                    'required' => $this->lang->line("field_is_required")));

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/User/show_user/'.$this->input->post('user_id'));

            } else {
                $user_id = $this->input->post('user_id');
                //Prevent to delete First and Super Admin user_id: 1
                if($user_id <= 1)
                {
                    $msg = $this->lang->line("You can not delete this item.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/User/show_user/'.$this->input->post('user_id'));
                    $this->db->close();
                    die();
                }

                //Prevent to delete yourself
                if($user_id <= $_SESSION['user_id'])
                {
                    $msg = $this->lang->line("You can not delete this item.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/User/show_user/'.$this->input->post('user_id'));
                    $this->db->close();
                    die();
                }

                //Prevent to delete if any content exist in it
                $check_content_exist = $this->User_model->check_content_exist('content_table', $user_id);
                if ($check_content_exist == TRUE) {
                    $msg = $this->lang->line("There are content exist in this user and you can not delete him/her.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/User/show_user/'.$user_id);
                    $this->db->close();
                    die();
                }

                //Remove user image from disk
                $q = $this->User_model->get_user_image("user_table",$user_id);
                echo "Q is: ".$q->user_image;
                if ($q->user_image != 'avatar.png')
                {
                    $user_image = "assets/upload/user/profile_img/".$q->user_image;
                    unlink($user_image);
                }

                //Delete any content for this user
                $this->Common_model->data_remove("content_table",array("content_user_id"=>$user_id));
				
				//Delete any comment/review/rate for this user
				$this->Common_model->data_remove("comment_table",array("comment_user_id"=>$user_id));
				
				//Delete any bookmark for this user
				$this->Common_model->data_remove("bookmark_table",array("bookmark_user_id"=>$user_id));
				
				//Delete any activity for this user
				$this->Common_model->data_remove("activity_table",array("activity_user_id"=>$user_id));
				
				//Delete any update coin for this user
				$this->Common_model->data_remove("update_coin_table",array("update_coin_user_id"=>$user_id));

                //Delete any withdrawal coin request
                $this->Common_model->data_remove("withdrawal_table",array("withdrawal_user_id"=>$user_id));

				//Delete user_table
                $result = $this->Common_model->data_remove("user_table",array("user_id"=>$user_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/User/users_list');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/User/users_list');
                }
            }


        }
    }


    //============================ Users Role
    public function users_role()
    {
        if(isset($_POST['user_role_title']))
        {
            $this->form_validation->set_rules('user_type_id', $this->lang->line("Account Type"), 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")));
            $this->form_validation->set_rules('user_role_title', $this->lang->line("Role Title"), 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")));
            $this->form_validation->set_rules('user_role_price', $this->lang->line("Price"), 'trim|required|xss_clean|numeric',
                array(
                    'required'      => $this->lang->line("field_is_required")
                ));
            $this->form_validation->set_rules('user_role_status', $this->lang->line("Status"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/User/users_role');

            } else {
                if ($this->input->post('user_role_status') == 'on') $user_role_status = 1;
                else $user_role_status = 2;

                $dataArray = array(
                    "user_type_id" => $this->input->post('user_type_id'),
                    "user_role_title" => $this->input->post('user_role_title'),
                    "user_role_price" => $this->input->post('user_role_price'),
                    "user_role_status" => $user_role_status,
                );
                //Insert $dataArray to DB
                $result = $this->Common_model->data_insert("user_role_table",$dataArray);
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data added successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/User/users_role');

                } else {
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/User/users_role');
                }
            }

        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["userType"] = $this->User_model->get_user_type('user_type_table')->result();
        $data["userRole"] = $this->User_model->get_user_role('user_role_table',null)->result();
        $this->load->model("dashboard/Settings_model");
        $data["currencyContent"] = $this->Settings_model->get_currency_content('currency_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("Add New Role");
        $this->load->view('dashboard/user/users_role_view', $data);
    }


    //============================ Delete role
    public function delete_role(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['user_role_id'])) {
            $this->form_validation->set_rules('user_role_id', 'User Role ID', 'trim|required|xss_clean',
                array(
                    'required' => $this->lang->line("field_is_required")));

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/User/users_role');

            } else {
                $user_role_id = $this->input->post('user_role_id');
                if($user_role_id <= 7) //Prevent to delete role 1, 2, 3, 4, 5, 6, 7
                {
                    $msg = $this->lang->line("You can not delete this item.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/User/users_role');
                    $this->db->close();
                    die();
                }

                //Prevent to delete if any data exist in it
                $check_exist = $this->User_model->check_user_exist_in_role('user_table', $user_role_id);
                if ($check_exist == TRUE) {
                    $msg = $this->lang->line("There are data exist in this item and you can not delete it.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','danger');
                    redirect(base_url().'dashboard/User/users_role');
                    $this->db->close();
                    die();
                }

                $result = $this->Common_model->data_remove("user_role_table",array("user_role_id"=>$user_role_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/User/users_role');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/User/users_role');
                }
            }


        }


    }


    //============================ Edit Role
    public function edit_role()
    {
        if(isset($_POST['user_role_title']))
        {
            $this->form_validation->set_rules('user_type_id', $this->lang->line("Account Type"), 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")));
            $this->form_validation->set_rules('user_role_title', $this->lang->line("Role Title"), 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")));
            $this->form_validation->set_rules('user_role_price', $this->lang->line("Price"), 'trim|xss_clean|numeric',
                array(
                    'required'      => $this->lang->line("field_is_required")
                ));
            $this->form_validation->set_rules('user_role_permission', $this->lang->line("Permission"), 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")
                ));
            $this->form_validation->set_rules('user_role_id', $this->lang->line("User Role"), 'trim|required|xss_clean',
                array(
                    'required'      => $this->lang->line("field_is_required")
                ));
            $this->form_validation->set_rules('user_role_status', $this->lang->line("Status"), 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/User/users_role');

            } else {
                if ($this->input->post('user_role_status') == 'on') $user_role_status = 1;
                else $user_role_status = 2;

                $dataArray = array(
                    "user_type_id" => $this->input->post('user_type_id'),
                    "user_role_title" => $this->input->post('user_role_title'),
                    "user_role_price" => $this->Shared_model->number2english($this->input->post('user_role_price')),
                    "user_role_permission" => $this->input->post('user_role_permission'),
                    "user_role_status" => $user_role_status,
                );
                //Update $dataArray to DB
                $result = $this->Common_model->data_update("user_role_table",$dataArray,array("user_role_id"=>$this->input->post('user_role_id')));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data edited successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/User/users_role');

                }else {
                    redirect(base_url().'dashboard/User/users_role');
                }
            }

        }

        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["userType"] = $this->User_model->get_user_type('user_type_table')->result();
        $data["userRole"] = $this->User_model->get_user_role('user_role_table', null)->result();
        $user_role_id = $this->uri->segment(4);
        @$data["userRoleContent"] = $this->User_model->get_user_role_content('user_role_table', $user_role_id)->result()[0];
        $this->load->model("dashboard/Settings_model");
        $data["currencyContent"] = $this->Settings_model->get_currency_content('currency_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("Edit Role");
        $this->load->view('dashboard/user/edit_role_view', $data);
    }


    //============================ Users activity
    public function users_activity()
    {
        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["usersActivity"] = $this->User_model->get_all_activity('activity_table', 500)->result();
        $data["pageTitle"] = $this->lang->line("Activity");
        $this->load->view('dashboard/user/users_activity_view', $data);
    }


    //============================ Transactions
    public function transactions()
    {
        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $this->load->model("dashboard/Settings_model");
        $data["currencyContent"] = $this->Settings_model->get_currency_content('currency_table', 1)->result()[0];
        $data["pageTitle"] = $this->lang->line("Transactions");
        //Check Staff or User
        if($_SESSION['user_type'] == 1)
        {
            $data["transactionsList"] = $this->User_model->get_transactions('transaction_table', 'staff')->result();
            $this->load->view('dashboard/user/transactions_list_view', $data);

        }else{
            $data["transactionsList"] = $this->User_model->get_transactions('transaction_table', $_SESSION['user_id'])->result();
            $this->load->view('dashboard/user/transactions_list_user_view', $data);
        }
    }


    //============================ Show transaction
    public function show_transaction()
    {
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $this->load->model("dashboard/Settings_model");
        $data["currencyContent"] = $this->Settings_model->get_currency_content('currency_table', 1)->result()[0];
        $transaction_id = $this->uri->segment(4);
        @$data["transactionContent"] = $this->User_model->get_transaction_content('transaction_table', $transaction_id)->result()[0];
        $data["pageTitle"] = $this->lang->line("Show Transaction Details");
        $this->load->view('dashboard/user/show_transaction_view', $data);
    }


    //============================ Approved comments
    public function comments_list()
    {
        $keyword = $comment_status = "";
        if(isset($_GET['keyword'])) $keyword = $_GET['keyword'];
        if(isset($_GET['comment_status'])) $comment_status = $_GET['comment_status'];

        //Start Pagination
        //Load For Pagination
        //$this->load->helper("url");
        $this->load->library("pagination");

        $config = array();
        $config['base_url'] = base_url() . "dashboard/User/comments_list/";
        $config['total_rows'] = $this->User_model->get_total_comments_count('comment_table', $keyword, $comment_status);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 3;
        $config['display_pages'] = TRUE;

        $config['full_tag_open'] = '<div style="text-align: center"><ul class="pagination pagination no-margin">';
        $config['full_tag_close'] = '</ul></div>';

        //$config['prev_link'] = '<i class="material-icons">chevron_left</i>';
        $config['prev_link'] = '';
        /*$config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';*/

        //$config['next_link'] = '<i class="material-icons">chevron_right</i>';
        $config['next_link'] = '';
        /*$config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';*/

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_link'] = '<i class="material-icons">first_page</i>';
        //$config['first_link'] = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        //$config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '<i class="material-icons">last_page</i>';
        //$config['last_link'] = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        //$config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        //To pass GET parametrs (keywords)
        if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

        //$config["num_links"] = round( $config["total_rows"] / $config["per_page"] );

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["Links"] = $this->pagination->create_links();
        // .End Pagination

        //Check permission from user_role_id
        $data["allowAccess"] =$this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $data["commentList"] = $this->User_model->get_comments('comment_table', $keyword, $comment_status, $config["per_page"], $page)->result();
        $data["pageTitle"] = $this->lang->line("Users Comments");
        $this->load->view('dashboard/user/comments_list_view', $data);
    }


    //============================ Show one comment
    public function show_comment()
    {
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        $comment_id = $this->uri->segment(4);
        @$data["oneComment"] = $this->User_model->get_one_comment('comment_table', $comment_id);
        $data["pageTitle"] = $this->lang->line("Show Comment");
        $this->load->view('dashboard/user/show_comment_view', $data);
    }


    //============================ Edit comment status
    public function edit_comment_status($comment_id, $comment_status)
    {
        $dataArray = array(
            "comment_status" => $comment_status,
        );
        //Update $dataArray to DB
        $result = $this->Common_model->data_update("comment_table", $dataArray, array("comment_id" => $comment_id));
        if ($result == TRUE) {
            $msg = $this->lang->line("Data edited successfully.");
            $this->session->set_flashdata('msg', $msg);
            $this->session->set_flashdata('msgType', 'success');
            redirect(base_url() . 'dashboard/User/comments_list/?comment_status=0');

        } else {
            redirect(base_url() . 'dashboard/User/comments_list/?comment_status=0');
        }
    }


    //============================ Delete comment
    public function delete_comment(){
        //Check permission from user_role_id
        $data["allowAccess"] = $this->Shared_model->check_permission('user_role_table', $_SESSION['user_role_id'], $this->uri->segment(3));
        if(isset($_POST['comment_id'])) {
            $this->form_validation->set_rules('comment_id', 'comment_id', 'trim|required|xss_clean',
                array(
                    'required' => $this->lang->line("field_is_required")));

            if ($this->form_validation->run() == FALSE) {
                //error
                $msg = $this->lang->line("Error!");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/User/comments_list/?comment_status=2');

            } else {
                $comment_id = $this->input->post('comment_id');

                $result = $this->Common_model->data_remove("comment_table",array("comment_id"=>$comment_id));
                if ($result == TRUE) {
                    $msg = $this->lang->line("Data deleted successfully.");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','success');
                    redirect(base_url().'dashboard/User/comments_list/?comment_status=2');

                }else{
                    $msg = $this->lang->line("something_wrong");
                    $this->session->set_flashdata('msg',$msg);
                    $this->session->set_flashdata('msgType','warning');
                    redirect(base_url().'dashboard/User/comments_list/?comment_status=2');
                }
            }


        }


    }


}
