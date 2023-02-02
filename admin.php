<?php 

    function style() {
        wp_register_style('style', plugins_url('style.css',__FILE__ ));
        wp_enqueue_style('style');
    }
    add_action( 'admin_init','style');

    add_action('admin_menu', 'agenda_menu');

    function agenda_menu(){
        add_menu_page('Agenda', 'Agenda', 'manage_options', 'agenda_page', 'agenda_render_page', 'dashicons-welcome-view-site', '3');
        add_submenu_page('agenda_page', 'Registro', 'Registro', 'manage_options', 'registro_page', 'registro_render_page');
    }

    function agenda_render_page(){
        ?>
<html>
<link rel="stylesheet" href="./style.css">
<div class="container1">
    <h1>Vincular Colaborador</h1>
    <form method="post">
        <div class="input-group">
            <label>Colaborador</label>
            <select name="collaborator_id">
                <?php 
                    global $wpdb;
                    $table_collaborator = $wpdb->prefix.'collaborator'; 
                    $resultado_collaborator = $wpdb->get_results("SELECT * FROM $table_collaborator ORDER BY id ASC");
                ?>
                <?php foreach ($resultado_collaborator as $valor): ?>
                <option value="<?php echo $valor->id ?>"><?php echo $valor->fullname?></option>
                <?php endforeach ?>
            </select>
        </div>
        <br>
        <div class="input-group">
            <label>Unidade Organizacional</label>
            <select name="uorg_id">
                <?php 
                    global $wpdb;
                    $table_uorg = $wpdb->prefix.'uorg'; 
                    $uorg = $wpdb->get_results("SELECT * FROM $table_uorg ORDER BY id ASC");
                ?>
                <?php foreach ($uorg as $uorg_value): ?>
                    <option value="<?php echo $uorg_value->id ?>"><?php echo $uorg_value->uorg_name?></option>
                <?php endforeach ?>
            </select>
        </div>
        <br>
        <div class="input-group">
            <label>Sala</label>
            <select name="room_id">
                <?php 
                    global $wpdb;
                    $table_room = $wpdb->prefix.'room'; 
                    $room = $wpdb->get_results("SELECT * FROM $table_room ORDER BY id ASC");
                    $table_uorg_room = $wpdb->prefix.'uorg_room'; 
                    $uorg_room = $wpdb->get_results("SELECT * FROM $table_uorg_room ORDER BY id ASC");
                ?>
                 <?php foreach($room as $room_value):?>
                        <option value="<?php echo $room_value->id ?>"><?php echo $room_value->room_number?></option>;
                    <?php endforeach ?>
            </select>
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
            <label>Fone</label>
            <input type="text" name="phone" class="form-control" placeholder="Insira o Fone">
        </div>
        <br>
        <div class="input-group">
            <label>Status</label>
            <input type="text" name="vinculo_status" class="form-control" placeholder="Insira o tipo de vinculo aqui">

        </div>
        <br>
        <div class="input-group">
            <label>Horario</label>
            <input type="text" name="horario" class="form-control" placeholder="Insira o Horario">
        </div>
        <br>
       

        <div class="input-group0">
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
                <th scope="col">Uorg</th>
                <th scope="col">Sala</th>
                <th scope="col">Papel</th>
                <th scope="col">Vinculo</th>
                <th scope="col">Status</th>
                <th scope="col">Fone</th>
                <th scope="col">Horario</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <?php 
                global $wpdb;

                $table_vinculo = $wpdb->prefix.'vinculo';
                $table_collaborator = $wpdb->prefix.'collaborator'; 
                $table_uorg_room = $wpdb->prefix.'uorg_room'; 
                $table_uorg = $wpdb->prefix.'uorg'; 
                
                $resultado = $wpdb->get_results("SELECT * FROM $table_vinculo ORDER BY id ASC");
                $collaborator = $wpdb->get_results("SELECT * FROM $table_collaborator ORDER BY id ASC");
                $uorg_room = $wpdb->get_results("SELECT * FROM $table_uorg_room ORDER BY id ASC");
                $uorg = $wpdb->get_results("SELECT * FROM $table_uorg ORDER BY id ASC");
                
        ?>
        <tbody>
            <?php foreach ($resultado as $valor_vinculo): ?>

            <tr>
                <th scope="row"><?php echo $valor_vinculo->id; ?></th>
                <td>
                    <?php foreach($collaborator as $collaborator_value): ?>
                    <?php if($collaborator_value->id == $valor_vinculo->collaborator_id) echo $collaborator_value->fullname; ?>
                    <?php endforeach ?>
                </td>
                <td>
                <?php foreach($uorg_room as $uorg_room_value): ?>
                    <?php if($uorg_room_value->id == $valor_vinculo->uorg_room_id)
                            {
                               foreach($uorg as $uorg_value):
                                    if($uorg_value->id == $uorg_room_value->uorg_id) echo $uorg_value->uorg_name;
                               endforeach;
                            }; ?>
                    <?php endforeach ?>
                </td>
                <td>
                <?php foreach($uorg_room as $uorg_room_value): ?>
                    <?php 
                        if($uorg_room_value->id == $valor_vinculo->uorg_room_id)  
                            {
                            foreach($room as $room_value):
                                if($room_value->id == $uorg_room_value->room_id) echo $room_value->room_number;
                            endforeach;
                        }; 
                    ?>
                <?php endforeach ?>
                </td>
                <td><?php echo $valor_vinculo->papel; ?></td>
                <td><?php echo $valor_vinculo->phone; ?></td>
                <td><?php echo $valor_vinculo->vinculo_type; ?></td>
                <td><?php echo $valor_vinculo->vinculo_status; ?></td>
                <td><?php echo $valor_vinculo->horario; ?></td>
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

    global $wpdb;

    $table_vinculo = $wpdb->prefix.'vinculo';
    $table_uorg_room = $wpdb->prefix.'uorg_room'; 
    $uorg_room = $wpdb->get_results("SELECT * FROM $table_uorg_room ORDER BY id ASC");

    if(!empty($_POST['botao'])){
        if(!empty($_POST['collaborator_id'])){
            $collaborator_id = sanitize_text_field($_POST['collaborator_id']);
            $uorg_id = sanitize_text_field($_POST['uorg_id']);
            $room_id = sanitize_text_field($_POST['room_id']);
            $papel = sanitize_text_field($_POST['papel']);
            $phone = sanitize_text_field($_POST['phone']);
            $vinculo_type = sanitize_text_field($_POST['vinculo_type']);
            $vinculo_status = sanitize_text_field($_POST['vinculo_status']);
            $horario = sanitize_text_field($_POST['horario']);
            foreach($uorg_room as $aux):
                if($aux->uorg_id == $uorg_id && $aux->room_id == $room_id)
                    {
                        $uorg_room_id = $aux->id;
                    }
            endforeach;
            global $wpdb;

            $wpdb->insert("$table_vinculo", array(
                'collaborator_id' => $collaborator_id,
                'uorg_room_id' => $uorg_room_id,
                'papel' => $papel,
                'phone' => $phone,
                'vinculo_type' => $vinculo_type,
                'vinculo_status' => $vinculo_status,
                'horario' => $horario,
            ));

        }else{
            echo '<h1>Todos os campos são obrigatórios</h1>';
        }
    }

    if(!empty($_GET['apagar_id'])){
        global $wpdb;
        $id = sanitize_text_field($_GET['apagar_id']);
        $delete_person = $wpdb->delete("$table_vinculo", array('id' => $id));
    }

    if(!empty($_GET['update_row'])){
        global $wpdb;
        $id = sanitize_text_field($_GET['update_row']);
        $update_person = $wpdb->update("$table_vinculo", array(
        'id' => $id,
        'name' => sanitize_text_field($_POST['name']),
        'email' => sanitize_text_field($_POST['email']),
        'function' => sanitize_text_field($_POST['function']),
        'bond_type' => sanitize_text_field($_POST['bond_type']),
        'department' => sanitize_text_field($_POST['department']),
        'status' => sanitize_text_field($_POST['status'])));
    }
?>