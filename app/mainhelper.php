<?php
function sendResponse($message,$status=200,$data=[]){

    return [
        'status'=>$status,
        'message'=>$message,
        'data'=>$data
    ];
}
function sendError($message,$status=400){

    return [
        'status'=>$status,
        'message'=>$message,
    ];
}
