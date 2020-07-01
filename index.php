
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

        var amountValue = "";
        var rateValue = "";
        var quantityValue = "";

        function addrow() {
            setAmount();
            var section = document.getElementById("additional");
            var divrow = document.createElement("div");
            counter++;
            divrow.innerHTML = "<div id=\"div"+counter+"\"><div class=\"row\" required>\n" +
                "            <div class=\"col-sm-1\">\n" +
                "                <label for=\"item\">Item</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"item"+counter+"\" required>\n" +
                "            </div>\n" +
                "            <div class=\"col-sm-4\">\n" +
                "                <label for=\"description\">Description</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"description"+counter+"\" required>\n" +
                "            </div>\n" +
                "            <div class=\"col-sm-2\">\n" +
                "                <label for=\"quantity\">Quantity</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"quantity"+counter+"\" id=\"quantity"+counter+"\" required>\n" +
                "            </div>\n" +
                "            <div class=\"col-sm-2\">\n" +
                "                <label for=\"rate\">Rate</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"rate"+counter+"\" id=\"rate"+counter+"\" onkeydown=\"setAmount('amount'+counter,'rate'+counter, 'quantity'+counter)\" required>\n" +
                "            </div>\n" +
                "            <div class=\"col-sm-2\">\n" +
                "                <label for=\"amount\">Amount</label>\n" +
                "                <input type=\"text\" class=\"form-control\" name=\"amount"+counter+"\" id=\"amount"+counter+"\" required readonly>\n" +
                "            </div>\n" +
                "            <div class=\"col-lg-1\">\n"+
                "               <br />\n"+
                "               <img src=\"https://img.icons8.com/fluent/48/000000/delete-sign.png\" class=\"div"+counter+"\" onclick=\"deleterow(this)\"/>\n"+
                "            </div>\n"+
                "\n" +
                "        </div></div>";
            section.appendChild(divrow);
        }

        function deleterow(row) {
            if(confirm('Are you sure you want to delete?')){
                var div = document.getElementById(row.className);
                div.parentNode.removeChild(div);
            }

        }

        function setAmount(amount = '0',rate = '0', quantity = '0') {
            if (amount!='0' || rate!='0' || quantity!=0){
                amountValue = amount;
                rateValue = rate;
                quantityValue = quantity;
            }

            if (amountValue == "" || rateValue == "" || quantity == ""){
                alert("Fill all the fields above first");
            }else {
                console.log("amount: "+amountValue+" Rate: "+rateValue);
                document.getElementById(amountValue).value = document.getElementById(quantityValue).value * document.getElementById(rateValue).value;
            }
        }

        function submitData(e) {
            setAmount()
            if(!confirm('Do you want to proceed?'))e.preventDefault();
        }
    </script>

    <form action="create_invoice.php" method="POST">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="bill_to">Bill To</label>
                    <textarea class="form-control" name="bill_to" rows="3" required></textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="desc_inv_no">Description</label>
                    <textarea class="form-control" name="desc_inv_no" rows="3" required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1">
                <label for="item1">Item</label>
                <input type="text" class="form-control" name="item1" required>
            </div>
            <div class="col-sm-4">
                <label for="description1">Description</label>
                <input type="text" class="form-control" name="description1" required>
            </div>
            <div class="col-sm-2">
                <label for="quantity1">Quantity</label>
                <input type="text" class="form-control" name="quantity1" id="quantity1" required>
            </div>
            <div class="col-sm-2">
                <label for="rate1">Rate</label>
                <input type="text" class="form-control" name="rate1" id="rate1" onkeydown="setAmount('amount1','rate1','quantity1')" required>
            </div>
            <div class="col-sm-2">
                <label for="amount1">Amount</label>
                <input type="text" class="form-control" name="amount1" id="amount1" required readonly>
            </div>
        </div>
        <div id="additional">

        </div>
        <button type="button" class="btn btn-primary" onclick="addrow()">Add Item</button>
        <br /><br /><br />


        <button type="submit" class="btn btn-primary" id="submit" onclick="submitData(event)">Generate Invoice</button>
    </form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>