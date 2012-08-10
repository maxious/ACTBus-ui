<?php

/*
 *    Copyright 2010,2011 Alexander Sadleir 

  Licensed under the Apache License, Version 2.0 (the 'License');
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

  http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an 'AS IS' BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
 */
// SELECT array_to_string(array(SELECT REPLACE(name_2006, ',', '\,') as name FROM suburbs order by name), ',')
$suburbs = explode(',', 'Acton,Ainslie,Amaroo,Aranda,Banks,Barton,Belconnen,Bonner,Bonython,Braddon,Bruce,Calwell,Campbell,Chapman,Charnwood,Chifley,Chisholm,City,Conder,Cook,Curtin,Deakin,Dickson,Downer,Duffy,Dunlop,Evatt,Fadden,Farrer,Fisher,Florey,Flynn,Forrest,Franklin,Fraser,Fyshwick,Garran,Gilmore,Giralang,Gordon,Gowrie,Greenway,Griffith,Gungahlin,Hackett,Hall,Harrison,Hawker,Higgins,Holder,Holt,Hughes,Hume,Isaacs,Isabella Plains,Kaleen,Kambah,Kingston,Latham,Lawson,Lyneham,Lyons,Macarthur,Macgregor,Macquarie,Mawson,McKellar,Melba,Mitchell,Monash,Narrabundah,Ngunnawal,Nicholls,Oaks Estate,O\'Connor,O\'Malley,Oxley,Page,Palmerston,Parkes,Pearce,Phillip,Pialligo,Red Hill,Reid,Richardson,Rivett,Russell,Scullin,Spence,Stirling,Symonston,Tharwa,Theodore,Torrens,Turner,Wanniassa,Waramanga,Watson,Weetangera,Weston,Yarralumla');

function staticmap($mapPoints, $collapsible = true, $twotone = false, $path = false, $numbered = false, $encpolyline = false)
{

    $markers = '';
    $height = 300;
    $width = $height;
    $index = 0;
    if (sizeof($mapPoints) < 1) {
        if ($encpolyline === false) {
            return 'map error';
        } else {
            $markers .= 'path=' . ($encpolyline === false ? "" : 'enc:' . $encpolyline);
        }
    } else if (sizeof($mapPoints) === 1) {
        if ($encpolyline === false) {
            $markers = 'markers=' . $mapPoints[0][0] . ',' . $mapPoints[0][1];
        } else {
            $markers = 'markers=' . $mapPoints[0][0] . ',' . $mapPoints[0][1] . '&amp;path=' . ($encpolyline === false ? "" : 'enc:' . $encpolyline);
        }
    } else {
        if (!$numbered) {
            $markers = 'markers=';
        }

        foreach ($mapPoints as $index => $mapPoint) {
            if ($twotone && $index == 0) {
                $markers = 'markerd=color:red|' . $mapPoint[0] . ',' . $mapPoint[1] . '&amp;markers=';
            } else {
                if ($numbered) {
                    $label = ($index > 9 ? 9 : $index);
                    $markers .= 'markers=label:' . $label . '|' . $mapPoint[0] . ',' . $mapPoint[1];
                    if ($index + 1 != sizeof($mapPoints)) {
                        $markers .= '&amp;';
                    }
                } else {
                    $markers .= $mapPoint[0] . ',' . $mapPoint[1];
                    if ($index + 1 != sizeof($mapPoints)) {
                        $markers .= '|';
                    }
                }
                $index++;
            }
        }
        if ($path) {
            $markers .= '&amp;path=' . ($encpolyline === false ? "" : 'enc:' . $encpolyline);
        }
    }
    $output = '';
    if ($collapsible) {
        $output .= '<div class="map geo" itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates" data-role="collapsible" data-collapsed="true"><h3>Open Map...</h3>
                <meta itemprop="latitude" content="' . $mapPoints[0][0] . '" />
                 <abbr class="latitude" title="' . $mapPoints[0][0] . '"></abbr>
 <abbr class="longitude" title="' . $mapPoints[0][1] . '"></abbr>
    <meta itemprop="longitude" content="' . $mapPoints[0][1] . '" />';
    }
    if (isIOSDevice()) {
        $output .= '<img class="hiresmap" src="http://maps.googleapis.com/maps/api/staticmap?size=' . $width . 'x' . $height . '&amp;' . $markers . '&amp;scale=2&amp;sensor=true" width=' . $width . ' height=' . $height . ' alt="map of stop location">';
    } else {
        $output .= '<img class="lowresmap" src="http://maps.googleapis.com/maps/api/staticmap?size=' . $width . 'x' . $height . '&amp;' . $markers . '&amp;scale=1&amp;format=jpg&amp;sensor=true" width=' . $width . ' height=' . $height . ' alt="map of stop location">';
    }

    if ($collapsible) {
        $output .= '</div>';
    }
    return $output;
}

