<?php

include 'header.php';
include 'nav-menu.php';

require 'controllers/subjects_controller.php';

?>

<div class="container">
<div class="pt-3">
    <h4>Subjects</h4>
    <form class="form-inline mb-2" action="" method="POST">
        <input type="hidden" name="id" value="subject">
        <div class="input-group">
            <input type="text" class="form-control mr-2" placeholder="Name" name="name" required>
        </div>        
        <button type="submit" class="btn btn-primary">Add</button>
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
                <?php foreach ($subject_rows as $key => $value): ?>
                    <tr>
                        <td scope="row"><?php echo $key+1 ?></td>
                        <td><?php echo $value['name'] ?></td>
                    </tr> 
                <?php endforeach; ?>           
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>
