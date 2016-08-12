<?php 

    require("common.php"); 
     
    if(!loggedIn()) 
    { 
        redirect("login.php");
    } 

    $id = get('id', 1);
    
    if(!empty($_POST))
    {
        if(empty($_POST['title'])) 
        {
            die("Please enter a title."); 
        } 
        
        if(empty($_POST['text'])) 
        { 
            die("Please enter some text."); 
        }
        
        $query = " 
            INSERT INTO posts ( 
                cid, 
                title, 
                authorid, 
                date 
            ) VALUES ( 
                :cid, 
                :title, 
                :authorid, 
                :date 
            ) 
        ";        
        $query_params = array( 
            ':cid' => $id,
            ':title' => $_POST['title'],
            ':authorid' => $_SESSION['user']['id'],
            ':date' => date("Y-m-d H:i:s")
        );         
        executeWithParams($query, $query_params);

        $query = "SELECT MAX(pid) FROM posts";
        $postid = fetchColumn($query);
        $tableName = "post_" . $postid;

        $query = "
        CREATE TABLE " . $tableName . " (
            `commentid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `text` TEXT NOT NULL ,
            `authorid` INT NOT NULL ,
            `date` DATETIME NOT NULL ,
            `removed` INT NOT NULL
        ) ENGINE = MYISAM ;

        ";
        execute($query);        

        $query = " 
            INSERT INTO " . $tableName . " ( 
                text,
                authorid,
                date,
                removed
            ) VALUES ( 
                :text, 
                :authorid,
                :date, 
                0
            ) 
        ";        
        $query_params = array(
            ':text' => $_POST['text'],
            ':authorid' => $_SESSION['user']['id'],
            ':date' => date("Y-m-d H:i:s")
        ); 
         
        executeWithParams($query, $query_params);

        $query = "SELECT MAX(pid) FROM posts";
        $postid = fetchColumn($query);
        
        redirect("viewpost.php?id=" . $postid);
    } 
     
?>
<html>
    <head>
        <title>New Post</title>
        <?php include 'head.php'; ?>
    </head>
    <body>
        <?php include 'nav.php'; ?>
        <div class="container">
            <h1>New Post</h1> 
            <hr>
            <form action="newpost.php?id=<?php echo $id;?>" method="post"> 
                <input type="text" style="width:600px;font-size:22px;" name="title" placeholder="Title" /> 
                <br /><br />
                <textarea name="text" class="fullwidth" rows="20"/> </textarea>
                <br /><br />
                <input type="submit" value="Submit" /> 
            </form>
        </div>
    </body>
</html>