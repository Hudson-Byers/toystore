<?php 

	include 'includes/header.php';

    /*
	 * Retrieve toy information from the database.
	 * 
	 * @param PDO $pdo       An instance of the PDO class.
	 * @param string|null $id     Optional. The ID of a specific toy to retrieve. If null, retrieves all toys.
	 * @return array|null    An associative array containing toy information, or array of toys if no ID provided.
	 */
	function get_toy(PDO $pdo, string $id = null) {
		if ($id) {                                          // If a specific toy ID is provided
			$sql = "SELECT * 
				FROM toy
				WHERE toyID = :id;";
			return pdo($pdo, $sql, ['id' => $id])->fetch();	// Fetch single toy
		} else {                                            // If no ID provided
			$sql = "SELECT * FROM toy;";
			return pdo($pdo, $sql)->fetchAll();             // Fetch all toys
		}
	}

	$toys = get_toy($pdo);                                 // Retrieve all toys from the database
?>


<section class="toy-catalog">


	<?php foreach ($toys as $toy): ?>                  <!-- Loop through each toy in the array -->
    <!-- TOY CARD START -->
    <div class="toy-card">
  	    <a href="toy.php?toynum=<?= $toy['toyID'] ?>">
  			<img src="<?= $toy['img_src'] ?>" alt="<?= $toy['name'] ?>">
  		</a>
  		<h2><?= $toy['name'] ?></h2>
  		<p>$<?= $toy['price'] ?></p>
  	</div>
    <!-- TOY CARD END -->
    <?php endforeach; ?>                               <!-- End of toy loop -->



</section>

<?php include 'includes/footer.php'; ?>
