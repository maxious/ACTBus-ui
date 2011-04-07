<?php
/* def StopZoneToTuple(stop):
  """Return tuple as expected by javascript function addStopMarkerFromList"""
  return (stop.stop_id, stop.stop_name, float(stop.stop_lat),
          float(stop.stop_lon), stop.location_type, stop.stop_code, stop.zone_id)
*/

function getStop($stopID) {
    
}

function getStops($timingPointsOnly = false) {
    
}

function stopsNear($lat,$lng,$limit) {
    
    /*
        -- Show a distance query and note, London is outside the 1000km tolerance
  SELECT name FROM global_points WHERE ST_DWithin(location, ST_GeographyFromText('SRID=4326;POINT(-110 29)'), 1000000, FALSE);
  // All the geography functions have the option of using a sphere calculation, by setting a final boolean parameter to 'FALSE'. This will somewhat speed up calculations, particularly for cases where the geometries are very simple.
    */
}

function stopsBySuburb($suburb) {
    
}

function stopRoutes($stopID,$service_period)
/*
  def handle_json_GET_stoproutes(self, params):
    """Given a stop_id return all routes to visit the stop."""
    schedule = self.server.schedule
    stop = schedule.GetStop(params.get('stop', None))
    service_period = params.get('service_period', None)
    trips = stop.GetTrips(schedule)
    result = {}
    for trip in trips:
      route = schedule.GetRoute(trip.route_id)
      if service_period == None or trip.service_id == service_period:
        if not route.route_short_name+route.route_long_name+trip.service_id in result:
          result[route.route_short_name+route.route_long_name+trip.service_id] = (route.route_id, route.route_short_name, route.route_long_name, trip.trip_id, trip.service_id)
    return result
*/

function stopTrips($stopID) {
    /*
  def handle_json_GET_stopalltrips(self, params):
    """Given a stop_id return all trips to visit the stop (without times)."""
    schedule = self.server.schedule
    stop = schedule.GetStop(params.get('stop', None))
    service_period = params.get('service_period', None)
    trips = stop.GetTrips(schedule)
    result = []
    for trip in trips:
      if service_period == None or trip.service_id == service_period:
        result.append((trip.trip_id, trip.service_id))
    return result
    */
}
function stopTripsWithTimes($stopID, $time, $service_period) {
    /*
  def handle_json_GET_stoptrips(self, params):
    """Given a stop_id and time in seconds since midnight return the next
    trips to visit the stop."""
    schedule = self.server.schedule
    stop = schedule.GetStop(params.get('stop', None))
    requested_time = int(params.get('time', 0))
    limit = int(params.get('limit', 15))
    service_period = params.get('service_period', None)
    time_range = int(params.get('time_range', 24*60*60))
    
    filtered_time_trips = []
    for trip, index in stop._GetTripIndex(schedule):
      tripstarttime = trip.GetStartTime()
      if tripstarttime > requested_time and tripstarttime < (requested_time + time_range):
        time, stoptime, tp = trip.GetTimeInterpolatedStops()[index]
        if time > requested_time and time < (requested_time + time_range):
          bisect.insort(filtered_time_trips, (time, (trip, index), tp))
    result = []
    for time, (trip, index), tp in filtered_time_trips:
      if len(result) > limit:
        break
      route = schedule.GetRoute(trip.route_id)
      trip_name = ''
      if route.route_short_name:
        trip_name += route.route_short_name
      if route.route_long_name:
        if len(trip_name):
          trip_name += " - "
        trip_name += route.route_long_name
      if service_period == None or trip.service_id == service_period:
        result.append((time, (trip.trip_id, trip_name, trip.service_id), tp))
    return result
    */
}
?>