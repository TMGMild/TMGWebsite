<?php
    require("common.php");
    $postid = get('id', 1);
    $text = $_POST['text'];
    $ctd = get('ctd', 5);
    
    if(!empty($_POST)) 
    {
        $query = " 
            INSERT INTO post_" . $postid . " ( 
                text,
                authorid,
                date
            ) VALUES ( 
                :text, 
                :authorid, 
                :date
            ) 
        ";        
        $query_params = array(
            ':text' => $text, 
            ':authorid' => $_SESSION['user']['id'],
            ':date' => date("Y-m-d H:i:s")
        ); 
         
        executeWithParams($query, $query_params);

        $query = "SELECT MAX(commentid) FROM post_" . $postid;

        $commentid = fetchColumn($query);
        
        redirect("redirect.php?postid=" . $postid . "&commentid=" . $commentid . "&ctd=" . $ctd);
    } 
     
?> 