<?php
include ('common.inc.php');
$stopid = filter_var($_REQUEST['stopid'], FILTER_SANITIZE_NUMBER_INT);
$url = $APIurl . "/json/stop?stop_id=" . $stopid;
$stop = json_decode(getPage($url));
$html.= '<table><tr><td><br><br> ';
$url = $APIurl . "/json/stoproutes?stop=" . $stopid . "&time=" . midnight_seconds() . "&service_period=" . service_period();
$routes = json_decode(getPage($url));
foreach ($routes as $route) {
	$html.= '<br> <a href="trip.php?routeid=' . $route[0] . '&stopid=' . $stopid . '">' . $route[1] . ' - ' . $route[2] . '</a>';
	$viaPoints = viaPointNames($route[3], $stopid);
	if ($viaPoints != "") $html.= '<br><small>Via: ' . $viaPoints . '</small>';
	$html.= "<br>";
}
$html.= '</td><td>' . staticmap(Array(
	0 => Array(
		$stop[2],
		$stop[3]
	)
) , 0, "iconb", false) . "</td></tr>";
$url = $APIurl . "/json/stoptrips?stop=" . $stopid . "&time=" . midnight_seconds() . "&service_period=" . service_period();
$trips = json_decode(getPage($url));
$html.= "</table><br><br><table>";
$html.= "<thead><tr><th>Route</th><th>Time</th></tr></thead>";
debug(print_r($trips, true));
foreach ($trips as $row) {
	$html.= '<tr><td><a href="trip.php?stopid=' . $stopid . '&tripid=' . $row[1][0] . '">' . $row[1][1] . "</a></td>";
	$html.= '<td>' . midnight_seconds_to_time($row[0]) . '</td>';
	$html.= '</tr>';
}
$html.= '</table>';
if (sizeof($trips) == 0) $html.= "<center>No trips in the near future.</center>";
require_once ('tcpdf/config/lang/eng.php');
require_once ('tcpdf/tcpdf.php');
// create new PDF document
class Custom_TCPDF extends TCPDF
{
	var $QRCodeURL;
	function set_QRCodeURL($url)
	{
		$this->QRCodeURL = $url;
	}
	/**
	 * This method is used to render the page header.
	 * It is automatically called by AddPage() and could be overwritten in your own inherited class.
	 * @public
	 */
	public function Header()
	{
		if ($this->header_xobjid < 0) {
			// start a new XObject Template
			$this->header_xobjid = $this->startTemplate($this->w, $this->tMargin + 10);
			$headerfont = $this->getHeaderFont();
			$headerdata = $this->getHeaderData();
			$this->y = $this->header_margin;
			if ($this->rtl) {
				$this->x = $this->w - $this->original_rMargin;
			}
			else {
				$this->x = $this->original_lMargin - 10;
			}
			if (isset($this->QRCodeURL)) {
				// QRCODE,H : QR-CODE Best error correction
				$style = array(
					'border' => 1,
					'padding' => 0,
					'fgcolor' => array(
						0,
						0,
						0
					) ,
					'bgcolor' => false, //array(255,255,255)
					'module_width' => 1, // width of a single module in points
					'module_height' => 1
					// height of a single module in points
					
				);
				$this->write2DBarcode($this->QRCodeURL, 'QRCODE,H', '', '', 25, 25, $style, 'T');
				$imgy = 50 + 20;
			}
			elseif (($headerdata['logo']) AND ($headerdata['logo'] != K_BLANK_IMAGE)) {
				$imgtype = $this->getImageFileType(K_PATH_IMAGES . $headerdata['logo']);
				if (($imgtype == 'eps') OR ($imgtype == 'ai')) {
					$this->ImageEps(K_PATH_IMAGES . $headerdata['logo'], '', '', $headerdata['logo_width']);
				}
				elseif ($imgtype == 'svg') {
					$this->ImageSVG(K_PATH_IMAGES . $headerdata['logo'], '', '', $headerdata['logo_width']);
				}
				else {
					$this->Image(K_PATH_IMAGES . $headerdata['logo'], '', '', $headerdata['logo_width']);
				}
				$imgy = $this->getImageRBY();
			}
			else {
				$imgy = $this->y;
			}
			$cell_height = round(($this->cell_height_ratio * $headerfont[2]) / $this->k, 2);
			// set starting margin for text data cell
			if ($this->getRTL()) {
				$header_x = $this->original_rMargin + ($headerdata['logo_width'] * 1.1);
			}
			else {
				$header_x = $this->original_lMargin + ($headerdata['logo_width'] * 1.1);
			}
			$cw = $this->w - $this->original_lMargin - $this->original_rMargin - ($headerdata['logo_width'] * 1.1);
			$this->SetTextColor(0, 0, 0);
			// header title
			$this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
			$this->SetX($header_x);
			$this->Cell($cw, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
			// header string
			$this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
			$this->SetX($header_x);
			$this->MultiCell($cw, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false);
			// print an ending header line
			//$this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
			//$this->SetY((2.835 / $this->k) + max($imgy, $this->y));
			if ($this->rtl) {
				$this->SetX($this->original_rMargin);
			}
			else {
				$this->SetX($this->original_lMargin);
			}
			//$this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
			$this->endTemplate();
		}
		// print header template
		$x = 0;
		$dx = 0;
		if ($this->booklet AND (($this->page % 2) == 0)) {
			// adjust margins for booklet mode
			$dx = ($this->original_lMargin - $this->original_rMargin);
		}
		if ($this->rtl) {
			$x = $this->w + $dx;
		}
		else {
			$x = 0 + $dx;
		}
		$this->printTemplate($this->header_xobjid, $x, 0, 0, 0, '', '', false);
	}
}
$pdf = new Custom_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('bus.lambdacomplex.org');
$pdf->SetTitle($stop[1]);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $stop[1] . " Timetable", "Some description of customization like Weekdays, 9am-10am");
$pdf->set_QRCodeURL(curPageURL() . "stop.php?stopid=" . $_REQUEST['stopid']);
// set header and footer fonts
$pdf->setHeaderFont(Array(
	PDF_FONT_NAME_MAIN,
	'',
	PDF_FONT_SIZE_MAIN
));
$pdf->setFooterFont(Array(
	PDF_FONT_NAME_DATA,
	'',
	PDF_FONT_SIZE_DATA
));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 14, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+

?>
