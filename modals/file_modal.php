<style>
/*
PDFObject appends the classname "pdfobject-container" to the target element.
This enables you to style the element differently depending on whether the embed was successful.
In this example, a successful embed will result in a large box.
A failed embed will not have dimensions specified, so you don't see an oddly large empty box.
*/

.pdfobject-container {
	width: 100%;
	max-width: 800px;
    height: 45rem;
	margin: 2em 0;
}

.pdfobject { border: solid 1px #666; }
/* #results { padding: 1rem; } */
/* .hidden { display: none; }
.success { color: #4F8A10; background-color: #DFF2BF; }
.fail { color: #D8000C; background-color: #FFBABA; } */
</style>
<div class="modal" id="file_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">  
    <div class="modal-backdrop-white modal-lg" role="document">
        <div class="modal-content">
            <div class="m-xl-n1 modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">File Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="drop"></div>
            <!-- <input id="file" id="inp"> -->
            <input type="checkbox" name="userabs" class="hidden">
            <div class="modal-body" id="excelbody">
                <div id="buttons" role="group" style="flex-wrap: wrap;"></div>
                <div id="right">
                    <div id="header">
                        <!-- <pre id="out"></pre>
                        <h2>SheetJS In-Browser Live Grid Demo</h2>
                        <h3>
                        Drop a spreadsheet in the box to the left to see a preview.<br>
                        Need a file?  Why not the <a href="https://obamawhitehouse.archives.gov/sites/default/files/omb/budget/fy2014/assets/receipts.xls">OMB FY 2014 Federal Receipts?</a>
                        </h3>
                        <table id="tt">
                        <tbody><tr><td colspan="6"><a href="https://github.com/SheetJS/SheetJS.github.io">View This Page Source</a>; <a href="https://github.com/SheetJS/js-xlsx">XLSX Library</a> (for parsing); <a href="https://github.com/TonyGermaneri/canvas-datagrid">Grid Library</a></td></tr>
                        <tr>
                        <th>File Formats</th>
                        <td><a href="https://github.com/SheetJS/js-xlsx">Library Source</a></td>
                        <td><a href="https://SheetJS.github.io/js-xlsx">Interactive Demo</a></td>
                        <td><a href="http://npm.im/xlsx">"xlsx" on npm</a></td>
                        <td><a href="https://travis-ci.org/SheetJS/js-xlsx">node CI status</a></td>
                        <td><a href="stress.html">browser stress test</a></td>
                        </tr>
                        </tbody></table> -->
                    </div>
                    <div id="grid"><canvas-datagrid></canvas-datagrid></div>
                    <div id="footnote">
                        <!-- <div>
                            <button class="btn btn-secondary" id="prev">Previous</button>
                            <button class="btn btn-secondary" id="next">Next</button>
                            &nbsp; &nbsp;
                            <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                        </div>
                        <canvas id="the-canvas"></canvas> -->
                    </div>
                    <!-- <div id="results" class="hidden"></div> -->
                    <!-- <div id="pdfcanvas"></pdf> -->
                </div>
                <!-- <div id="pdf-main-container">
                    <div id="pdf-loader">Loading document ...</div>
                    <div id="pdf-contents">
                        <div id="pdf-meta">
                            <div id="pdf-buttons">
                                <button id="pdf-prev">Previous</button>
                                <button id="pdf-next">Next</button>
                            </div>
                            <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div>
                        </div>
                        <canvas id="pdf-canvas" width="400"></canvas>
                        <div id="page-loader">Loading page ...</div>
                    </div>
                </div> -->
            </div>
            <script src="js/shim.js?v=1.0.0.1"></script>
            <script lang="javascript" src="js/dist/xlsx.full.min.js"></script>
            <script src="js/dropsheet.js"></script>
            <!-- <script type="module" src="js/sheetjsw.js"></script> -->
            <!-- <script type="module" src="js/xlsx.modalmain.js?v=1.0.0.3"></script> -->
            <script src="js/spin.js"></script>
            
        </div>
    </div>
</div>
<div class="modal" id="pdf_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">  
    <div class="modal-backdrop-white modal-lg" role="document">
        <div class="modal-content">
            <div class="m-xl-n1 modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">File Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="excelbody">
                <div id="buttons" role="group" style="flex-wrap: wrap;"></div>
                <div id="right">
                    <div class="modal-body" id="pdfcanvas"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="pptx_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">  
    <div class="modal-backdrop-white modal-lg" role="document">
        <div class="modal-content">
            <div class="m-xl-n1 modal-header">
                <h5 class="modal-title" id="exampleModalPreviewLabel">File Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="excelbody">
                <div id="buttons" role="group" style="flex-wrap: wrap;"></div>
                <div id="right">
                    <div class="modal-body">
                        <iframe id="pptx-if" width='100%' height='600px' frameborder='0'></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>