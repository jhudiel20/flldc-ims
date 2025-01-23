<?php
// $url =  base_url();
// define("BASE_URL",$url);
define('BASE_URL', $_ENV['BASE_URL'] ?? 'https://flldc-ims.vercel.app/');
define("DOMAIN_PATH", dirname(__DIR__));
define('FILE_VERSION', '1.1.3');
define('PAGE_TITLE', 'FAST LDIMS');
define('FOOTER_PATH' , DOMAIN_PATH.'/action/global/footer.php');
define('DATE_PATH' , DOMAIN_PATH.'/action/global/date.php');


define('VACCINE', array('Pfizer-BioN Tech','Oxford-AstraZeneca','Sinovac','Moderna','Johnson and johnsons Janssen','Gamaleya Sputnik V','Bharat BioTeck','Sinopharm'));
define('VAC_INFO', array('Fully Vaccinated','Partially Vaccinated','Not Vaccinated'));

define('g_cipher','aes-256-cbc');
define('g_key','qwertyuiopasdfghjklzxcvbnm1234567890johnjhudieljoycediannemnbvcxzlkjhgfdsapoiuytrewq0987654321diannejoycejohnjhudiel1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0pp0lo9ki8mju7nhy6bgt5vfr4cde3xsw2zaq1');
define('SALT', 'qwertyuiopasdfghjklzxcvbnm1234567890johnjhudieljoycediannemnbvcxzlkjhgfdsapoiuytrewq0987654321diannejoycejohnjhudiel1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0pp0lo9ki8mju7nhy6bgt5vfr4cde3xsw2zaq1');

define('PAYGROUP', array('ASSOCIATE','PROTECH','SUPERVISOR','MANAGER','EXECUTIVE'));
define('SBU', array('FAST SERVICES CORPORATION','FAST LOGISTICS CORPORATION','FAST COLDCHAIN SOLUTION INC.','FAST TOLL MANUFACTURING CORPORATION','FAST UNIMERCHANTS INC.','FAST DISTRIBUTION CORPORATION'));

define('PR_STATUS', array('PENDING','CANCEL','COMPLETED'));
define('RESERVE_STATUS', array('PENDING','DECLINED','APPROVED'));
// define('MODE OF PAYMENT', array('Category','Subcategory'));
define('UNIT', array('packs','pcs','milligram','kilogram','ounce','litre'));
// define('UNIT', array('meter','kilometer','centimeter','millimeter','feet','yard','inch','mile','gram','milligram','kilogram','ounce','pound'
// ,'ton','litre','millilitre','kilolitre','gallon','pint','fluid ounce','packs','pcs'));
define('TRANSAC_STATUS', array('Pending','Delivered'));
define('CLASSES', array('Category','Subcategory'));
define('GENDER', array('Male','Female'));
define('ROLE', array('Manager','Cashier','Inventory Clerk','Sales Employee'));
define('is_digit','/^[0-9]+$/');
define('is_letter','/^[a-z A-Z]+$/');
define('is_date','/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/');
define('format','/^(19|20)\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/');
define('date','/^d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/');
define('FISCAL','/^[0-9]{4}-[0-9]{4}$/');
define('BIRTHDAY','/^(19|20)\d{2}\/([1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])$/');
define('BARANGAY', array('Barangay 1','Barangay 2','Barangay 3','Barangay 4','Barangay 5','Barangay 6','Barangay 7','Bagong Kalsada','Bañadero','Banlic','Barandal','Batino','Bubuyan','Bucal','Bunggo','Burol','Camaligan','Canlubang','Halang','Hornalan','Kay-Anlog','Laguerta','La Mesa','Lawa','Lecheria','Lingga','Looc','Mabato','Majada-Labas','Makiling','Mapagong','Masili','Maunong','Mayapa','Milagrosa','Paciano Rizal','Palingon','Palo-Alto','Pansol','Parian','Prinza','Punta','Puting Lupa','Real','Saimsim','Sampiruhan','Sirang Lupa','San Cristobal','San Jose','San Juan','Sucol','Turbina','Uwisan'));


