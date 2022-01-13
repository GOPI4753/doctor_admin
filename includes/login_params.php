<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://code.jquery.com/jquery-1.5.min.js"
            integrity="sha256-IpJ49qnBwn/FW+xQ8GVI/mTCYp9Z9GLVDKwo5lu5OoM=" crossorigin="anonymous"></script> -->
    <script src="/assets/js/v1.5_cdn.js"></script>
    <script src="/assets/js/imagemapster.js"></script>
    <title>Document</title>
</head>

<body>
    <?php
    // $url = "' . 'login_params.php?tethdata=xyz&mouthdata=123";
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    json_decode($url);
    
    $parts = parse_url($url);
    // print_r($url);
    // exit;

    
    parse_str($parts['query'], $query);
    // print_r($query);
    
    // echo json_decode($query['teethdata']);
    // echo json_decode($query['mouthData']);
    // exit;

    ?>
    <div>
        <img src="/assets/images/mouth.jpeg" usemap="#usa" style="width: 400px;height: auto;">
        <img src="/assets/images/teeths.jpeg" usemap="#bsa" style="width:400px;height: auto;">
    </div>
    <map id="mouth_map" name="usa">
        <!-- <area href="#" state="NV" full="Nevada" shape="rect" coords="200,50,160,80"> -->
    </map>
    <map id="teeth_map" name="bsa">
        <!-- <area href="#" state="NV" full="Nevada" shape="rect" coords="200,50,160,80"> -->
    </map>
   
            
    <script>
 var mouth_map = [
    {
        id: '1',
        name: 'Lip',
        shape: 'rectangle',
        x2: 250,
        y2: 25,
        x1: 170,
        y1: 10,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '2',
        name: 'Labial',
        shape: 'rectangle',
        x2: 200,
        y2: 50,
        x1: 160,
        y1: 30,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '3',
        name: 'Mucosa',
        shape: 'rectangle',
        x2: 260,
        y2: 50,
        x1: 220,
        y1: 30,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '4',
        name: 'vestibule',
        shape: 'rectangle',
        x2: 180,
        y2: 75,
        x1: 130,
        y1: 65,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '5',
        name: 'gigiva',
        shape: 'rectangle',
        x2: 170,
        y2: 100,
        x1: 130,
        y1: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '6',
        name: 'Palate',
        shape: 'rectangle',
        x2: 235,
        y2: 120,
        x1: 180,
        y1: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '7',
        name: 'Soft',
        shape: 'rectangle',
        x2: 235,
        y2: 150,
        x1: 180,
        y1: 130,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '8',
        name: 'Buccal',
        shape: 'rectangle',
        x2: 120,
        y2: 200,
        x1: 40,
        y1: 130,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '9',
        name: 'Left',
        shape: 'rectangle',
        x2: 360,
        y2: 200,
        x1: 290,
        y1: 130,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
    {
        id: '10',
        name: 'Tounge',
        shape: 'rectangle',
        x2: 235,
        y2: 230,
        x1: 180,
        y1: 200,
        // prefill: getRandomColor(),
        fill: 'blue',
    },
];
                 var data_map = <?php  echo json_decode($query['mouthData']); ?>

                 mouth_map.forEach(function (element) {

data_map.forEach(function (data) {
    if (element.id == data) {
        console.log("found", element)
        var e = $('<area href="#" state="NV" full=' + element.name + ' shape="rect" coords="' + (element.x1 - 10) + ',' + (element.y1 - 5) + ',' + (element.x2 - 10) + ',' + (element.y2 - 5) +'">');
        $('#mouth_map').append(e);
        e.attr('id', 'myid');
    }
})
})
var TEETH_MAP = [
    {
        id: '1',
        name: 'Lip',
        shape: 'rectangle',
        x1: 10,
        x2: 55,
        y1: 10,
        y2: 85,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '2',
        name: 'Labial',
        shape: 'rectangle',
        x1: 65,
        x2: 110,
        y1: 10,
        y2: 85,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '3',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 115,
        x2: 160,
        y1: 10,
        y2: 85,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '4',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 172,
        x2: 210,
        y1: 10,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '5',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 220,
        x2: 260,
        y1: 10,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '6',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 280,
        x2: 320,
        y1: 1,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '7',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 330,
        x2: 360,
        y1: 10,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '8',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 380,
        x2: 420,
        y1: 10,
        y2: 95,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '9',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 430,
        x2: 467,
        y1: 10,
        y2: 95,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '10',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 480,
        x2: 515,
        y1: 10,
        y2: 95,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '11',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 527,
        x2: 570,
        y1: 1,
        y2: 95,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '12',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 585,
        x2: 618,
        y1: 10,
        y2: 95,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '13',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 635,
        x2: 670,
        y1: 10,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '14',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 685,
        x2: 730,
        y1: 10,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '15',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 740,
        x2: 780,
        y1: 10,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '16',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 790,
        x2: 840,
        y1: 10,
        y2: 90,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '101',
        name: 'Lip',
        shape: 'rectangle',
        x1: 10,
        x2: 50,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '102',
        name: 'Labial',
        shape: 'rectangle',
        x1: 60,
        x2: 100,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '103',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 110,
        x2: 155,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '104',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 165,
        x2: 198,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '105',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 220,
        x2: 250,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '106',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 270,
        x2: 310,
        y1: 110,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '107',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 320,
        x2: 355,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '108',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 370,
        x2: 410,
        y1: 127,
        y2: 220,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '109',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 425,
        x2: 470,
        y1: 127,
        y2: 220,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '110',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 480,
        x2: 510,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '111',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 530,
        x2: 565,
        y1: 110,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '112',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 580,
        x2: 620,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '113',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 630,
        x2: 670,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '114',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 680,
        x2: 725,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '115',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 735,
        x2: 775,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
    {
        id: '116',
        name: 'Mucosa',
        shape: 'rectangle',
        x1: 785,
        x2: 850,
        y1: 127,
        y2: 210,
        // prefill: getRandomColor(),
        fill: 'blue',
        selectedProblemId: 0,
    },
];

var teethdata_map = <?php echo json_decode($query['teethdata']);?>;
TEETH_MAP.forEach(function(element) {
    console.log(element)

    teethdata_map.forEach(function (data) {

        if (element.id == data.teeth) {
            console.log("found", element)
            var e = $('<area href="#" state="NV" full=' + element.name + ' shape="rect" coords="' + element.x1 + ',' + element.y1 + ',' + element.x2 + ',' + element.y2 + '">');
            $('#teeth_map').append(e);
            e.attr('id', 'myid');
        }
    })
})

var basic_opts = {
    mapKey: 'state'
};

var initial_opts = $.extend({}, basic_opts,
    {
        staticState: true,
        fill: false,
        stroke: true,
        strokeWidth: 2,
        strokeColor: '000000'
    });

$('map').mapster(initial_opts)
    .mapster('set', true, 'CA', {
        fill: true,
        fillColor: '00ff00'
    })
    .mapster('snapshot')
    .mapster('rebind', basic_opts);
$('img').mapster({
    areas: [
        {
            key: 'TX',
            fillColor: '00ff00',
            staticState: true,
            stroke: true
        },
        {
            key: 'NV',
            fillColor: 'ff0000',
            staticState: true
        }

    ],
    mapKey: 'state'
});

             </script>


 
</body>

</html>