function distance($lat1, $lng1, $lat2, $lng2, $roundLargeValues = false)
{
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;
    $r = 6372.797; // mean radius of Earth in km
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c;
    if ($roundLargeValues) {
        if ($km < 1)
            return floor($km * 1000);
        else
            return round($km, 2) . 'k';
    } else
        return floor($km * 1000);
}


function geocode($query, $giveOptions)
{
    global $cloudmadeAPIkey;
    $url = 'http://geocoding.cloudmade.com/' . $cloudmadeAPIkey . '/geocoding/v2/find.js?query=' . urlencode($query) . '&bbox=-35.5,149.00,-35.15,149.1930&return_location=true&bbox_only=true';
    $contents = json_decode(getPage($url));
    if ($giveOptions)
        return $contents->features;
    elseif (isset($contents->features[0]->centroid))
        return $contents->features[0]->centroid->coordinates[0] . ',' . $contents->features[0]->centroid->coordinates[1];
    else
        return '';
}

function reverseGeocode($lat, $lng)
{
    global $cloudmadeAPIkey;
    $url = 'http://geocoding.cloudmade.com/' . $cloudmadeAPIkey . '/geocoding/v2/find.js?around=' . $lat . ',' . $lng . '&distance=closest&object_type=road';
    $contents = json_decode(getPage($url));
    return $contents->features[0]->properties->name;
}

/*
 * Copyright (c) 2008 Peter Chng, http://unitstep.net/
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Decodes a polyline that was encoded using the Google Maps method.
 *
 * The encoding algorithm is detailed here:
 * http://code.google.com/apis/maps/documentation/polylinealgorithm.html
 *
 * This function is based off of Mark McClure's JavaScript polyline decoder
 * (http://facstaff.unca.edu/mcmcclur/GoogleMaps/EncodePolyline/decode.js)
 * which was in turn based off Google's own implementation.
 *
 * This function assumes a validly encoded polyline.  The behaviour of this
 * function is not specified when an invalid expression is supplied.
 *
 * @param String $encoded the encoded polyline.
 * @return Array an Nx2 array with the first element of each entry containing
 *  the latitude and the second containing the longitude of the
 *  corresponding point.
 */
