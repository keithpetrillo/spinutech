<?php
/**
 * Instructions:
 * 1) We need 5 circles in a row. They should be in the following order. Red, Green, Blue, Orange and Yellow.
 * 2) When they are hovered, text should appear under the icon that states what the color is and all other Icons in
 * the row should fade out to a 50% opacity.
 * 3) Once the icon is clicked it should appear in a row below the original row and become a square.
 * 4) When it is hovered, it should have the same effect as the circles. State the color above the icon and fade out
 * the other icons in the row.
 * 5) When a square is clicked, the square should become a circle and be placed first in the circle row.
 * 6) Page should be responsive, have a black background except when viewing on mobile, background should be white
 * 7) Open Sans font should be used
 * 8) The site title should be your name and date
 * 9) Center content and code should be commented
 * 10) Use any libraries you are comfortable with, just list them on the page after the circles and squares in a
 * “Made with” section.
 *
 *
 * General notes:
 * - I could have made this without PHP, but where's the fun in that?
 * - I'm inlining styles from Tailwind for this demo, but normally would use a stylesheet include
 * - The instructions didn't explicitly say remove from the top row when moving, I made an assumption, but I would have
 * typically asked for clarification
 */
$colors = [
    "red" => [
        "label" => "Red",
        "color" => "bg-red-500",
    ],
    "green" => [
        "label" => "Green",
        "color" => "bg-green-500",
    ],
    "blue" => [
        "label" => "Blue",
        "color" => "bg-blue-500",
    ],
    "orange" => [
        "label" => "Orange",
        "color" => "bg-orange-500",
    ],
    "yellow" => [
        "label" => "Yellow",
        "color" => "bg-yellow-500",
    ],
]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Keith Petrillo - <?= date("d/m/y") ?></title>

    <!-- I use PostCSS or SCSS/SASS or Tailwind's package manage for use of directives -->
    <style>
        h1, h2, h3, h4, h5, h6, p, li, span {
            font-family: "Open Sans", sans-serif
        }

        #circles .item .item--icon {
            border-radius: 9999px
        }

        .item {
            flex-direction: column
        }

        .item .item--label {
            opacity: 0
        }

        .item:hover > .item--label {
            opacity: 1
        }

        /*
        I"ve been geeking about this! The :has() selector is relatively new, but is well supported:
        https://developer.mozilla.org/en-US/docs/Web/CSS/:has#browser_compatibility

        In the past, this was only possible through JS
        */
        #circles:has(> :hover) .item:not(:hover),
        #squares:has(> :hover) .item:not(:hover){
            opacity: .5
        }

        #squares .item {
            flex-direction: column-reverse
        }
    </style>
</head>
<body class="p-8 md:bg-black">
<div class="max-w-screen-md mx-auto">
    <div id="circles" class="grid grid-cols-1 md:grid-cols-5"> <!-- Normally, I would count() the total objects -->
        <?php foreach ($colors as $index => $value) : ?>
            <div class="item flex items-center">
                <span class="item--icon transition w-12 h-12 my-4 block <?= $value["color"] ?>"></span>
                <span class="item--label md:text-white transition block"><?= $value["label"] ?></span>
            </div>
        <?php endforeach ?>
    </div>

    <div id="squares" class="grid grid-cols-1 md:grid-cols-5"></div>

    <div class="mt-8">
        <p class="text-center md:text-white">
            Made with Tailwind CSS
        </p>
    </div>
</div>

<script type="application/javascript">
    window.addEventListener("load", function () {
        const circles = document.querySelectorAll("#circles .item")
        const squares = document.querySelector("#squares")

        // Attach click event listeners to circles
        circles.forEach(circle => {
            circle.addEventListener("click", function () {
                moveToSquares(circle)
            })
        })

        squares.addEventListener("click", function (e) {
            // Don't move if outer item is clicked
            if (e.target.classList.contains("item")) {
                return
            }

            moveToCircles(e.target.parentNode)
        })
    })

    function moveToSquares(circle) {
        // Remove the circle from the circles container
        circle.parentNode.removeChild(circle)

        // Add the circle to the squares container
        document.getElementById("squares").appendChild(circle)
    }

    function moveToCircles(square) {
        // Remove the square from the squares container
        square.parentNode.removeChild(square)

        // Add the square back to the circles container as the first child
        const circlesContainer = document.querySelector("#circles")
        const firstCircle = circlesContainer.firstChild
        circlesContainer.insertBefore(square, firstCircle)
    }
</script>
</body>
</html>