define('LD', array('Technical Operation','Technical Support','Foundational','Health and Wellness','Leadership/Managerial'));
define('ACCESS', array('ADMIN','ENCODER','REQUESTOR','GUARD'));
define('STATUS_WORK', array('PERMANENT','JOB ORDER'));
define('GOV_SERVICE', array('YES','NO'));
define('STATUS', array('Permanent','Casual','Temporary','Contractual'));
define('CIVIL', array('SINGLE','WIDOWED','MARRIED','SEPERATED'));
define('CITIZEN', array('FILIPINO','DUAL CITIZENSHIP'));
define('BLOOD', array('O+','O-','A+','A-','B+','B-','AB+','AB-'));
define('OFFICE', array('',
'REGIONAL OFFICE',
'PENRO BATANGAS',
'CENRO CALACA, BATANGAS',
'CENRO LIPA CITY, BATANGAS',
'PENRO CAVITE',
'PENRO RIZAL',
'PENRO QUEZON',
'PENRO LAGUNA', 
'CENRO STA. CRUZ, LAGUNA',
'CENRO TAYABAS',
'CENRO REAL',
'CENRO CATANAUAN',
'CENRO CALAUAG',
'CENRO PAGSANJAN, LAGUNA'));
define('SECTION', array('',
'ADMINISTRATIVE DIVISION',
'ADMINISTRATIVE UNIT',
'CONSERVATION AND DEVELOPMENT DIVISION',
'CONSERVATION AND DEVELOPMENT SECTION',
'ENFORCEMENT DIVISION',
'FINANCE DIVISION',
'LEGAL DIVISION',
'LICENSES, PATENTS AND DEEDS DIVISION',
'MANAGEMENT SERVICES DIVISION',
'MONITORING AND ENFORCEMENT SECTION',
'OFFICE OF THE REGIONAL EXECUTIVE DIRECTOR',
'PLANNING AND MANAGEMENT DIVISION',
'PLANNING AND SUPPORT UNIT',
'REGIONAL STRATEGIC COMMUNICATION AND INITIATIVES GROUP',
'REGULATION AND PERMITTING SECTION',
'SURVEYS AND MAPPING DIVISION',
'TECHNICAL SERVICES DIVISION'));

