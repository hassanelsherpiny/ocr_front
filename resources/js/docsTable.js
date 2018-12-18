function initDetail(ui) {
    var rowData = ui.rowData;
    console.log(rowData);
    var content;
    if (rowData.content == "testPDF") {
        content = "<div> PDF CONTENT<br><br><br><br><br><br><br><br>PDF CONTENT<br><br><br><br><br><br><br><br>PDF CONTENT<br><br><br><br><br><br><br><br>PDF CONTENT<br><br><br><br><br><br><br><br>PDF CONTENT<br><br><br><br><br><br><br><br></div>";
    } else {

        {
            if (rowData.content == "testIMG")
                content = "<div id='container' style='position:absolute;'>\
<img src='http://www.placekitten.com/200/200' />\
<div id='highlight' style='position:absolute;width:25px;height:15px;top:95px;left:111px;\
background: rgba(255, 0, 0, 0.4);'></div>\
</div>";
        }
    }
    var $detail = $("<div id='pq-detail' tabindex='0'>" + content + "</div>");
    return $detail;
};

$('#fileupload').fileupload({
    dataType: 'json',
    add: function (e, data) {
        $('#loading').text('Uploading...');
        data.submit();
    },
    done: function (e, data) {
        // $.each(data.result.files, function (index, file) {
        //     $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
        //     if ($('#file_ids').val() != '') {
        //         $('#file_ids').val($('#file_ids').val() + ',');
        //     }
        //     $('#file_ids').val($('#file_ids').val() + file.fileID);
        // });
        console.log("finished");
        $('#loading').text('');
    }
});
$(function () {
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

        }
    ];
    var staticData = [{
        "content": "testPDF",
        "id": "<div id='pdfTest.pdf' ><a href='DOCSAPI/down?fileName=pdfTest.pdf'  target='_blank'><img style='width:20%;height:20%;' src = '/pdf.png'' /></a></div>"
    }, {
        "content": "testIMG",
        "id": "<div id='imageTest.JPG' ><a href='DOCSAPI/down?fileName=imageTest.JPG'  target='_blank'><img style='width:20%;height:20%;' src = '/img.png'' /></a></div>"
    }]
    //define dataModel
    var dataModel = {
        location: "local",
        sorting: "local",
        dataType: "JSON",
        method: "GET",
        url: "/DOCSAPI",
        data: staticData,
        getData: function (dataJSON) {
            return {
                data: staticData
            };
        }
    }
    var obj = {
        dataModel: dataModel,
        colModel: colM,
        pageModel: {
            type: 'local',
            rPP: 20
        },
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
        {{ csrf_field() }}\
        Files(can add more than one):\
        <input type="file" id="fileupload" name="files[]" data-url="/upload" multiple />\
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

});
