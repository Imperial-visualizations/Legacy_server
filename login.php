<?php

require_once('../../simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
// $as->login(array(
//     'saml:idp' => 'https://shibboleth.imperial.ac.uk/idp/profile/SAML2/Redirect/SSO',
// ));
$as->requireAuth();
$attributes = $as->getAttributes();
print_r($attributes);

?>