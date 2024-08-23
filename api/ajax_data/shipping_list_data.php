<?php
include '../DBConnection.php';
include '../config/config.php';

// $session_class->session_close();
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
	include HTTP_404;
	exit();
}

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
// 
// ,
 
$dbfield = array('ID','DELIVERED_IMAGE','TRANSACTION_ID','SHIPPING_FEE','SUBTOTAL','LESSVAT','NETVAT','ADDVAT','FORMAT(GRANDTOTAL,2) as GRANDTOTAL','CASH','DATE','TRANSACTION_STATUS','CUSTOMER_NAME','DELIVERED_DATE'); // need iset based sa table columns na need sa query
$db_orig = array('ID','DELIVERED_IMAGE','TRANSACTION_ID','SHIPPING_FEE','SUBTOTAL','LESSVAT','NETVAT','ADDVAT','GRANDTOTAL','CASH','DATE','TRANSACTION_STATUS','CUSTOMER_NAME','TRANSACTION_DATE_CREATED','DELIVERED_DATE'); //gamit sa filter  tabulator

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
			if($id == "PRODUCT_CODE" ){
                $id = "product.PRODUCT_CODE";
				array_push($sql_where_array,$id.' LIKE \'%'.$value.'%\'');
			}elseif($id == "total_stock"){
				$id = " 
					SELECT
						PRODUCT_CODE
					FROM
						product
					GROUP BY
						PRODUCT_CODE
					HAVING
						SUM(QTY_STOCK)
				";
				array_push($sql_where_array, 'PRODUCT_CODE IN ('.$id.' = \''.$value.'\')');
			}else{
			// 	if($id =="name"){
			// 		$id="u.name";
			// 	}
				array_push($sql_where_array,$id.' LIKE \''.$value.'%\'');
			}
		}
	}
}

array_push($sql_where_array, " TRANSACTION_STATUS != 'Walk-In'  "); //set default WHERE CONDITION HERE

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
$field_query ='COUNT(DISTINCT TRANSACTION_ID) AS count'; // baguhin based sa need
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;

$default_query ="SELECT ".$field_query." FROM transaction ".$sql_conds;
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

$default_query ="SELECT ".$field_query.",DATE_FORMAT(TRANSACTION_DATE_CREATED, '%Y-%m-%d %h:%i:%s %p') as TRANSACTION_DATE_CREATED,DATE_FORMAT(DELIVERED_DATE, '%Y-%m-%d %h:%i:%s %p') as DELIVERED_DATE FROM transaction ".$sql_conds." ORDER BY TRANSACTION_DATE_CREATED DESC";
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
			$data['xid'] = $data['TRANSACTION_ID'];
            $data['transaction_status'] = $data['TRANSACTION_STATUS'];
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
