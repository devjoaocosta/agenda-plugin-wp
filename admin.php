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
            <div class="container">
                <h1>Inserir Funcionario</h1>
                <form method="post">
                    <div class="input-group">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control" placeholder="Insira o nome aqui">
                    </div>
                    <br>
                    <div class="input-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="exemplo@email.com">
                    </div>
                    <br>
                    <div class="input-group">
                        <label>Função</label>
                        <input type="text" name="function" class="form-control" placeholder="Insira a função aqui">
                    </div>
                    <br>
                    <div class="input-group">
                        <label>Vinculo</label>
                        <input type="text" name="bond_type" class="form-control" placeholder="Insira o tipo de vinculo aqui">
                    </div>
                    <br>
                    <div class="input-group">
                        <label>Departamento</label>
                        <select name="department">
                            <option value="dead" selected>Diretoria de ensino a distancia</option>
                            <option value="diretoria de administração">Diretoria de administração</option>
                            <option value="direção geral">Direção geral</option>
                            <option value="diretoria academica">Diretoria academica</option>
                        </select>
                    </div>
					   <div class="input-group">
                        <label>Status</label>
                        <select name="status">
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
                            <th scope="col">Coordenador</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <?php 
                    global $wpdb;
                    $table_name = $wpdb->prefix.'agenda_plugin';
                    $resultado = $wpdb->get_results('SELECT * FROM wp_agenda_plugin ORDER BY id ASC');
                    ?>
                    <tbody>
                        <?php foreach ($resultado as $key => $valor): ?>
                            <tr>
                                <th scope="row"><?php echo $valor->id; ?></th>
                                <td><?php echo $valor->name; ?></td>
                                <td><?php echo $valor->email; ?></td>
                                <td><?php echo $valor->function; ?></td>
                                <td><?php echo $valor->bond_type; ?></td>
                                <td><?php echo $valor->department; ?></td>
                                <td><?php echo $valor->coordinator; ?></td>
                                <td><?php echo $valor->status; ?></td>
                                <td><a href="?apagar_id=<?php echo $valor->id;?>">Excluir</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </html>
        <?php
    };

    if(!empty($_POST['botao'])){
        if(!empty($_POST['name']) AND !empty($_POST['email']) AND !empty($_POST['function']) AND !empty($_POST['bond_type']) AND !empty($_POST['department'])){
            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_text_field($_POST['email']);
            $function = sanitize_text_field($_POST['function']);
            $bond_type = sanitize_text_field($_POST['bond_type']);
            $department = sanitize_text_field($_POST['department']);
            $status = sanitize_text_field($_POST['status']);

            global $wpdb;

            $wpdb->insert('wp_agenda_plugin', array(
                'name' => $name,
                'email' => $email,
                'function' => $function,
                'bond_type' => $bond_type,
                'department' => $department,
                'coordinator' => '0',
				'status' => $status,
            ));
        }else{
            echo 'Todos os campos são obrigatórios';
        }
    }

    if(!empty($_GET['apagar_id'])){
        global $wpdb;
        $id = sanitize_text_field($_GET['apagar_id']);
        $delete_person = $wpdb->delete('wp_agenda_plugin', array('id' => $id));
    }
?>