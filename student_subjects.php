<?php 

include 'header.php';
include 'nav-menu.php';

require 'controllers/student_subjects_controller.php';

?>

<div class="container">
    <div class="pt-5">
        <h4>Student subjects</h4>
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

<Script>
    $('.multiselect').multiselect({nonSelectedText: 'Select subjects', inheritClass: true});
</Script>
<?php include 'footer.php'; ?>
