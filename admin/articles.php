<?php
require("./bootstrap.php");
require_once("./config.php");
require_once("./../libs/db_query.php");
$db = new db_query();
$dblink = $db->start($server, $user, $password, $dbname);
$mode = $_GET['mode'];
$stype = $_GET['type'];
switch($mode) {

    // delete from DB

    case 'del':
        $sid = $_GET['id'];                                  // get post id
        $squery1 = $db->post_query($dblink, $sid);           // get topic id
        $sdata = mysqli_fetch_array($squery1);               // fetch array
        $tpc = $sdata['topicid'];                            // topic id

        // delete from DB 

        $dbq = $dblink->prepare("DELETE FROM posts WHERE id = :id");
        $dbq->bindParam(':id', $sid);
        $dbq->execute();

        // return to admin panel

        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;

    // edit post
    
    case 'edit':
        $sid = $_GET['id']; // get id
        $name = htmlspecialchars($_POST['namePost']);        // get name from form
        $date = $_POST['datePost'];                          // get date from form
        $article = $_POST['articlePost'];                    // get article text from form
        $article = nl2br($article);                          // add to $artile <br />
        $article = htmlspecialchars($article);               // shielding $artilce
        $article = base64_encode($article);                  // encode to base64
        $desc = $_POST['descPost'];                          // get description from form
        $desc = nl2br($desc);                                // add to $desc <br />
        $desc = htmlspecialchars($desc);                     // shielding $desc
        $desc = base64_encode($desc);                        // encode to base64
        
        // edit DB

        $dbq = $dblink->prepare("UPDATE posts SET title = :name, date = :date, post = :post, description = :desc WHERE id = :id");
        $dbq->bindParam(':name', $name);
        $dbq->bindParam(':date', $date);
        $dbq->bindParam(':post', $article);
        $dbq->bindParam(':desc', $desc);
        $dbq->bindParam(':id', $sid);
        $dbq->execute();
        
        // get topic id

        $squery1 = $db->post_query($dblink, $sid);           
        $sdata = mysqli_fetch_array($squery1);
        $tpc = $sdata['topicid'];

        // return to admin panel

        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;
    
    // add in DB

    case 'add':
        $name = htmlspecialchars($_POST['namePost']);        // get name from form
        $tpc = $_POST['selectPost'];                         // get topic from form
        $date = $_POST['datePost'];                          // get date from form
        $article = $_POST['articlePost'];                    // get article text from form
        $article = nl2br($article);                          // af <br /> to $article
        $artilce = htmlspecialchars($article);               // shielding $article
        $article = base64_encode($article);                  // encode to base64
        $pf = 2;                                             // status draft
        $author = $_SESSION['login'];                        // get author
        $desc = $_POST['descPost'];                          // get description from form
        $desc = nl2br($desc);                                // add <br /> to $desc
        $desc = htmlspecialchars($desc);                     // shielding $desc
        $desc = base64_encode($desc);                        // encode to base64

        // add in BD

        mysqli_query($dblink, "INSERT INTO posts (date, topicid, postflag, title, author, post, description) VALUES ('$date', $tpc, $pf, '$name', '$author', '$article', '$desc')");
        
        // return to admin panel

        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;

    // include add form

    case 'addpost':
        $squery = $db->topic_query($dblink);
        include './includes/articles_addform.php';
        break;
    
    // set post flag

    case 'setpf':
        $pf = $_GET['pf'];
        $sid = $_GET['id'];
        $tpc = $_GET['from_tpc'];
        mysqli_query($dblink, "UPDATE posts SET postflag = $pf WHERE id = $sid");
        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$tpc.'">';
        break;
    
    // include admin panel

    default:
    //check on topic ID exists
    $tpcid = filter_input(INPUT_GET, 'topic', FILTER_SANITIZE_STRING);
    if(!isset($mode)) {
    if(!isset($tpcid) || $tpcid == '') {
        $squery = $db->topic_query($dblink);
        $sdata = mysqli_fetch_array($squery);
        echo '<meta http-equiv="refresh" content="0;URL=?page=articles&topic='.$sdata['id'].'">';
    } else {
        $squery = $db->topic_query_pages($dblink, $tpcid);
        $sdata = mysqli_fetch_array($squery);
        $query_2 = $db->posts_query_list($dblink, $tpcid, 2, "id", "DESC"); // postflag = 2, drafts
        $query_1 = $db->posts_query_list($dblink, $tpcid, 1, "id", "DESC"); // postflag = 1, published
        $query_0 = $db->posts_query_list($dblink, $tpcid, 0, "id", "DESC"); // postflag = 0, deleted
        include './includes/articles_default.php';
    }
}
}
