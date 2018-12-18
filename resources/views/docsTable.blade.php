<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <style> 
        [id^='pq-detail']{
            overflow: auto !important;
            max-height:120px;
        }
        </style>
        <link rel="stylesheet" href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.min.css')}}" />
        <script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
        <script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.js')}}"></script>
        <script src="{{asset('js/jQuery-File-Upload-master/js/vendor/jquery.ui.widget.js')}}"></script>
        <script src="{{asset('js/jQuery-File-Upload-master/js/jquery.iframe-transport.js')}}"></script>
        <script src="{{asset('js/jQuery-File-Upload-master/js/jquery.fileupload.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('js/grid-2.4.1/pqgrid.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('css/jquery-ui.theme.css')}}" />
        <script src="{{ asset('js/uploader-master/src/js/jquery.dm-uploader.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/grid-2.4.1/pqgrid.min.js')}}" ></script>   
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DOCS</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <script src="{{asset('js/docsTable.js')}}"></script>
  
    </head>
    <body>
       <div id="table"></div>
       <div id="dialog" title="Basic dialog" style="display: none;">
            <p>File Describtion</p>
            <input type="text" id="describtion"  />
          </div>
           
    </body>
</html>
