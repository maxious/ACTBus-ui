<?php

function getRoute($routeID) {
/*
        def handle_json_GET_routerow(self, params):
    schedule = self.server.schedule
    route = schedule.GetRoute(params.get('route', None))
    return [transitfeed.Route._FIELD_NAMES, route.GetFieldValuesTuple()]
*/
}
function getRoutes() {
/* def handle_json_GET_routes(self, params):
    """Return a list of all routes."""
    schedule = self.server.schedule
    result = []
    for r in schedule.GetRouteList():
      servicep = None
      for t in schedule.GetTripList():
        if t.route_id == r.route_id:
          servicep = t.service_period
          break
      result.append( (r.route_id, r.route_short_name, r.route_long_name, servicep.service_id) )
    result.sort(key = lambda x: x[1:3])
    return result
*/    
}

function findRouteByNumber($routeNumber) {
    /*
  def handle_json_GET_routesearch(self, params):
    """Return a list of routes with matching short name."""
    schedule = self.server.schedule
    routeshortname = params.get('routeshortname', None)
    result = []
    for r in schedule.GetRouteList():
      if r.route_short_name == routeshortname:
        servicep = None
        for t in schedule.GetTripList():
          if t.route_id == r.route_id:
            servicep = t.service_period
            break
        result.append( (r.route_id, r.route_short_name, r.route_long_name, servicep.service_id) )
    result.sort(key = lambda x: x[1:3])
    return result
    */
}

function getRouteNextTrip($routeID) {
    /*
  def handle_json_GET_routetrips(self, params):
    """ Get a trip for a route_id (preferablly the next one) """
    schedule = self.server.schedule
    query = params.get('route_id', None).lower()
    result = []
    for t in schedule.GetTripList():
      if t.route_id == query:
        try:
          starttime = t.GetStartTime()  
        except:
          print "Error for GetStartTime of trip #" + t.trip_id + sys.exc_info()[0]
        else:
          cursor = t._schedule._connection.cursor()
          cursor.execute(
              'SELECT arrival_secs,departure_secs FROM stop_times WHERE '
              'trip_id=? ORDER BY stop_sequence DESC LIMIT 1', (t.trip_id,))
          (arrival_secs, departure_secs) = cursor.fetchone()
          if arrival_secs != None:
            endtime = arrival_secs
          elif departure_secs != None:
            endtime = departure_secs
          else:
            endtime =0
          result.append ( (starttime, t.trip_id, endtime) )
    return sorted(result, key=lambda trip: trip[2])
    */
}

?>