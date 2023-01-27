<?php 

    function style() {
        wp_register_style('style', plugins_url('style.css',__FILE__ ));
        wp_enqueue_style('style');
    }
    add_action( 'admin_init','style');

    add_action('admin_menu', 'agenda_menu');

    function agenda_menu(){
        add_menu_page('Agenda', 'Agenda', 'manage_options', 'agenda_page', 'agenda_render_page', 'dashicons-welcome-view-site', '3');
    }

    function agenda_render_page(){
        ?>
<html>
<link rel="stylesheet" href="./style.css">
<div class="container1">
    <h1>Inserir Funcionario</h1>
    <form method="post">
        <div class="input-group">
            <label>Nome</label>
            <input type="text" name="fullname" class="form-control" placeholder="Insira o nome aqui">
        </div>
        <br>
        <div class="input-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" placeholder="exemplo@email.com">
        </div>
        <br>
        <div class="input-group">
            <label>Papel</label>
            <input type="text" name="papel" class="form-control" placeholder="Insira a função aqui">
        </div>
        <br>
        <div class="input-group">
            <label>Vinculo</label>
            <input type="text" name="vinculo_type" class="form-control" placeholder="Insira o tipo de vinculo aqui">
        </div>
        <br>
        <div class="input-group">
            <label>Unidade Organizacional</label>
            <select name="uorg">
                <option value="diretoria de ensino a distancia" selected>Diretoria de ensino a distancia</option>
                <option value="diretoria de administração">Diretoria de administração</option>
                <option value="direção geral">Direção geral</option>
                <option value="diretoria academica">Diretoria academica</option>
            </select>
        </div>
        <div class="input-group0">
            <label>Status</label>
            <select name="vinculo_status">
                <option value="ativo" selected>Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
        </div>
        <br>
        <div class="input-group">
            <input type="submit" name="botao" value="registrar" class="form-control btn btn-danger">
        </div>
    </form>
</div>

<div class="container">
    <h1>Agenda</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Função</th>
                <th scope="col">Vinculo</th>
                <th scope="col">Departamento</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <?php 
                    global $wpdb;
                    $table_name = $wpdb->prefix.'list_vinculo';
                    $resultado = $wpdb->get_results('SELECT * FROM $table_name ORDER BY id ASC');
                    ?>
        <tbody>
            <?php foreach ($resultado as $key => $valor): ?>
            <tr>
                <th scope="row"><?php echo $valor->id; ?></th>
                <td><?php echo $valor->name; ?></td>
                <td><?php echo $valor->email; ?></td>
                <td><?php echo $valor->papel; ?></td>
                <td><?php echo $valor->vinculo_type; ?></td>
                <td><?php echo $valor->uorg; ?></td>
                <td><?php echo $valor->coordinator; ?></td>
                <td><?php echo $valor->vinculo_status; ?></td>
                <td><a href="?apagar_id=<?php echo $valor->id;?>">Excluir</a> <a
                        href="?update_row=<?php echo $valor->id;?>">Atualizar</a></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

</html>
<?php
    };

    if(!empty($_POST['botao'])){
        if(!empty($_POST['fullname']) AND !empty($_POST['email']) AND !empty($_POST['papel']) AND !empty($_POST['vinculo_type']) AND !empty($_POST['uorg'])){
            $fullname = sanitize_text_field($_POST['fullname']);
            $email = sanitize_text_field($_POST['email']);
            $papel = sanitize_text_field($_POST['papel']);
            $vinculo_type = sanitize_text_field($_POST['vinculo_type']);
            $uorg = sanitize_text_field($_POST['uorg']);
            $vinculo_status = sanitize_text_field($_POST['vinculo_status']);

            global $wpdb;

            $wpdb->insert('wp_list_collaborator', array(
                'fullname' => $fullname,
                'email' => $email,
            ));

            $wpdb->insert('wp_list_collaborator', array(
            'papel' => $papel,
            'vinculo_type' => $vinculo_type,
            'vinculo_status' => $vinculo_status,
            ));

        }else{
            echo '<h1>Todos os campos são obrigatórios</h1>';
        }
    }

    if(!empty($_GET['apagar_id'])){
        global $wpdb;
        $id = sanitize_text_field($_GET['apagar_id']);
        $delete_person = $wpdb->delete('wp_agenda_plugin', array('id' => $id));
    }

    if(!empty($_GET['update_row'])){
        global $wpdb;
        $id = sanitize_text_field($_GET['update_row']);
        $update_person = $wpdb->update('wp_agenda_plugin', array(
        'id' => $id,
        'name' => sanitize_text_field($_POST['name']),
        'email' => sanitize_text_field($_POST['email']),
        'function' => sanitize_text_field($_POST['function']),
        'bond_type' => sanitize_text_field($_POST['bond_type']),
        'department' => sanitize_text_field($_POST['department']),
        'status' => sanitize_text_field($_POST['status'])));
    }
?>