define('COUNTRY', array('',
'Afghanistan',
'Albania',
'Algeria',
'Andorra',
'Angola',
'Antigua and Barbuda',
'Argentina',
'Armenia',
'Austria',
'Azerbaijan',
'Bahrain',
'Bangladesh',
'Barbados',
'Belarus',
'Belgium',
'Belize',
'Benin',
'Bhutan',
'Bolivia',
'Bosnia and Herzegovina',
'Botswana',
'Brazil',
'Brunei',
'Bulgaria',
'Burkina Faso',
'Burundi',
'Cabo Verde',
'Cambodia',
'Cameroon',
'Canada',
'Central African Republic',
'Chad',
'Channel Islands',
'Chile',
'China',
'Colombia',
'Comoros',
'Congo',
'Costa Rica',
'Côte d Ivoire',
'Croatia',
'Cuba',
'Cyprus',
'Czech Republic',
'Denmark',
'Djibouti',
'Dominica',
'Dominican Republic',
'DR Congo',
'Ecuador',
'Egypt',
'El Salvador',
'Equatorial Guinea',
'Eritrea',
'Estonia',
'Eswatini',
'Ethiopia',
'Faeroe Islands',
'Finland',
'France',
'French Guiana',
'Gabon',
'Gambia',
'Georgia',
'Germany',
'Ghana',
'Gibraltar',
'Greece',
'Grenada',
'Guatemala',
'Guinea',
'Guinea-Bissau',
'Guyana',
'Haiti',
'Holy See',
'Honduras',
'Hong Kong',
'Hungary',
'Iceland',
'India',
'Indonesia',
'Iran',
'Iraq',
'Ireland',
'Isle of Man',
'Israel',
'Italy',
'Jamaica',
'Japan',
'Jordan',
'Kazakhstan',
'Kenya',
'Kuwait',
'Kyrgyzstan',
'Laos',
'Latvia',
'Lebanon',
'Lesotho',
'Liberia',
'Libya',
'Liechtenstein',
'Lithuania',
'Luxembourg',
'Macao',
'Madagascar',
'Malawi',
'Malaysia',
'Maldives',
'Mali',
'Malta',
'Mauritania',
'Mauritius',
'Mayotte',
'Mexico',
'Moldova',
'Monaco',
'Mongolia',
'Montenegro',
'Morocco',
'Mozambique',
'Myanmar',
'Namibia',
'Nepal',
'Netherlands',
'Nicaragua',
'Niger',
'Nigeria',
'North Korea',
'North Macedonia',
'Norway',
'Oman',
'Pakistan',
'Panama',
'Paraguay',
'Peru',
'Philippines',
'Poland',
'Portugal',
'Qatar',
'Réunion',
'Romania',
'Russia',
'Rwanda',
'Saint Helena',
'Saint Kitts and Nevis',
'Saint Lucia',
'Saint Vincent and the Grenadines',
'San Marino',
'Sao Tome & Principe',
'Saudi Arabia',
'Senegal',
'Serbia',
'Seychelles',
'Sierra Leone',
'Singapore',
'Slovakia',
'Slovenia',
'Somalia',
'South Africa',
'South Korea',
'South Sudan',
'Spain',
'Sri Lanka',
'State of Palestine',
'Sudan',
'Suriname',
'Sweden',
'Switzerland',
'Syria',
'Taiwan',
'Tajikistan',
'Tanzania',
'Thailand',
'The Bahamas',
'Timor-Leste',
'Togo',
'Trinidad and Tobago',
'Tunisia',
'Turkey',
'Turkmenistan',
'Uganda',
'Ukraine',
'United Arab Emirates',
'United Kingdom',
'United States',
'Uruguay',
'Uzbekistan',
'Venezuela',
'Vietnam',
'Western Sahara',
'Yemen',
'Zambia',
'Zimbabwe'

));



function response(){
  array(
    'success' => false,
    'message' => 'Unknown error',
    'title' => 'SOMETHING WENT WRONG!'
  );
}



$cipher_method = 'AES-256-CBC';
$encryption_key = 'qwertyuiopasdfghjklzxcvbnm1234567890johnjhudieljoycediannemnbvcxzlkjhgfdsapoiuytrewq0987654321diannejoycejohnjhudiel1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0pp0lo9ki8mju7nhy6bgt5vfr4cde3xsw2zaq1'; // Use a strong key

// Function to encrypt the value
function encrypt_cookie($array, $key, $cipher_method) {
    $iv_length = openssl_cipher_iv_length($cipher_method);
    $iv = openssl_random_pseudo_bytes($iv_length);
    $serialized_data = serialize($array);
    $encrypted_data = openssl_encrypt($serialized_data, $cipher_method, $key, 0, $iv);
    // Combine the IV and encrypted data to store together
    return base64_encode($iv . $encrypted_data);
}

// Function to decrypt the value
function decrypt_cookie($encrypted_data, $key, $cipher_method) {
    $encrypted_data = base64_decode($encrypted_data);
    $iv_length = openssl_cipher_iv_length($cipher_method);
    $iv = substr($encrypted_data, 0, $iv_length);
    $encrypted_data = substr($encrypted_data, $iv_length);
    $decrypted_data = openssl_decrypt($encrypted_data, $cipher_method, $key, 0, $iv);
    return unserialize($decrypted_data);
}
$decrypted_array = [];
if (isset($_COOKIE['secure_data'])) {
  $decrypted_array = decrypt_cookie($_COOKIE['secure_data'], $encryption_key, $cipher_method);
}


function page_url(){
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $actual_link;
}

