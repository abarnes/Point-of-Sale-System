      <div id="content">content</div>
 
 <script type="text/javascript" src="/js/prototype.js"></script>
  <script type="text/javascript">
  var comet = {
    connection   : false,
    iframediv    : false,
 
    initialize: function() {
      if (navigator.appVersion.indexOf("MSIE") != -1) {
 
        // For IE browsers
        comet.connection = new ActiveXObject("htmlfile");
        comet.connection.open();
        comet.connection.write("<html>");
        comet.connection.write("<script>document.domain = '"+document.domain+"'");
        comet.connection.write("</html>");
        comet.connection.close();
        comet.iframediv = comet.connection.createElement("div");
        comet.connection.appendChild(comet.iframediv);
        comet.connection.parentWindow.comet = comet;
        comet.iframediv.innerHTML = "<iframe id='comet_iframe' src='/backend.php'></iframe>";
 
      } else if (navigator.appVersion.indexOf("KHTML") != -1) {
 
        // for KHTML browsers
        comet.connection = document.createElement('iframe');
        comet.connection.setAttribute('id',     'comet_iframe');
        comet.connection.setAttribute('src', '/backend.php');
        with (comet.connection.style) {
          position   = "absolute";
          left       = top   = "-100px";
          height     = width = "1px";
          visibility = "hidden";
        }
        document.body.appendChild(comet.connection);
 
      } else {
 
        // For other browser (Firefox...)
        comet.connection = document.createElement('iframe');
        comet.connection.setAttribute('id',     'comet_iframe');
        with (comet.connection.style) {
          left       = top   = "-100px";
          height     = width = "1px";
          visibility = "hidden";
          display    = 'none';
        }
        comet.iframediv = document.createElement('iframe');
        comet.iframediv.setAttribute('src', '/users/test');
        comet.connection.appendChild(comet.iframediv);
        document.body.appendChild(comet.connection);
 
      }
    },
 
    // this function will be called from backend.php  
    printServerTime: function (vf) {
      $('content').innerHTML = vf;
    },
 
    onUnload: function() {
      if (comet.connection) {
        comet.connection = false; // release the iframe to prevent problems with IE when reloading the page
      }
    }
  }
  Event.observe(window, "load",   comet.initialize);
  Event.observe(window, "unload", comet.onUnload);
 
  </script>