<?php require "head.php" ?>

<?php
if (isset($_POST['deletecheckbox'])) {
    if (isset($_GET['action']) && $_GET['action'] == "delete") {
        foreach ($_POST['deletecheckbox'] as $chkval) {
            $sql_d = "DELETE FROM products WHERE id = " . $chkval;
            $q_d = mysqli_query($conn, $sql_d);
            header("Location: index.php");
        }
    }
}
?>

<body>
    <div class="wrapper">
        <header>
            <form method='post' action='?action=delete'>
                <div class="container">
                    <div class="header-block">
                        <p class="header-block__name-page">Product List</p>
                        <div class="header-block__buttons">
                            <a class="header-block__btn btn__primary" href="addproduct.php" id="add-product-btn">ADD</a>
                            <button class="header-block__btn btn__secondary" id="delete-product-btn" type="submit">
                                MASS DELETE
                            </button>
                        </div>
                    </div>
                </div>
        </header>

        <main class="main">
            <div class="container">
                <div class="cards-container">
                    <div class="main-block">
                        <?php
                        abstract class Product
                        {
                            public $id;
                            public $sku;
                            public $name;
                            public $price;

                            public function __construct($id, $sku, $name, $price)
                            {
                                $this->id = $id;
                                $this->sku = $sku;
                                $this->name = $name;
                                $this->price = $price;
                            }
                            public function param()
                            {
                                echo "<div class='card'>";
                                echo "<div class='checkbox'>";
                                echo "<input id=$this->id type='checkbox' name='deletecheckbox[]' value='" . $this->id . "' class='delete-checkbox'/>";
                                echo "<label class='checkbox-label' for=$this->id>✓</label>";
                                echo "</div>";
                                echo "<div class='card__content'>";
                                echo "<p class='card__sku'>$this->sku</p>";
                                echo "<p class='card__name'>$this->name</p>";
                                echo "<p class='card__price'>$this->price$</p>";

                                array_push($_SESSION['skus'], $this->sku);
                            }
                        }
                        class Dvd extends Product
                        {
                            public $size;

                            public function __construct($id, $sku, $name, $price, $size)
                            {
                                $this->id = $id;
                                $this->sku = $sku;
                                $this->name = $name;
                                $this->price = $price;
                                $this->size = $size;
                            }
                            public function param()
                            {
                                parent::param();
                                echo "<p class='card__attribute'>Size: $this->size MB</p></div></div>";
                            }
                        }
                        class Book extends Product
                        {
                            public $weight;

                            public function __construct($id, $sku, $name, $price, $weight)
                            {
                                $this->id = $id;
                                $this->sku = $sku;
                                $this->name = $name;
                                $this->price = $price;
                                $this->weight = $weight;
                            }
                            public function param()
                            {
                                parent::param();
                                echo "<p class='card__attribute'>Weight: $this->weight KG</p></div></div>";
                            }
                        }
                        class Furniture extends Product
                        {
                            public $height;
                            public $width;
                            public $weight;

                            public function __construct($id, $sku, $name, $price, $height, $width, $length)
                            {
                                $this->id = $id;
                                $this->sku = $sku;
                                $this->name = $name;
                                $this->price = $price;
                                $this->height = $height;
                                $this->width = $width;
                                $this->length = $length;
                            }
                            public function param()
                            {
                                parent::param();
                                echo "<p class='card__attribute'>Dimensions: $this->height x $this->width x $this->length</p></div></div>";
                            }
                        }

                        $sql1 = "SELECT `id`, `sku`, `name`, `price`, `size`, `weight`, `height`, `width`, `length` FROM `products` where product_type=1";
                        $sql2 = "SELECT `id`, `sku`, `name`, `price`, `size`, `weight`, `height`, `width`, `length` FROM `products` where product_type=2";
                        $sql3 = "SELECT `id`, `sku`, `name`, `price`, `size`, `weight`, `height`, `width`, `length` FROM `products` where product_type=3";
                        $q1 = mysqli_query($conn, $sql1);
                        $q2 = mysqli_query($conn, $sql2);
                        $q3 = mysqli_query($conn, $sql3);
                        while ($row = mysqli_fetch_array($q1)) {
                            $dvd = new Dvd($row['id'], $row['sku'], $row['name'], $row['price'], $row['size']);
                            $dvd->param();
                        }
                        while ($row = mysqli_fetch_array($q2)) {
                            $book = new Book($row['id'], $row['sku'], $row['name'], $row['price'], $row['weight']);
                            $book->param();
                        }
                        while ($row = mysqli_fetch_array($q3)) {
                            $fntr = new Furniture($row['id'], $row['sku'], $row['name'], $row['price'], $row['height'], $row['width'], $row['length']);
                            $fntr->param();
                        }

                        function replaceNull($var)
                        {
                            if (!isset($_POST[$var])) {
                                return 'null';
                            } else {
                                return $_POST[$var];
                            }
                        }

                        if (isset($_GET['action'])) {
                            if ($_GET['action'] == "add") {
                                if (in_array($_POST['sku'], $_SESSION['skus'])) {
                                    echo '<script>location.replace("addproduct.php?action=skualert");</script>';
                                    exit;
                                    die();
                                } else {
                                    $sqlq = "INSERT INTO `products`(`sku`, `name`, `price`, `size`, `weight`, `height`, `width`, `length`, `product_type`) 
                            VALUES ('" . $_POST['sku'] . "', '" . $_POST['name'] . "', " . $_POST['price'] . ", " . replaceNull('Size') . ", " . replaceNull('Weight') . ", " . replaceNull('Height') . ", " . replaceNull('Width') . ", " . replaceNull('Length') . ", " . $_POST['productType'] . ")";
                                    $q_d = mysqli_query($conn, $sqlq);
                                    echo '<script>location.replace("index.php");</script>';
                                    exit;
                                }
                            }
                        }
                        ?>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <?php require "footer.php" ?>