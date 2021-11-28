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
    <title>Student | Subjects</title>
</head>
<body>
<?php include 'header.php' ?>
<div class="container">
    <?php require 'controllers/student_subjects_controller.php'; ?>    
    <div class="pt-5">
        <h4>Student Subjects</h4>
        <form class="form-inline mb-2" action="/student_subjects.php" method="POST">
            <input type="hidden" name="id" value="student_subject">
            <div class="input-group">
                <select name="student_id" class="form-control mr-2" required>
                    <option value="">-- select student --</option>
                    <?php foreach($student_options as $row): ?>
                        <option value="<?php echo $row['id'] ?>">
                            <?php echo $row['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <select name="subject_id[]" class="form-control mr-2 multiselect" required multiple>
                    <?php foreach($subject_options as $row): ?>
                        <option value="<?php echo $row['id'] ?>">
                            <?php echo $row['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <div style="height:80vh;overflow:auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th class="text-center">Subjects</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($student_subjects as $key => $value): ?>
                        <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $value['name'] ?></td>
                            <td>
                                <?php foreach($value['subject'] as $subject): ?>
                                    <?php echo $subject['name'] ?>,&nbsp;&nbsp;
                                <?php endforeach; ?>
                            </td>
                        </tr> 
                    <?php endforeach; ?>  
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<Script>
    $('.multiselect').multiselect({nonSelectedText: 'Select subjects', inheritClass: true});
</Script>
</body>
</html>