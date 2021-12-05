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
    <style>
        #score-table tr td:first-child {
            padding-right: 5pt;
        } 
    </style>
    <title>Student | Ranks</title>
</head>
<body>
<?php include 'header.php' ?>
<div class="container">
    <?php require 'controllers/rank_controller.php'; ?>
    <div class="pt-3">
        <h4>Student Ranks</h4>
        <form class="form mb-2" action="" method="POST">
            <input type="hidden" name="id" value="rank">
            <div class="row pb-1">
                <div class="col-3">
                    <div class="input-group">
                        <select name="student_id" class="form-control" id="student-id" required>
                            <option value="0">-- select student --</option>
                            <?php foreach($student_subjects as $student): ?>
                                <option value="<?php echo $student['id'] ?>">
                                    <?php echo $student['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary d-inline">Save scores</button>
            </div>
            <table id="score-table">
                <thead>
                    <tr>
                        <td>Subject</td>
                        <td>Score</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </form>

        <div style="height:80vh;overflow:auto">
            <table class="table table-striped" id="rank">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <?php foreach ($subject_rows as $row): ?>
                            <th><?php echo $row['name'] ?></th>
                        <?php endforeach; ?>
                        <th>Mean Grade</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($student_scores as $key => $student): ?>
                        <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $student['name'] ?></td>                            
                            <?php foreach ($subject_rows as $subject): ?>
                                <td style="min-width: 80px;">
                                    <?php 
                                        foreach ($student['scores'] as $score_obj) {
                                            if ($subject['code'] == $score_obj['code']) {
                                                if (!empty($score_obj['score'])) echo $score_obj['score'] .' '. $score_obj['grade'];
                                                else echo 'XX'; 
                                            }
                                        }                                    
                                    ?>              
                                </td>
                            <?php endforeach; ?>
                            <td><?php echo $student['mean_points'] .' '.$student['mean_grade'] ?></td>
                            <td><?php echo $student['position'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    <?php $ss_list = json_encode($student_subjects); ?>
    const student_subjects = <?php echo $ss_list ?>;

    function scoreRow(v) {
        return `
            <tr>
                <td><input class="form-control" value="${v.name}" readonly></td>
                <td><input type="number" class="form-control" name="score[]"></td>
                <input type="hidden" name="subject_id[]" value="${v.id}">
            </tr>
        `;
    }

    $('#score-table').css('display', 'none');
    $('#student-id').change(function() {
        if (Number($(this).val())) {
            $('#score-table').css('display', 'block');
        } else {
            $('#score-table').css('display', 'none');
        }

        let subjects;
        for (let i=0; i<student_subjects.length; i++) {
            const student_id = student_subjects[i]['id'];
            if (student_id === $(this).val()) {
                subjects = student_subjects[i]['subject'];
                break;
            }
        }        
        $('#score-table tbody').html('');
        subjects.forEach((v) => $('#score-table tbody').append(scoreRow(v)));
    });

    $('#rank tbody tr').each(function() {
        $(this).find('td').each(function() {
            // replace empty td with underscore
            if ($(this).text().trim() == '') $(this).text('_');
        });
    });
</script>
</html>