<?php require "head.php" ?>

<body>
    <div class="wrapper">
        <div class="main">
            <form method="post" id="product_form" action="index.php?action=add">

                <header class="header">
                    <div class="container">
                        <div class="header-block">
                            <p class="header-block__name-page">Product Add</p>
                            <div class="header-block__buttons">
                                <button class="header-block__btn btn__primary" id="save" type="submit">
                                    Save
                                </button>
                                <a class="header-block__btn btn__secondary" id="cancel" href="index.php">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </header>

                <main>
                    <div class="container">
                        <div class="main-block">
                            <div class="input-box">
                                <div class="input">
                                    <label class="input__label" for="sku">SKU</label>
                                    <input class="input__field" name="sku" id="sku" type="text" maxlength="30" placeholder="max 30 symbols" required />
                                </div>
                                <div class="input">
                                    <label class="input__label" for="name">Name</label>
                                    <input class="input__field" name="name" id="name" type="text" maxlength="30" placeholder="max 30 symbols" required />
                                </div>
                                <div class="input">
                                    <label class="input__label" for="price">Price ($)</label>
                                    <input class="input__field" name="price" id="price" type="number" step="any" min="0" required />
                                </div>
                                <div class="input">
                                    <label class="input__label" for="productType">Type Switcher
                                    </label>
                                    <select class="input__field" id="productType" required>
                                        <option id="DVD">DVD</option>
                                        <option id="Book">Book</option>
                                        <option id="Furniture">Furniture</option>
                                    </select>
                                </div>

                                <div id="xinfo"></div>

                                <?php
                                if (isset($_GET['action'])) {
                                    if ($_GET['action'] == "skualert") {
                                        echo "<p class='skualert'>Please provide a unique SKU for the new product.</p>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </main>

            </form>
        </div>
        <script>
            // Dynamic Inputs

            var sku = document.getElementById("sku");
            var name = document.getElementById("name");
            var price = document.getElementById("price");
            var save = document.getElementById("save");
            var productType = document.getElementById("productType");
            var container = document.getElementById("xinfo");

            var DVD = {
                params: ["Size"],
                l: 1,
                desc: "Please, provide size in megabytes.",
                pt: 1,
            };
            var Book = {
                params: ["Weight"],
                l: 1,
                desc: "Please, provide weight in kilograms.",
                pt: 2,
            };
            var Furniture = {
                params: ["Height", "Width", "Length"],
                l: 3,
                desc: "Please, provide dimensions in HxWxL format.",
                pt: 3,
            };

            function extraParams() {
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild); // remove old inputs
                }
                for (var i = 0; i < window[productType.value].l; i++) { // add new inputs
                    var cont = document.createElement("div");
                    cont.setAttribute("class", "inner");

                    var contMain = document.getElementById("xinfo");

                    var lbl = document.createElement("label");
                    lbl.setAttribute("class", "input__label");
                    lbl.for = window[productType.value].params[i];
                    lbl.innerHTML = window[productType.value].params[i];

                    var inp = document.createElement("input");
                    inp.setAttribute("type", "number");
                    inp.setAttribute("name", window[productType.value].params[i]);
                    inp.setAttribute("class", "input__field");
                    inp.setAttribute("required", true);
                    inp.setAttribute("step", "any");
                    inp.setAttribute("min", "0");

                    cont.appendChild(lbl);
                    cont.appendChild(inp);

                    contMain.appendChild(cont);
                }
                var desc = document.createElement("p");
                desc.setAttribute("class", "desc");
                desc.innerHTML = window[productType.value].desc;
                container.appendChild(desc);

                var pt = document.createElement("input");
                pt.value = window[productType.value].pt;
                pt.setAttribute("type", "hidden");
                pt.setAttribute("name", "productType");
                container.appendChild(pt);
            }

            extraParams();
            productType.addEventListener("change", function() {
                extraParams();
            });
        </script>
        <?php require "footer.php" ?>