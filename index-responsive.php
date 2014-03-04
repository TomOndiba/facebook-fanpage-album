<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Facebook Album Integration in website</title>
    
    <!-- Lightbox Start here-->
    
    <script src="lightbox/js/modernizr.custom.js"></script>
	<link rel="stylesheet" href="lightbox/css/screen.css" media="screen"/>
	<link rel="stylesheet" href="lightbox/css/lightbox.css" media="screen"/>
    <script src="lightbox/js/jquery-1.10.2.min.js"></script>
	<script src="lightbox/js/lightbox-2.6.min.js"></script>
    
    

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/grid.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.EzzyFBalbum{
	float: left;
	height: 140px;
	width: 96%;
	background-color: #ebebeb;
	padding: 2%;
	margin-bottom: 15px;
	box-shadow: 0px 0px 2px #999999;
        }
.album-image {
	float: left;
	height: 100px;
	width: 100%;
	overflow: hidden;
	border-bottom-width: 3px;
	border-bottom-style: solid;
	border-bottom-color: #0099CC;
}

.album-name {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	text-transform: capitalize;
	color: #333333;
	float: left;
	height: 25px;
	width: 97%;
	padding-top: 5px;
	padding-left: 3%;
}

.EzzyFBalbum2{
	float: left;
	height: 110px;
	width: 96%;
	background-color: #ebebeb;
	padding: 2%;
	margin-bottom: 15px;
	box-shadow: 0px 0px 2px #999999;
        }
-->
    </style>
</head>

  <body>
    <div class="container">

      <div class="page-header">
      
      <div class="row" style="border-bottom:solid 3px #0099FF; padding-bottom:15px;">
      <div class="col-md-3"><a href="index-responsive.php"><img src="images/logo.png" width="100%" border="0"></a></div>
      <div class="col-md-9"></div>
      </div>
      
       <div class="row">
      <div class="col-md-12"> <h1>Facebook Fan Page Album Integration GraphAPI</h1>
        <p class="lead">Create Lighbox Image Gallery by Using Facebook Fan Page Album.</p></div>
      </div>
        
        
      </div>
      
      <div class="row">
    <div class="col-md-12" >
    <form name="form1" method="post" action="" class="well form-search">
    <div class="row">
    <div class="col-md-3">
      <div align="right">Facebook Fan Page Album URL:</div>
    </div>
    <div class="col-md-5">
      <div align="left">
        <input name="page_url" type="text" id="page_url" class="form-control">
      </div>
    </div>
    <div class="col-md-4"> 
      <div align="left">
        <input type="submit" name="button" id="button" value="Submit" class="btn btn-primary">
      </div>
    </div>
    </div>
    
    
    
      </form>
    </div>
    </div>

    <div class="row">
    <div class="col-md-12">
   <?php
if(isset($_REQUEST['page_url']))
{
$fbpage_url=$_REQUEST['page_url'];
}
else
{
$fbpage_url="https://www.facebook.com/DesiMinimalistPoster";
}
$fbpage=str_replace('http://graph.facebook.com/','',$fbpage_url);
set_time_limit ( 960000 ) ; 

//include the fb php sdk
require 'src/facebook.php';

$facebook = new Facebook(array(
    'appId'  => 'Your App Id', // You Facebook Appid goes here
    'secret' => 'Your Secret', // You Facebook Secret goes here
    'cookie' => true, // enable optional cookie support
));
    
	
// Get owner id==>
$FBpage="$fbpage";
$File= file_get_contents("http://graph.facebook.com/$FBpage/");
$obj=json_decode($File);
$owner_id=$obj->id;

if($fbpage!="")
{

	
//defining action index
isset( $_REQUEST['action'] ) ? $action = $_REQUEST['action'] : $action = "";

/*
 * This will show 
 */
if( $action == ''){
    echo "<p>Facebook Fan Page Album Gallery!</p>";
    
    // select albums from our dummy page
    $fql    =   "SELECT 
                    aid, cover_pid, name 
                FROM 
                    album 
                WHERE owner=$owner_id  LIMIT 12";
                
    $param  =   array(
        'method'    => 'fql.query',
        'query'     => $fql,
        'callback'  => ''
    );
    
    $fqlResult   =   $facebook->api($param);
	
	  $i = 1;

  //Open the row div
  echo '<div class="row">';
    
    foreach( $fqlResult as $keys => $values ){

        //to get album cover
        $fql2    =   "select src from photo where pid = '" . $values['cover_pid'] . "'";
        $param2  =   array(
            'method'    => 'fql.query',
            'query'     => $fql2,
            'callback'  => ''
        );
        $fqlResult2   =   $facebook->api($param2);
        
        foreach( $fqlResult2 as $keys2 => $values2){
            $album_cover = $values2['src'];
        }
        
        //show the album
		//Set the counter to 1
		
		echo '<div class="col-md-2">';
		  
        echo "<div class='EzzyFBalbum'>";
		
		echo "<div class='album-image'>";
		
            echo "<a href='index-responsive.php?page_url=$fbpage_url&action=list_pics&aid=" . $values['aid'] . "&name=" . $values['name'] . "'>";
                echo "<img src='$album_cover' border='0' width='100%' height='150px'>";
            echo "</a>";
			
			echo "</div>";
			
			
            echo "<div class='album-name'>{$values['name']}</div>";
      echo "</div>";
		echo "</div>";
		
		//======
		if($i % 6 == 0) {echo '</div><div class="row">';}

  //End stuff
  $i++;

 
		//=====
        
    }
	 //Close the row div
  echo '</div>';
  
  
}

/*
 * This will show the photo(s) on the clicked album.
 */
if( $action == 'list_pics'){

    isset( $_GET['name'] ) ? $album_name = $_GET['name'] : $album_name = "";
    
    echo "<div><a href='index-responsive.php?page_url=$fbpage_url'>Back To Albums</a> | Album Name: <b>" . $album_name . "</b></div>";
    
    // query all the images in the album
    $fql = "SELECT 
                pid, src, src_small, src_big, caption 
            FROM 
                photo 
            WHERE 
                aid = '" . $_REQUEST['aid'] ."' ORDER BY created DESC LIMIT 100";
    
    $param  =   array(
        'method'    => 'fql.query',
        'query'     => $fql,
        'callback'  => ''
    );
    
    $fqlResult   =   $facebook->api($param);
    

	 $i = 1;
	  echo '<div class="row">';
    echo '<div class=image-set>';
    foreach( $fqlResult as $keys => $values ){
        
        if( $values['caption'] == '' ){
            $caption = "";
        }else{
            $caption = $values['caption'];
        }   
        
        echo '<div class="col-md-2">';
		  
        echo "<div class='EzzyFBalbum2'>";
		
		echo "<div class='album-image2'>";
		
            echo "<a class='example-image-link' data-lightbox='example-set' href=\"" . $values['src_big'] . "\" title=\"" . $caption . "\" >";
                echo "<img src='" . $values['src'] . "'  width='100%' height='100px' class='example-image' />";
            echo "</a>"; 
        echo "</div>";
		echo "</div>";
		echo "</div>";
		
		if($i % 6 == 0) {echo '</div><div class="row">';}

  //End stuff
  $i++;

    }
    echo "</div>"; // Lightbox row div close
	
   echo "</div>";
   
   
   
}



}// main if page url exist close here
?>
    </div>
    </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
