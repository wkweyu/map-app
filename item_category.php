<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <?php require_once 'process_category.php'; ?>

    <?php
            if(isset($_SESSION['message'])): ?>
    <div class="alert alert-<?=$_SESSION['msg_type']?>">
        <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
            ?>
    </div>
    <?php endif ?>
    <div class="container">

        <?php
        include('connection.php');
        require_once 'functions.php';
        $query = pg_query($link,"SELECT * FROM public.category");
            if (!$query) {
                echo "An error occurred.\n";
                exit;
                };
        ?>
        <header>
            <h1>Add Category</h1>
        </header>

        <div class="row justify-content-center">

            <form action="process_category.php" method="post" id="products-form">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                </div>
                <div class="form-group">
                    <?php
                        if ($update == true):
                    ?>
                    <label class="form-label">category Code</label>
                    <input name="category_code" value="<?php echo $code;?>" class="form-control" type="" disabled>
                    <?php endif; ?>

                </div>
                <div class="form-group">
                    <label class="form-label">category Name</label>
                    <input oninput="productCode()" name="category_name" value="<?php echo $name;?>" placeholder="Enter category name" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <?php
                        if ($update == true):
                    ?>
                    <button class="btn btn-info" name="update" type="submit">Update</button>
                    <?php else: ?>
                    <button class="btn btn-primary" name="save" type="submit">Save</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <th>category Code</th>
                    <th>category Name</th>
                    <th colspan='2'>Action</th>
                </thead>
                <?php
                while ($row = pg_fetch_assoc($query)):?>
                <tr>
                    <td><?php echo $row['category_code']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td>
                        <a href="item_category.php?edit=<?php echo $row['category_id']?>" class="btn btn-info">edit</a>
                        <a href="process_category.php?delete=<?php echo $row['category_id']?>" class="btn btn-danger">delete</a>
                    </td>

                </tr>
                <?php endwhile; ?>

            </table>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


        <script type="text/javascript">

        </script>
    </div>

</body>

</html>
