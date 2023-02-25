<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            margin:0;
            padding:0;
        }
    </style>
</head>
<body>

<a onclick="redirect('{!! $creative->landing_url !!}')" href="{!! $creative->landing_url !!}" target="_blank">
    <img src="{!! asset('public/uploads/'.$creative->creative) !!}" alt="{!! $creative->creative_title !!}">
</a>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.dev.js"></script>

<script type="text/javascript">
    let socket = io('https://tracking.bikroyit.com');
    let server_url = 'https://tracking.bikroyit.com/visitor/save';
    function talk_to_server(request_type,location){
        console.log(location)
        let req = axios.get(
            server_url,
            {
                params:{
                    client_id:'{!! $creative->campaign->client->id !!}',
                    request_type:request_type,
                    campaign_type: '{!! $creative->size !!}',
                    campaign_id: '{!! $creative->campaign_id !!}',
                    ip_address:location.ip_address,
                    device:'Desktop',
                    region:location.region,
                    district:location.district,
                    city:location.city,
                    postal_code:location.postal_code,
                }
            }
        );
        req.then(function(res){
            console.log(res.data);
        });
        req.catch(function(error){
            console.log(error);
        });
    };
    axios.get('https://api.ipify.org').then(function(res){
        talk_to_server('View',{
            ip_address:res.data,
            region:null,
            district:null,
            city:null,
            postal_code:null,
        });
    }).catch(function(err){
        talk_to_server('View',{
            ip_address:null,
            region:null,
            district:null,
            city:null,
            postal_code:null,
        });
        console.log('stacked at ipify.org / '+ err);
    });

    function create_socket_connection(){

        socket.on('connect', function(){
            console.log('User Connected as client');
        });
        socket.on('event', function(data){
            console.log(data)
        });
        socket.on('disconnect', function(){
            console.log('User disconnected')
        });

    }
    function redirect(url) {

        talk_to_server('Click',{
            ip_address:null,
            region:null,
            district:null,
            city:null,
            postal_code:null,
        });
        window.open(url, '_blank');
    }

</script>
</body>
</html>