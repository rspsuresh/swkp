<?php
if(isset($_GET['url'])){
  $url = './'.$_GET['url'];
  print_r($url);
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Previous/Next example</title>
</head>
<body>

<h1>'Previous/Next' example</h1>

<div>
  <button id="prev">Previous</button>
  <button id="next">Next</button>
  &nbsp; &nbsp;
  <button id="zoomin">Zoom In</button>
  <button id="zoomout">Zoom Out</button>
  &nbsp; &nbsp;
  <a href="./">Back</a>
 
  <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
</div>

<div style="max-width:45%;overflow:scroll;height:820px">
  <canvas id="the-canvas" style="border:1px solid black"></canvas>
</div>

<!-- for legacy browsers add compatibility.js -->
<!--<script src="../compatibility.js"></script>-->

<script src="./build/pdf.js"></script>

<script id="script">
  //
  // If absolute URL from the remote server is provided, configure the CORS
  // header on that server.
  //
  var url = '<?php echo $url; ?>';
  //
  // Disable workers to avoid yet another cross-origin issue (workers need
  // the URL of the script to be loaded, and dynamically loading a cross-origin
  // script does not work).
  //
  PDFJS.disableWorker = true;
  //
  // In cases when the pdf.worker.js is located at the different folder than the
  // pdf.js's one, or the pdf.js is executed via eval(), the workerSrc property
  // shall be specified.
  //
  PDFJS.workerSrc = './build/pdf.worker.js';
  var pdfDoc = null,
      pageNum = 1,
      pageRendering = false,
      pageNumPending = null,
      scale = 0.8,
      canvas = document.getElementById('the-canvas'),
      ctx = canvas.getContext('2d'),
      pdfScale = 1;
  /**
   * Get page info from document, resize canvas accordingly, and render page.
   * @param num Page number.
   */

     

  
  function renderPage(num) {
    pageRendering = true;
    scale = pdfScale;

    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function(page) {

      var viewport = page.getViewport(scale);
      canvas.height = viewport.height;
      canvas.width = viewport.width;
   
      // Render PDF page into canvas context
      var renderContext = {
        canvasContext: ctx,
        viewport: viewport
      };
      var renderTask = page.render(renderContext);
      // Wait for rendering to finish
      renderTask.promise.then(function () {
        pageRendering = false;
        if (pageNumPending !== null) {
          // New page rendering is pending
          renderPage(pageNumPending);
          pageNumPending = null;
        }
      });
    });
    // Update page counters
    document.getElementById('page_num').textContent = pageNum;
  }
  /**
   * If another page rendering in progress, waits until the rendering is
   * finised. Otherwise, executes rendering immediately.
   */
  function queueRenderPage(num) {
    if (pageRendering) {
      pageNumPending = num;
    } else {
      renderPage(num);
    }
  }
  function zoom(num) {
    renderPage(num);
  }
  /**
   * Displays previous page.
   */
  function onPrevPage() {
    if (pageNum <= 1) {
      return;
    }
    pageNum--;
    queueRenderPage(pageNum);
  }
  document.getElementById('prev').addEventListener('click', onPrevPage);
  /**
   * Displays next page.
   */
  function onNextPage() {
    if (pageNum >= pdfDoc.numPages) {
      return;
    }
    pageNum++;
    queueRenderPage(pageNum);
  }
  document.getElementById('next').addEventListener('click', onNextPage);

  function onZoomIn() {
   
    pdfScale = parseFloat(pdfScale)+0.25;

    zoom(pageNum);
  }
  document.getElementById('zoomin').addEventListener('click', onZoomIn);

  function onZoomOut() {
     if (pdfScale <= 1) {
      return;
    }
    pdfScale = parseFloat(pdfScale)-0.25;
    zoom(pageNum);
  }
  document.getElementById('zoomout').addEventListener('click', onZoomOut);
  /**
   * Asynchronously downloads PDF.
   */
  PDFJS.getDocument(url).then(function (pdfDoc_) {

    pdfDoc = pdfDoc_;
     var numPages = pdfDoc.numPages;
     console.log(numPages);
    document.getElementById('page_count').textContent = pdfDoc.numPages;
    // Initial/first page rendering
    renderPage(pageNum);
    for(var z = 0;z<numPages;z++){
        pdfDoc.getPage( z ).then(handlePages);  
    }
    
  });
  function handlePages(page)
{
  console.log(page);
    //This gives us the page's dimensions at full scale
    var viewport = page.getViewport( 1 );

    //We'll create a canvas for each page to draw it on
    var canvas = document.createElement( "canvas" );
    var canvas1 = document.createElement( "input" );
    canvas1.setAttribute("type", "checkbox");
    canvas1.setAttribute("name", (page.pageIndex+1)); 
    canvas.style.display = "block";
    var context = canvas.getContext('2d');
   canvas.height = viewport.height;
    canvas.width = viewport.width;

   /* canvas.height = "500";
    canvas.width = "500";*/
    canvas.setAttribute("onClick","setalert("+(page.pageIndex+1)+")");

    //Draw it on the canvas
    page.render({canvasContext: context, viewport: viewport});

    //Add it to the web page
    document.body.appendChild( canvas );
    document.body.appendChild( canvas1 );

    //Move to next page
    currPage++;
    if ( thePDF !== null && currPage <= numPages )
    {
        thePDF.getPage( currPage ).then( handlePages );
    }
}
function setalert(num){
  renderPage(num);
}
</script>

</body>
</html>