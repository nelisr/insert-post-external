## Insert Post External
... É um plugin wordpress que possibilida a inserção de um post type através de um formulário no front-end do site.

## Instalação
... Baixa o plugin e adiciona na pasta de plugins no wordpress 'wp-content/plugins' e ir na administração 'meusite.com.br/wp-admin/plugins.php' e ativar o plugin.

## Como usar?
... Após fazer a instalação do plugin você pode está customizando o formulário com os campos referentes ao post type. Após isso é so chamar o shortcode [insert_post] na página que deseja exibir o formulário. 

## Onde customizar o formulário com a minha realidade?
... Basta acessar na pasta do plugin e ir em 'includes/view/forms/form_insert_post.php'.

## Como customizar a função que insere dados do formulário no post type?
... Basta acessar a pasta do plugin e ir em 'includes/model/class_insert_post.php' e modificar  a função 'insert_post()' de acordo com a sua realidade.

## Como é feito a inserção?
... Logo abaixo eu mostro o código que irá inserir os dados no post type desejado.

´´´php
    
	$args = array(
    	'post_author' => 1, // aqui é o ID do usuário que estaca cadastrando o posttype
        'post_title' => 'Título do post type', // esse valor pode vim do formulário
        'post_content' => 'Descricao do post type', // esse valor pode vim do formulário
        'post_type' => 'associado', // Aqui é o nome do post type que deseja inserir as informações que vem do formulário
        'post_status' => 'draft'  // aqui diz que o post type irá ficar como rascunho      
    );

    $associed_id = wp_insert_post($args); // aqui a função do wordpress que inseri os valores no post type
´´´ 

## Observações
... Esse plugin precisa ser ajustado muitas coisas ainda, pois devido a correria ainda não consegui tempo para melhorar, mas quem quiser ajudar a melhorar pode mandar os pull resquest. 