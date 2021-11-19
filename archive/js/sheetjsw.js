// importScripts('dist/xlsx.full.min.js');
// // import * as XLSX from './dist/xlsx.full.min.js';
// // import 'dist/xlsx.full.min.js';
// postMessage({t:'ready'});
// onmessage = function(evt) {
//   var v;
//   try { v = XLSX.read(evt.data.d, evt.data.b); }
//   catch(e) { postMessage({t:"e",d:e.stack}); }
//   postMessage({t:evt.data.t, d:JSON.stringify(v)});
// }
if( 'function' === typeof importScripts) {
    importScripts('dist/xlsx.full.min.js');
    addEventListener('message', onMessage);
    ostMessage({t:'ready'});
    onmessage = function(evt) {
    var v;
    try { v = XLSX.read(evt.data.d, evt.data.b); }
    catch(e) { postMessage({t:"e",d:e.stack}); }
    postMessage({t:evt.data.t, d:JSON.stringify(v)});
    }
    function onMessage(e) { 
      // do some work here 
    }    
 }