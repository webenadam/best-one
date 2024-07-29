<?php

/**
 * Cardcom webhook subscription function (after userid, subscription id, term id (optional) checks
 */


function cardcom_subscribe($user_id, $subscription_id, $term_id = null, $lowprofilecode = null)
{

    // Subscribe


    # Satatic Vars :
    $TerminalNumber = 1000; # Company terminal
    $UserName = 'test2025';   # API User
    $OperationAdd = "newandupdate";  # newandupdate  do one or all of the following :  Update\Add New Account  And\Or Update\Add account payment info  And\Or Add new    recurring payment


    # Dynamic Vars:
    $lowprofilecode = $lowprofilecode; #(Same as lowProfileCode)

    // Fetch user details
    $user_info = get_userdata($user_id);
    if (!$user_info) {
        echo "User not found."; // Handle the error appropriately
        return; // Exit the function if user is not found
    }

    $client_email = $user_info->user_email; // User's email
    $client_name = $user_info->display_name; // User's display name. Can also use $user_info->first_name and $user_info->last_name

    $subscription_id = $subscription_id;
    $product_description = get_the_title($subscription_id);


    ###############################################################                              
    ### Add New Account new  Payment Info new recurring payment.###
    ###############################################################
    $vars =  array();
    // Const parameters:
    $vars['terminalnumber'] = $TerminalNumber;
    $vars['username'] = $UserName;
    $vars['codepage'] = '65001'; // unicode
    $vars["Operation"] = $OperationAdd;

    $vars["LowProfileDealGuid"] = $lowprofilecode;



    // Add Acount Info , all Params At : kb.XXXX.XXXX
    $vars["Account.CompanyName"] = $client_name; # Req Name of the account / company
    // $vars["Account.RegisteredBusinessNumber"] = $client_id;
    $vars["Account.Email"] = $client_email;


    #### Add Recurring Payment  ###

    $today = date("d/m/Y");  // Gets today's date
    $oneMonthFromToday = date("d/m/Y", strtotime("+1 month"));

    $vars["RecurringPayments.InternalDecription"] = $product_description; # some internal description for the Recurring Payment 
    $vars["RecurringPayments.NextDateToBill"] = $oneMonthFromToday; #  the first time to bill the account .
    $vars["RecurringPayments.TotalNumOfBills"] = "999999"; #  number of time to bill the account
    $vars["RecurringPayments.FinalDebitCoinId"] = "1"; #   1- NIS , 2- USD -else ISO currency.  
    $vars["RecurringPayments.ReturnValue"] = "subscribe-".$client_id."-".$subscription_id.($term_id ? "-".$term_id : '')."-createdoncardcom"; # subscribe-user_id-subscription_id-term_id
    $vars["RecurringPayments.FlexItem.Price"] = get_field('subscription_price',$subscription_id); #   Sum to Bill the account  in every time. (total account bill is TotalNumOfBills*FlexItem.Price)
    $vars["RecurringPayments.FlexItem.IsPriceIncludeVat"] = "false"; # the account will be bill 100 include vat - good for BTC , if BTB , send FlexItem.Price no vat and FlexItem.IsPriceIncludeVat=false   


    // Send Data To Bill Gold Server
    $r = PostVars($vars, 'https://secure.cardcom.solutions/Interface/RecurringPayment.aspx');


    parse_str($r, $responseArray);

    # Is Deal OK 
    if ($responseArray['ResponseCode'] == "0") {
        echo "<br/>Description: " . $responseArray['Description'] . "<br/>"; #  response Description
        echo "Total Recurring: " . $responseArray['TotalRecurring'] . "<br/>"; # total number of new /update  Recurring Payment
        echo "Is New Account: " . $responseArray['IsNewAccount'] . "<br/>"; # Is the Account a new One (if not then update)
        echo "Account Id: " . $responseArray['AccountId'] . "<br/>"; # Update \ New Account ID.

        echo "<br/>Print Recurring Payment result<br/>";
        echo "------------------------------<br/>";
        $total = $responseArray['TotalRecurring'];



        for ($i = 0; $i < $total; $i++) {

            echo "Recurring Id " . $i . ": " . $responseArray['Recurring' . $i . '_RecurringId'] . "<br/>"; # CardCom  Recurring Id
            echo "Return Value " . $i . ": " . $responseArray['Recurring' . $i . '_ReturnValue'] . "<br/>"; # your custom temp value for the Recurring Payment
            echo "Is New Recurring " . $i . ": " . $responseArray['Recurring' . $i . '_IsNewRecurring'] . "<br/><br/>"; # Is New Recurring Payment ?
        }

        echo "<br/><br/><br/>" . $r;
        // See Full Response  At : kb.XXXX.XXXX    
    }
    # Show Error to developer only
    else {
        echo $r;
    }




    // Log stuff
    $log_file = WP_CONTENT_DIR . '/webhook.log';
    $log_data = "user: $user_id, has been subscribed to the $subscription_id subscription";
    if ($term_id) {
        $log_data .= " for the term: $term_id";
    }
    $log_data .= PHP_EOL;
    file_put_contents($log_file, $log_data, FILE_APPEND);
}



function PostVars($vars, $PostVarsURL)
{
    $urlencoded = http_build_query($vars);
    #init curl connection
    if (function_exists("curl_init")) {
        $CR = curl_init();
        curl_setopt($CR, CURLOPT_URL, $PostVarsURL);
        curl_setopt($CR, CURLOPT_POST, 1);
        curl_setopt($CR, CURLOPT_FAILONERROR, true);
        curl_setopt($CR, CURLOPT_POSTFIELDS, $urlencoded);
        curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($CR, CURLOPT_FAILONERROR, true);
        #actual curl execution perfom
        $r = curl_exec($CR);
        $error = curl_error($CR);
        # some error , send email to developer
        if (!empty($error)) {

            echo $error;

            die();
        }
        curl_close($CR);
        return $r;
    } else {
        echo "No curl_init";
        die();
    }
}