function decodePolylineToArray($encoded)
{
    $length = strlen($encoded);
    $index = 0;
    $points = array();
    $lat = 0;
    $lng = 0;

    while ($index < $length) {
        // Temporary variable to hold each ASCII byte.
        $b = 0;

        // The encoded polyline consists of a latitude value followed by a
        // longitude value.  They should always come in pairs.  Read the
        // latitude value first.
        $shift = 0;
        $result = 0;
        do {
            // The `ord(substr($encoded, $index++))` statement returns the ASCII
            //  code for the character at $index.  Subtract 63 to get the original
            // value. (63 was added to ensure proper ASCII characters are displayed
            // in the encoded polyline string, which is `human` readable)
            $b = ord(substr($encoded, $index++)) - 63;

            // AND the bits of the byte with 0x1f to get the original 5-bit `chunk.
            // Then left shift the bits by the required amount, which increases
            // by 5 bits each time.
            // OR the value into $results, which sums up the individual 5-bit chunks
            // into the original value.  Since the 5-bit chunks were reversed in
            // order during encoding, reading them in this way ensures proper
            // summation.
            $result |= ($b & 0x1f) << $shift;
            $shift += 5;
        } // Continue while the read byte is >= 0x20 since the last `chunk`
            // was not OR'd with 0x20 during the conversion process. (Signals the end)
        while ($b >= 0x20);

        // Check if negative, and convert. (All negative values have the last bit
        // set)
        $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));

        // Compute actual latitude since value is offset from previous value.
        $lat += $dlat;

        // The next values will correspond to the longitude for this point.
        $shift = 0;
        $result = 0;
        do {
            $b = ord(substr($encoded, $index++)) - 63;
            $result |= ($b & 0x1f) << $shift;
            $shift += 5;
        } while ($b >= 0x20);

        $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        $lng += $dlng;

        // The actual latitude and longitude values were multiplied by
        // 1e5 before encoding so that they could be converted to a 32-bit
        // integer representation. (With a decimal accuracy of 5 places)
        // Convert back to original values.
        $points[] = array($lat * 1e-5, $lng * 1e-5);
    }

    return $points;
}

// http://www.derivante.com/2009/04/20/phpkml-polyline-simplification-with-douglas-peucker/
//
class PolylineEncoder
{

    var $numLevels;
    var $zoomFactor;
    var $verySmall;
    var $forceEndpoints;
    var $zoomLevelBreaks;

    function __construct($numLevels = 18, $zoomFactor = 2, $verySmall = 0.00001)
    {
        $this->numLevels = $numLevels;
        $this->zoomFactor = $zoomFactor;
        $this->verySmall = $verySmall;
        $this->forceEndpoints = true;

        for ($i = 0; $i < $this->numLevels; $i++) {
            $this->zoomLevelBreaks[$i] = $this->verySmall * pow($this->zoomFactor, $this->numLevels - $i - 1);

        }
    }

    function computeLevel($dd)
    {
        if ($dd > $this->verySmall) {
            $lev = 0;
            while ($dd < $this->zoomLevelBreaks[$lev]) {
                $lev++;
            }
        }
        return $lev;
    }

    function dpEncode($points)
    {
        $dists = array();
        $stack = array();

        if (count($points) > 2) {
            $stack[] = array(0, count($points) - 1);
            while (count($stack) > 0) {
                $current = array_pop($stack);
                $maxDist = 0;
                for ($i = $current[0] + 1; $i < $current[1]; $i++) {
                    $temp = $this->distance($points[$i], $points[$current[0]], $points[$current[1]]);
                    if ($temp > $maxDist) {
                        $maxDist = $temp;
                        $maxLoc = $i;
                        if (!isset($absMaxDist) || $maxDist > $absMaxDist) {
                            $absMaxDist = $maxDist;
                        }
                    }
                }
                if ($maxDist > $this->verySmall) {
                    $dists[$maxLoc] = $maxDist;
                    array_push($stack, array($current[0], $maxLoc));
                    array_push($stack, array($maxLoc, $current[1]));
                }
            }
        }

        $encodedPoints = $this->createEncodings($points, $dists);
        $encodedLevels = $this->encodeLevels($points, $dists, $absMaxDist);
        $encodedPointsLiteral = str_replace('\\', "\\\\", $encodedPoints);

        return array($encodedPoints, $encodedLevels, $encodedPointsLiteral);
    }

