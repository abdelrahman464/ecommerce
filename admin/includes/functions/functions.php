<?php
/*
** getTitle function v1.0
** title function that echo the page title
** in case the page has the title variable $pageTitle 
** and echo default title for the other pages
*/ 


function getTitle()
{
    global $pageTitle ;
    if(isset($pageTitle))
    {
        echo $pageTitle ;
    }
    else
    {
        echo 'Default';
    }
}


/*
** redirectHome function v2.0
**  Home redirect function  [with parameters]
**  $theMsg = echo The Error Msg
**  $url =the link want you redirect to 
**  $seconds = seconds befor redirecting 
*/

function redirectHome($theMsg,$url=null,$seconds=3)
{
    if($url === null)
    {
        $url = 'index.php';
        $link = 'Home Page';
    }else
    {
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='')
        {
            $url= $_SERVER['HTTP_REFERER'];
            $link = 'Previos Page';
        }else{
            $url= 'index.php';
            $link = 'Home Page';
        }
     
      ;

    }
    echo  $theMsg ;
    echo '<div class="alert alert-info"> You Will be Directed To ' .$link.' After ' .$seconds.' seconds.</div>';

    header("Refresh:$seconds;url=".$url);

    exit();
}



/**************************************
 ** checkItem function v1.0 
 ** function to check item in database [with parameters]
 ** $select = the item to select [exampls: user ,item ,category]   
 ** $from = the table to select from [exampls: users,items,categories]
 ** $value = the value of select [exampls: username,box,electornics]
 */

 function checkItem($select,$from,$value)
 {                          
    global $con;    
    $statment= $con->prepare("SELECT " .$select. " FROM " .$from. " WHERE ".$select. "= ?" );
    $statment->execute(array($value));

    $count = $statment->rowCount();

   return $count ;
 }
 
/************************************
** countItems() function  v2.0
** function to count number of item rows [with parameters]
**  $item = the item i want  to count
**  $table = the table who i count the item from 
**  $query = query i want to add 
*/   


function countItems($item,$table,$query='')
{
    global $con;
    $stmt2  = $con->prepare("SELECT count(".$item.") FROM ".$table." ". $query);
    $stmt2->execute();

    return $stmt2->fetchColumn();
}


/************************************
**  getLatest() function  v2.0
**  function to get lates items from database [users,items,comments]
**  $select = item to select
**  $table = the table who i select from 
**  $order = the desc order about it 
**  $limit = number of records i get
*/   


function getLatest($select,$table,$order,$limit = 5,$query='')
{
    global $con;
    $getstmt=$con->prepare('SELECT '. $select. ' FROM '.$table.' '.$query.' ORDER BY '.$order.' DESC LIMIT '.$limit);
    $getstmt->execute();
    $rows = $getstmt->fetchAll();
    return $rows;
}



/************************************
**  getRecord() function  v2.0
**  function to get items from database [users,items,comments]

*/   


function getRecord($select,$table,$orderby,$query='',$ordertype='DESC')
{
    global $con;
    $getstmt=$con->prepare('SELECT '. $select. ' FROM '.$table.' '.$query.' ORDER BY '.$orderby.' '.$ordertype);
    $getstmt->execute();
    $rows = $getstmt->fetchAll();
    return $rows;
}
