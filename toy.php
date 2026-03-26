<?php

    include 'includes/header.php';

    // Retrieve the value of the 'toynum' parameter from the URL query string
	//          Example URL: .../toy.php?toynum=0001
	$toy_id = $_GET['toynum'];

    /*
	 * Retrieve toy and manufacturer information from the database based on the toy ID.
	 * 
	 * @param PDO $pdo       An instance of the PDO class.
	 * @param string $id     The ID of the toy to retrieve.
	 * @return array|null    An associative array containing toy and manufacturer information.
	 */
	function get_toy_info(PDO $pdo, string $id) {
		$sql = "SELECT toy.toyID, toy.name as toy_name, toy.price, toy.age_range, toy.sold, toy.in_stock, toy.img_src, toy.description, toy.manID,
				        manuf.manID, manuf.name as manufacturer_name, manuf.street, manuf.city, manuf.state, manuf.zip, manuf.phone, manuf.contact
				FROM toy
				JOIN manuf ON toy.manID = manuf.manID
				WHERE toy.toyID = :id;";
		
		return pdo($pdo, $sql, ['id' => $id])->fetch();
	}

    /* Call function to retrieve toy information */
	$toy = get_toy_info($pdo, $toy_id);

?>

<section class="toy-details-page container">
    <div class="toy-details-container">
        <div class="toy-image">

            <!-- Display the toy image and update the alt text to the toy name -->
            <img src="<?= $toy['img_src'] ?>" alt="<?= $toy['toy_name'] ?>">

        </div>

        <div class="toy-details">

            <!-- Display the toy name -->
            <h1><?= $toy['toy_name'] ?></h1>

            <h3>Toy Information</h3>

            <!-- Display the toy description -->
            <p><strong>Description:</strong> <?= $toy['description'] ?></p>

            <!-- Display the toy price -->
            <p><strong>Price:</strong> $ <?= $toy['price'] ?></p>

            <!-- Display the toy age range -->
            <p><strong>Age Range:</strong> <?= $toy['age_range'] ?></p>

            <!-- Display stock of toy -->
            <p><strong>Number In Stock:</strong> <?= $toy['in_stock'] ?></p>

            <br />

            <h3>Manufacturer Information</h3>

            <!-- Display the manufacturer name -->
            <p><strong>Name:</strong> <?= $toy['manufacturer_name'] ?> </p>

            <!-- Display the manufacturer address -->
            <p><strong>Address:</strong> <?= $toy['street'] ?>, <?= $toy['city'] ?>, <?= $toy['state'] ?> <?= $toy['zip'] ?></p>

            <!-- Display the manufacturer phone -->
            <p><strong>Phone:</strong> <?= $toy['phone'] ?></p>

            <!-- Display the manufacturer contact -->
            <p><strong>Contact:</strong> <?= $toy['contact'] ?></p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>