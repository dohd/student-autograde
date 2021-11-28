<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <title>Student | Marks</title>
</head>
<body>
<?php include 'header.php' ?>
<div class="container">
    <?php require 'controllers/student_marks_controller.php'; ?>
    <div class="pt-5">
        <h4>Student Marks</h4>
        <form class="form-inline mb-2" action="/" method="POST">
            <input type="hidden" name="id" value="student_mark">
            <div class="input-group">
                <select name="student_id" class="form-control mr-2" id="student-id" required>
                    <option>-- select student --</option>
                    <?php foreach($student_subjects as $student): ?>
                        <option value="<?php echo $student['id'] ?>">
                            <?php echo $student['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <select name="subject_id" class="form-control mr-2" id="subject-id" required>
                    <option value="0">-- select subject --</option>
                </select>
            </div>
            <div class="input-group">
                <input type="number" class="form-control mr-2" name="mark" placeholder="score">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <div style="height:80vh;overflow:auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <?php foreach ($subject_rows as $row): ?>
                            <th><?php echo $row['name'] ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    <?php $ss_list = json_encode($student_subjects); ?>
    const student_subjects = <?php echo $ss_list ?>;
    // on selecting student
    $('#student-id').change(function() {
        // reinitialize select
        $('#subject-id').html($('<option/>', {text: '-- select subject --', value: 0}));
        // assign student subjects
        for (let i=0; i<student_subjects.length; i++) {
            const student_id = student_subjects[i]['id'];
            if (student_id === $(this).val()) {
                const subjects = student_subjects[i]['subject'];
                subjects.forEach(function(v) {
                    $('#subject-id').append($('<option/>', {text: v.name, value: v.id}));
                });                
                break;
            }
        }
    });
</script>
</body>
</html>