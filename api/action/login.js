const crypto = require('crypto');
const { Pool } = require("pg");

const pool = new Pool({ connectionString: process.env.POSTGRES_URL });

module.exports = async (req, res) => {
    if (req.method !== "POST") {
        return res.status(405).json({ success: false, error: "Method Not Allowed" });
    }

    try {
        let body = "";
        req.on("data", (chunk) => (body += chunk));
        await new Promise((resolve) => req.on("end", resolve));

        const { email, password, recaptchaResponse, userType } = JSON.parse(body);

        if (!email || !password || !recaptchaResponse || !userType) {
            return res.status(400).json({ success: false, error: "All fields are required, including reCAPTCHA." });
        }

        return await handleAdminLogin(email, password, res);
    } catch (error) {
        console.error("Error handling authentication:", error);
        return res.status(500).json({ success: false, error: "Server error", details: error.message });
    }
};

// Encryption Setup
const cipherMethod = 'aes-256-cbc';
const encryptionKey = process.env.ENCRYPTION_KEY || "default_secure_key";
const key = crypto.createHash('sha256').update(encryptionKey).digest();

function encrypt_cookie(data) {
    const iv = crypto.randomBytes(16);
    const cipher = crypto.createCipheriv(cipherMethod, key, iv);
    const serializedData = JSON.stringify(data);

    let encrypted = cipher.update(serializedData, 'utf8', 'base64');
    encrypted += cipher.final('base64');

    return Buffer.concat([iv, Buffer.from(encrypted, 'base64')]).toString('base64');
}

function setPassword(text) {
    return text.trim() !== "" ? crypto.createHash('sha1').update(text + encryptionKey).digest('hex') : '';
}

// **Handle Admin Login**
const handleAdminLogin = async (email, password, res) => {
    try {
        const hashedpassword = setPassword(password);

        const userRes = await pool.query("SELECT * FROM user_account WHERE username = $1", [email]);
        const user = userRes.rows[0];

        if (!user || user.password !== hashedpassword) {
            return res.status(401).json({ success: false, error: "Invalid username or password." });
        }

        if (user.approved_status === 1) {
            return res.status(403).json({ success: false, error: "Administrator rejected your registration." });
        }

        if (user.locked === 3 && user.access !== 'ADMIN') {
            return res.status(403).json({ success: false, error: "Account locked. Contact admin." });
        }

        const cookieData = {
            status: true,
            ID: user.id,
            ACCESS: user.access,
            USERNAME: user.username,
            DATE_CREATED: user.date_created,
            FNAME: user.fname,
            MNAME: user.mname,
            LNAME: user.lname,
            EMAIL: user.email,
            IMAGE: user.image,
            LOCKED: user.locked,
            ADMIN_STATUS: user.admin_status,
            RESERVATION_ACCESS: user.reservation_access
        };

        const encryptedValue = encrypt_cookie(cookieData);

        res.setHeader("Set-Cookie", [
            `secure_data=${encryptedValue}; Path=/; Domain=flldc-ims.vercel.app; HttpOnly; Secure; SameSite=Strict; Max-Age=1800`
        ]);

        await pool.query("INSERT INTO logs (USER_ID, ACTION_MADE) VALUES ($1, $2)", [user.id, "Logged in the system."]);
        await pool.query("UPDATE user_account SET status = '1', locked = '0' WHERE id = $1", [user.id]);

        return res.status(200).json({ success: true, redirectUrl: "/dashboard-lnd" });
    } catch (error) {
        console.error("Database Error:", error);
        return res.status(500).json({ success: false, error: "Database error", details: error.message });
    }
};
