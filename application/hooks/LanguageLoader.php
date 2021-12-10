<?php
class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');

        $site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) {
            //$ci->lang->load('dashboard',$ci->session->userdata('site_lang'));
            $ci->lang->load(array('dashboard', 'date', 'form_validation'), $ci->session->userdata('site_lang'));
            $ci->lang->load(array('frontend', 'date', 'form_validation'), $ci->session->userdata('site_lang'));
            //Set language in Config file
            $ci->config->set_item('language',$ci->session->userdata('site_lang'));

        } else {
            //$ci->lang->load('dashboard','persian');
            $ci->lang->load(array('dashboard', 'date', 'form_validation'), 'english');
            $ci->lang->load(array('frontend', 'date', 'form_validation'), 'english');
            //Set language in Config file
            $ci->config->set_item('language','english');
        }
    }
}