    function distance($p0, $p1, $p2)
    {
        if ($p1[0] == $p2[0] && $p1[1] == $p2[1]) {
            $out = sqrt(pow($p2[0] - $p0[0], 2) + pow($p2[1] - $p0[1], 2));
        } else {
            $u = (($p0[0] - $p1[0]) * ($p2[0] - $p1[0]) + ($p0[1] - $p1[1]) * ($p2[1] - $p1[1])) / (pow($p2[0] - $p1[0], 2) + pow($p2[1] - $p1[1], 2));
            if ($u <= 0) {
                $out = sqrt(pow($p0[0] - $p1[0], 2) + pow($p0[1] - $p1[1], 2));
            }
            if ($u >= 1) {
                $out = sqrt(pow($p0[0] - $p2[0], 2) + pow($p0[1] - $p2[1], 2));
            }
            if (0 < $u && $u < 1) {
                $out = sqrt(pow($p0[0] - $p1[0] - $u * ($p2[0] - $p1[0]), 2) + pow($p0[1] - $p1[1] - $u * ($p2[1] - $p1[1]), 2));
            }
        }
        return $out;
    }

    function encodeSignedNumber($num)
    {
        $sgn_num = $num << 1;
        if ($num < 0) {
            $sgn_num = ~($sgn_num);
        }
        return $this->encodeNumber($sgn_num);
    }

    function createEncodings($points, $dists)
    {
        $encoded_points = '';

        for ($i = 0; $i < count($points); $i++) {
            if (isset($dists[$i]) || $i == 0 || $i == count($points) - 1) {
                $point = $points[$i];
                $lat = $point[0];
                $lng = $point[1];
                $late5 = floor($lat * 1e5);
                $lnge5 = floor($lng * 1e5);
                $dlat = (isset($plat)) ? $late5 - $plat : $late5;
                $dlng = (isset($plng)) ? $lnge5 - $plng : $lnge5;
                $plat = $late5;
                $plng = $lnge5;
                $encoded_points .= $this->encodeSignedNumber($dlat) . $this->encodeSignedNumber($dlng);

            }
        }
        return $encoded_points;
    }

    function encodeLevels($points, $dists, $absMaxDist)
    {
        $encoded_levels = '';

        if ($this->forceEndpoints) {
            $encoded_levels .= $this->encodeNumber($this->numLevels - 1);
        } else {
            $encoded_levels .= $this->encodeNumber($this->numLevels - $this->computeLevel($absMaxDist) - 1);

        }
        for ($i = 1; $i < count($points) - 1; $i++) {
            if (isset($dists[$i])) {
                $encoded_levels .= $this->encodeNumber($this->numLevels - $this->computeLevel($dists[$i]) - 1);

            }
        }
        if ($this->forceEndpoints) {
            $encoded_levels .= $this->encodeNumber($this->numLevels - 1);
        } else {
            $encoded_levels .= $this->encodeNumber($this->numLevels - $this->computeLevel($absMaxDist) - 1);

        }
        return $encoded_levels;
    }

    function encodeNumber($num)
    {
        $encodeString = '';
        while ($num >= 0x20) {
            $nextValue = (0x20 | ($num & 0x1f)) + 63;
            $encodeString .= chr($nextValue);
            $num >>= 5;
        }
        $finalValue = $num + 63;
        $encodeString .= chr($finalValue);
        return $encodeString;
    }

}

/*========================================================
/* Implementation of Douglas-Peuker in PHP.
/*
/* Anthony Cartmell
/* ajcartmell@fonant.com
/*
/* This software is provided as-is, with no warranty.
/* Please use and modify freely for anything you like :)
/* Version 1.1 - 17 Jan 2007  (fixes nasty bug!)
/*========================================================*/

class PolylineReducer
{
    var $original_points = array();
    var $tolerance;
    var $tolerance_squared;

    public function __construct($geopoints_array)
    {
        foreach ($geopoints_array as $point) {
            $this->original_points[] = new Vector($point[0], $point[1]);
        }
        /*----- Include first and last points -----*/
        $this->original_points[0]->include = true;
        $this->original_points[count($this->original_points) - 1]->include = true;
    }

