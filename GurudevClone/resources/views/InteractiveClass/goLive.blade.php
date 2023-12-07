
<!DOCTYPE html>

<head>
    <link rel="icon" href="{{URL::asset('app_data/img/'.$app_config_data['titlebar_icon'])}}" type="image/x-icon"/>

    <!-- TITLE -->
    <title>Gurudev Academy - Live Class</title>
    <meta charset="utf-8" />
    <style>
        iframe{
            position:absolute;
            height: 100%;
        }
    </style>

</head>
<body>


<div id="meet"></div>
</body>
{{ Html::script("assets/js/vendors/jquery-3.2.1.min.js") }}
<script src='{{URL::asset('js/external.js')}}'></script>
<script>
    const domain = 'meet.jit.si';
    var options='';
    options = {
        roomName: '{{ $meeting['meeting_id'] }}',
        width: '100%',
        height: '99%',
        parentNode: document.querySelector('#meet'),
        userInfo: {
            displayName: '{{$userName}}'
        },
        configOverwrite: {
            startWithAudioMuted: false,
            chromeExtensionBanner: {
                // The chrome extension to be installed address
                url: 'ourwork.in',
                remoteVideoMenu:
                    {
                        disableKick: true,
                    },
                // Extensions info which allows checking if they are installed or not
                chromeExtensionsInfo: [
                    {
                        id: 'kglhbbefdnlheedjiejgomgmfplipfeb',
                        path: 'jitsi-logo-48x48.png'
                    }
                ]
            },
        },
        interfaceConfigOverwrite: {

            CONNECTION_INDICATOR_DISABLED: false,
            SHOW_JITSI_WATERMARK: false,
            SHOW_WATERMARK_FOR_GUESTS: false,
            DEFAULT_BACKGROUND: '#474747',
            DEFAULT_LOCAL_DISPLAY_NAME: 'me',
            DEFAULT_LOGO_URL: 'images/watermark.png',
            DEFAULT_REMOTE_DISPLAY_NAME: 'Fellow Jitster',
            TOOLBAR_BUTTONS: [
                'microphone', 'desktop', 'fullscreen','camera','close','hangup',
                'fodeviceselection',  'profile', 'chat', 'recording',
                'livestreaming', 'etherpad', 'sharedvideo',  'raisehand',
                'feedback', 'stats',  'shortcuts',
                'tileview'
            ],
        }
    };
    const api = new JitsiMeetExternalAPI(domain, options);
    api.addEventListener('readyToClose',  function(){
        window.location='{{url($url)}}'
    });
    var iframe = document.getElementById('jitsiConferenceFrame0');
    var style = document.createElement('style');
    style.textContent =
        'body {' +
        '  background-color: some-color;' +
        '  background-image: some-image;' +
        '}'
    ;
    iframe.contentDocument.head.appendChild(style);
    /* access();
     function access() {
         var iframe = document.getElementById("jitsiConferenceFrame0");
         var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
         console.log(innerDoc.body);
     }*/

</script>
</html>
