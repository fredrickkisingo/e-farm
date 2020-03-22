<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\GMaps;
use App\Map;

use App\Http\Requests;

class DirectionsController extends Controller
{

    protected $gmap;

    public function __construct(GMaps $gmap)
    {
        $this->gmap = $gmap;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    //Custom map controls //
        
    $leftTopControls = ['document.getElementById("leftTopControl")']; // values must be html or javascript element
    $this->gmap->injectControlsInLeftTop = $leftTopControls; // inject into map
    $leftCenterControls = ['document.getElementById("leftCenterControl")'];
    $this->gmap->injectControlsInLeftCenter = $leftCenterControls;
    $leftBottomControls = ['document.getElementById("leftBottomControl")'];
    $this->gmap->injectControlsInLeftBottom = $leftBottomControls;

    $bottomLeftControls = ['document.getElementById("bottomLeftControl")'];
    $this->gmap->injectControlsInBottomLeft = $bottomLeftControls;
    $bottomCenterControls = ['document.getElementById("bottomCenterControl")'];
    $this->gmap->injectControlsInBottomCenter = $bottomCenterControls;
    $bottomRightControls = ['document.getElementById("bottomRightControl")'];
    $this->gmap->injectControlsInBottomRight = $bottomRightControls;

    $rightTopControls = ['document.getElementById("rightTopControl")'];
    $this->gmap->injectControlsInRightTop = $rightTopControls;
    $rightCenterControls = ['document.getElementById("rightCenterControl")'];
    $this->gmap->injectControlsInRightCenter = $rightCenterControls;
    $rightBottomControls = ['document.getElementById("rightBottomControl")'];
    $this->gmap->injectControlsInRightBottom = $rightBottomControls;

    $topLeftControls = ['document.getElementById("topLeftControl")'];
    $this->gmap->injectControlsInTopLeft = $topLeftControls;
    $topCenterControls = ['document.getElementById("topCenterControl")'];
    $this->gmap->injectControlsInTopCenter = $topCenterControls;
    $topRightControls = ['document.getElementById("topRightControl")'];
    $this->gmap->injectControlsInTopRight = $topRightControls;

    $locate = 'Thika,Kenya';
    //a collection of addresses from maps DB
    $locateCollections = Map::pluck('product_address');
    $config = array();
    $config['map_height'] = "100%";
    $config['center'] = $locateCollections;
    $config['geocodeCaching'] = true;
    $config['zoom'] = "auto";
    $config['scrollwheel'] = false;
    $config['onboundschanged'] = 'if (!centreGot) {
        var mapCentre = map.getCenter();
        marker_0.setOptions({
            position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
        });
    }
    centreGot = true;';

    $this->gmap->initialize($config); // Initialize Map with custom configuration

    //  marker set up ready for positioning
    $marker = array();
    $marker['draggable'] = true;
    $marker['ondragend'] = '
    iw_' . $this->gmap->map_name . '.close();
    reverseGeocode(event.latLng, function(status, result, mark){
        if(status == 200){
            iw_' . $this->gmap->map_name . '.setContent(result);
            iw_' . $this->gmap->map_name . '.open(' . $this->gmap->map_name . ', mark);
        }
    }, this);
    ';
    $marker['position'] = $locate;
        $marker['infowindow_content'] = $locate;
        $this->gmap->add_marker($marker);

        $map = $this->gmap->create_map(); // This object will render javascript files and map view; you can call JS by $map['js'] and map view by $map['html']

        return view('pages.directions')->with('map', $map);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'start_location' => 'required',
            'end_location' => 'required',
        ]);

        $start = $request->input('start_location');
        $stop = $request->input('end_location');

        $config = array();

        //Directions
        $config['directions'] = true;
        $config['directionsStart'] = $start;
        $config['directionsEnd'] = $stop;
        $config['directionsDivID'] = 'directionsDiv';

        $config['map_height'] = "100%";
        $config['geocodeCaching'] = true;
        $config['zoom'] = "7.49";
        $config['scrollwheel'] = false;
        $config['onboundschanged'] = 'if (!centreGot) {
            var mapCentre = map.getCenter();
            marker_0.setOptions({
                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
            });
        }
        centreGot = true;';

        $this->gmap->initialize($config); // Initialize Map with custom configuration

        // set up the marker ready for positioning
        $marker = array();
        $marker['draggable'] = true;
        $marker['ondragend'] = '
        iw_' . $this->gmap->map_name . '.close();
        reverseGeocode(event.latLng, function(status, result, mark){
            if(status == 200){
                iw_' . $this->gmap->map_name . '.setContent(result);
                iw_' . $this->gmap->map_name . '.open(' . $this->gmap->map_name . ', mark);
            }
        }, this);
        ';

        $map = $this->gmap->create_map(); // This object will render javascript files and map view; you can call JS by $map['js'] and map view by $map['html']

        return view('pages.directions')->with('map', $map);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
