<?php

// fetch data
$student_rows = $pdo->query('SELECT * FROM students')->fetchAll(PDO::FETCH_ASSOC);
$subject_rows = $pdo->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="pt-5">
    <h4>Student ranks</h4>
    <div style="height:50vh;overflow:auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Position</th>
                    <th>Grade</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

