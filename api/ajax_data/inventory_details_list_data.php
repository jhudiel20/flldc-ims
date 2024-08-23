<?php
include '../DBConnection.php';
include '../config/config.php';

// $session_class->session_close();
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
	include HTTP_404;
	exit();
}

$product_code = mysqli_real_escape_string($conn, isset($_POST['product_code']) ? trim($_POST['product_code']) : '');

header("Content-type: application/json; charset=utf-8");
// if(!($g_user_role[0] == "TEACHER")){  
// 	$output =  json_encode(["last_page"=>1, "data"=>"","total_record"=>0]);
// 	echo $output;
// 	exit();
// }

$query_limit = 50;
$table_name= "product";
$field_query ='*';	
$pages = 0;
$start = 0;
$size = 0;

$sorters =array();
$orderby ="DATE_CREATED DESC";
$sql_where="";
$sql_conds="";
$sql_where_array=array();
$to_encode=array();
$output="";
$total_query=0;
$flag_all = false;

// PRODUCT_CODE,PRODUCT_ID, PRICE, p.NAME, QTY_STOCK,  ON_HAND, SUBCATEGORY_NAME, EXPIRY_DATE,
// CATEGORY_NAME, p.CREATED_BY, COMPANY_NAME, p.SUPPLIER_ID, DATE_FORMAT(DATE_STOCK_IN, '%Y-%m-%d %h:%i:%s %p') AS DATE_STOCK_IN 

 
$dbfield = array('PRODUCT_ID','PRODUCT_CODE','NAME','PRICE','QTY_STOCK','ON_HAND','CATEGORY_NAME','SUBCATEGORY_NAME','COMPANY_NAME','DATE_STOCK_IN','EXPIRY_DATE','DATE_FORMAT(DATE_STOCK_IN, "%Y-%m-%d %h:%i:%s %p") AS DATE_STOCK_IN '); // need iset based sa table columns na need sa query
$db_orig = array('PRODUCT_ID','PRODUCT_CODE','NAME','PRICE','QTY_STOCK','ON_HAND','CATEGORY_NAME','SUBCATEGORY_NAME','COMPANY_NAME','DATE_STOCK_IN','EXPIRY_DATE'); //gamit sa filter  tabulator

if(isset($_GET['filter'])){
	$filters =array();
	$sort_filters =array();
	$filters = $_GET['filter'];
	foreach($filters as $filter){
		if(isset($filter['field'])){
			$id = $filter['field'];
			$sort_filters[$id] = $filter['value'];
		}
	}
	// var_dump($filter);
	foreach($db_orig as $id){
		if(isset($sort_filters[$id])){
			$value = mysqli_real_escape_string($conn,$sort_filters[$id]);	
			if($id == "QTY_STOCK" ){

				array_push($sql_where_array,$id.' = \''.$value.'\'');
			}else{
			// 	if($id =="name"){
			// 		$id="u.name";
			// 	}
				array_push($sql_where_array,$id.' LIKE \''.$value.'%\'');
			}
		}
	}
}

array_push($sql_where_array, " PRODUCT_CODE = '$product_code' "); //set default WHERE CONDITION HERE

if(!empty($sql_where_array)){
	$temp_arr = implode(' AND ',$sql_where_array);
	$sql_where = (empty($temp_arr)) ? '' : $temp_arr;		
}

if(isset($_GET['sort'])){
	$sorters = $_GET['sort'];
	$tag =array('asc','desc');
	if(in_array($sorters[0]['field'],$db_orig) AND in_array($sorters[0]['dir'],$tag)){
		$orderby = $sorters[0]['field'].' '.$sorters[0]['dir'];
	}

}

if(isset($_GET['size'])){
    if($_GET['size'] == 'true'){
        $flag_all = true;
    }else{
	$query_limit = ($_GET['size'] > $query_limit) ? $_GET['size'] : $query_limit;
    }
}


//total query counter 
$total_query = 0;
$field_query ='COUNT(DISTINCT PRODUCT_ID) AS count'; // baguhin based sa need
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;

$default_query ="SELECT ".$field_query." FROM product AS p
JOIN supplier as s ON p.SUPPLIER_ID = s.SUPPLIER_ID 
".$sql_conds;
if($query = mysqli_query($conn,$default_query)){
	if($num = mysqli_num_rows($query)){
		while($data = mysqli_fetch_assoc($query)){
			$total_query = $data['count'];
		}
	}
}

$pages= ($total_query===0) ? 1 : ceil($total_query/($query_limit));
if(isset($_GET['page'])){
	$page_no = $_GET['page'] - 1;
	$start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start;

$field_query = implode(',',$dbfield);
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;

$default_query ="SELECT ".$field_query." FROM product AS p
JOIN supplier as s ON p.SUPPLIER_ID = s.SUPPLIER_ID
 ".$sql_conds;
$limit=" LIMIT ". $start_no.",".$query_limit; 
if($flag_all){
    $limit = '';
    $pages = 1;
}
$sql_limit=$default_query.' '.$limit;
// echo $sql_limit;	
if($query = mysqli_query($conn,$sql_limit)){
	if($num = mysqli_num_rows($query)){
		while($data = mysqli_fetch_assoc($query)){
			$class_text ="";
			// $data['shared'] = ($data['share_to']=='[]') ? 'No': 'Yes';
			$to_encode[] = $data;
		}
	}
	
}

if(empty($to_encode)){
    $output =  json_encode(["last_page"=>1, "data"=>"","total_record"=>0]);
}else{
    $output = json_encode(["last_page"=>$pages, "data"=>$to_encode,"total_record"=>$total_query]);
}

echo $output; //output

?>
