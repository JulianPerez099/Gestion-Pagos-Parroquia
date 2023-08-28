<?php include('db_connect.php'); ?>
<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3);
        -moz-transform: scale(1.3);
        -webkit-transform: scale(1.3);
        -o-transform: scale(1.3);
        transform: scale(1.3);
        padding: 10px;
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
            </div>
        </div>
        <div class="row">
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Registro de propietarios </b>
                            <span class="float-right">
                                <a class="btn btn-primary col-md-auto col-sm-auto float-right"
                                   href="javascript:void(0)" id="new_student">
                                    <i class="fa fa-plus"></i> Propietario
                                </a>
                            </span>
                    </div>
                    <div class="card-body">
                        <div class="table-container"> <!-- Agregado para el desplazamiento -->
                            <table class="table table-condensed table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Nº Propietario</th>
                                    <th class="">Nombre Completo</th>
                                    <th class="">Información</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                $student = $conn->query("SELECT * FROM student order by name asc ");
                                while ($row = $student->fetch_assoc()) :
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td>
                                            <?php echo $row['id_no'] ?>
                                        </td>
                                        <td>
                                            <?php echo ucwords($row['name']) ?>
                                        </td>
                                        <td class="">
                                            <p>Correo: <?php echo $row['email'] ?></p>
                                            <p>Numero Documento Identificación: <?php echo $row['num_iden'] ?></p>
                                            <p>Numero de Celular: <?php echo $row['contact'] ?></p>
                                            <p>Dirección: <?php echo $row['address'] ?></p>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-primary edit_student" type="button"
                                                    data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger delete_student" type="button"
                                                    data-id="<?php echo $row['id'] ?>"><i
                                                        class="fa fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>
</div>
<style>
    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset;
    }

    img {
        max-width: 100px;
        max-height: 150px;
    }

    .table-container {
        max-height: 330px; /* Ajusta la altura máxima según tus necesidades */
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>

<script>
    $(document).ready(function () {
        $('table').dataTable();
    });

    $('#new_student').click(function () {
        uni_modal("Nuevo Propietario ", "manage_student.php", "mid-large");
    });

    $('.edit_student').click(function () {
        uni_modal("Actualizar Información del Propietario", "manage_student.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_student').click(function () {
        _conf("Deseas eliminar este propietario? ", "delete_student", [$(this).attr('data-id')]);
    });

    function delete_student($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_student',
            method: 'POST',
            data: {
                id: $id
            },
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Datos eliminados exitósamente", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
