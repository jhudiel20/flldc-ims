<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FLLDC Applications and Website</title>
<style>
    /* Basic Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: Arial, sans-serif;
        background-color: #fafafa;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .container {
        text-align: center;
        padding: 40px;
        max-width: 900px;
    }
    .logo img {
        width: 120px;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 1.8em;
        font-weight: 600;
        color: #0073e6;
        margin: 30px 0;
    }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 30px;
        margin-top: 20px;
    }
    .app-link {
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .app-link:hover {
        transform: scale(1.05);
        color: #0073e6;
    }
    .app-link img {
        width: 60px;
        height: 60px;
        margin-bottom: 8px;
        filter: grayscale(80%);
        transition: filter 0.3s ease;
    }
    .app-link:hover img {
        filter: grayscale(0%);
    }
    .app-link p {
        font-size: 0.9em;
        font-weight: 500;
        color: #555;
    }
</style>
</head>
<body>

<div class="container">
    <div class="logo">
        <img src="../assets/img/LOGO.png" alt="logo">
    </div>

    <!-- Tools Section -->
    <div class="section-title">Tools</div>
    <div class="grid">
        <a href="/system-login" class="app-link" target="_blank">
            <img src="../assets/img/LOGO.png" alt="FLLDC IMS">
            <p>FLLDC IMS</p>
        </a>
        <a href="https://flldc-booking-app.vercel.app/" class="app-link" target="_blank">
            <img src="../assets/img/LOGO.png" alt="FLLDC Booking Website">
            <p>FLLDC Booking Website</p>
        </a>
        <a href="https://flldc-ims.vercel.app/reservation" class="app-link" target="_blank">
            <img src="../assets/img/LOGO.png" alt="Reserved Room Calendar">
            <p>Reserved Room Calendar</p>
        </a>
    </div>
</div>

</body>
</html>
