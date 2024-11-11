<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FLLDC Applications and Website</title>
<style>
    /* High-Tech Dark Mode Theme */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #0e0e0e;
        color: #d1d1d1;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
        text-align: center;
    }
    .logo img {
        width: 120px;
        height: auto;
        margin-bottom: 20px;
        filter: drop-shadow(0 0 8px #00e6e6);
    }
    .section-title {
        font-size: 2em;
        color: #00e6e6;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 40px 0 20px;
        position: relative;
    }
    .section-title::after {
        content: "";
        display: block;
        width: 80px;
        height: 2px;
        background: #00e6e6;
        margin: 8px auto 0;
    }
    .grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
    }
    .card {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5), 0 0 15px #00e6e6;
        text-align: center;
        padding: 20px 10px;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: #d1d1d1;
        overflow: hidden;
        position: relative;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.7), 0 0 20px #00e6e6;
        background: rgba(0, 230, 230, 0.15);
    }
    .card img {
        width: 60px;
        height: 60px;
        filter: drop-shadow(0 0 5px #00e6e6);
        transition: transform 0.3s ease;
        object-fit: contain; /* Ensures image maintains its aspect ratio */
    }
    .card:hover img {
        transform: scale(1.1);
    }
    .card p {
        font-size: 0.5rem;
        color: #d1d1d1;
        margin-top: 10px;
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
        background: radial-gradient(circle, rgba(0, 230, 230, 0.2), transparent);
        transition: opacity 0.3s ease;
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
            width: 80%;
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
        <a href="" class="card" target="_blank" title="Visit FLLDC Booking Website">
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
