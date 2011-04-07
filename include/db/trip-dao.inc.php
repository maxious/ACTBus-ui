<?php
function getTrip($tripID) {
    global $conn;
        $query = "Select * from trips where trip_id = '$tripID' join routes on trips.route_id = routes.route_id LIMIT 1";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	return pg_fetch_assoc($result);    
   }
function getTripShape() {
    /* def handle_json_GET_tripstoptimes(self, params):
    schedule = self.server.schedule
    try:
      trip = schedule.GetTrip(params.get('trip'))
    except KeyError:
       # if a non-existent trip is searched for, the return nothing
      return
    time_stops = trip.GetTimeInterpolatedStops()
    stops = []
    times = []
    for arr,ts,is_timingpoint in time_stops:
      stops.append(StopToTuple(ts.stop))
      times.append(arr)
    return [stops, times]

  def handle_json_GET_tripshape(self, params):
    schedule = self.server.schedule
    try:
      trip = schedule.GetTrip(params.get('trip'))
    except KeyError:
       # if a non-existent trip is searched for, the return nothing
      return
    points = []
    if trip.shape_id:
      shape = schedule.GetShape(trip.shape_id)
      for (lat, lon, dist) in shape.points:
        points.append((lat, lon))
    else:
      time_stops = trip.GetTimeStops()
      for arr,dep,stop in time_stops:
        points.append((stop.stop_lat, stop.stop_lon))
    return points*/
}
function getTimeInterpolatedTrip($tripID) {
    /*     rv = []

    stoptimes = self.GetStopTimes()
    # If there are no stoptimes [] is the correct return value but if the start
    # or end are missing times there is no correct return value.
    if not stoptimes:
      return []
    if (stoptimes[0].GetTimeSecs() is None or
        stoptimes[-1].GetTimeSecs() is None):
      raise ValueError("%s must have time at first and last stop" % (self))

    cur_timepoint = None
    next_timepoint = None
    distance_between_timepoints = 0
    distance_traveled_between_timepoints = 0

    for i, st in enumerate(stoptimes):
      if st.GetTimeSecs() != None:
        cur_timepoint = st
        distance_between_timepoints = 0
        distance_traveled_between_timepoints = 0
        if i + 1 < len(stoptimes):
          k = i + 1
          distance_between_timepoints += util.ApproximateDistanceBetweenStops(stoptimes[k-1].stop, stoptimes[k].stop)
          while stoptimes[k].GetTimeSecs() == None:
            k += 1
            distance_between_timepoints += util.ApproximateDistanceBetweenStops(stoptimes[k-1].stop, stoptimes[k].stop)
          next_timepoint = stoptimes[k]
        rv.append( (st.GetTimeSecs(), st, True) )
      else:
        distance_traveled_between_timepoints += util.ApproximateDistanceBetweenStops(stoptimes[i-1].stop, st.stop)
        distance_percent = distance_traveled_between_timepoints / distance_between_timepoints
        total_time = next_timepoint.GetTimeSecs() - cur_timepoint.GetTimeSecs()
        time_estimate = distance_percent * total_time + cur_timepoint.GetTimeSecs()
        rv.append( (int(round(time_estimate)), st, False) )

    return rv*/
}
function getTimeInterpolatedTripAtStop($trip_id, $stop_sequence) {
   foreach(getTimeInterpolatedTrip($tripID) as $tripStop) {
    if ($tripStop['stop_sequence'] == $stop_sequence) return $tripStop;
   }
   return Array();
}

function getTripStartTime($tripID) {
    $query = 'SELECT arrival_secs,departure_secs FROM stop_times WHERE trip_id=? ORDER BY stop_sequence LIMIT 1';
    
}

function viaPointNames($tripid, $stopid)
{
    global $conn;
        $query = "SELECT stop_name
FROM stop_times join stops on stops.stop_id = stop_times.stop_id
WHERE stop_times.trip_id = '$tripid'
AND stop_sequence > '$stop_sequence'
AND substr(stop_code,1,2) != 'Wj' ORDER BY stop_sequence";
        debug($query,"database");
	$result = pg_query($conn, $query);
	if (!$result) {
		databaseError(pg_result_error($result));
		return Array();
	}
	$pointNames = pg_fetch_all($result);
	return r_implode(", ", $pointNames);
}
?>