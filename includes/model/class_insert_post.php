<?php

if (!defined('ABSPATH')) exit;

// Exit if accessed directly.

class IPE_Insert_Post
{

    public static function init()
    {
        // Inserir Post
        add_action('wp', array(__CLASS__, 'verify'));
        add_action('mipe-notice', array(__CLASS__, 'notice'));
    }


    // Verifica de qual formulário vem a raquisição
    public static function verify(){
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'insert_post_external') {
            self::insert_post();
        } elseif('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'insert_post_external_2'){
            self::insert_post2();
        }
    }

    // Monta HTML para enviar pro email
    public static  function htmlEmail($data = null, $for ){

        if( $for == 1){

            return $data = "
            <h2>Novo Cadastro de Associado no Site ( Empresa )</h2>
            <hr />
            <h3>$data cadastrou sua empresa pelo formulário no site do Empresa </h3>
            Veja mais detalhes neste <a href='http://empresa.com.br/wp-admin/edit.php?post_type=associado'>link</a>
           
        ";

        }else{
            $html =  "<h4>Novo Cadastro de Associado no Site ( Empresa )</h4><hr />";

            $datas = array($data);

            foreach( $datas as $d ):
               $html .=  '<strong>Razão Social: </strong>'.$d['razao_social'].'<br />';
               $html .=  '<strong>Nome Fantasia: </strong>'.$d['nome_fantasia'].'<br />';
               $html .=  '<strong>Email: </strong>'.$d['email'].'<br />';
               $html .=  '<strong>Ramo de Atividade: </strong>'.$d['ramo_de_atividade'].'<br />';
               $html .=  '<strong>CNPJ: </strong>'.$d['cnpj'].'<br />';
               $html .=  '<strong>Inscrição Social: </strong>'.$d['inscricao_social'].'<br />';
               $html .=  '<strong>Número de Lojas: </strong>'.$d['numero_de_lojas'].'<br />';
               $html .=  '<strong>Endereço: </strong>'.$d['endereco'].'<br />';
               $html .=  '<strong>Número: </strong>'.$d['numero'].'<br />';
               $html .=  '<strong>Bairro: </strong>'.$d['bairro'].'<br />';
               $html .=  '<strong>Cidade: </strong>'.$d['cidade'].'<br />';
               $html .=  '<strong>UF: </strong>'.$d['uf'].'<br />';
               $html .=  '<strong>CEP: </strong>'.$d['cep'].'<br />';
               $html .=  '<strong>Telefone: </strong>'.$d['telefone'].'<br />';
               $html .=  '<strong>Fax: </strong>'.$d['fax'].'<br />';
               $html .=  '<strong>Celular: </strong>'.$d['celular'].'<br />';
               $html .=  '<strong>Whatsapp: </strong>'.$d['whatsapp'].'<br />';
               $html .=  '<strong>Nome: </strong>'.$d['associado'].'<br />';
               $html .=  '<strong>RG: </strong>'.$d['rg'].'<br />';
               $html .=  '<strong>CPF: </strong>'.$d['cpf'].'<br />';
               $html .=  '<strong>Data de Nascomento: </strong>'.$d['data_de_nascimento'].'<br />';
               $html .=  '<strong>Site: </strong>'.$d['site'].'<br />';
            endforeach;

            return $html;
        }

    }

    // Cadastra empresa 
    public static function insert_post()
    {

        global $notice;


            $notice = array();

            // pega as informações vindas do formulário
            $nomeassociado   = esc_attr($_POST['nomeassociado']);
            $empresaassociado  = esc_attr($_POST['empresaassociado']);
            $categoria     =  esc_attr($_POST['categoria']);
            $siteempresa = esc_attr($_POST['siteempresa']);
            $tags = esc_attr($_POST['tags']);
            $email = esc_attr($_POST['email']);
            $descricao = esc_attr($_POST['descricao']);


            // Usar quando tiver imagem no formulário
            if (!empty($_FILES['image_logo']['name'])) {

                $image = $_FILES['image_logo']['name'];
                $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

                if (!empty($_FILES['image_logo']['error'])) :
                    $notice[] = array('alert-danger', 'Error!', ' Erro ao enviar sua logo, por favor tente novamente.');

                elseif ($_FILES['image_logo']['size'] >= 2097152) :
                    $notice[] = array('alert-danger', 'Error!', ' Erro ao enviar sua logo, o tamanho não pode passar de 2M.');

                elseif (strpos('jpg;jpeg;png', $extension) === false) :
                    $notice[] = array('alert-danger', 'Error!', ' Erro ao enviar sua logo, o formato da imagem deve ser JPG, JPEG ou PNG');

                else:

                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    require_once(ABSPATH . 'wp-admin/includes/media.php');

                endif;

            }

            // Mensagens de erro
            if (empty($nomeassociado)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione o nome do associado.');
            if (empty($empresaassociado)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione a empresa do associado.');
            if (empty($categoria)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione categoria.');
            if (empty($siteempresa)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione site da empresa.');
            if (empty($email)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione seu email.');
            if (empty($descricao)) $notice[] = array('alert-danger', 'Error!', ' Por favor adicione seu descrição.');


            // se estiver tudo ok nas validações agora vamos iniciar inserção do post
            if (empty($notice)) {

                $args = array(
                    'post_author' => 1,
                    'post_title' => $empresaassociado,
                    'post_content' => $descricao,
                    'post_type' => 'associado',
                    'post_status' => 'draft'
                );

                
                $associed_id = wp_insert_post($args);

                if (!$associed_id) :

                    $notice[] = array('alert-warning', 'Alerta!', ' Erro ao gravar seus dados. Tente novamente.');

                else :

                    // Taxonomias (Tags)
                    wp_set_object_terms($associed_id, array($tags), 'post_tag', true);

                    // Campos Personalizados
                    $predicted = array(
                       'nome_do_associado' => $nomeassociado,
                       'site'      => $siteempresa,
                       'email'     => $email,
                       'categoria' => $categoria
                    );

                    foreach ($predicted as $key => $value) :
                        update_post_meta($associed_id, $key, $value);
                    endforeach;

                    if(isset($image)){
                        // Pega a imagem e associa a banda e depois inseri
                        $attachment_id = media_handle_upload('image_logo', $associed_id);
                        update_post_meta($associed_id, '_thumbnail_id', $attachment_id);

                        if (!$attachment_id) $notice[] = array('alert-warning', 'Alerta!', ' Erro na geração da logo.');
                    }

                    // quando tudo estiver cadastrado manda email para avisar que mais uma pessoa se cadastrou
                    $headers = array('Content-Type: text/html; charset=UTF-8','From: Empresa <contato@empresa.com.br');

                    wp_mail(
                        'contato@empresa.com.br, destino@empresa.com.br',
                        'Cadastre sua Empresa ( Empresa )',
                        self::htmlEmail($empresaassociado,1),
                        $headers,
                        ''
                    );


                    $notice[] = array('alert-success', 'Obrigado! ', ' O cadastro foi concluído com sucesso. Vamos analisar as informações e em breve disponibilizar a página da sua empresa.');


                endif;

            }


    }

   

    public static function notice()
    {

        global $notice;

        if (is_array($notice) && !empty($notice)) :
            foreach ($notice as $item) : ?>

                <div class="alert <?php echo $item[0] ?>" role="alert">
                    <i class="fa fa-check" aria-hidden="true"></i>
                    <strong><?php echo $item[1] ?></strong><?php echo $item[2] ?>
                </div>

                <?php
            endforeach;
        endif;

    }

}

IPE_Insert_Post::init();