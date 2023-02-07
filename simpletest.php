<?php
// *******************************************************************************
// For super simple usage, upload this file to your server, then navigate
// to your maigun account's webhook page using url below (replace YOURDOMAINNAME)
// https://app.mailgun.com/app/sending/domains/YOURDOMAINNAME/webhooks
// *********************************************************************************

$data = json_decode(file_get_contents('php://input'), true);

    // print entire object for debugging
    // return print_r($data);

    // do this if a permanent fail 
    if ($data['event-data']['event'] == 'failed' && $data['event-data']['severity'] == 'permanent') {
        
        http_response_code(200);

        // massage data
        $responseObj = array(
                        'failid'          =>  $data['event-data']['id'],
                        'fail_recipient'  =>  $data['event-data']['recipient'],
                        'error_msg'       =>  $data['event-data']['delivery-status']['message'],
                        'error_descrip'   =>  $data['event-data']['delivery-status']['description']
        );

        echo 'Message bounced.';
        print_r($responseObj);

    } else {
        http_response_code(400);
        echo "Not the response I wanted."
    }

?>
