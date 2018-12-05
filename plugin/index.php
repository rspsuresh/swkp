<!DOCTYPE html>
<html>
    <head>
        <title>index</title>
        <script type="text/javascript" src="jquery/jquery.js"></script>
    </head>
    <body>
        <ul>
            <li><a href="./pdfdisplay.php?url=test1.pdf">one</a></li>
            <li><a href="./pdfdisplay.php?url=test2.pdf">two</a></li>
            <li><a href="./pdfdisplay.php?url=test3.pdf">three</a></li>

        </ul>
        <input  type="checkbox" name="f1" value="1" data-url="test1.pdf"/>
        <input type="checkbox" name="f2" value="2" data-url="test2.pdf"/>
        <input type="checkbox" name="f3" value="3" data-url="test3.pdf"/>
        <label id="totalPages"></label>
    </body>
    <script src="./build/pdf.js"></script>
    <script >
        (function ($) {

            $('input[type=checkbox]').change(function () {
                var filelist = [];
                $('input[type=checkbox]').each(function () {
                    if ($(this).prop('checked') == true) {
                        filelist.push({id:$(this).val(),url:$(this).data('url')}); 
                    }
                });
                getpages(filelist);
            });
        })(jQuery);
        PDFJS.workerSrc = './build/pdf.worker.js';
//        var filelist = [{id: 1, url: 'test1.pdf'}, {id: 2, url: 'test2.pdf'}, {id: 3, url: 'test3.pdf'}];
        var totalPages = 0;
        
        function getpages(filelist) {
            totalPages = 0;
            for (var i = 0; i < filelist.length; i++) {
                PDFJS.getDocument(filelist[i].url).then(function (pdfDoc_) {
                    var pdfDoc = pdfDoc_;
                    totalPages += pdfDoc.numPages;
                });
            }
            setTimeout(function() {
                $('#totalPages').html(totalPages);
    }, 600);
            
        }
    </script>
    
</html>