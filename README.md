# OEMPRO PHP Api

This SDK is intended to facilitate the integration with OEMPRO

## Basic config for integration
 
    $oemproApiKey = '9291-0e9a-b2b1-c9b4-ea1e-3450-a718-1234';
    $oemproListId = '1';
    $oemproUrl    = 'https://example.com/';
    $oempro       = new Api($oemproUrl, $oemproApiKey);

## Manage subscriber information

    
### Search email in list
    
    $subscriber = $oempro->get('Subscriber.Get', [
        'ListID' => $oemproListId, 
        'EmailAddress' => $email
        ], 'array');

#### Verify if email exists in list
    if ($subscriber['Success']) {
        $sId = $subscriber['SubscriberInformation']['SubscriberID'];
    }

            
### Set data in Custom Fields
    
        $fields = [
            '1'  => 'Fist Name',
            '2' => 'Last Name',
        ];

### Insert subscriber

    $this->oempro->get('Subscriber.Subscribe', [
        'ListID'       => $oemproListId,
        'EmailAddress' => $email,
        'IPAddress'    => '1234',
        'fields'       => $fields,
    ], 'array');

### Update subscriber

    $this->oempro->get('Subscriber.Update', [
        'SubscriberListID' => $oemproListId,
        'SubscriberID'     => $sId,
        'EmailAddress'     => 'email',
        'IPAddress'        => '1234',
        'fields'           => $fields,
    ], 'array');


## Manage campaigns with html content

###1 - Create a email
    $email = $oempro->post('Email.Create', [], 'array');
###2 - Update a email with html content
    $email = $oempro->post('Email.Update', [
        'EmailID' => $email['EmailID'],
        'ValidateScope' => 'Campaign',
        'FromName' => 'John',
        'FromEmail' => 'john@gmail.com',
        'ReplyToName' => 'Jhon',
        'ReplyToEmail' => 'john@gmail.com',
        'Subject' => 'My subject',
        'Mode' => 'Empty',
        'HTMLContent' => $html
    ], 'array');
###3 - Create a campaign
    $campaign = $oempro->post('Campaign.Create', [
        'CampaignName' => 'Best price'
    ], 'array');
###4 - Update a campaign schedule and list
    $campaign = $oempro->post('Campaign.Update', [
        'CampaignID' => $campaign['CampaignID'],
        'RelEmailID' => $email['EmailID'],
        'RecipientListsAndSegments' => '1:0', #'2:5'
        'ScheduleType' => 'Immediate'
    ], 'array');    

