<?php

// fetch data
$subject_rows = $pdo->query('SELECT * FROM subjects')->fetchAll(PDO::FETCH_ASSOC);

// on form submit
if (isset($_POST['id']) && $_POST['id'] == 'subject') {
    // store data
    $stmt = $pdo->prepare('INSERT INTO subjects(name,type) VALUES(?,?)');
    $stmt->execute([$_POST['name'], $_POST['type']]);

    unset($_POST['name']);
    unset($_POST['type']);
    unset($_POST['id']);
}

?>

<div class="pt-3">
    <h4>Subjects</h4>
    <form class="form-inline mb-2" action="/" method="POST">
        <input type="hidden" name="id" value="subject">
        <div class="input-group">
            <input type="text" class="form-control mr-2" placeholder="Name" name="name">
        </div>
        <div class="input-group">
            <select name="type" class="form-control mr-2">
                <option>-- select type --</option>
                <option value="0">optional</option>
                <option value="1">required</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>

    <div style="height:50vh;overflow:auto">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subject_rows as $key => $value): ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $value['name'] ?></td>
                        <td><?php echo $value['type']? 'required':'optional' ?></td>
                    </tr> 
                <?php endforeach; ?>           
            </tbody>
        </table>
    </div>
</div>

