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
<!--style>
    #form {
        background-color: ;
        display: flex;
        margin: 5px;
        padding: 15px;
        justify-content: flex-start;
    }

    .form {
        background-color: ;
        margin: auto;
        padding: 5px;
    }

</style-->

<body>
    <?php 
        require_once 'process_products.php';
        include_once 'connection.php';
        include_once 'functions.php';
    ?>
    <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
    </div>
    <?php endif; ?>
    <header>
        <h1>Add Products</h1>
    </header>
    <div class="alert alert-danger">
        <?php echo $error; ?>
    </div>

    <div id="form" class="container-fluid bg-2">

        <form class="form-horizontal col-sm-4" action="" method="post">
            <div class="form-group">
                <label class="form-label">Product code</label>
                <input name="prd_code" value="<?php echo $prdCode ?>" placeholder="Enter product name" class="form-control" type="text">
            </div>
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input name="prd_name" value="<?php echo $name ?>" placeholder="Enter product name" class="form-control" type="text">
            </div>
            <div class="form-group">
                <?php 
                    $query = pg_query($link, "SELECT * FROM public.group ORDER BY group_name DESC");
                        if ($query !=0) {
                            echo '<label class="form-label">Product Group';
                            echo '<select class="form-control" name="group">';
                            echo '<option value="">---Group Name---</option>';
                $num_rows = pg_num_rows($query);
                for ($i = 0;$i<=$num_rows;$i++){ $row=pg_fetch_assoc($query); $name=$row['group_name']; $id=$row['group_id']; echo'<option value="'.$name.'" , "'.$id.'">'.$name.'
                    </option>';
                    }
                    echo '</select>';
                    echo '</label>';
                    }
                    ?>

            </div>
            <div class="form-group">
                <?php
                    $query = pg_query($link, "SELECT * FROM public.category ORDER BY category_name ASC");
                    if ($query !=0) {
                        echo '<label class="form-label">Product Category';
                        echo '<select class="form-control" name="category">';
                        echo '<option value="<?php echo $category ?>">---Category Name---</option>';
                echo $category;
                $num_rows = pg_num_rows($query);
                for ($i=0;$i<=$num_rows;$i++) { $row=pg_fetch_assoc($query); $cname=$row['category_name']; $id=$row['category_id']; echo '<option value="' .$cname.'","'.$id.'">'.$cname.'<option>';
                        }
                        echo '</select>';
                        echo '</label>';
                        }
                        ?>
            </div>
            <div class="form-group">
                <label class="form-label">Price</label>
                <input name="selling-price" value="<?php echo $sprice ?>" placeholder="Enter product selling price" class="form-control" type="number" step="any">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" name="save" type="submit">Save</button>
            </div>
        </form>
        <div class="row justify-content-center">
            <?php
            require_once 'connection.php';
                $query = pg_query($link, "SELECT * FROM public.items");
                    if ($query !=0) {
                        
                    }
          ?>
            <table class="table table-bordered">
                <thead>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Group</th>
                    <th>Categroy</th>
                    <th>Price</th>
                    <th colspan="2">Action</th>
                </thead>
                <tr>
                    <?php  while($row = pg_fetch_assoc($query)):?>
                    <td><?php echo $row['item_code'];?></td>
                    <td><?php echo $row['item_desc'];?></td>
                    <td><?php echo $row['item_group'];?></td>
                    <td><?php echo $row['item_category'];?></td>
                    <td><?php echo $row['item_sprice'];?></td>
                    <td>
                        <a href="products.php?edit=<?php echo $row['item_id']?>" class="btn btn-info">edit</a>
                        <a href="process_products.php?delete=<?php echo $row['item_id']?>" class="btn btn-danger">delete</a>
                    </td>

                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

</body>

</html>
