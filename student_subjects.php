<?php 

require_once 'header.php';

require_once 'helpers.php';
require_once 'database.php';

require_once 'controllers/student_subjects_controller.php';
require_once 'controllers/subjects_controller.php';
require_once 'controllers/students_controller.php';

?>

<div class="container">
    <div class="pt-5">
        <h4>Student subjects</h4>
        <form class="form-inline mb-2" action="/student_subjects.php" method="POST">
            <input type="hidden" name="id" value="student_subject">
            <div class="input-group">
                <select name="student_id" class="form-control mr-2">
                    <option>-- select student --</option>
                    <?php foreach($student_rows as $row): ?>
                        <option value="<?php echo $row['id'] ?>">
                            <?php echo $row['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group">
                <select name="subject_id[]" class="form-control mr-2 multiselect" multiple>
                    <?php foreach($subject_rows as $row): ?>
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
                        <th>Subjects</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<Script>
    $('.multiselect').multiselect();
</Script>
<?php include 'footer.php'; ?>
