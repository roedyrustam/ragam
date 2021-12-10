<?php
class User_model extends CI_Model {

    //============================ Main construct
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }


    //============================ Check if username exist or not
    function check_username($table, $user_username){
        $q = $this->db->get_where($table, array('user_username' => $user_username));
        if ($q->num_rows() > 0)
            return FALSE;
        return TRUE;
    }


    //============================ Check if email exist or not
    function check_email($table, $user_email){
        $q = $this->db->get_where($table, array('user_email' => $user_email));
        if ($q->num_rows() > 0)
            return FALSE;
        return TRUE;
    }


    //============================ Check any users exist in the role table
    function check_user_exist_in_role($table, $user_role_id){
        $q = $this->db->get_where($table, array('user_role_id' => $user_role_id));
        if ($q->num_rows() > 0)
            return TRUE;
        return FALSE;
    }
	
	
	//============================ Check if any content exist in user
    function check_content_exist($table, $user_id){
        $q = $this->db->get_where($table, array('content_user_id' => $user_id));
        if ($q->num_rows() > 0)
            return TRUE;
        return FALSE;
    }


    //============================ Check if email exist or not
    function check_mobile($table, $user_mobile){
        $q = $this->db->get_where($table, array('user_mobile' => $user_mobile));
        if ($q->num_rows() > 0)
            return FALSE;
        return TRUE;
    }


    //============================ Check if referral ID exist or not
    function check_referral($table, $user_referral){
        $q = $this->db->get_where($table, array('user_id' => $user_referral));
        if ($q->num_rows() > 0)
            return TRUE;
        return FALSE;
    }


    //============================ Authentication user login with user_username OR user_email
    function auth_user_information($table, $user_username, $user_password){
        //Login with Username
        $query = $this->db->get_where($table, array('user_username'=>$user_username, 'user_password'=>$user_password));
        if ($query->num_rows() > 0)
            return true;

        else { //Login with Email
            $query = $this->db->get_where($table, array('user_email'=>$user_username, 'user_password'=>$user_password));
            if ($query->num_rows() > 0)
                return true;
            else
                return false;
        }
    }


    //============================ Authentication user login
    function compare_old_new_password($table, $user_id, $old_password){
        $query = $this->db->get_where($table, array('user_id'=>$user_id, 'user_password'=>$old_password));
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }


    //============================ Read user information with user_username OR user_email
    function read_user_information($table, $user_username){
        $query = $this->db->get_where($table, array('user_username'=>$user_username));
        if ($query->num_rows() > 0)
            return $query->result();

        else {
            $query = $this->db->get_where($table, array('user_email'=>$user_username));
            if ($query->num_rows() > 0)
                return $query->result();
            else
                return false;
        }

    }
	
	
	//============================ User role
    function get_users_list2($table){
        $q = $this->db->query("Select $table.*, user_type_table.user_type_title, user_role_table.user_role_title, device_type_table.device_type_title
								FROM $table
								INNER JOIN user_type_table
								ON user_table.user_type = user_type_table.user_type_id 
								INNER JOIN user_role_table
								ON user_table.user_role_id = user_role_table.user_role_id
								INNER JOIN device_type_table
								ON user_table.user_device_type_id = device_type_table.device_type_id
								ORDER BY user_id desc");
        return $q;
    }


    //============================ Reset password
    public function reset_password_process($user_email, $new_user_password)
    {
        $data = array(
            'user_password' => $new_user_password
        );
        $this->db->where('user_email', $user_email);
        if ($this->db->update('user_table', $data))
            return TRUE;
        else
            return FALSE;
    }


    //============================ Get user information with user_id
    function get_user_content($table, $user_id){
        $query = $this->db->query("Select $table.*, user_type_table.user_type_title, user_role_table.user_role_title, device_type_table.device_type_title
								FROM $table
								INNER JOIN user_type_table
								ON $table.user_type = user_type_table.user_type_id 
								INNER JOIN user_role_table
								ON $table.user_role_id = user_role_table.user_role_id 
								INNER JOIN device_type_table
								ON $table.user_device_type_id = device_type_table.device_type_id 
								WHERE user_id = $user_id;");
        if ($query->num_rows() > 0)
            return $query;

        else{
            //Clear session
            unset(
                $_SESSION['user_id'],
                $_SESSION['user_username'],
                $_SESSION['user_email'],
                $_SESSION['user_mobile'],
                $_SESSION['user_role_id'],
                $_SESSION['user_type']
            );

            $msg = $this->lang->line("Successfully Logout!");
            $this->session->set_flashdata('msg',$msg);
            $this->session->set_flashdata('msgType','success');
            redirect(base_url().'dashboard/Auth');
            $this->db->close();
            die();
        }
    }



	//============================ Get reward coin settings
	function get_reward_coin_content($table, $reward_coin_id){
		$q = $this->db->query("Select *
							   FROM $table
							   WHERE (reward_coin_id = '$reward_coin_id');");
		return $q;
	}


	//===============================================================//
	function get_withdrawal_account_type($table){
		$q = $this->db->query("Select *
							   FROM $table
							   WHERE (withdrawal_account_type_status = '1');");
		return $q;
	}




    //============================ Get user image with user_id
    function get_user_image($table, $user_id){
        $this->db->select('user_image');
        $query = $this->db->get_where($table, array('user_id'=>$user_id));
            return $query->result()[0];
    }


    //============================ Get user activity with user_id
    function get_user_activity($table, $user_id, $limit){
        $this->db->order_by('activity_id DESC');
        $query = $this->db->get_where($table, array('activity_user_id' => $user_id), $limit);
        return $query;
    }


    //============================ Total user referral
    function total_user_referral($table, $user_id){
        $this->db->select($user_id);
        $this->db->where('user_referral', $user_id);
        $q = $this->db->get($table);
        return $q->num_rows();
    }


    //============================ Total user games
    function total_user_games($table, $user_id){
        $this->db->select($user_id);
        $this->db->where('content_user_id', $user_id);
        $q = $this->db->get($table);
        return $q->num_rows();
    }


    //============================ User type (Account type)
    function get_user_type($table){
        $this->db->order_by('user_type_id ASC');
        return $q = $this->db->get($table);
    }


    //============================ User role
    function get_user_role($table, $user_type_id){
        if(isset($user_type_id))
            $where = "WHERE $table.user_type_id = '$user_type_id'";
        else
            $where = "";
        $q = $this->db->query("Select $table.*, user_type_table.*
								FROM user_role_table
								INNER JOIN user_type_table
								ON user_role_table.user_type_id = user_type_table.user_type_id 
								$where
								ORDER BY user_role_id ASC;");
        return $q;
    }


    //============================ User role for upgrade account
    function get_user_role_for_upgrade($table){
        $current_user_role_id = $_SESSION['user_role_id'];
        $q = $this->db->query("Select $table.*
								FROM $table
								WHERE (user_type_id = 2) AND (user_role_id != 5) AND (user_role_id != $current_user_role_id)
								ORDER BY user_role_id ASC;");
        return $q;
    }


    //============================ Get role from type
    public function get_role_from_type($user_type_id)
    {
        $this->db->where('user_type_id', $user_type_id);
        $this->db->order_by('user_type_id', 'ASC');
        $query = $this->db->get('user_role_table');
        $select = $this->lang->line("--- Please Select ---");
        $output = '<option disabled>'.$select.'</option>';
        foreach($query->result() as $row)
        {
            $output .= '<option value="'.$row->user_role_id.'">'.$row->user_role_title.'</option>';
        }
        return $output;
    }


    //============================ Get user information with user_id
    function get_user_role_content($table, $user_role_id){
        $query = $this->db->query("Select $table.*
								FROM $table
								WHERE user_role_id = $user_role_id;");
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Ajax all users count
    function all_users_count()
    {
        $query = $this->db->get('user_table');
        return $query->num_rows();
    }


    //============================ Ajax all users list
    function all_users($limit,$start,$col,$dir)
    {
        $query = $this->db->query("Select user_table.*, user_type_table.user_type_title, user_role_table.user_role_title, device_type_table.device_type_title
								FROM user_table
								INNER JOIN user_type_table
								ON user_table.user_type = user_type_table.user_type_id 
								INNER JOIN user_role_table
								ON user_table.user_role_id = user_role_table.user_role_id
								INNER JOIN device_type_table
								ON user_table.user_device_type_id = device_type_table.device_type_id
								ORDER BY $col $dir 
								LIMIT $start, $limit;");
        //$query = $this->db->limit($limit,$start)->order_by($col,$dir)->get('user_table');
        if($query->num_rows()>0)
            return $query->result();
        else
            return null;
    }


    //============================ Ajax users search
    function users_search($limit,$start,$search,$col,$dir)
    {
        /*$query = $this
            ->db
            ->like('user_username',$search)
            ->or_like('user_firstname',$search)
            ->or_like('user_lastname',$search)
            ->or_like('user_email',$search)
            ->limit($limit,$start)
            ->order_by($col,$dir)
            ->get('user_table');*/

        $query = $this->db->query("Select user_table.*, user_type_table.user_type_title, user_role_table.user_role_title, device_type_table.device_type_title
								FROM user_table
								INNER JOIN user_type_table
								ON user_table.user_type = user_type_table.user_type_id 
								INNER JOIN user_role_table
								ON user_table.user_role_id = user_role_table.user_role_id
								INNER JOIN device_type_table
								ON user_table.user_device_type_id = device_type_table.device_type_id
								WHERE ((user_username LIKE '%$search%') OR (user_firstname LIKE '%$search%') OR (user_lastname LIKE '%$search%') OR (user_email LIKE '%$search%')
								OR (user_type_title LIKE '%$search%') OR (user_role_title LIKE '%$search%') OR (device_type_title LIKE '%$search%')) 
								ORDER BY $col $dir 
								LIMIT $start, $limit;");

        if($query->num_rows()>0)
            return $query->result();
        else
            return null;
    }


    //============================ Ajax users count
    function users_search_count($search)
    {
        $query = $this
            ->db
            ->like('user_username',$search)
            ->or_like('user_firstname',$search)
            ->or_like('user_lastname',$search)
            ->or_like('user_email',$search)
            ->get('user_table');

        return $query->num_rows();
    }


    //============================ Users activity
    function get_all_activity($table, $limit){
        $q = $this->db->query("Select $table.*, user_table.user_username, user_table.user_id
								FROM $table
								INNER JOIN user_table
								ON $table.activity_user_id = user_table.user_id 
								ORDER BY activity_id DESC
								LIMIT $limit;");
        return $q;
    }


    //============================ Get transactions list
    function get_transactions($table, $user_id)
    {
        //Check Staff or User
        if($user_id == 'staff')
        {
            $q = $this->db->query("Select $table.*, gateway_table.gateway_name, user_table.user_id, user_table.user_firstname, user_table.user_lastname
								FROM $table
								INNER JOIN gateway_table
                                ON $table.transaction_gateway = gateway_table.gateway_id
                                INNER JOIN user_table
                                ON $table.transaction_user_id = user_table.user_id
								ORDER BY transaction_id DESC;");
        }else{
            $q = $this->db->query("Select $table.*, gateway_table.gateway_name, user_table.user_id, user_table.user_firstname, user_table.user_lastname
								FROM $table
								INNER JOIN gateway_table
                                ON $table.transaction_gateway = gateway_table.gateway_id
                                INNER JOIN user_table
                                ON $table.transaction_user_id = user_table.user_id
                                WHERE transaction_user_id = $user_id
								ORDER BY transaction_id DESC;");
        }

        return $q;
    }


    //============================ Get transaction content with transaction_id
    function get_transaction_content($table, $transaction_id)
    {
        $query = $this->db->query("Select $table.*, user_table.user_firstname, user_table.user_lastname, user_table.user_id, gateway_table.gateway_name
								FROM $table
								INNER JOIN user_table
								ON $table.transaction_user_id = user_table.user_id 
								INNER JOIN gateway_table
								ON $table.transaction_gateway = gateway_table.gateway_id 
								WHERE transaction_id = $transaction_id;");
        if ($query->num_rows() > 0)
            return $query;
        else
            return false;
    }


    //============================ Get user credit
    function get_user_credit($table, $user_id){
        $query = $this->db->query("Select $table.user_credit
								FROM $table
								WHERE user_id = $user_id;");
        return $query;

    }


    //============================ Update user credit
    function update_user_credit($table, $amount, $user_id, $type){
        /*
         * Type +: Add Funds
         * Type -: Decrease Funds
         */
        if($type == "+") {
            $this->db->query("UPDATE $table SET user_credit = user_credit + $amount WHERE user_id = '$user_id'");

        }elseif($type == "-") {
            $this->db->query("UPDATE $table SET user_credit = user_credit - $amount WHERE user_id = '$user_id'");
        }
    }


    //============================ Comments count
    public function get_total_comments_count($table, $keyword, $comment_status) {

        $where = "WHERE comment_status = '$comment_status'";
        if($keyword != "")
            $where = "WHERE comment_text LIKE '%$keyword%'";

        $q = $this->db->query("Select $table.*
								FROM $table
								$where
								;");
        return $q->num_rows();
    }


    //============================ Comments List
    function get_comments($table, $keyword, $comment_status, $limit, $start)
    {
        $where = "WHERE comment_status = '$comment_status'";
        if($keyword != "")
            $where = "WHERE comment_text LIKE '%$keyword%'";

        $q = $this->db->query("Select $table.*, user_table.user_username, user_table.user_id, device_type_table.device_type_title, content_table.content_title, content_table.content_id
								FROM $table
								INNER JOIN user_table
								ON $table.comment_user_id = user_table.user_id 
								INNER JOIN device_type_table
								ON $table.comment_device_type_id = device_type_table.device_type_id 
								INNER JOIN content_table
								ON $table.comment_content_id = content_table.content_id 
								$where
								ORDER BY comment_id DESC
								LIMIT $limit OFFSET $start;");
        return $q;
    }


    //============================ Get one comment
    function get_one_comment($table, $comment_id)
    {
        $q = $this->db->query("Select $table.*, user_table.user_username, user_table.user_id, device_type_table.device_type_title, content_table.content_title, content_table.content_id
                            FROM $table
                            INNER JOIN user_table
                            ON $table.comment_user_id = user_table.user_id 
                            INNER JOIN device_type_table
                            ON $table.comment_device_type_id = device_type_table.device_type_id 
                            INNER JOIN content_table
                            ON $table.comment_content_id = content_table.content_id 
                            WHERE comment_id = '$comment_id'
                            ;");
        if($q->num_rows() > 0)
            return $q->result()[0];
        else
            redirect(base_url()."dashboard/User/comments_list");
    }
}
