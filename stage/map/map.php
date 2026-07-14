<!DOCTYPE html>
<html lang="en">
  <head>
    <title></title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
    #map {
  height: 400px;
 width : 100%
}

html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}
    </style>
  </head>
  <body>
        
    <div id="map"></div>

    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbV6guze9AOGJf91eU07rfrrK0qnICW1E&callback=initMap&v=weekly"
      defer
    ></script>
    <script>
      
        function initMap() {
        var option = {
            zoom: 15,
            center : { lat: 11.8822394, lng: 79.7300253 }
          }
        // { lat: 11.916064, lng: 79.812325 }
  var map = new google.maps.Map(document.getElementById("map"),option);
    
  // var marker = new google.maps.Marker({
  //   map: map,
  //   position: option.center
  // });
  // var infoWindow = new google.maps.InfoWindow({
  //   content: "abirami soaps",
  // });
  // marker.addListener("click",function(){
  //   infoWindow.open(map,marker);
  // });
  let directionsService = new google.maps.DirectionsService;
  let directionsRenderer = new google.maps.DirectionsRenderer;
      var arr = [
                
                    { 
                      origin : {lat: 11.8822394, lng: 79.7300253 } ,
                      destination : { lat: 11.916064, lng: 79.812325 } ,
                      content : "1",

                      //optimizeWaypoints: true,
                    //travelMode: google.maps.TravelMode.DRIVING
                    },

                    // { 
                    //   coords : { lat: 11.916064, lng: 79.812325 } ,
                    //   content : "hello"
                    // },

                    { 
                      origin : { lat: 11.877740, lng: 79.721661 } ,
                      destination : { lat: 11.891457, lng: 79.735390 } ,
                      content : "2",
                    //   optimizeWaypoints: true,
                    // travelMode: google.maps.TravelMode.DRIVING
                    },
                    // { 
                    //   coords : { lat: 11.891457, lng: 79.735390 } ,
                    //   content : "2"
                    // },
                    { 
                      origin : { lat: 11.891010, lng: 79.751709 } ,
                      destination : { lat: 11.901829, lng: 79.752502 } ,
                      content : "3",
                    //   optimizeWaypoints: true,
                    // travelMode: google.maps.TravelMode.DRIVING
                    },
                    
                    // { 
                    //   coords : { lat: 11.901829, lng: 79.752502 } ,
                    //   content : "4"
                    // },
                    // { 
                    //   coords : { lat: 11.908273, lng: 79.754550 } ,
                    //   content : "5"
                    // },
                    
                
      ];

      console.log(typeof arr.length);
    
      for (let i = 0; i < arr.length; i++) {
        
        //console.log(arr[i].origin);
          var points = {
            origin : arr[i].origin,
            destination : arr[i].destination,
            
          }
          
          console.log("points",points);
        var arraydata = arr[i];
       
        for(var data in arraydata){
          //console.log(arraydata[data]);
          setdata(arraydata[data]);
         
        }
        //console.log(arraydata[data].origin);
        calculateAndDisplayRoute(directionsService,directionsRenderer,points); 
        directionsRenderer.setMap(map); 
        // google.maps.TravelMode.DRIVING
      }
      
    function setdata(props){
    var marker = new google.maps.Marker({
    map: map,
    position:props,
    
  });

      if (props) {
          var infoWindow = new google.maps.InfoWindow({
          content: props.content,
  });
      }

          marker.addListener("click",function(){
        infoWindow.open(map,marker);
      });

}
// function calculateAndDisplayRoute(directionsService,points) {
//   //var directionsDisplay = new google.maps.DirectionsRenderer;
  
//   //var position = new google.maps.LatLng(position.origin,points.destination);
// directionsService.route(
//         console.log("hai",points.origin),
//         points,
//          function (response, status){
//           console.log(response);
//           if (status === "OK") {
//             directionsRenderer.setDirections(response);
//             directionsRenderer.setMap(map);  

//           } else {
//             console.log("Directions request failed due to " + status);
//           }
//         }
//       );
//       }
//////////////////////////////////////////////////////////////////////
function calculateAndDisplayRoute(directionsService, directionsRenderer , points) {
  
      directionsService.route({

          origin: points.origin,
          destination: points.destination,
          travelMode: 'DRIVING'
        }, function(response, status) {
          console.log("response",response);
          if (status === 'OK') {
            directionsRenderer.setDirections(response);
                 
          } else {
            console.log('Directions request failed due to ' + status);
          }
        });
      }
}


    </script>
    

  </body>
</html>