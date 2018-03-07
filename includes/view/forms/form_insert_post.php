<?php global $post; ?>

<form name="cadastro-de-associado" action="<?php the_permalink(); ?>"
      method="POST" enctype="multipart/form-data" class="insert_post col-md-12">

    <div class="row">

        <?php do_action('mipe-notice'); ?>

        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label for="nomeassociado">Nome do Associado*</label>
                <input type="text" class="form-control required" required id="nomeassociado"
                        name="nomeassociado" />
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label for="empresaassociado">Empresa do Associado*</label>
                <input type="text" class="form-control required" required id="empresaassociado"
                       name="empresaassociado" />
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label for="categoria">Categoria*</label>
                <!--<select required="required" name="categoria" id="categoria"
                        class="form-control required">
                    <?php
/*
                    $args = array(
                        'taxonomy' => 'categoria',
                        'hide_empty' => 1
                    );

                    $categories = get_terms($args);

                    echo "<option value=''>Categoria</option>";

                    foreach ($categories as $category) {
                        echo "<option value='" . $category->term_id . "'>" . $category->name . "</option>";
                    }

                    echo "<option value='-1'>Outro</option>";

                    */?>
                </select>-->
                <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Ex: Marketing, Negócios, Alimentos, etc"/>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label for="siteempresa">Site</label>
                <input type="text" class="form-control required" id="siteempresa"
                       name="siteempresa" />
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" class="form-control required" required id="email"
                       name="email" />
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label for="tags">Tags</label>
                <textarea name="tags" id="tags" cols="30" rows="5" class="form-control" ></textarea>
                <small style=" margin: 5px 0px 0px 0px;display: block; text-align: left; color: red;">
                    * quais as palavras-chave que melhor identificam sua empresa, Produtos   e/ou Serviços.
                    Ex: Comércio, Óculos, Contabilidade, Pneus, Eventos, Etc.
                </small>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label for="descricao">Descrição*</label>
                <textarea name="descricao" id="descricao" required cols="30" rows="10" class="form-control"></textarea>
            </div>
        </div>

    </div>


    <hr />

    <div class="row">

        <div class="col-md-8 col-sm-8">
            <div class="form-group">
                <input type="file" class="btn btn--blue" name="image_logo" id="image_logo"
                       value="Logo da empresa"/>
                <?php wp_nonce_field('image_logo', 'image_logo_nonce'); ?>
                <small style="color: red;float: left;">Somente arquivos no formato .jpg, .jpeg ou .png</small>
                <br/><br/>
            </div>
        </div>

        <div class="col-md-4 col-sm-4">
            <input type="submit" class="btn  pull-right" value="Cadastrar"/>
        </div>

    </div>

    <input type="hidden" name="action" value="insert_post_external"/>
    <?php wp_nonce_field('new-post'); ?>

</form>