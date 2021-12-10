<?php
class Shared_model extends CI_Model {

    //============================ Main construct
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
	}


    //============================ Check user is login or not
    private function is_login() {
        if (!isset($_SESSION['user_username']) && !isset($_SESSION['user_type']))
        {
            redirect(base_url()."dashboard/Auth");
            die();
        }
    }


    //============================ Send Email
	public function send_email($to, $cc, $subject, $message)
	{
	    //https://www.codeigniter.com/user_guide/libraries/email.html
	    //Send Email Guide
        /* $this->load->model("Shared_model");
          $to = $user_email;
        $cc = false;  //To send a copy of email
        $subject = $email_subject;
        $message = $email_body;
        $this->Shared_model->send_email($to, $cc, $subject, $message);*/

		//Connect to email setting table
		$q = $this->db->get_where('email_setting_table', array('email_setting_id'=> 1));
		$from = $q->row()->email_setting_fromemail;

		//Logo
        $qLogo = $this->db->get_where('setting_table', array('setting_id'=> 1));
        $setting_logo = $qLogo->row()->setting_logo;
        $setting_logo = base_url()."assets/upload/$setting_logo";

		//Check if send email is enable or not
		if ($q->result()[0]->email_setting_status == 1)
		{
			//Email content
            $direction = $this->lang->line("app_direction");
            $htmlMSG = "<div style='margin:15px 23px 0px 23px; padding:1px 8px 1px 8px;'><img style='-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;' width='120px' height='auto' src='$setting_logo'></div>";
            $htmlMSG.= "<div style='margin:2px 30px 15px 30px; padding:1px 8px 1px 8px; line-height: 23px; border:1px solid #CCCCCC; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; background-color:#F9F9F9; direction: $direction; font-family:Tahoma, Helvetica, sans-serif; font-size:13.5px; box-shadow: 0px 0px 5px #E9E9E9'>";
			$htmlMSG.= "<p><b>".$subject."</b></p>";
			$htmlMSG.= "<p style='padding-bottom: 7px;'>".$message."</p>";
			$htmlMSG.= "<p style='padding-top: 10px; border-top:1px solid #D4D4D4'>".html_entity_decode($q->row()->email_setting_signature)."</p></div>";
			
			if($q->row()->email_setting_mailtype == "smtp")
			{
				// ----------- SMTP Email ------------
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = $q->row()->email_setting_smtphost;
				$config['smtp_port'] = $q->row()->email_setting_smtpport;
				$config['smtp_user'] = $q->row()->email_setting_smtpuser;
				$config['smtp_pass'] = $this->encrypt->decode($q->row()->email_setting_smtppass);
				if ($q->result()[0]->email_setting_crypto != "none") { $config['smtp_crypto'] = $q->result()[0]>email_setting_crypto; }
				$config['mailtype'] = 'html';
				$config['charset'] = 'utf-8';

                $this->load->library('email');
				$this->email->initialize($config);
				
				$this->email->set_newline("\r\n");
				$this->email->from($from, $q->row()->email_setting_fromname);
				$this->email->to($to);
				if ($q->row()->email_setting_cc == true) { $this->email->cc($q->result()[0]->email_setting_cc); }
				$this->email->subject($subject);
				$this->email->message($htmlMSG);
				$result = $this->email->send();
				if($result){
					//echo "SMTP Mail sent successfully...";
				}
				else{
					//echo "SMTP Error in mail sending...";
				}
				
			}
			// ---------- PHP Mail -----------
			elseif ($q->result()[0]->email_setting_mailtype == "mail" or $q->result()[0]->email_setting_mailtype == "sendmail"){
				
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: <$from>" . "\r\n";
				if(@mail($to,$subject,$htmlMSG,$headers))
				{
					//echo "PHP mail sending...";
				}else{
					//echo "PHP mail error in mail sending...";
				}
				
			}
			
		} //.end of if send email is enable
	}

    
    //============================ Generate CAPTCHA
    public function generate_captcha() {
        $this->load->helper('captcha');
        //Generate CAPTCHA
        $vals = array(
            'word' => rand(10000,99999),
            'word_length' => 5,  // To set length of captcha word.
            'img_path'      => './assets/captcha/',
            'img_url'       => base_url().'assets/captcha/',
            'img_width'     => 120,
            'img_height'    => 36,
            'expiration'    => 900,
            'font_size'     => 21,

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(50, 50, 50),
                'grid' => array(160, 160, 160)
            )
        );
        $cap = create_captcha($vals);
        //Insert CAPTCHA word into the DB
        $dataArray = array(
            'captcha_time'  => $cap['time'],
            'captcha_ip_address'    => $this->input->ip_address(),
            'captcha_word'          => $cap['word']
        );
        $this->Common_model->data_insert("captcha_table", $dataArray);

        return $cap['image'];
    }


    //============================ English Number 2 Arabic
    function number2farsi($srting)
    {
        $en_num = array('0','1','2','3','4','5','6','7','8','9');
        $fa_num = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        return str_replace($en_num, $fa_num, $srting);
    }


    //============================ Arabic Number 2 English
    function number2english($srting)
    {
        $fa_num = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        $en_num = array('0','1','2','3','4','5','6','7','8','9');
        return str_replace($fa_num, $en_num, $srting);
    }


    //============================ Check user permission
    public function check_permission($table, $user_role_id, $last_segment)
    {
        $this->is_login();
        if($_SESSION['user_role_id'] != 1)
        {
            $q = $this->db->query("SELECT user_role_permission
                               FROM $table
                               WHERE (user_role_id = $user_role_id);");
            $user_role_permission = $q->row()->user_role_permission;

            $user_permission = (explode(' ',$user_role_permission));
            $allow_access = array_search($last_segment, $user_permission);
            if (empty($allow_access))
            {
                //Deny Access
                $msg = $this->lang->line("You have no permission to access this page.");
                $this->session->set_flashdata('msg',$msg);
                $this->session->set_flashdata('msgType','danger');
                redirect(base_url().'dashboard/Dashboard/message');
                $this->db->close();
                die();
            }else
                return "Allow";
        }
    }


//============================ URL Slug
	public function url_slug($str, $options = array()) {
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => false,
		);

		// Merge options
		$options = array_merge($defaults, $options);

		$char_map = array(
			// Latin
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
			'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
			'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
			'ß' => 'ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
			'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
			'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
			'ÿ' => 'y',

			// Latin symbols
			'©' => '(c)',

			// Greek
			'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
			'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
			'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
			'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
			'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
			'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

			// Turkish
			'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

			// Russian
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
			'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
			'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
			'я' => 'ya',

			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

			// Czech
			'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
			'Ž' => 'Z',
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			'ž' => 'z',

			// Polish
			'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
			'Ż' => 'Z',
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			'ż' => 'z',

			// Latvian
			'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
			'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			'š' => 's', 'ū' => 'u', 'ž' => 'z',

			// Other
			'ی' => 'ي'
		);

		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

		// Transliterate characters to ASCII
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}

		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

		// Truncate slug to max. characters
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);

		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}
	
	
	//============================ Send push notification via OneSignal
    function send_push_notification_one_signal($push_notification_title, $push_notification_message, $push_notification_image, $push_notification_external_link)
    {
        //Connect to setting table
        $q = $this->db->get_where('setting_table', array('setting_id'=> 1));
        $setting_one_signal_app_id = $this->encrypt->decode($q->result()[0]->setting_one_signal_app_id);
        $setting_one_signal_rest_api_key = $this->encrypt->decode($q->result()[0]->setting_one_signal_rest_api_key);
        define("ONESIGNAL_APP_ID", $setting_one_signal_app_id);
        define("ONESIGNAL_REST_KEY", $setting_one_signal_rest_api_key);

        if($push_notification_external_link != "") $external_link =  $push_notification_external_link;
        else $external_link = false;

		$push_notification_image_url = "";
		if($push_notification_image != "") $push_notification_image_url = base_url()."assets/upload/notification/$push_notification_image";

        $content      = array(
            "en" => $push_notification_message
        );

		if($external_link == false)
		{
			if($push_notification_image != "")
			{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content,
					"big_picture" => $push_notification_image_url
				);

			}else{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content
				);
			}


		}else{
			if($push_notification_image != "")
			{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'url' => $external_link,
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content,
					"big_picture" => $push_notification_image_url
				);

			}else{
				$fields = array(
					'app_id' => ONESIGNAL_APP_ID,
					'included_segments' => array('All'),
					'data' => array("foo" => "bar"),
					'url' => $external_link,
					'headings'=> array("en" => $push_notification_title),
					'contents' => $content
				);
			}
		}


        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.ONESIGNAL_REST_KEY
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }


    //============================ Send push notification via OneSignal
    function send_push_notification_one_signal_specific_user($push_notification_title, $push_notification_message, $push_notification_external_link, $push_notification_player_id)
    {
        //Connect to setting table
        $q = $this->db->get_where('setting_table', array('setting_id'=> 1));
        $setting_one_signal_app_id = $this->encrypt->decode($q->result()[0]->setting_one_signal_app_id);
        $setting_one_signal_rest_api_key = $this->encrypt->decode($q->result()[0]->setting_one_signal_rest_api_key);
        define("ONESIGNAL_APP_ID", $setting_one_signal_app_id);
        define("ONESIGNAL_REST_KEY", $setting_one_signal_rest_api_key);

        if($push_notification_external_link != "") $external_link =  $push_notification_external_link;
        else $external_link = false;

        $content      = array(
            "en" => $push_notification_message
        );


        if($external_link == false)
        {
            $fields = array(
                'app_id' => ONESIGNAL_APP_ID,
                'include_player_ids' => $push_notification_player_id,
                'data' => array("foo" => "bar"),
                //'url' => $external_link,
                'headings'=> array("en" => $push_notification_title),
                'contents' => $content
            );

        }else{
            $fields = array(
                'app_id' => ONESIGNAL_APP_ID,
                'include_player_ids' => $push_notification_player_id,
                'data' => array("foo" => "bar"),
                'url' => $external_link,
                'headings'=> array("en" => $push_notification_title),
                'contents' => $content
            );
        }


        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.ONESIGNAL_REST_KEY
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
