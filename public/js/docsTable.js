

function initDetail(ui) {
    var rowData = ui.rowData;
    // console.log(rowData);
    // var responseData=;
    // var $detail = $("<div style='overflow-y: scroll; height:400px;' id='pq-detail' tabindex='0'>" + highlight("/hocr.jpg", 457-20  ,108 , rechieght = 125-108, recwidth =489-457+20 ) + "</div>");
    // return $detail;
    var content;
    var responseDataM;
    var $detail;    
    $.ajax({
        url: "/DOCSAPI/details",
        method: "GET",
        async:false,
        data: {
            id: rowData.id
        },
        success: function (responseData) {
            responseDataM=responseData;
            console.log(responseDataM[0]);
            //  var $detail = $("<div id='pq-detail' tabindex='0'>" + highlight(responseData.imageSrc, responseData.fromtTopLefX, responseData.fromtTopLefY, rechieght = 1, recwidth = 1) + "</div>");
            //  return $detail;
            if (responseData[0].type == "image") {
                $detail= $("<div style='overflow-y: scroll; height:400px;' id='pq-detail' tabindex='0'>" + highlightAdapter(responseData[0].src,responseData[0].hocr) + "</div>");

            } else {
                $detail=  $("<div style='overflow-y: scroll; height:400px;' id='pq-detail' tabindex='0'>" + responseData.content + "</div>");
            }

        },
        async:false

    });

  //console.log(responseDataM);
  return $detail;
};

function highlightAdapter(imageSrc,highlights)
{
    var highlightDivs=""
    for (var i=0;i<highlights.length;i++)
    {
        var currentDiv=highlights[i].split(" ");
        currentDiv[3]= parseInt(currentDiv[3])-parseInt(currentDiv[1]);
        currentDiv[2]= parseInt(currentDiv[2])-parseInt(currentDiv[0]);
        //console.log(currentDiv);
        highlightDivs=highlightDivs+(" <div id='highlight' style='position:absolute;width:" + currentDiv[2]  + "px;height:" + currentDiv[3] + "px;top:" + currentDiv[0] + "px;left:" + currentDiv[1] + "px;background: rgba(255, 0, 0, 0.4);'></div>");

        
    }
    //console.log(highlightDivs);
    content = "<div id='container' style='position:relative;'>\
    <img src='" + imageSrc + "' />"+highlightDivs+"</div>";
    return content;
}

function highlight(imageSrc, fromtTopLefX, fromtTopLefY, rechieght = 1, recwidth = 1, maxXforScale = 0, maxYforScale = 0) {
    if (maxXforScale != 0 && maxXforScale != 0)
    //need to rescale
    {
        var img = new Image();
        img.onload = function () {
            var height = img.height;
            var width = img.width;
            fromtTopLefX = fromtTopLefX * width / maxXforScale;
            fromtTopLefY = fromtTopLefY * height / maxYforScale;
            content = "<div id='container' style='position:relative;'>\
<img src='" + imageSrc + "' />\
<div id='highlight' style='position:absolute;width:" + recwidth + "px;height:" + rechieght + "px;top:" + fromtTopLefY + "px;left:" + fromtTopLefX + "px;\
background: rgba(255, 0, 0, 0.4);'></div>\
</div>";
            return content;
        }
        img.src = imageSrc;

    } else {
        content = "<div id='container' style='position:relative;'>\
<img src='" + imageSrc + "' />\
<div id='highlight' style='position:absolute;width:" + recwidth + "px;height:" + rechieght + "px;top:" + fromtTopLefY + "px;left:" + fromtTopLefX + "px;\
background: rgba(255, 0, 0, 0.4);'></div>\
</div>";
        return content;

    }
}

$(function () {
    var types={png:"image",jpg:"image",pdf:"pdf"};
    var colM = [{
            title: "",
            minWidth: 27,
            maxWidth: 27,
            type: "detail",
            resizable: false,
            editable: false,
        },
        {
            width: '80%',
            title: "Content",
            dataIndx: "content",
            filter: {
                type: 'textbox',
                listeners: ['change']
            }
        },
        {
            width: '20%',
            title: "File",
            dataIndx: "id",
            render:
            function (ui) {
                console.log(ui);
                var id=ui.rowData.id;
                var iconType=types[(id.substr(id.length - 3))]+".png";
               return "<div id='"+id+"' ><a href='DOCSAPI/down?fileName="+id+"'  target='_blank'><img style='width:20%;height:20%;' src = '/"+iconType+"'' /></a></div>"; 
            }

        }
    ];
    var staticData = [{
        "content": "testPDF",
        "id": "pdfTest.pdf"
    }, {
        "content": "testIMG",
        "id": "imageTest.png"
    },
    {
        "content": "testhocr",
        "id": "hocr.jpg"
    }]
    //define dataModel
    var dataModel = {
        location: "remote",
        sorting: "local",
        dataType: "JSON",
        method: "GET",
        url: "/DOCSAPI",
        //data: staticData,
        getData: function (dataJSON) {
            console.log(dataJSON);
            return {
                data: dataJSON
            };
        }
    }
    var obj = {
        dataModel: dataModel,
        colModel: colM,
        virtualX: true, virtualY: true,
        pageModel: {
            type: 'local',
            rPP: 20
        },
        height: "100%",
        editable: false,
        selectionModel: {
            type: 'cell'
        },
        filterModel: {
            on: true,
            mode: "AND",
            header: true
        },
        title: '\
<form action="/upload" method="post">\
Files(can add more than one):<br>\
<input type="hidden" name="_csrf" value="<your_csrf_token>" />\
<input class="ui-widget-header ui-widget-header ui-state-active" type="file" id="fileupload" name="files[]" data-url="/upload" multiple />\
<p id="loading"></p>\
</form>',
        resizable: true,
        hwrap: true,
        detailModel: {
            init: initDetail
        }
    };
    var $grid = $("#table").pqGrid(obj);

    $(".filesGetter").click(
        function (event) {
            alert(event.target.id);
            $.ajax({
                url: "DOCSAPI/down",
                data: {
                    fileName: event.target.id
                }
            }).done(function () {
                alert("done");
            });
        }
    );

    $('#fileupload').fileupload({
        dataType: 'json',
        add: function (e, data) {
            var accepted = false,
                describtion = "";

            $('#describtion').val(describtion);
            $("#dialog").dialog({
                modal: true,
                buttons: [{
                    text: "Upload",
                    icon: "ui-icon-heart",
                    click: function () {
                        accepted = true;
                        describtion = $('#describtion').val();
                        $("#dialog").dialog("close");
                        if (accepted) {
                            $('#loading').text('Uploading...');
                            //data.files[0].describtion=describtion;
                            console.log(describtion);
                            console.log(data);
                            data.submit();
                        }
                    }
                }]
            });

        },
        done: function (e, data) {
            console.log("finished");
            $('#loading').text('');
        }
    });
});