    /**
     * Returns a list of GeoPoints for the simplest polyline that leaves
     * no original point more than $tolerance away from it.
     *
     * @param float  $tolerance
     * @return Geopoint array
     */
    public function SimplerLine($tolerance = 0.5)
    {
        $this->tolerance = $tolerance;
        $this->tolerance_squared = $tolerance * $tolerance;
        $this->DouglasPeucker(0, count($this->original_points) - 1);
        foreach ($this->original_points as $point) {
            if ($point->include) {
                $out[] = Array($point->x, $point->y);
            }
        }
        return $out;
    }

    /**
     * Douglas-Peuker polyline simplification algorithm. First draws single line
     * from start to end. Then finds largest deviation from this straight line, and if
     * greater than tolerance, includes that point, splitting the original line into
     * two new lines. Repeats recursively for each new line created.
     *
     * @param int $start_vertex_index
     * @param int $end_vertex_index
     */
    private function DouglasPeucker($start_vertex_index, $end_vertex_index)
    {
        if ($end_vertex_index <= $start_vertex_index + 1) // there is nothing to simplify
            return;

        // Make line from start to end
        $line = new Line($this->original_points[$start_vertex_index], $this->original_points[$end_vertex_index]);

        // Find largest distance from intermediate points to this line
        $max_dist_to_line_squared = 0;
        for ($index = $start_vertex_index + 1; $index < $end_vertex_index - 1; $index++) {
            $dist_to_line_squared = $line->DistanceToPointSquared($this->original_points[$index]);
            if ($dist_to_line_squared > $max_dist_to_line_squared) {
                $max_dist_to_line_squared = $dist_to_line_squared;
                $max_dist_index = $index;
            }
        }

        // Check max distance with tolerance
        if ($max_dist_to_line_squared > $this->tolerance_squared) // error is worse than the tolerance
        {
            // split the polyline at the farthest vertex from S
            $this->original_points[$max_dist_index]->include = true;
            // recursively simplify the two subpolylines
            $this->DouglasPeucker($start_vertex_index, $max_dist_index);
            $this->DouglasPeucker($max_dist_index, $end_vertex_index);
        }
        // else the approximation is OK, so ignore intermediate vertices
    }

}


class Vector
{
    public $x;
    public $y;
    public $include;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function DotProduct(Vector $v)
    {
        $dot = ($this->x * $v->x + $this->y * $v->y);
        return $dot;
    }

    public function Magnitude()
    {
        return sqrt($this->x * $this->x + $this->y * $this->y);
    }

    public function UnitVector()
    {
        if ($this->Magnitude() == 0) return new Vector(0, 0);
        return new Vector($this->x / $this->Magnitude(), $this->y / $this->Magnitude());
    }
}

class Line
{
    public $p1;
    public $p2;

    public function __construct(Vector $p1, Vector $p2)
    {
        $this->p1 = $p1;
        $this->p2 = $p2;
    }

    public function LengthSquared()
    {
        $dx = $this->p1->x - $this->p2->x;
        $dy = $this->p1->y - $this->p2->y;
        return $dx * $dx + $dy * $dy;
    }

    public function DistanceToPointSquared(Vector $point)
    {
        $v = new Vector($point->x - $this->p1->x, $point->y - $this->p1->y);
        $l = new Vector($this->p2->x - $this->p1->x, $this->p2->y - $this->p1->y);
        $dot = $v->DotProduct($l->UnitVector());
        if ($dot <= 0) // Point nearest P1
        {
            $dl = new Line($this->p1, $point);
            return $dl->LengthSquared();
        }
        if (($dot * $dot) >= $this->LengthSquared()) // Point nearest P2
        {
            $dl = new Line($this->p2, $point);
            return $dl->LengthSquared();
        } else // Point within line
        {
            $v2 = new Line($this->p1, $point);
            $h = $v2->LengthSquared();
            return $h - $dot * $dot;
        }
    }
}


function simplePolyline($points)
{
    $reducer = new PolylineReducer($points);
    $simple = $reducer->SimplerLine(0.001);
    $p = new PolylineEncoder;
    $pl = $p->dpEncode($simple);
    return $pl[2];
}