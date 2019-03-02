<?php
header("Content-type: application/json; charset=utf-8");

require_once 'RedisCmnCache.php';
try {
    $VISITOR_TIMES_KEY = 'fen_visitor_times';
    $PRAISE_TIMES_KEY = 'fen_praise_times';
    $cmnCache = new RedisCmnCache();

    $visitorTimes = $cmnCache->get($VISITOR_TIMES_KEY);
    if ($visitorTimes) {
        $cmnCache->set($VISITOR_TIMES_KEY, ++$visitorTimes);
    } else {
        $cmnCache->set($VISITOR_TIMES_KEY, 1);
    }
    $praiseTimes = $cmnCache->get($PRAISE_TIMES_KEY);
    $praiseTimes = $praiseTimes ? $praiseTimes : 0;
    echo responseData(array('visitor' => $visitorTimes, 'praise' => $praiseTimes));
} catch(Exception $e){
    echo responseData($e->getPrevious(), $e->getCode(), $e->getMessage());
}

function responseData($data = array(), $code = 20000, $message = 'success'){
    $res = array(
        'code' => $code,
        'msg' => $message,
        'data' => $data
    );
    return json_encode($res);
}
?>
