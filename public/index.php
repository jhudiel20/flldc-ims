<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FLLDC Applications and Website</title>
<style>
    /* Modern Dark Theme */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #121212;
        color: #E1E1E1;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        text-align: center;
    }
    .logo img {
        width: 150px;
        height: auto;
        margin-bottom: 30px;
        filter: drop-shadow(0 0 10px rgba(0, 255, 255, 0.5));
    }
    .section-title {
        font-size: 2.5em;
        color: #00bcd4;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 60px 0 30px;
        position: relative;
    }
    .section-title::after {
        content: "";
        display: block;
        width: 100px;
        height: 2px;
        background: #00bcd4;
        margin: 8px auto 0;
    }
    .grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 40px;
    }
    .card {
        width: 280px;
        height: 280px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.6), 0 0 20px rgba(0, 255, 255, 0.5);
        text-align: center;
        padding: 20px;
        cursor: pointer;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        text-decoration: none;
        color: #E1E1E1;
        overflow: hidden;
        position: relative;
    }
    .card:hover {
        transform: translateY(-12px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.7), 0 0 30px rgba(0, 255, 255, 0.7);
        background: rgba(0, 188, 212, 0.2);
    }
    .card img {
        width: 80px;
        height: 80px;
        margin-bottom: 15px;
        filter: drop-shadow(0 0 8px rgba(0, 255, 255, 0.5));
        transition: transform 0.4s ease;
        object-fit: contain;
    }
    .card:hover img {
        transform: scale(1.2);
    }
    .card p {
        font-size: 1.1em;
        color: #E1E1E1;
        margin-top: 15px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .card::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 300%;
        height: 300%;
        background: radial-gradient(circle, rgba(0, 188, 212, 0.25), transparent);
        transition: opacity 0.4s ease;
        opacity: 0;
        transform: translate(-50%, -50%);
        z-index: 0;
    }
    .card:hover::before {
        opacity: 1;
    }
    @media (max-width: 768px) {
        .grid {
            flex-direction: column;
            align-items: center;
        }
        .card {
            width: 90%;
            height: auto;
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
