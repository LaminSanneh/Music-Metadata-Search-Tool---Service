<?php

return array(

    /**
     * You may wish for all e-mails sent with Mailgun to be sent from
     * the same address. Here, you may specify a name and address that is
     * used globally for all e-mails that are sent by Mailgun.
     *
     */
    'from' => array(
        'address' => 'lamin.evra@gmail.com',
        'name' => 'Musica Api'
    ),


    /**
     * Global reply-to e-mail address
     *
     */
    'reply_to' => 'lamin.evra@gmail.com',


    /**
     * Mailgun API key (non-public)
     *
     */
    'api_key' => 'key-8s2h3nscyskt7z4rllw75hwdedl91nw4',


    /**
     * Domain name registered with Mailgun
     *
     */
    'domain' => 'sandbox16241.mailgun.org',

    /**
     * Force the from address
     *
     * When your `from` e-mail address is not from the domain specified some
     * e-mail clients (Outlook) tend to display the from address incorrectly
     * By enabling this setting Mailgun will force the `from` address so the
     * from address will be displayed correctly in all e-mail clients.
     *
     * Warning:
     * This parameter is not documented in the Mailgun documentation
     * because if enabled, Mailgun is not able to handle soft bounces
     *
     */
    'force_from_address' => false,
);