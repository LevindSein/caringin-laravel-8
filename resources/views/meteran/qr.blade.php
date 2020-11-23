<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Aplikasi PT. Pengelola Pusat Perdagangan Caringin di Kota Bandung">
        <meta name="author" content="">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
        <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
        
        <!-- Custom fonts for this template -->
        <link
            href="{{asset('vendor/fontawesome-free/css/all.min.css')}}"
            rel="stylesheet"
            type="text/css">
        <link
            href="{{asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}"
            rel="stylesheet">
        
        <!-- Custom styles for this template -->
        <link href="{{asset('css/sb-admin-2-copy.min.css')}}" rel="stylesheet">

        <link href="{{asset('css/fixed-columns.min.css')}}" rel="stylesheet">

        <!-- Custom styles for this page -->
        <link
            href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}"
            rel="stylesheet">

        <link rel="icon" href="{{asset('img/logo.png')}}">

        <script src="{{asset('js/animate.min.js')}}"></script>
        
        <link rel="stylesheet" href="{{asset('vendor/select2/select2.min.css')}}"/>
        <script src="{{asset('vendor/select2/select2.min.js')}}"></script>
    </head>

    <body id="page-top">
        <div style="text-align:center">
            <h1>Print Zebra ZPL commands from Javascript</h1>
            <hr />
            <label class="checkbox">
                <input type="checkbox" id="useDefaultPrinter" /> <strong>Print to Default printer</strong>
            </label>
            <p>or...</p>
            <div id="installedPrinters">
                <label for="installedPrinterName">Select an installed Printer:</label>
                <select name="installedPrinterName" id="installedPrinterName"></select>
            </div>
            <br /><br />
            <button type="button" onclick="print();">Print Now...</button>
        </div>

        <script src="{{asset('js/printmanager/zip.js')}}"></script>
        <script src="{{asset('js/printmanager/zip-ext.js')}}"></script>
        <script src="{{asset('js/printmanager/deflate.js')}}"></script>
        <script src="{{asset('js/printmanager/JSPrintManager.js')}}"></script>

        <script>
 
            //WebSocket settings
            JSPM.JSPrintManager.auto_reconnect = true;
            JSPM.JSPrintManager.start();
            JSPM.JSPrintManager.WS.onStatusChanged = function () {
                if (jspmWSStatus()) {
                    //get client installed printers
                    JSPM.JSPrintManager.getPrinters().then(function (myPrinters) {
                        var options = '';
                        for (var i = 0; i < myPrinters.length; i++) {
                            options += '<option>' + myPrinters[i] + '</option>';
                        }
                        $('#installedPrinterName').html(options);
                    });
                }
            };
        
            //Check JSPM WebSocket status
            function jspmWSStatus() {
                if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
                    return true;
                else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
                    alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
                    return false;
                }
                else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
                    alert('JSPM has blocked this website!');
                    return false;
                }
            }
        
            //Do printing...
            function print(o) {
                if (jspmWSStatus()) {
                    //Create a ClientPrintJob
                    var cpj = new JSPM.ClientPrintJob();
                    //Set Printer type (Refer to the help, there many of them!)
                    if ($('#useDefaultPrinter').prop('checked')) {
                        cpj.clientPrinter = new JSPM.DefaultPrinter();
                    } else {
                        cpj.clientPrinter = new JSPM.InstalledPrinter($('#installedPrinterName').val());
                    }
                    //Set content to print...
                    //Create Zebra ZPL commands for sample label
                    var cmds =  "^XA";
                    cmds += "^FO150,30^ABB,30,18^BQN,2,10^FDQA 1 ^FS";
                    cmds += "^FO185,265^ABN,25,9^FDA-1-001 LISTRIK^FS";
                    cmds += "^XZ";
                    
                    cpj.printerCommands = cmds;
                    //Send print job to printer!
                    cpj.sendToClient();
                }
            }
        
        </script>
    </body>
</html>