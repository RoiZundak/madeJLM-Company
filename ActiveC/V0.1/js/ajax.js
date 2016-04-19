$.ajax({
        type: "POST",
        url: "Service.asmx/EmailNotification",
        data: "{}",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data)
        {

        },
        error: function (XHR, errStatus, errorThrown) {
            var err = JSON.parse(XHR.responseText);
            errorMessage = err.Message;
            alert(errorMessage);
        }
    });