<?php

// fetch data
$student_rows = $pdo->query('SELECT * FROM students')->fetchAll(PDO::FETCH_ASSOC);
$subject_rows = $pdo->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);

// on form submit
if (isset($_POST['id']) && $_POST['id'] == 'student_subject') {


    // store data
    $stmt = $pdo->prepare('INSERT INTO student_subjects(student_id, subject_id) VALUES(?,?)');
    $stmt->execute([$_POST['student_id'], $_POST['subject_id']]);
    
    unset($_POST['id']);
}

?>

<div class="pt-5">
    <h4>Student subjects</h4>
    <form class="form-inline mb-2" action="/" method="POST">
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
            <select name="subject_id" class="form-control mr-2 multiselect" multiple>
                <?php foreach($subject_rows as $row): ?>
                    <option value="<?php echo $row['id'] ?>">
                        <?php echo $row['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

    <div style="height:50vh;overflow:auto">
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

<Script>
    $('.multiselect').multiselect();
</Script>
