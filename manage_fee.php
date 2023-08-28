<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM student_ef_list where id = {$_GET['id']} ");
	foreach ($qry->fetch_array() as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form id="manage-fees">
		<div id="msg"></div>
		
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

		<div class="form-group">
			<label for="" class="control-label">Nº Cripta</label>
			<input type="text" class="form-control" name="ef_no" value="<?php echo isset($ef_no) ? $ef_no : '' ?>" required>
		</div>

		<div class="form-group">
			<label for="" class="control-label">Propietario</label>
			<select name="student_id" id="student_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
				$student = $conn->query("SELECT * FROM student order by name asc ");
				while ($row = $student->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($student_id) && $student_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) . ' | ' . $row['id_no'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="" class="control-label">Año</label>
			<select name="course_id" id="course_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
				$student = $conn->query("SELECT *,concat(course) as class FROM courses order by course asc ");
				while ($row = $student->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>" data-amount="<?php echo $row['total_amount'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="" class="control-label">Tarifa</label>
			<input type="text" class="form-control text-right" name="total_fee" value="<?php echo isset($total_fee) ? number_format($total_fee) : '' ?>" required readonly>
		</div>
	</form>
</div>

<script>
    $('.select2').select2({
        placeholder: 'Por favor seleccione aquí',
        width: '100%'
    })

    $('#course_id').change(function() {
        var amount = $('#course_id option[value="' + $(this).val() + '"]').attr('data-amount')
        $('[name="total_fee"]').val(parseFloat(amount).toLocaleString('en-US', {
            style: 'decimal',
            maximumFractionDigits: 2,
            minimumFractionDigits: 2
        }))
    })

    $('#manage-fees').submit(function(e) {
        e.preventDefault();
        console.log($(this).serialize()); // Verifica los datos que se están enviando
		start_load()
        $('#msg').html('')
        $.ajax({
            url: 'ajax.php?action=save_fees',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json', // Esperar una respuesta JSON
            error: err => {
                console.log(err);
                end_load();
            },
            success: function(resp) {
                console.log(resp); // Mostrar la respuesta JSON en la consola
                if (resp.message) {
                    alert_toast(resp.message, 'success');
                    if (resp.message === "Data saved successfully") {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                }
            }
        });
    })
</script>