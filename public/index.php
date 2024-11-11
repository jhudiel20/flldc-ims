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
    .logo img {
        width: 100px;
        height: auto;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 1.8em;
        color: #333;
        border-bottom: 2px solid #ccc;
        display: inline-block;
        padding-bottom: 8px;
        margin-top: 30px;
        margin-bottom: 20px;
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
        height: 140px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 15px;
        cursor: pointer;
        transition: transform 0.3s ease, background-color 0.3s ease;
        text-decoration: none;
        color: inherit;
    }
    .card:hover {
        transform: scale(1.05);
        background-color: #0073e6;
        color: #fff;
    }
    .card img {
        width: 60px;
        height: 60px;
        margin-bottom: 10px;
    }
    .card p {
        font-size: 0.9em;
        margin: 0;
    }
    @media (max-width: 768px) {
        .grid {
            flex-direction: column;
            align-items: center;
        }
        .card {
            width: 80%;
            height: auto;
            padding: 20px;
        }
    }
</style>
</head>
<body>

<div class="container">
    <div class="logo"><img src="../assets/img/LOGO.png" alt="FLLDC Logo"></div>

    <!-- Tools Section -->
    <div class="section-title">Tools</div>
    <div class="grid">
        <a href="/system-login" class="card" target="_blank" title="Access FLLDC IMS">
            <img src="../assets/img/LOGO.png" alt="FLLDC IMS App">
            <p>FLLDC IMS</p>
        </a>
        <a href="https://flldc-booking-app.vercel.app/" class="card" target="_blank" title="Visit FLLDC Booking Website">
            <img src="../assets/img/LOGO.png" alt="FLLDC Booking App">
            <p>FLLDC Booking Website</p>
        </a>
        <a href="https://flldc-ims.vercel.app/reservation" class="card" target="_blank" title="View Reserved Room Calendar">
            <img src="../assets/img/LOGO.png" alt="FLLDC Reserved Calendar">
            <p>Reserved Room Calendar</p>
        </a>
    </div>
</div>

</body>
</html>
