# OEMPRO PHP Api

This SDK is intended to facilitate the integration with OEMPRO

## Basic config for integration
 
    $oemproApiKey = '9291-0e9a-b2b1-c9b4-ea1e-3450-a718-1234';
    $oemproListId = '1';
    $oemproUrl    = 'https://example.com/';
    $oempro       = new Api($oemproUrl, $oemproApiKey);
    
### Search email in list
    
    $subscriber = $oempro->get('Subscriber.Get', [
        'ListID' => $oemproListId, 
        'EmailAddress' => $email
        ], 'array');

#### Verify if email exists in list
    if ($subscriber['Success']) {
        $sId = $subscriber['SubscriberInformation']['SubscriberID'];
    }
            
## Set data in Custom Fields
    
        $fields = [
            '1'  => 'Fist Name',
            '2' => 'Last Name',
        ];

## Insert

    $this->oempro->get('Subscriber.Subscribe', [
        'ListID'       => $oemproListId,
        'EmailAddress' => $email,
        'IPAddress'    => '1234',
        'fields'       => $fields,
    ], 'array');

## Update

    $this->oempro->get('Subscriber.Update', [
        'SubscriberListID' => $oemproListId,
        'SubscriberID'     => $sId,
        'EmailAddress'     => 'email',
        'IPAddress'        => '1234',
        'fields'           => $fields,
    ], 'array');




