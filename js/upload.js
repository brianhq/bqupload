//Javascript Document
/* upload.js
   @Author: Brian Quach
   @Date: 05 Dec 2012
   @Purpose: Use JS to send the files to the PHP uploader;
             Use jQuery for styling and DOM manipulation
*/
(function() {
      
      //grab the file element
      var fileUp = document.getElementById("file");

      //ensure FormData works
      if(window.FormData) {
         //create FormData key
         var formData = new FormData();
         formData.append("file", String(fileUp));

         //hide submit button because it isn't necessary
         document.getElementById("submit").style.display = "none";
      }

      //begin upload process, after the user has attempted to select files
      fileUp.addEventListener("change", function(evt) {

         //clear #upload-info
         document.getElementById("upload-info").innerHTML = "";

         //grab the number of files for iteration and 
         //to check to make sure at least 1 file is selected
         var numFiles = this.files.length;
         var file, reader;
         for(var i=0; i<numFiles; i++) {
            file = this.files[i];

            //if FileReader can be used, start reading files
            if(window.FileReader) {
               reader = new FileReader();
               reader.readAsDataURL(file);
            }
            if(formData) {
               //add the files to our POST array
               formData.append("file[]", file);
            }
         }

         //begin the upload!
         if(formData && numFiles > 0) {
            $.ajax({
               url: "bq_upload.php",
               type: "POST",
               data: formData,
               processData: false,
               contentType: false,
               success: function (result) {

                  //seperate the #file-info and #dir-list in the return string
                  var fileStream = result;
                  var seperator = fileStream.indexOf("<div");
                  var dirList = fileStream.substr(seperator);
                  var fileInfo = fileStream.substring(0,seperator-1);

                  //update the divs accordingly
                  document.getElementById("upload-info").innerHTML = fileInfo;
                  document.getElementById("upload-form").height = "auto";
                  document.getElementById("dir-list").innerHTML = dirList;
               }
            });

            //clear previous form data to prevent re-uploading
            formData = new FormData();
            formData.append("file", String(fileUp));
         }
      }, false);
}());

$(document).ready(function() {
   //get the file list and update #dir-list on startup
   $.ajax({
       url: "bq_upload.php",
       type: "POST",
       data: "",
       processData: false,
       contentType: false,
       success: function (result) {
          document.getElementById("dir-list").innerHTML = result;
       }
   }); 
});
