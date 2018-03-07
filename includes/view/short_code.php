<?php

if (!defined('ABSPATH')) exit;
// Exit if accessed directly.

class IPE_Short_Codes
{

    public static function init()
    {
        // Formulário Inserir Post
        add_shortcode('insert_post', array(__CLASS__, 'form_insert_post'));
    }

    public static function form_insert_post()
    {
        include_once('forms/form_insert_post.php');
    }

}

IPE_Short_Codes::init();