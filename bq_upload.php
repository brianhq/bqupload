<?php
/* bq_upload.php
   @author: Brian Quach
   @date: 05 Dec 2012
   @purpose: Parse a list of files provided by POST and store 
             them in the upload/ directory
*/

//check for errors, and print the caught error
function errorOut($upload) {
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
}

//check uploaded file's size
function checkFile($upload) {
   if($upload > 51200) {
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

//upload files
//check if upload/ exists
if(!is_dir("upload")){
   mkdir("upload");
}
//make sure there are files to be uploaded
if($_FILES["file"]["name"][0] != "") {
   foreach ($_FILES["file"]["error"] as $key => $error) {
      //check to see if the file uploaded properly
      if($error == UPLOAD_ERR_OK) {
         //send the file to size checker
         if(checkFile($_FILES["file"]["size"][$key])){

            //check if the file is already uploaded
            if(file_exists("upload/" . $_FILES["file"]["name"][$key])) {
               echo $_FILES["file"]["name"][$key] . " already exists. ";
            } else {

               //print upload info
               echo "<h1>Upload Info</h1>";
               echo "Name: " . $_FILES["file"]["name"][$key] . "<br/>";
               echo "Type: " . $_FILES["file"]["type"][$key] . "<br/>";
               echo "Size: " . ($_FILES["file"]["size"][$key] / 1024) . " kB</div>\n<br/>";

               //upload file to upload/
               move_uploaded_file($_FILES["file"]["tmp_name"][$key], "upload/" . $_FILES["file"]["name"][$key]);

               //notify user on success
               echo "File(s) successfully uploaded!<br/>\n<br/>";
            }
         }
      }
   }
}

//print directory listing
printdir("upload/");

?>
