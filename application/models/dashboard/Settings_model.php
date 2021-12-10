<?php
class Settings_model extends CI_Model {

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ Get general setting content
    function get_setting_content($table, $setting_id){
        $query = $this->db->get_where($table, array('setting_id'=>$setting_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get currency content
    function get_currency_content($table, $currency_id){
        $query = $this->db->get_where($table, array('currency_id'=>$currency_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get seo content
    function get_seo_content($table, $seo_id){
        $query = $this->db->get_where($table, array('seo_id'=>$seo_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get admob setting content
    function get_admob_setting_content($table, $admob_setting_id){
        $query = $this->db->get_where($table, array('admob_setting_id'=>$admob_setting_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get reward setting content
    function get_reward_setting_content($table, $reward_coin_id){
        $query = $this->db->get_where($table, array('reward_coin_id'=>$reward_coin_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get email setting content
    function get_email_setting_content($table, $email_setting_id){
        $query = $this->db->get_where($table, array('email_setting_id'=>$email_setting_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get api key content
    function get_api_key_content($table, $api_id){
        $query = $this->db->get_where($table, array('api_id'=>$api_id));
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get PC
    function get_pc($table, $setting_id){
        $query = $this->db->get_where($table, array('setting_id'=>$setting_id));
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return false;
    }


    //============================ Get push notification user list
    function get_push_notification_user_list($table){
        $q = $this->db->query("Select $table.user_username, $table.user_onesignal_player_id
								FROM user_table
								WHERE ($table.user_onesignal_player_id != 'Not set yet.')
								ORDER BY user_username ASC;");
        return $q;
    }
}