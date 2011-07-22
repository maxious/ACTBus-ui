<?php
  header('Content-type: text/css');
  ob_start("compress");
  function compress($buffer) {
    /* remove comments */
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    /* remove tabs, spaces, newlines, etc. */
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
  }

echo '
.ui-li-thumb, .ui-li-icon { position: relative; }

     .ui-navbar {
     width: 100%;
     }
     .ui-btn-inner {
        white-space: normal !important;
     }
     .ui-li-heading {
        white-space: normal !important;
     }
    .ui-listview-filter {
        margin: 0 !important;
     }
    .ui-icon-navigation {
        background-image: url(images/113-navigation.png);
        background-position: 1px 0;
     }
    .ui-icon-beaker {
        background-image: url(images/91-beaker-2.png);
        background-position: 1px 0;
    }
    #footer {
        text-size: 0.75em;
        text-align: center;
    }
    body {
        background-color: #F0F0F0;
    }
    #jqm-homeheader {
        text-align: center;
    }        
    .viaPoints {
        display: none;
        text-size: 0.2em;
    }
    .min-width-480px .viaPoints {
        display: inline;
    }
    #extrainfo {
    visibility: hidden;
    display: none;
    }
    #servicewarning {
    padding: 1em;
    margin-bottom: 0.5em;
    text-size: 0.2em;
    background-color: #FF9;
    -moz-border-radius: 15px;
border-radius: 15px;
    }


#footer {
clear:both;
text-align:center;
}
    // source http://webaim.org/techniques/skipnav/
    #skip a, #skip a:hover, #skip a:visited 
{ 
position:absolute; 
left:0px; 
top:-500px; 
width:1px; 
height:1px; 
overflow:hidden;
} 

#skip a:active, #skip a:focus 
{ 
position:static; 
width:auto; 
height:auto; 
}';

//if (false)
 echo '
// adaptive layout from jQuery Mobile docs site
.type-interior .content-secondary {
	border-right: 0;
	border-left: 0;
	margin: 10px -15px 0;
	background: #fff;
	border-top: 1px solid #ccc;
}
.type-home .ui-content {
	margin-top: 5px;
}
.type-interior .ui-content {
	padding-bottom: 0;
}
.content-secondary .ui-collapsible-contain {
	padding: 10px 15px;

}
.content-secondary .ui-collapsible-heading {
	margin: 0 0 30px;
}
.content-secondary .ui-collapsible-heading-collapsed,
.content-secondary .ui-collapsible-content {
	padding:0;
	margin: 0;
}
@media all and (min-width: 650px){
.content-secondary {
		text-align: left;
		float: left;
		width: 45%;
		background: none;
		border-top: 0;
	}
	.content-secondary,
	.type-interior .content-secondary {
		margin: 30px 0 20px 2%;
		padding: 20px 4% 0 0;
			background: none;
	}
	.type-index .content-secondary {
		padding: 0;
	}
	.type-index .content-secondary .ui-listview {
		margin: 0;
	}
	.content-primary {
		width: 45%;
		float: right;
		margin-top: 30px;
		margin-right: 1%;
		padding-right: 1%;
	}
	.content-primary ul:first-child {
		margin-top: 0;
	}

	.type-interior .content-primary {
		padding: 1.5em 6% 3em 0;
		margin: 0;
	}
	/* fix up the collapsibles - expanded on desktop */
	.content-secondary .ui-collapsible-heading {
		display: none;
	}
	.content-secondary .ui-collapsible-contain {
		margin:0;
	}
	.content-secondary .ui-collapsible-content {
		display: block;
		margin: 0;
		padding: 0;
	}
		.type-interior  .content-secondary .ui-li-divider {
		padding-top: 1em;
		padding-bottom: 1em;
	}
	.type-interior .content-secondary {
		margin: 0;
		padding: 0;
	}
}
@media all and (min-width: 750px){
	.type-home .ui-content,
	.type-interior .ui-content {
		background-position: 39%;
	}
	.content-secondary {
		width: 34%;
	}
	.content-primary {
		width: 56%;
		padding-right: 1%;
	}	
	.type-interior .ui-content {
		background-position: 34%;
	}
}

@media all and (min-width: 1200px){
	.type-home .ui-content{
		background-position: 38.5%;
	}
	.type-interior .ui-content {
		background-position: 30%;
	}
	.content-secondary {
		width: 30%;
		padding-right:6%;
		margin: 30px 0 20px 5%;
	}
	.type-interior .content-secondary {
		margin: 0;
		padding: 0;
	}
	.content-primary {
		width: 50%;
		margin-right: 5%;
		padding-right: 3%;
	}
	.type-interior .content-primary {
		width: 60%;
	}
}';
  ob_end_flush();
?>
