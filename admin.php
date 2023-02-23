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
<div class="container ex">
    <h1>Vincular Colaborador</h1>
    <form method="post">
        <div class="input-group">
            <label>Colaborador</label>
            <select id="collaborator" name="collaborator_id">
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
            <select id="uorg_id" name="uorg_id">
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
            <select id="room_id" name="room_id">
                <?php
                    $table_room = $wpdb->prefix.'room';
                    $table_uorg_room = $wpdb->prefix.'uorg_room';

                    $rooms = $wpdb->get_results("
                        SELECT $table_room.*, $table_uorg_room.uorg_id
                        FROM $table_room
                        INNER JOIN $table_uorg_room ON $table_uorg_room.room_id = $table_room.id
                        ORDER BY id ASC
                    ");
                ?>
                <option value="null" style="display: none;" selected> </option>

                <?php foreach ($rooms as $room): ?>
                <option id="<?= $room->uorg_id; ?>" value="<?= $room->id; ?>" style="display: none;">
                    <?= $room->room_number; ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>
        <br>
        <div class="input-group">
            <label>Papel</label>
            <input type="text" id="papel" name="papel" class="form-control" placeholder="Insira a função aqui">
        </div>
        <br>
        <div class="input-group">
            <label>Vinculo</label>
            <input type="text" id="vinculo" name="vinculo_type" class="form-control"
                placeholder="Insira o tipo de vinculo aqui">
        </div>
        <br>
        <div class="input-group">
            <label>Fone</label>
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Insira o Fone">
        </div>
        <br>
        <div class="input-group">
            <label>Status</label>
            <input type="text" id="status" name="vinculo_status" class="form-control"
                placeholder="Insira o tipo de vinculo aqui">

        </div>
        <br>
        <div class="input-group">
            <label>Horario</label>
            <input type="text" id="horario" name="horario" class="form-control" placeholder="Insira o Horario">
        </div>
        <br>


        <div class="input-group0">
            <input type="submit" name="botao" value="registrar" class="form-control btn btn-danger">
        </div>
    </form>

</div>

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

<?php
            foreach($uorg as $uorg_value):
        ?>
<div class="container add">
    <h1><?php echo $uorg_value->uorg_name ?></h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Uorg</th>
                <th scope="col">Sala</th>
                <th scope="col">Papel</th>
                <th scope="col">Fone</th>
                <th scope="col">Vinculo</th>
                <th scope="col">Status</th>
                <th scope="col">Horario</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($resultado as $valor_vinculo): ?>

            <?php foreach($uorg_room as $uorg_room_value): ?>
            <?php if($uorg_room_value->id == $valor_vinculo->uorg_room_id)
                            {
                            foreach($uorg as $uorg_value):
                                if($uorg_value->id == $uorg_room_value->uorg_id) echo $uorg_value->uorg_name;
                            endforeach;
                            };
                        ?>
            <?php endforeach ?>

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
                        global $wpdb;
                        $table_room = $wpdb->prefix.'room';
                        $room = $wpdb->get_results("SELECT * FROM $table_room ORDER BY id ASC");
                        $table_uorg_room = $wpdb->prefix.'uorg_room';
                        $uorg_room = $wpdb->get_results("SELECT * FROM $table_uorg_room ORDER BY id ASC");

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
                <td>
                    <button onclick="location.href='?apagar_id=<?php echo $valor_vinculo->id;?>'">Excluir</button>
                    <button onclick="getLinkForUpdate(<?php echo $valor_vinculo->id;?>)">Atualizar</button>
                </td>
            </tr>
            <?php endforeach ?>

        </tbody>
    </table>
</div>
<?php
            endforeach;
        ?>












<script>
// filter rooms on select by selected uorg
const domqs = document.querySelector.bind(document);
const domqsAll = document.querySelectorAll.bind(document);

const uorgSelect = domqs('#uorg_id');

function showOptionByUorgId(uorgId) {
    const options = domqsAll('#room_id > option');

    options.forEach((option) => {
        if (option.id == uorgId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    })

}

uorgSelect.addEventListener('change', (ev) => {
    const uorgId = ev.target.value;
    showOptionByUorgId(uorgId);
    domqs('#room_id').value = 'null';
})

const collaboratorSelect = document.querySelector("select#collaborator");
const uorgNameSelect = document.querySelector("select#uorg_id");
const roomNumberSelect = document.querySelector("select#room_id");
const papelInput = document.querySelector("input#papel");
const vinculoInput = document.querySelector("input#vinculo");
const phoneInput = document.querySelector("input#phone");
const statusInput = document.querySelector("input#status");
const horarioInput = document.querySelector("input#horario");

function getLinkForUpdate(id) {
    location.href =
        `?update_row=${id}
        &collaborator=${collaboratorSelect.value}
        &uorgName=${uorgNameSelect.value}
        &roomNumber=${roomNumberSelect.value}
        &papel=${papelInput.value}
        &vinculo=${vinculoInput.value}
        &phone=${phoneInput.value}
        &vinculoStatus=${statusInput.value}
        &horario=${horarioInput.value}`;
};
</script>

</html>
<?php
    }

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
            wp_safe_redirect( wp_get_referer() );

        }else{
            echo '<h1>Todos os campos são obrigatórios</h1>';
        }
    }

    if(!empty($_GET['apagar_id'])){
        global $wpdb;
        $id = sanitize_text_field($_GET['apagar_id']);
        $delete_person = $wpdb->delete("$table_vinculo", array('id' => $id));
        wp_safe_redirect( wp_get_referer() );
    }

    if (isset($_GET['update_row'])) {
        $collaborator_id = $_GET['collaborator'];
        $uorg_id = $_GET['uorgName'];
        $room_id = $_GET['roomNumber'];
        $papel = $_GET['papel'];
        $vinculo = $_GET['vinculo'];
        $phone = $_GET['phone'];
        $status = $_GET['vinculoStatus'];
        $horario = $_GET['horario'];
        foreach($uorg_room as $aux):
            if($aux->uorg_id == $uorg_id && $aux->room_id == $room_id)
                {
                    $uorg_room_id = $aux->id;
                }
        endforeach;

        global $wpdb;
        
        $id = intval( $_GET['update_row'] );
        $table_vinculo = $wpdb->prefix.'vinculo'; 
        
        $data = array(
            'collaborator_id' => $collaborator_id,
            'uorg_room_id' => $uorg_room_id,
            'phone' => $phone,
            'papel' => $papel,
            'vinculo_status' => $status,
            'vinculo_type' => $vinculo,
            'horario' => $horario
        );
            
        $where = array(
            'id' => $id
        );

        $update_vinculo = $wpdb->update(
            $table_vinculo, 
            $data,
            array( 'id' => $id ),
            array( '%s', '%s' ),
            array( '%d' )
        );

        if ( false === $update_vinculo ) {
            // Erro na atualização
            echo '<script> alert("nao funcionou")</script>' . $wpdb->last_error;
            
        } else {
            // Atualização realizada com sucesso
            wp_safe_redirect( wp_get_referer() );
        }
    }
    
?>