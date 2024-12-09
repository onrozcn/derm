<?php
require_once('settings.php');
setcookie($siteCookiePrefix . 'sessionId' . $sitePhpSessionVersion, '', time()-3600, $sitePath);
LogOut();