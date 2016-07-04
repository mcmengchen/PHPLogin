<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 16/6/30
 * Time: 上午11:53
 */




//POST
//$name = $_POST['name'];
//$psd = $_POST['psd'];
//$phone = $_POST['phone'];

//Get
$name = $_GET['name'];
$psd = $_GET['psd'];
$phone = $_GET['phone'];




//OpenDb($con);
CollectDb($name,$psd,$phone);
//closeDb($con);

//开启数据库log
function OpenDb($link){
    if(!$link)
    {
        die('Could not connect: '.mysqli_error($link));
    }else {
        echo "Open Succees";
    }
}
//关闭数据库log
function closeDb($link){
    if($link){
        if(mysqli_close($link)){
            echo "\nClose Success";
        }else{
            echo "\nClose Failed";
        }
    }
}

//链接数据库
function CollectDb($name, $psd, $phone){
    //打印任务名称
    $data = "执行插入数据库";
    $newData = iconv('UTF-8','GBK',$data);
    echo $newData;
    //打开数据库
    $con = mysqli_connect("localhost","mc","uG9VaSjT2Azahsab");
    OpenDb($con);
    $myCon = mysqli_select_db($con,"mc");
    $select = "select name from user where name = '$name'";
    $seleResult = mysqli_query($con,$select);
    //开始查询,并且获取查询结果
    $resultArr = array();
    $result = mysqli_num_rows($seleResult);
    solveLog($result,$resultArr);
}

//打印日志
function solveLog($result,$resultArr){
    if($result){
        //如果注册过
        $resultArr['success'] = "-1";
        $resultArr['status'] = "already have";
        $arr = json_encode($resultArr);
        echo $arr;
        return $arr;
    }else{
        $result = mysqli_query($con,"INSERT INTO user (name, psd, phone)VALUES ('$name','$psd','$phone')");
        if($result == 1){
            $resultArr['success'] = "1";
            $resultArr['status'] = "ok";
            $arr = json_encode($resultArr);
            echo  $arr;
        }else{
            $resultArr['success'] = "0";
            $resultArr['status'] = "no";
            $arr = json_encode($resultArr);
            echo $arr;
        }
    }


}

//创建数组
$arr = array(
    'id' =>1,
    'name' =>'siangwa'
);

//反应类
class Response {
    /**
     * @param $code
     * @param string $message
     * @param array $data
     * @return string
     */
    public static function json($code, $message='', $data = array()){
        if (!is_numeric($code))	 {
            return '';
        }
        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
        echo json_encode($result);
        exit;
    }
}

//添加别的引用
//require_once('./convertjson.php');
