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
    <div style="background-color:yellow;" class="d-flex justify-content-center">
        <h3>POS SALES</h3>
    </div>
    <div style="background-color:;display:flex;" class="container-fluid bg-2 text-center">
        <div style="background-color:" class="col-sm-8">
            <form class="form-horizontal">
                <caption>Add Product</caption>
                <table class="table table-bordered">

                    <tr>
                        <th>Product Code</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Option</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="prdcode" placeholder="productcode" required>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="description" placeholder="Description" required>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="price" placeholder="price" required>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quantity" placeholder="quantity" required>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="amount" placeholder="amount" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" name="add" name="Add">Add</button>
                        </td>
                    </tr>

                </table>
            </form>
            <caption>Products</caption>
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th style="width:40px">Remove</th>
                        <th>Product Code</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Option</th>

                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div style="background-color:" class="col-sm-4" align="right">
            <div class="form-group" align="left">
                <label>Total</label>
                <input type="text" class="form-control" name="total" placeholder="Total">
                <label>Pay Amount</label>
                <input type="text" class="form-control" name="pay" placeholder="Pay Amount">
                <label>Balance</label>
                <input type="text" class="form-control" name="balance" placeholder="Balance">
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script>
        getProductCode();

        function getProductCode() {
            $("#prdcode").empty();
            $("#prdcode").keyup(function(e) {
                $.ajax({
                    type: "JSON",
                    url: "get_product.php",
                    datatype: "JSON",
                    data: {
                        prdcode: $["#prdcode"].val()
                    },
                    success: function(data) {
                        $("$pname").val(data[0].item_description);
                        $("$price").val(data[0].item_sprice);
                        $("$qty").focus();
                    }

                })
            })
        }

    </script>
</body>

</html>
