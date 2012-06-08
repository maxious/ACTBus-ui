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

function staticmap($mapPoints, $collapsible = true, $twotone = false, $path = false, $numbered = false, $encpolyline = false) {

    $markers = '';
    $height = 300;
    $width = $height;
    $index = 0;
    if (sizeof($mapPoints) < 1) {
       if ($encpolyline === false) {
        return 'map error';
        } else {
               $markers.= 'path='. ($encpolyline === false ? "" : 'enc:'.$encpolyline);
        }
    } else  if (sizeof($mapPoints) === 1 ) {
        if ($encpolyline === false) {
        $markers = 'markers='.$mapPoints[0][0].','.$mapPoints[0][1];
        } else {     
         $markers= 'markers='.$mapPoints[0][0].','.$mapPoints[0][1].'&amp;path='. ($encpolyline === false ? "" : 'enc:'.$encpolyline);
        }
    }
    else {
        if (!$numbered) {
            $markers = 'markers=';
        }
        if ($path) {
            $markers.= 'markers='.$mapPoints[0][0].','.$mapPoints[0][1].'&amp;path='. ($encpolyline === false ? "" : 'enc:'.$encpolyline);
        }
        foreach ($mapPoints as $index => $mapPoint) {
            if ($twotone && $index == 0) {
                $markers = 'markerd=color:red|' . $mapPoint[0] . ',' . $mapPoint[1] . '&amp;markers=';
            } else {
                if ($numbered) {
                    $label = ($index > 9 ? 9 : $index);
                    $markers.= 'markers=label:' . $label . '|' . $mapPoint[0] . ',' . $mapPoint[1];
                    if ($index + 1 != sizeof($mapPoints)) {
                        $markers.= '&amp;';
                    }
                } else {
                    $markers.= $mapPoint[0] . ',' . $mapPoint[1];
                    if ($index + 1 != sizeof($mapPoints)) {
                        $markers.= '|';
                    }
                }
                $index++;
            }
        }
    }
    $output = '';
    if ($collapsible) {
        $output.= '<div class="map geo" itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates" data-role="collapsible" data-collapsed="true"><h3>Open Map...</h3>
                <meta itemprop="latitude" content="'.$mapPoints[0][0].'" />
                 <abbr class="latitude" title="'.$mapPoints[0][0].'"></abbr> 
 <abbr class="longitude" title="'.$mapPoints[0][1].'"></abbr>
    <meta itemprop="longitude" content="'.$mapPoints[0][1].'" />';
    }
    if (isIOSDevice()) {
        $output.= '<img class="hiresmap" src="http://maps.googleapis.com/maps/api/staticmap?size=' . $width . 'x' . $height . '&amp;' . $markers . '&amp;scale=2&amp;sensor=true" width=' . $width . ' height=' . $height . ' alt="map of stop location">';
    }
    else {
        $output.= '<img class="lowresmap" src="http://maps.googleapis.com/maps/api/staticmap?size=' . $width . 'x' . $height . '&amp;' . $markers . '&amp;scale=1&amp;format=jpg&amp;sensor=true" width=' . $width . ' height=' . $height . ' alt="map of stop location">';
    }
    
    if ($collapsible) {
        $output.= '</div>';
    }
    return $output;
}

function distance($lat1, $lng1, $lat2, $lng2, $roundLargeValues = false) {
    $pi80 = M_PI / 180;
    $lat1*= $pi80;
    $lng1*= $pi80;
    $lat2*= $pi80;
    $lng2*= $pi80;
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
    }
    else
        return floor($km * 1000);
}

function decodePolylineToArray($encoded) {
    // source: http://latlongeeks.com/forum/viewtopic.php?f=4&t=5
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
            $result|= ($b & 0x1f) << $shift;
            $shift+= 5;
        }
        // Continue while the read byte is >= 0x20 since the last `chunk`
        // was not OR'd with 0x20 during the conversion process. (Signals the end)
        while ($b >= 0x20);
        // Check if negative, and convert. (All negative values have the last bit
        // set)
        $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        // Compute actual latitude since value is offset from previous value.
        $lat+= $dlat;
        // The next values will correspond to the longitude for this point.
        $shift = 0;
        $result = 0;
        do {
            $b = ord(substr($encoded, $index++)) - 63;
            $result|= ($b & 0x1f) << $shift;
            $shift+= 5;
        } while ($b >= 0x20);
        $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        $lng+= $dlng;
        // The actual latitude and longitude values were multiplied by
        // 1e5 before encoding so that they could be converted to a 32-bit
        // integer representation. (With a decimal accuracy of 5 places)
        // Convert back to original values.
        $points[] = array(
            $lat * 1e-5,
            $lng * 1e-5
        );
    }
    return $points;
}

function geocode($query, $giveOptions) {
    global $cloudmadeAPIkey;
    $url = 'http://geocoding.cloudmade.com/$cloudmadeAPIkey/geocoding/v2/find.js?query=' . urlencode($query) . '&bbox=-35.5,149.00,-35.15,149.1930&return_location=true&bbox_only=true';
    $contents = json_decode(getPage($url));
    if ($giveOptions)
        return $contents->features;
    elseif (isset($contents->features[0]->centroid))
        return $contents->features[0]->centroid->coordinates[0] . ',' . $contents->features[0]->centroid->coordinates[1];
    else
        return '';
}

function reverseGeocode($lat, $lng) {
    global $cloudmadeAPIkey;
    $url = 'http://geocoding.cloudmade.com/$cloudmadeAPIkey/geocoding/v2/find.js?around=' . $lat . ',' . $lng . '&distance=closest&object_type=road';
    $contents = json_decode(getPage($url));
    return $contents->features[0]->properties->name;
}
