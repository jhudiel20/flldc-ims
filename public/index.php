<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FLLDC Applications and Website</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        text-align: center;
    }
    .logo {
        font-size: 2em;
        font-weight: bold;
        color: #0073e6;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 1.5em;
        margin-top: 30px;
        color: #333;
        border-bottom: 1px solid #ccc;
        display: inline-block;
        padding-bottom: 5px;
    }
    .grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }
    .card {
        width: 120px;
        height: 120px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 10px;
        cursor: pointer;
        transition: transform 0.2s;
        text-decoration: none;
        color: inherit;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .card img {
        width: 50px;
        height: 50px;
        margin-bottom: 10px;
    }
    .card p {
        font-size: 0.9em;
        color: #333;
        margin: 0;
    }
</style>
</head>
<body>

<div class="container">
    <div class="logo"><img src="../assets/img/LOGO.png" alt="logo"></div>

    <!-- People Section -->
    <!-- <div class="section-title">People</div>
    <div class="grid">
        <a href="https://ontime.example.com" class="card" target="_blank">
            <img src="ontime-icon.png" alt="Ontime">
            <p>Ontime</p>
        </a>
        <a href="https://coaching.example.com" class="card" target="_blank">
            <img src="coaching-icon.png" alt="Coaching Online">
            <p>Coaching Online</p>
        </a>
        <a href="https://inlieu.example.com" class="card" target="_blank">
            <img src="inlieu-icon.png" alt="InLieu">
            <p>InLieu</p>
        </a>
        <a href="https://pms.example.com" class="card" target="_blank">
            <img src="pms-icon.png" alt="PMS">
            <p>PMS</p>
        </a>
    </div> -->

    <!-- Tools Section -->
    <div class="section-title">Tools</div>
    <div class="grid">
        <a href="/system-login" class="card" target="_blank">
            <img src="../assets/img/LOGO.png" alt="flldc-ims-app">
            <p>Learning and Development Inventory Management System</p>
        </a>
        <a href="https://flldc-booking-app.vercel.app/" class="card" target="_blank">
            <img src="../assets/img/LOGO.png" alt="flldc-booking-app">
            <p>Learning and Development Booking Application</p>
        </a>
        <a href="https://flldc-ims.vercel.app/reservation" class="card" target="_blank">
            <img src="../assets/img/LOGO.png" alt="flldc-reserved-calendar">
            <p>Reserved Room Calendar</p>
        </a>
    </div>
</div>

</body>
</html>
