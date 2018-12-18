<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
            <meta name="csrf-token" content="{{ csrf_token() }}"> 
                <!--jQuery dependencies-->
        <link rel="stylesheet"
        href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>    
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

        <!--Include Touch Punch file to provide support for touch devices-->
        {{-- <script type="text/javascript" src="path to touch-punch.js" ></script>    --}}

        <!--ParamQuery Grid files-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pqGrid/2.4.1/pqgrid.min.css" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pqGrid/2.4.1/pqgrid.min.js" ></script>   
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="{{asset('js/jQuery-File-Upload-master/js/vendor/jquery.ui.widget.js')}}"></script>
        <script src="{{asset('js/jQuery-File-Upload-master/js/jquery.iframe-transport.js')}}"></script>
        <script src="{{asset('js/jQuery-File-Upload-master/js/jquery.fileupload.js')}}"></script>
        
        <title>DOCS</title>
        {{-- https://cdnjs.cloudflare.com/ajax/libs/pqGrid/2.4.1/pqgrid.min.js --}}
        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css"> --}}
        <script src="{{ asset('js/uploader-master/src/js/jquery.dm-uploader.js')}}"></script>
        {{-- <script src="{{ asset('js/components/pizza.js')}}"></script> --}}

        <script>
                $(function(){
                    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
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
    // });
    /////////


});
                </script>    
    </head>
    <body>
            {{-- {!!  Form::open(array('url' => '/upload','files'=>'true'))!!} 
            {!!  Form::token()!!}
            {!!  Form::file('image')!!}
            {!!  Form::submit('Upload File')!!}
            {!!  Form::close()!!} --}}






 
    <form action="/upload" method="post">
    {{ csrf_field() }}
    Files(can add more than one):
    <input type="file" id="fileupload" name="files[]" data-url="/upload" multiple />
    <p id="loading"></p>
    </form>
    </body>
</html>
