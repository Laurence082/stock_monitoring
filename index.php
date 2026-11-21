<?php
declare(strict_types=1);

$products = [
    "Gaming Processor (CPU)" => [12500.00, 12],
    "Graphics Card (GPU)" => [18500.00, 5],
    "RAM 16GB DDR4" => [2500.00, 8],
    "SSD 1TB" => [3500.00, 15],
    "Motherboard" => [5500.00, 10],
    "Power Supply 650W" => [3000.00, 18]
];

$tax_rate = 80;
function get_reorder_message(int $stock): string {
    return ($stock < 10) ? "Yes" : "No";
}
function get_total_value(float $price, int $quantity): float {
    return $price * $quantity;
}
function get_tax_due(
    float $price,
    int $quantity,
    int $tax_rate = 0
): float {
    return ($price * $quantity) * ($tax_rate / 100);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Candy Store - Stock Control</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <h1>TECHCORE</h1>
    <p>Computer Parts Inventory System</p>
</header>
<main>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Stock</th>
                <th>Re-order</th>
                <th>Total Value</th>
                <th>Tax Due</th>
            </tr>
        </thead>
          <tbody>

        <?php
$total_inventory = 0;
$total_tax = 0;

foreach ($products as $product_name => $data) {

    $price = $data[0];
    $stock = $data[1];

    $total_value = get_total_value($price, $stock);
    $tax_due = get_tax_due($price, $stock, $tax_rate);

    // Calculate totals
    $total_inventory += $total_value;
    $total_tax += $tax_due;

    echo "<tr>";
    echo "<td>" . htmlspecialchars($product_name) . "</td>";
    echo "<td>" . $stock . "</td>";
    echo "<td>" . get_reorder_message($stock) . "</td>";
    echo "<td>₱" . number_format($total_value, 2) . "</td>";
    echo "<td>₱" . number_format($tax_due, 2) . "</td>";
    echo "</tr>";
}
?>
        </tbody>
    </table>
    <section class="summary">
        <h2>Inventory Summary</h2>
        <p>Total Products: <?= count($products) ?></p>
        <p>Total Stock Value:
            ₱<?= number_format($total_inventory, 2) ?>
        </p>
        <p>Total Tax Due:
            ₱<?= number_format($total_tax, 2) ?>
        </p>
        <p>Tax Rate: <?= $tax_rate ?>%</p>
    </section>
</main>
<footer>
    <p>TECHCORE | STOCK MANAGEMENT SYSTEM</p>
</footer>
</body>
</html>
