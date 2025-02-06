<?php

    include 'form_services.php';
    $file = "form_data.json";
    $product_name = $num_in_stock = $price_each = '';
    $product_name_err = $num_in_stock_err = $price_each_err = '';
    $catalog = read_catalog($file);

    if(isset($_POST['submit'])) {
        if(empty($_POST['product_name'])) {
            $product_name_err = 'Product Name is required!';
        } else {
            $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(empty($_POST['num_in_stock'])) {
            $num_in_stock_err = 'Quantity in Stock is required!';
        } else {
            $num_in_stock = filter_input(INPUT_POST, 'num_in_stock', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(empty($_POST['price_each'])) {
            $price_each_err = 'Price per Item is required!';
        } else {
            $price_each = filter_input(INPUT_POST, 'price_each', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(empty($product_name_err) && empty($num_in_stock_err) && empty($price_each_err)) {
            $form_entry = ['product_name' => $product_name,
                'num_in_stock' => $num_in_stock,
                'price_each' => $price_each,
                'when_submitted' => date("m/d"),
                'total_value' => $price_each * $num_in_stock];
            add_to_catalog($file, $form_entry);
            header('Location: form.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Online Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <main>
        <h1 class="h1" style="text-align:center; margin-top: 1em; margin-bottom: 1em; background-color:gainsboro; padding: 1em">Your Online Store</h1>
        <section class="container" style="border: 1px solid grey; border-radius: 5px; margin-top: 1em; margin-bottom: 1em">
            <h2 class="h2" style="text-align:center; margin-top: 1em; margin-bottom: 1em">Enter New Product</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name:</label>
                    <input type="text" name="product_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="num_in_stock" class="form-label">Quantity in Stock:</label>
                    <input type="number" min="0" name="num_in_stock" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="price_each" class="form-label">Price per Item:</label>
                    <input type="number" step="0.01" min="0" name="price_each" class="form-control">
                </div>
                <input type="submit" value="Submit" name="submit" class="btn btn-primary" style=" margin-top: 1em; margin-bottom: 1em">
            </form>
        </section>
        <section>
            <h2 class="h2" style="text-align:center; margin-top: 1em; margin-bottom: 1em">Current Catalog</h2>
            <?php if(empty($catalog)): ?>
                <p>The catalog is currently empty</p>
            <?php endif; ?>
            <?php foreach($catalog[0] as $each_product): ?>
                <div class="container" style="border: 1px solid grey; border-radius: 5px; margin-top: 1em; margin-bottom: 1em">
                    <h3 class="h3" style="text-align:center; margin-top: 1em; margin-bottom: 1em"><?php echo $each_product['product_name'] ?></h3>
                    <p>Quantity in Stock: <?php echo $each_product['num_in_stock'] ?></p>
                    <p>Price Each: $<?php echo $each_product['price_each'] ?></p>
                    <p>Total Value: <?php echo $each_product['total_value'] ?></p>
                    <p>Submitted: <?php echo $each_product['when_submitted'] ?></p>
                </div>
            <?php endforeach ?>
        </section>
    </main>
</body>
</html>