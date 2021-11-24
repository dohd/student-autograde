<?php 

require_once 'header.php';

require_once 'database.php';

require_once 'controllers/students_controller.php';

?>

<div class="container">
    <div class="pt-3">
        <h4>Students</h4>
        <form class="form-inline mb-2" action="" method="POST">
            <input type="hidden" name="id" value="student">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Name" name="name">
            </div>
            <br>
            <button type="submit" class="btn btn-primary ml-2">Add</button>
        </form>

        <div style="height:80vh;overflow:auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($student_rows as $key => $value): ?>
                        <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $value['name'] ?></td>
                        </tr> 
                    <?php endforeach; ?>           
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
