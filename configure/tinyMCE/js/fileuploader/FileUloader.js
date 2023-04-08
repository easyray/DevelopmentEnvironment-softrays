/*
This object is best used in an i-frame

The object ativates a file object <input type="file" ..../>
To make it open the file to upload and can help to automatically
submit the  chosen file

How to use:

    create a form to contain the file object (and other data if necessary)
    create a JSON that looks something like
    
    {
        SelectButton: "#my-div-to-click",
        FileObject:   "#File-Object",
        FormId:       "#Form-selector",
        AutoSubmit:   true/false
    }
*/

function FileUploader(JsonObject)
    {
        var Json_Object = JsonObject;
        var ClickButton = $(JsonObject.SelectButton).get(0);
        var MyFile      = $(JsonObject.FileObject  ).get(0);
        var MyForm      = $(JsonObject.FormId      ).get(0);
        var AutoSubmit  = JsonObject.AutoSubmit;
        console.log("Webutils 750 "+Json_Object.SelectButton +"<br />");

        ClickButton.onclick = function()
        {
           
           var elem = MyFile;
           if(elem && document.createEvent) 
           {
              var evt = document.createEvent("MouseEvents");
              evt.initEvent("click", true, false);
              elem.dispatchEvent(evt);                
           }
        }

        MyFile.onchange = function()
        {
            if(AutoSubmit) MyForm.submit();
        }
    }