function base_url(){   
// first get http protocol if http or https
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
    $base_url .= "flldc-ims.vercel.app/"; 
    return $base_url;  
}

function encrypted_string($unencrypt){ 
  
  $dirty = array("+", "/", "=");
	$clean = array("_PLUS_", "_SLASH_", "_EQUALS_");
  $plaintext="$unencrypt";
  
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(g_cipher));
  $encrypted = openssl_encrypt($plaintext, g_cipher, g_key, 0, $iv);
  $ciphertext = base64_encode($encrypted . '::' . $iv);
  $encrypted = str_replace($dirty, $clean, $ciphertext);
	return $encrypted;
}


function decrypted_string($encrypted_string){
  
	$dirty = array("+", "/", "=");
	$clean = array("_PLUS_", "_SLASH_", "_EQUALS_");
  $garble = str_replace($clean, $dirty, $encrypted_string);
  list($decoded, $iv) = explode('::', base64_decode($garble), 2);

  if (strlen($iv) < 16) {
      header("Location: /404");
      exit(); // Stop further execution if IV is invalid
  }
	$plaintext = openssl_decrypt($decoded, g_cipher, g_key, 0, $iv);

  return $plaintext;

}


function set_password($text){
	if(trim($text) !=""){
		return SHA1($text.SALT);
	}
	return '';
}

function generateCATID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  // Get the current year
  $year = date("Y");

  // Shuffle the year and combine it with the random string
  $shuffledCATID = $year . '-' . $randomString; // Use the first two characters of the shuffled year

  return $shuffledCATID;
}

function generateBrandID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  // Get the current year
  $year = date("Y");

  // Shuffle the year and combine it with the random string
  $shuffledBrandID = $year . '-B-' . $randomString; // Use the first two characters of the shuffled year

  return $shuffledBrandID;
}

function generate_PRODUCT_CODE($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  // Get the current year
  $year = date("Y");

  // Shuffle the year and combine it with the random string
  $shuffled_PRODUCT_CODE = $year .''. $randomString; // Use the first two characters of the shuffled year

  return $shuffled_PRODUCT_CODE;
}

function generate_PR_ID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  $year = date("Ymd");
  $generate_PR_ID = $year.'-PR-'.$randomString;
  return $generate_PR_ID;
}



function generate_REQUEST_ID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  $year = date("Ymd");
  $generate_REQUEST_ID = $year.'-R-'.$randomString;
  return $generate_REQUEST_ID;
}

// function generate_TOKEN($length = 15) {
//   // Characters to be used in the ID
//   $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

//   // Generate a random string of the specified length
//   $randomString = substr(str_shuffle($characters), 0, $length);

//   $generate_REQUEST_ID = $randomString;
//   return $generate_TOKEN;
// }

function generate_RCA_ID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  $year = date("Ymd");
  $generate_RCA_ID = 'RCA-'.$year.'-'.$randomString;
  return $generate_RCA_ID;
}

function generate_PCV_ID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  $year = date("Ymd");
  $generate_PCV_ID = 'PCV-'.$year.'-'.$randomString;
  return $generate_PCV_ID;
}

function isUserAuthenticated() {
  // Check if the user is logged in (adjust according to your authentication mechanism)
  return isset($decrypted_array['ACCESS']) && !empty($decrypted_array['ACCESS']);
}

function generateReserveID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  $year = date("Ymd");
  $generateReserveID = 'RES-'.$year.'-'.$randomString;
  return $generateReserveID;
}

function generateRoomID($length = 10) {
  // Characters to be used in the ID
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

  // Generate a random string of the specified length
  $randomString = substr(str_shuffle($characters), 0, $length);

  $year = date("Ymd");
  $generateRoomID = 'ROOM-'.$year.'-'.$randomString;
  return $generateRoomID;
}

