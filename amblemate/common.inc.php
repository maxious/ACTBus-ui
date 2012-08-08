<?php
$otpURL = "http://amblemate.lambdacomplex.org:8080/";

if (php_uname('n') == 'ip-10-196-142-253') $otpURL = "http://localhost:8080/";

function include_header($title) {
?>
<!doctype html>
<!-- Conditional comment for mobile ie7 blogs.msdn.com/b/iemobile/ -->
<!--[if IEMobile 7 ]>    <html class="no-js iem7" lang="en"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8">

  <title><?php echo $title; ?></title>
  <meta name="description" content="">

  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width">

  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/h/apple-touch-icon.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/m/apple-touch-icon.png">
  <link rel="apple-touch-icon-precomposed" href="img/l/apple-touch-icon-precomposed.png">
  <link rel="shortcut icon" href="img/l/apple-touch-icon.png">

  <!-- <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black"> -->
  <!-- <script>(function(){var a;if(navigator.platform==="iPad"){a=window.orientation!==90||window.orientation===-90?"img/startup-tablet-landscape.png":"img/startup-tablet-portrait.png"}else{a=window.devicePixelRatio===2?"img/startup-retina.png":"img/startup.png"}document.write('<link rel="apple-touch-startup-image" href="'+a+'"/>')})()</script> -->
  
  <!-- <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script> -->
  

  <link rel="stylesheet" href="css/style.css">

  <script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>

  <div id="container">
    <header>

    </header>
    <div id="main" role="main">
<?php
}

function include_footer() {
?>

    </div>

    <footer>

    </footer>
  </div> <!--! end of #container -->


  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script -->
  <script src="js/helper.js"></script>
  <!-- end concatenated and minified scripts-->

  <!-- <script src="https://getfirebug.com/firebug-lite.js"></script>

  <script> // Change UA-XXXXX-X to be your site's ID
    var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
    s.parentNode.insertBefore(g,s)}(document,"script"));
  </script>-->

</body>
</html>
<?php 
}
function startsWith($haystack, $needle, $case = true) {
    if ($case) {
        return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
    }
    return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
}

function endsWith($haystack, $needle, $case = true) {
    if ($case) {
        return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
    }
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
}
