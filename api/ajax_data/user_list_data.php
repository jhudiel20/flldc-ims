<?php
require_once __DIR__ . '/../DBConnection.php';
require_once __DIR__ . '/../../public/config/config.php'; // Adjusted path for config.php

error_reporting(0);
ini_set('display_errors', 0);

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

$query_limit = 20;
$table_name= "user_account";
$field_query ='*';	
$pages =0;
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


$dbfield = array('ID','CONTACT','FNAME','MNAME','LNAME','EXT_NAME','IMAGE','STATUS', 'ACCESS', 'DATE_CREATED','EMAIL','LOCKED','APPROVED_STATUS','ADMIN_STATUS'); // need iset based sa table columns na need sa query
$db_orig = array('ID','CONTACT','FNAME','MNAME','LNAME','EXT_NAME','IMAGE','STATUS', 'ACCESS', 'DATE_CREATED','EMAIL','LOCKED','APPROVED_STATUS','ADMIN_STATUS'); //gamit sa filter  tabulator

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
	foreach($db_orig as $id){
		if(isset($sort_filters[$id])){
			$value = mysqli_real_escape_string($conn_acc,$sort_filters[$id]);			
			// if(is_digit($value)){
			// 	array_push($sql_where_array,$id.' = \''.$value.'\'');
			// }else{
			// 	if($id =="name"){
			// 		$id="u.name";
			// 	}
				array_push($sql_where_array,$id.' LIKE \''.$value.'%\'');
			// }
		}
	}



}

// array_push($sql_where_array, " "); //set default WHERE CONDITION HERE

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
$field_query ='COUNT(DISTINCT ID) as count'; // baguhin based sa need
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;
$default_query ="SELECT ".$field_query." FROM user_account ".$sql_conds;

if ($query = pg_query($conn, $default_query)) {
    if ($num = pg_num_rows($query)) {
        while ($data = pg_fetch_assoc($query)) {
            $total_query = $data['count'];
        }
    }
}

// $field_query ='COUNT(DISTINCT q.exam_id) as count'; // baguhin based sa need
// $default_query ="SELECT ".$field_query." FROM quiz as q LEFT JOIN (SELECT exam_ques_id,exam_id,COUNT(exam_id) as counter FROM quiz_question GROUP BY exam_id) as qq ON q.exam_id = qq.exam_id ".$sql_conds;
// if($query = call_mysql_query($default_query)){
// 	if($num = call_mysql_num_rows($query)){
// 		while($data = call_mysql_fetch_array($query)){
// 			$total_query += $data['count'];
// 		}
// 	}
// }

$pages= ($total_query===0) ? 1 : ceil($total_query/($query_limit));
if(isset($_GET['page'])){
	$page_no = $_GET['page'] - 1;
	$start = $page_no * $query_limit;
}

$start_no = ($start >= $total_query) ? $total_query : $start;

// $field_query = implode(',',$dbfield);
// $sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;
// $default_query ="SELECT ".$field_query." FROM exam as q  LEFT JOIN (SELECT exam_ques_id,exam_id,COUNT(exam_id) as counter FROM exam_question GROUP BY exam_id) as qq ON q.exam_id = qq.exam_id ".$sql_conds." ORDER BY ".$orderby;
// $limit=" LIMIT ". $start_no.",".$query_limit; 
// $sql_limit=$default_query.' '.$limit;

// if($query = call_mysql_query($sql_limit)){
// 	if($num = call_mysql_num_rows($query)){
// 		while($data = call_mysql_fetch_array($query)){
// 			$class_text ="";
// 			$data['id'] = $data['exam_id'];
// 			$data['shared'] = ($data['share_to']=='[]') ? 'No': 'Yes';
//             $data['typed'] = 'Test';
// 			$to_encode[] = array_html($data);
// 		}
// 	}
	
// }


$field_query = implode(',',$dbfield);
$sql_conds = (empty($sql_where)) ? '' : 'WHERE '.$sql_where;

$default_query = "SELECT " . $field_query . " FROM user_account " . $sql_conds . " ORDER BY " . $orderby;
$limit = " LIMIT " . $query_limit . " OFFSET " . $start_no;

if ($flag_all) {
    $limit = '';
    $pages = 1;
}
$sql_limit = $default_query . ' ' . $limit;

// echo $sql_limit;
if ($query = pg_query($conn_acc, $sql_limit)) {
    if ($num = pg_num_rows($query)) {
        while ($data = pg_fetch_assoc($query)) {
            $class_text = "";
            $data['data'] = $data['STATUS'];
            $data['data_id'] = $data['ID'];
            $data['data_fname'] = $data['FNAME'];
            $data['data_mname'] = $data['MNAME'];
            $data['data_lname'] = $data['LNAME'];
            $data['data_locked'] = $data['LOCKED'];
            $data['data_suffix'] = $data['EXT_NAME'];
            $data['data_access'] = $data['ACCESS'];
            $data['data_email'] = $data['EMAIL'];
            $data['data_approved'] = $data['APPROVED_STATUS'];
            // $data['data_pass'] = $data['PASSWORD'];
            // $data['shared'] = ($data['share_to'] == '[]') ? 'No' : 'Yes';
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