// Function to download file from GitHub and return the file content
function downloadFileFromGitHub($rawFileUrl) {
  // Initialize cURL
  $ch = curl_init($rawFileUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects (useful for GitHub URLs)
  
  $fileContent = curl_exec($ch);
  
  // Check for cURL errors
  if(curl_errno($ch)) {
      throw new Exception("cURL Error: " . curl_error($ch));
  }
  
  // Check for HTTP response code
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  if ($httpCode != 200) {
      throw new Exception("Failed to download file from GitHub. HTTP Status Code: " . $httpCode);
  }

  curl_close($ch);

  // Check if the file content is empty
  if (empty($fileContent)) {
      throw new Exception("Downloaded file is empty.");
  }

  return $fileContent;
}

define('BRANCH', array("ALABANG",
    "ALABANG-FMM",
    "ALABANG-RETAIL",
    "AZUCENA-PMFTC OVERFLOW",
    "BACOLOD",
    "BACOLOD-NA",
    "BACOLOD-PERSONAL COLLECTION",
    "BACOLOD-SHELL",
    "BALITE-PMFTC OVERFLOW",
    "BASILAN",
    "BATANGAS",
    "BATANGAS-CDI",
    "BATANGAS-CDO FOODSPHERE RETAIL",
    "BATANGAS-HONDA",
    "BATANGAS-NPI",
    "BATANGAS-NPI RETAIL",
    "BATANGAS-PMFTC",
    "BATANGAS-PMFTC OVERFLOW",
    "BATANGAS-SAFI",
    "BATANGAS-YAMAHA",
    "BATINO-NPI EXTENSION",
    "BATINO-NPI ICD",
    "BATINO-NPI RETAIL",
    "BATINO-NPI SDC",
    "BATINO-SDC TRUCKING",
    "BATINO-TRUCKING",
    "BAYBAY",
    "BORONGAN",
    "BULACAN-NDC TRUCKING",
    "BULACAN-NPI NDC",
    "BULACAN-NPI NDC CAW",
    "BUTUAN",
    "CABUYAO",
    "CABUYAO-ABBOTT",
    "CABUYAO-ABBOTT-RETAIL",
    "CABUYAO-ACTIMED INC.",
    "CABUYAO-DMPI",
    "CABUYAO-EC OVERFLOW",
    "CABUYAO-FAPC",
    "CABUYAO-GREEN CROSS INC.",
    "CABUYAO-J&J",
    "CABUYAO-J&J RETAIL",
    "CABUYAO-J&J TRANSPORT",
    "CABUYAO-L&D CENTER",
    "CABUYAO-LAGUNA",
    "CABUYAO-MEGA PACK",
    "CABUYAO-NA RETAIL",
    "CABUYAO-NPI",
    "CABUYAO-NPI DC",
    "CABUYAO-NPI LISP FG",
    "CABUYAO-NPI MMC3",
    "CABUYAO-NPI OVERFLOW",
    "CABUYAO-NPI RETAIL",
    "CABUYAO-NPI TRUCKING",
    "CABUYAO-NUTRIASIA",
    "CABUYAO-P&G",
    "CABUYAO-P&G RETAIL",
    "CABUYAO-PERSONAL COLLECTION",
    "CABUYAO-PMFTC OVERFLOW",
    "CABUYAO-PMFTC1",
    "CABUYAO-PMFTC2",
    "CABUYAO-RENGO",
    "CABUYAO-RFM",
    "CABUYAO-UNILEVER",
    "CABUYAO-URC",
    "CABUYAO-VMI RETAIL",
    "CAGAYAN",
    "CAGAYAN - NPI CDC RETAIL",
    "CAGAYAN-DMPI",
    "CAGAYAN-DMPI RETAIL",
    "CAGAYAN-FACILITY",
    "CAGAYAN-FMM",
    "CAGAYAN-GMC",
    "CAGAYAN-NPI",
    "CAGAYAN-NPI PHARMA",
    "CAGAYAN-NPI RETAIL",
    "CAGAYAN-PERSONAL COLLECTION",
    "CAGAYAN-PMFTC",
    "CAGAYAN-ROBINSONS",
    "CAGAYAN-SHELL",
    "CAGAYAN-SILVERSWAN",
    "CAGAYAN-URC",
    "CAINTA-MONDELEZ",
    "CALAMBA OVERFLOW",
    "CALAMBA-ALFAMART",
    "CALAMBA-DISTRIPHIL",
    "CALAMBA-GREEN CROSS INC.",
    "CALAMBA-JAPAN TOBACCO INT'L.",
    "CALAMBA-JAPAN TOBACCO INT'L. OVERFLOW",
    "CALAMBA-JOLLIBEE",
    "CALAMBA-LAGUNA",
    "CALAMBA-MMC SDC",
    "CALAMBA-P&G",
    "CALAMBA-RED RIBBON SITE",
    "CALAMBA-RFM",
    "CALAMBA-RFM RETAIL",
    "CALAMBA-WYETH",
    "CALBAYOG",
    "CALBAYOG-NA",
    "CALBAYOG-NPI",
    "CAMIGUIN",
    "CANLUBANG-EDWARD KELLER",
    "CANLUBANG-ZUELLIG",
    "CARMONA-KALINISAN CHEMICALS CORP.",
    "CARMONA-LAFARGE",
    "CARMONA-LAFARGE RETAIL",
    "CARMONA-OVERFLOW 1",
    "CARMONA-OVERFLOW 2",
    "CATARMAN",
    "CATBALOGAN-NPI",
    "CAUAYAN-ZUELLIG",
    "CEBU",
    "CEBU-CDI",
    "CEBU-COLPAL",
    "CEBU-EPI",
    "CEBU-FACILITY",
    "CEBU-FACILITY 2",
    "CEBU-FDI",
    "CEBU-FMM",
    "CEBU-GMC",
    "CEBU-GREEN CROSS",
    "CEBU-JJPI RDC",
    "CEBU-JOLLIBEE CONSO",
    "CEBU-JOLLIBEE CONSO-2",
    "CEBU-KIMBERLY CLARK",
    "CEBU-KIMBERLY CLARK RETAIL",
    "CEBU-MARIWASA",
    "CEBU-MONDE NISSIN",
    "CEBU-NA",
    "CEBU-NATIONAL BOOKSTORE",
    "CEBU-NEXTRADE",
    "CEBU-NEXTRADE RETAIL",
    "CEBU-NPI ICD",
    "CEBU-NPI PHARMA",
    "CEBU-NPI RETAIL",
    "CEBU-NPI VDC",
    "CEBU-NPI VDC OVERFLOW",
    "CEBU-NPI VDC RETAIL",
    "CEBU-PERSONAL COLLECTION",
    "CEBU-PILMICO CONSO",
    "CEBU-PRIFOOD",
    "CEBU-RFM",
    "CEBU-SHELL",
    "CEBU-SYSU",
    "CEBU-TRANSPORT",
    "CEBU-URC",
    "CEBU-URC CONSO",
    "CEBU-URC SAN FERNANDO",
    "CEBU-WYETH",
    "CORPORATE",
    "COTABATO",
    "COTABATO-DOLE RETAIL",
    "DAGUPAN",
    "DASMARIÑAS-GREEN CROSS INC",
    "DASMARIÑAS-GREEN CROSS INC.-2",
    "DASMARIÑAS-OVERFLOW",
    "DASMARIÑAS-PMFTC OVERFLOW",
    "DAVAO",
    "DAVAO-CDI",
    "DAVAO-CITIHARDWARE",
    "DAVAO-EPI",
    "DAVAO-FMM",
    "DAVAO-JS UNITRADE",
    "DAVAO-JS UNITRADE RETAIL",
    "DAVAO-NA",
    "DAVAO-NEXTRADE",
    "DAVAO-NPI PHARMA",
    "DAVAO-PERSONAL COLLECTION",
    "DAVAO-PERSONAL COLLECTION-2",
    "DAVAO-PMFTC",
    "DAVAO-PRIFOOD",
    "DAVAO-RFM",
    "DAVAO-ROBINSONS",
    "DAVAO-SHELL",
    "DAVAO-SILVER SWAN",
    "DAVAO-URC",
    "DAVAO-WYETH",
    "DIPOLOG",
    "DIPOLOG-MONDE NISSIN",
    "DUMAGUETE",
    "DUMAGUETE-NA",
    "ELISCO-EPI TRANSPORT",
    "ELISCO-SHELL",
    "FLEX-CALAMBA",
    "FLEX-TAGUIG",
    "FORTUNE-PMFTC1",
    "FORTUNE-PMFTC2",
    "GENSAN",
    "GENSAN-GMC",
    "HOME OFFICE",
    "HOME OFFICE-FMM",
    "ILIGAN",
    "ILOILO",
    "ILOILO-COLPAL",
    "ILOILO-JAPAN TOBACCO INT'L",
    "ILOILO-JS UNITRADE",
    "ILOILO-JS UNITRADE RETAIL",
    "ILOILO-NA",
    "ILOILO-NEXTRADE",
    "ILOILO-PMFTC",
    "ILOILO-RFM",
    "ILOILO-SHELL",
    "ILOILO-SM",
    "IMUS-ALFAMART",
    "IMUS-COLDCHAIN",
    "IMUS-COLDCHAIN RETAIL",
    "IMUS-FOOD PANDA",
    "IMUS-SM",
    "JOLO",
    "KALIBO",
    "KALIBO-NPI",
    "KORONADAL",
    "LA UNION-CDI",
    "LAGUNA-GMC",
    "LAGUNA-MONDE NISSIN",
    "LAGUNA-PRIFOOD",
    "LAGUNA-RED RIBBON",
    "LAPULAPU-PMFTC OVERFLOW",
    "LAS PIÑAS-BOIE",
    "LAWA-OVERFLOW",
    "LIBIS OVERFLOW",
    "LIBIS-COLPAL",
    "LIBIS-PMFTC",
    "LIBIS-UNILEVER",
    "MAKATI-ALFAMART",
    "MAKATI-CDI",
    "MAKATI-JOLLIBEE",
    "MAKATI-P&G",
    "MAKATI-PERSONAL COLLECTION",
    "MAKATI-PG",
    "MANDAUE",
    "MANDAUE-NA",
    "MANDAUE-PMFTC OVERFLOW",
    "MAYON",
    "MINDANAO",
    "MUNTINLUPA",
    "MUNTINLUPA-PMFTC",
    "NAGA",
    "NAGA-PERSONAL COLLECTION",
    "NAGA-PMFTC",
    "NAGA-ROBINSONS",
    "NORTH COTABATO",
    "NORTH COTABATO-RETAIL",
    "ODIONGAN",
    "OLONGAPO",
    "OLONGAPO-NPI",
    "OTTAWA",
    "ORIENTAL MINDORO",
    "ORIENTAL MINDORO-NA",
    "ORIENTAL MINDORO-NPI",
    "PANGASINAN",
    "PASAY",
    "PASAY-PMFTC",
    "PASIG",
    "PASIG-NA",
    "PASIG-NPI",
    "PASIG-NPI RETAIL",
    "PANGASINAN-NA",
    "PANGASINAN-PERSONAL COLLECTION",
    "PANGASINAN-URC",
    "PANGASINAN-PERSONAL COLLECTION",
    "PAMPANGA",
    "PAMPANGA-CDI",
    "PAMPANGA-CDI-RETAIL",
    "PAMPANGA-NPI",
    "PAMPANGA-PERSONAL COLLECTION",
    "PANGALAT",
    "ROXAS",
    "SANTIAGO",
    "SANTA ROSA",
    "SANTA ROSA-RETAIL",
    "TACLOBAN",
    "TAGUIG",
    "TALISAY",
    "TALISAY-NA",
    "TALISAY-PMFTC",
    "TAYTAY-NA",
    "TAYTAY-PMFTC",
    "TOLEDO",
    "ZAMBOANGA"));