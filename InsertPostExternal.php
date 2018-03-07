<?php

/**
 * Plugin Name: Insert Post External
 * Description: Cria conteúdo (post type) partindo de um formulário da site.
 * Version: 1.0
 * Author: Nelis Rodrigues
 * Author URI: https://nelisrodrigues.com.br
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

final class InsertPostExternal
{

    /**
     * Atributo estatico para instanciar a classe.
     */
    private static $_instance = null;

    /**
     * Construtor da classe.
     */
    public function __construct()
    {
        $this->includes();
    }

    /**
     * Instância Principal
     * @static
     * @return Instancia a classe.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) self::$_instance = new self;
    }

    /**
     * Seleciona o tipo de requisição
     * @param $type
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined('DOING_AJAX');
            case 'cron' :
                return defined('DOING_CRON');
            case 'frontend' :
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
        }
    }

    /**
     * Includes dos arquivos
     */
    private function includes()
    {
        if ($this->is_request('frontend')) {

            // inclui os arquivos ( Shortcode que returna o formulário e Classe que faz a inserção do post indo do formulário )
            include_once('includes/model/class_insert_post.php');
            include_once('includes/view/short_code.php');

        }
    }

}

InsertPostExternal::instance();
