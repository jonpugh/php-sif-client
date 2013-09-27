Creating an Authorization Token
===============================


See http://rest3api.sifassociation.org/jsp/documentation.jsp/

1. "Combine the Initial Token and Consumer Secret separated by a colon."
These can be anything when integrating with the REST sandbox.

The consumer secret, once set, must be used for further authentication.

  - Initial Token: new
  - Consumer Secret: guest

2. "Base64 encode the resulting string"

On unix based systems:

    $ echo 'new:guest' | base64
    bmV3Omd1ZXN0Cg==

    <?php
    $token = 'new';
    $consumerSecret = 'guest';
    $newAuthToken = 'Basic ' . base64($token . ':' . $consumerSecret);
    ?>

3. Now we are going to prefix the string with the Authentication Method separated by a space. Basic bmV3Omd1ZXN0Cg==

Basic bmV3Omd1ZXN0Cg==

4. You now have your Authorization Token. Pass this string in the Authorization standard header of your REST call to Create Environment and you will obtain your Environment record which contains the new Session Token and your Environment Id.

5. Once you have a sessionToken you must use that to create a NEW Authorization Token:

    <?php
    $sessionToken = "VeryLongStringFromEnvironmentResponse";
    $consumerSecret = 'guest';
    $newAuthToken = 'Basic ' . base64($sessionToken . ':' $consumerSecret);
    ?>

Note of course that Create Environment needs you to provide your Environment Information for the create. For info on this see the Create Environment API call in the environments service
