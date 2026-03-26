<?php

    include 'includes/header.php';
            
	require_login($logged_in);                              // Redirect user if not logged in
	$username = $_SESSION['username'];                      // Retrieve the username from the session data
    $custID   = $_SESSION['custID'];                        // Retrieve the custID from the session data

    /*
	 * Retrieve all orders for a specific customer from the database.
	 * 
	 * @param PDO $pdo       An instance of the PDO class.
	 * @param int $custID    The customer ID to retrieve orders for.
	 * @return array         An array of associative arrays containing order and toy information.
	 */
	function get_customer_orders(PDO $pdo, int $custID) {
		$sql = "SELECT orders.orderID, orders.custID, orders.toyID, orders.quantity, orders.date_ordered, 
				       orders.deliv_addr, orders.date_deliv, toy.name, toy.img_src
				FROM orders
				JOIN toy ON orders.toyID = toy.toyID
				WHERE orders.custID = :custID
				ORDER BY orders.date_ordered DESC;";
		
		return pdo($pdo, $sql, ['custID' => $custID])->fetchAll();
	}

    /* Call function to retrieve orders for the logged-in user */
	$orders = get_customer_orders($pdo, $custID);

	
?>

<main class="container profile-page">

    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>

    <!-- Check if no orders were returned from the database -->
    <?php if (empty($orders)): ?>
        <div class="no-orders">
            <p>You have no orders yet.</p>
        </div>

    <!-- Otherwise (order data was returned) -->
    <?php else: ?>
        <div class="orders-container">

            <!-- Loop through each order returned from the database -->
            <?php foreach ($orders as $order): ?>

                <div class="order-card">

                    <!-- Display the toy image and update the alt text to the toy name -->
                    <img src="<?= $order['img_src'] ?>" alt="<?= $order['name'] ?>">

                    <div class="order-info">

                        <!-- Display the order number -->
                        <p><strong>Order Number:</strong> <?= $order['orderID'] ?></p>

                        <!-- Display the toy name -->
                        <p><strong>Toy:</strong> <?= $order['name'] ?></p>

                        <!-- Display the order quantity -->
                        <p><strong>Quantity:</strong> <?= $order['quantity'] ?></p>

                        <!-- Display the date ordered -->
                        <p><strong>Date Ordered:</strong> <?= $order['date_ordered'] ?></p>

                        <!-- Display the delivery address -->
                        <p><strong>Delivery Address:</strong> <?= $order['deliv_addr'] ?></p>

                        <!-- Display the delivery date (with null check) -->
                        <p><strong>Delivery Date:</strong> <?= $order['date_deliv'] ?? 'Pending' ?></p>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>