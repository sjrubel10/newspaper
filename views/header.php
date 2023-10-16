<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Prothom Alo</title>
</head>
<body>
<div class="header">
    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="Prothom Alo Logo">
        </div>
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="#">প্রথম পাতা</a></li>
                <li><a href="#">বাংলাদেশ</a></li>
                <li><a href="#">আন্তর্জাতিক</a></li>
                <li><a href="#">অর্থনীতি</a></li>
                <li><a href="#">বিনোদন</a></li>
                <li><a href="#">খেলা</a></li>
                <li><a href="#">মতামত</a></li>
            </ul>
        </nav>
        <div class="search">
            <input type="text" placeholder="অনুসন্ধান করুন">
            <button>অনুসন্ধান</button>
        </div>
    </div>
</div>

<!-- Rest of your website content goes here -->

<script src="script.js"></script>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuToggle = document.querySelector(".menu-toggle");
        const menu = document.querySelector(".menu ul");

        menuToggle.addEventListener("click", function() {
            menu.classList.toggle("show");
        });
    });

</script>
