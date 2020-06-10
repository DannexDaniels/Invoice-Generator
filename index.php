
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="a simple invoice generator">
    <meta name="author" content="Dannex Daniels & Doris Munga">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Invoice Generator</title>

    <style>
        body{
            background: #485B65;
        }
        .container{
            margin-top: 100px;
            background: #F0F5FF;
        }
    </style>
</head>
<body>

<div class="container">

    <script>
        var counter = 1;

        function addrow() {
            var section = document.getElementById("additional");
            var divrow = document.createElement("div");
            counter++;
            divrow.innerHTML = "<div class=\"row\">\n" +
                "            <div class=\"col-lg-2\">\n" +
                "                <label for=\"item\">Item</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"item"+counter+"\">\n" +
                "            </div>\n" +
                "            <div class=\"col-lg-4\">\n" +
                "                <label for=\"description\">Description</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"description"+counter+"\">\n" +
                "            </div>\n" +
                "            <div class=\"col-lg-2\">\n" +
                "                <label for=\"quantity\">Quantity</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"quantity"+counter+"\">\n" +
                "            </div>\n" +
                "            <div class=\"col-lg-2\">\n" +
                "                <label for=\"rate\">Rate</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"rate"+counter+"\">\n" +
                "            </div>\n" +
                "            <div class=\"col-lg-2\">\n" +
                "                <label for=\"amount\">Amount</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"amount"+counter+"\">\n" +
                "            </div>\n" +
                "\n" +
                "        </div>";
            section.appendChild(divrow);
        }
    </script>

    <form action="create_invoice.php" method="POST">

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="bill_to">Bill To</label>
                    <textarea class="form-control" name="bill_to" rows="3"></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="desc_inv_no">Description and Invoice Number</label>
                    <textarea class="form-control" name="desc_inv_no" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <label for="item">Item</label>
                <input type="text" class="form-control" name="item">
            </div>
            <div class="col-lg-4">
                <label for="description">Description</label>
                <input type="text" class="form-control" name="description">
            </div>
            <div class="col-lg-2">
                <label for="quantity">Quantity</label>
                <input type="text" class="form-control" name="quantity">
            </div>
            <div class="col-lg-2">
                <label for="rate">Rate</label>
                <input type="text" class="form-control" name="rate">
            </div>
            <div class="col-lg-2">
                <label for="amount">Amount</label>
                <input type="text" class="form-control" name="amount">
            </div>

        </div>
        <div id="additional">

        </div>
        <button type="button" class="btn btn-primary" onclick="addrow()">Add Item</button>
        <br /><br /><br />


        <button type="submit" class="btn btn-primary" id="submit">Generate Invoice</button>
    </form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>