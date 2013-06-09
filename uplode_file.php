<?php
/* bq_upload.php
   @author: Brian Quach
   @date: 05 Dec 2012
   @purpose: Parse a list of files provided by POST and store 
             them in the upload/ directory
*/

//check for errors, and print the caught error
function checkFile($upload) {
   if($upload["error"] > 0) {
      echo "Error: ";
      $errorCode = $upload["error"];
      switch($errorCode) {
         case 1: 
            echo "File size too large<br/>"; break;
         case 2:
            echo "File size too large<br/>"; break;
         case 3:
            echo "Upload interrupted<br/>"; break;
         case 4:
            echo "No file selected<br/>"; break;
         case 6:
            echo "Missing temp folder<br/>"; break;
         case 7:
            echo "Failed to write to disk<br/>"; break;
      }
      return false;
   }
   
   //check file size
   if($upload["size"] > 51200) {
      echo "Error: File size too large<br/>";
      return false;
   } else {
      return true;
   } 
}

//sort and print the current list of files under /upload
function printdir($dir) {
   //array to contain list of files and markup
   $dirList = array();

   echo "<div id='file-list'><h1>Files currently in /upload</h1><br/>\n<ul>";

   if($handle = opendir("$dir")) {
      while(false !== ($entry = readdir($handle))) {
         if($entry != "." && $entry != "..") {
            //add file to array for sorting
            $dirList[] = "<li class='file'>$entry</li>";
         }
      }
      closedir($handle);
   }

   //sort file list
   natcasesort($dirList);

   //print the list
   foreach ($dirList as $listing) {
      echo $listing;
   }

   echo "</ul></div>";
}

?>

<!--create stylable code-->
<html>
<body>
<div id="container">
   <div id="upload-info">
   
   <?php   
   //verify the file for uploading per our rules
   if(checkFile($_FILES["file"])){
   
      //check if the file is already uploaded
      if (file_exists("upload/" . $_FILES["file"]["name"])) {
         echo $_FILES["file"]["name"] . " already exists. ";
      } else {
      
         //print upload info
         echo "<h1>Upload Info</h1>";
         echo "Name: " . $_FILES["file"]["name"] . "<br/>";
         echo "Type: " . $_FILES["file"]["type"] . "<br/>";
         echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB</div>\n<br/>";
         
         //check if default directory exists
         if(!is_dir("upload")){
            mkdir("upload");
         }

         //upload file
         move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
         echo "File uploaded!<br/>\n<br/>";

         //print directory listing
         printdir("upload/");
      }
   }
   ?>
</div>
</body>
</html>
