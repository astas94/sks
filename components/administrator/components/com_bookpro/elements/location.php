<?php


/**
 * @package 	Bookpro
 * @author 		Ngo Van Quan
 * @link 		http://joombooking.com
 * @copyright 	Copyright (C) 2011 - 2012 Ngo Van Quan
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: bookpro.php 27 2012-07-08 17:15:11Z quannv $
 **/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.parameter.element');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
class JFormFieldLocation extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'Location';

	var $latitude  = '27.2257277';

	var $longitude  = '2.4929454000000533';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
		$html = array();

		$latitude            = $this->element['latitude'] ? (string) $this->element['latitude'] : $this->latitude;
		$longitude            = $this->element['longitude'] ? (string) $this->element['longitude'] : $this->longitude;
		$autocomplete   = ((string) $this->element['autocomplete'] == 'true') ? true : false;
		$typeahead      = $autocomplete ? 'data-provide="typeahead" autocomplete="off"' : '';
		$class          = $autocomplete ? '' : 'class="input-append"';
		$prefix         = $this->formControl . '_';
		
		$prefix_name= $this->formControl.'[';
		$html[]         = '<div ' . $class . '>';
		$html[]         = '<input type="text" name="' . $this->name . '" id="' . $this->id . '" value="" ' . $typeahead . ' placeholder="Type a location" />';
		if(!$autocomplete)
			$html[]         = '<button type="button" id="' . $this->id . '-load" class="btn btn-success">Search</button>';
		$html[]         = '</div>';
		$html[]         = '<input type="hidden" name="jform[latitude]" id="' . $prefix . 'latitude" value="' . $latitude . '" />';
		$html[]         = '<input type="hidden" name="jform[longitude]" id="' . $prefix . 'longitude" value="' . $longitude . '" />';

		return implode("\n", $html);
	}

	/**
	 * Method to get the field map.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	public function getMap()
	{
		$html = array();

		// Initialize some field attributes.
		$class          = $this->element['class'] ? ' class="map ' . (string) $this->element['class'] . '"' : ' class="map"';
		$latitude            = $this->element['latitude'] ? (string) $this->element['latitude'] : $this->latitude;
		$longitude            = $this->element['longitude'] ? (string) $this->element['longitude'] : $this->longitude;
		$autocomplete   = ((string) $this->element['autocomplete'] == 'true') ? true : false;
		$zoom           = $this->element['zoom'] ? (int) $this->element['zoom'] : 17;
		$width          = $this->element['width'] ? (int) $this->element['width'] : 300;
		$height         = $this->element['height'] ? (int) $this->element['height'] : 300;
		$prefix         = $this->formControl . '_';

	
		
		$javascript[]   = 'var map;';
		$javascript[]   = 'jQuery(function() {';
		$javascript[]   = '    var service = new google.maps.places.AutocompleteService();';
		$javascript[]   = '    var geocoder = new google.maps.Geocoder();';
		$javascript[]   = '    var hasLocation = false;';
		$javascript[]   = '    var latlng = new google.maps.LatLng(' . $latitude . ', ' . $longitude  . ');';
		$javascript[]   = '    var options = {';
		$javascript[]   = '        zoom: ' . $zoom . ',';
		$javascript[]   = '        center: latlng,';
		$javascript[]   = '        mapTypeId: google.maps.MapTypeId.ROADMAP';
		$javascript[]   = '    };';
		$javascript[]   = '    if(jQuery("#' . $this->id . '_map").length > 0) {';
		$javascript[]   = '        map = new google.maps.Map(document.getElementById("' . $this->id . '_map"), options);';
		$javascript[]   = '        if(!hasLocation) {';
		$javascript[]   = '            map.setZoom(13);';
		$javascript[]   = '        }';
		$javascript[]   = '    var marker = new google.maps.Marker({';
		$javascript[]   = '                position: latlng,';
		$javascript[]   = '                map: map,';
		$javascript[]   = '                title: "Job Location"';
		$javascript[]   = '            });';
		$javascript[]   = '        google.maps.event.addListener(map, "click", function(event) {';
		$javascript[]   = '            reverseGeocode(event.latLng);';
		$javascript[]   = '        })';
		$javascript[]   = '        jQuery("#' . $this->id . '-load").click(function() {';
		$javascript[]   = '            if(jQuery("#' . $this->id . '").val() != "") {';
		$javascript[]   = '                geocode(jQuery("#' . $this->id . '").val());';
		$javascript[]   = '                return false;';
		$javascript[]   = '            } else {';
		$javascript[]   = '                marker.setMap(null);';
		$javascript[]   = '                return false;';
		$javascript[]   = '            }';
		$javascript[]   = '            return false;';
		$javascript[]   = '        })';
		$javascript[]   = '        jQuery("#' . $this->id . '").keyup(function(e) {';
		$javascript[]   = '            if(e.keyCode == 13)';
		$javascript[]   = '                jQuery("#' . $this->id . '-load").click();';
		$javascript[]   = '        })';
		$javascript[]   = '    }';
		if($autocomplete)
		{
			$javascript[]   = '    jQuery("#' . $this->id . '").typeahead({';
			$javascript[]   = '        source: function(query, process){';
			$javascript[]   = '            service.getPlacePredictions({ input: query }, function(predictions, status) {';
			$javascript[]   = '                if (status == google.maps.places.PlacesServiceStatus.OK) {';
			$javascript[]   = '                    process(jQuery.map(predictions, function(prediction) {';
			$javascript[]   = '                        return prediction.description;';
			$javascript[]   = '                    }))';
			$javascript[]   = '                }';
			$javascript[]   = '            })';
			$javascript[]   = '        },';
			$javascript[]   = '        updater: function (item) {';
			$javascript[]   = '            geocode(results[0].geometry.location);';
			$javascript[]   = '            return item;';
			$javascript[]   = '        }';
			$javascript[]   = '    })';
		}
		$javascript[]   = '    function placeMarker(location) {';
		$javascript[]   = '        if (marker == "") {';
		$javascript[]   = '            marker = new google.maps.Marker({';
		$javascript[]   = '                position: latlng,';
		$javascript[]   = '                map: map,';
		$javascript[]   = '                title: "Job Location"';
		$javascript[]   = '            })';
		$javascript[]   = '        }';
		$javascript[]   = '        marker.setPosition(location);';
		$javascript[]   = '        map.setCenter(location);';
		$javascript[]   = '        map.setZoom(12);';
		$javascript[]   = '        if((location.lat() != "") && (location.lng() != "")) {';
		$javascript[]   = '            jQuery("#' . $prefix . 'latitude").val(location.lat());';
		$javascript[]   = '            jQuery("#' . $prefix . 'longitude").val(location.lng());';
		$javascript[]   = '        }';
		$javascript[]   = '    }';
		$javascript[]   = '    function geocode(address) {';
		$javascript[]   = '        if (geocoder) {';
		$javascript[]   = '            geocoder.geocode({"address": address}, function(results, status) {';
		$javascript[]   = '                if (status != google.maps.GeocoderStatus.OK) {';
		$javascript[]   = '                    alert("Cannot find address");';
		$javascript[]   = '                    return;';
		$javascript[]   = '                }';
		$javascript[]   = '                placeMarker(results[0].geometry.location);';
		$javascript[]   = '                reverseGeocode(results[0].geometry.location);';
		$javascript[]   = '                if(!hasLocation) {';
		$javascript[]   = '                    map.setZoom(12);';
		$javascript[]   = '                    hasLocation = true;';
		$javascript[]   = '                }';
		$javascript[]   = '            })';
		$javascript[]   = '        }';
		$javascript[]   = '    }';
		$javascript[]   = '    function reverseGeocode(location) {';
		$javascript[]   = '        if (geocoder) {';
		$javascript[]   = '            geocoder.geocode({"latLng": location}, function(results, status) {';
		$javascript[]   = '                if (status == google.maps.GeocoderStatus.OK) {';
		$javascript[]   = '                    var address, city, country, state;';
		$javascript[]   = '                    for ( var i in results ) {';
		$javascript[]   = '                        var address_components = results[i]["address_components"];';
		$javascript[]   = '                        for ( var j in address_components ) {';
		$javascript[]   = '                            var types = address_components[j]["types"];';
		$javascript[]   = '                            var long_name = address_components[j]["long_name"];';
		$javascript[]   = '                            var short_name = address_components[j]["short_name"];';
		$javascript[]   = '                            if ( jQuery.inArray("locality", types) >= 0 && jQuery.inArray("political", types) >= 0 ) {';
		$javascript[]   = '                                city = long_name;';
		$javascript[]   = '                            }';
		$javascript[]   = '                            else if ( jQuery.inArray("administrative_area_level_1", types) >= 0 && jQuery.inArray("political", types) >= 0 ) {';
		$javascript[]   = '                                state = long_name;';
		$javascript[]   = '                            }';
		$javascript[]   = '                            else if ( jQuery.inArray("country", types) >= 0 && jQuery.inArray("political", types) >= 0 ) {';
		$javascript[]   = '                                country = long_name;';
		$javascript[]   = '                            }';
		$javascript[]   = '                        }';
		$javascript[]   = '                    }';
		$javascript[]   = '                    if((city) && (state) && (country))';
		$javascript[]   = '                        address = city + ", " + state + ", " + country;';
		$javascript[]   = '                    else if((city) && (state))';
		$javascript[]   = '                        address = city + ", " + state;';
		$javascript[]   = '                    else if((state) && (country))';
		$javascript[]   = '                        address = state + ", " + country;';
		$javascript[]   = '                    else if(country)';
		$javascript[]   = '                        address = country;';
		$javascript[]   = '                    jQuery("#' . $this->id . '").val(address);';
		$javascript[]   = '                    placeMarker(location);';
		$javascript[]   = '                    return true;';
		$javascript[]   = '                }';
		$javascript[]   = '            })';
		$javascript[]   = '        }';
		$javascript[]   = '        return false;';
		$javascript[]   = '    }';
		$javascript[]   = '})';

		// Fix Google Map Corrupted Controls in Twitter Bootstrap Modal
		$css[]          = '#' . $this->id . '_map img {';
		$css[]          = '    max-width: none';
		$css[]          = '}';
		$css[]          = '#' . $this->id . '_map label {';
		$css[]          = '    width: auto; display:inline;';
		$css[]          = '}';

		$document       = JFactory::getDocument();
		$document->addScript('http://maps.google.com/maps/api/js?sensor=false&libraries=places');
		$document->addScriptDeclaration(implode("\n", $javascript));
		$document->addStyleDeclaration(implode("\n", $css));

		$html[]         = '<div id="' . $this->id . '_map" ' . $class . 'style="height: ' . $height . 'px; width:"' . $width . 'px;""></div>';

		return implode("\n", $html);
	}
}