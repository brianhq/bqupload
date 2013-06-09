Brian Quach's QuickUploader v1.0
05 Dec 12

/////////
Changelog
/////////
v1.0 - initial version

////////////
Requirements
////////////
jQuery 1.8
PHP5
an HTML5 compatible browser, preferrably Chrome or Firefox

////////////////
Included scripts
////////////////
jQuery-1.8.3.js
bq_upload.php
upload.js

////////////
What it does
////////////
QuickUploader is a simple script that uploads multiple user-specified files and 
stores them inside a specified uploads/ folder.

////////////
How it works
////////////
QuickUploader takes in form data through POST in the HTML. The Javascript 
upload.js handles the sending and receiving of data. The first bit of error 
handling comes from JavaScript checking if the client is using a browser with FormData and 
FileReader compatibility. If it doesn't, the script will be run through POST in 
typical manner, without JavaScript. From there, a handler checks whether or not 
the user has selected any files, and when it does, it adds them to a FormData 
object which is sent through POST to bq_upload.php.

bq_upload.php first makes sure upload/ exists as a directory, then follows 
through with the following error checks:
1. Was an empty $_FILES array sent? If so, just print the directory.
2. Was any specific PHP error encountered on file transfer? If so, alert the client.
3. Is the file over 50KB?
4. Is the file already on the server?

If the files pass the above checks, then the script stores them into upload/.
Output-wise, the script has two parts returned in its result:
1. Upload Info, which are the specs of the files uploaded. It will show the user
   which files made it in or if any were duplicates.
2. File Directory, which is the current list of files in upload/ with HTML 
   markup.
   
upload.js hands the final bit of processing, first breaking up the results into 
their respective parts. From there, it updates each appropriate div, and 
waits for the user to upload more.