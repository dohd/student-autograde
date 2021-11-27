<?php

include 'header.php';
include 'nav-menu.php';

require 'controllers/student_marks_controller.php';

?>

<div class="container">
    <div class="pt-5">
        <h4>Student marks</h4>
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

<?php $student_subjects = json_encode($student_subjects); ?>

<script>
    const student_subjects = <?php echo $student_subjects ?>;
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

<?php include 'footer.php'; ?>
