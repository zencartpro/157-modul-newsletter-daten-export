<?php
/**
* @package Export Newsletter Data as CSV
* @copyright Copyright 2018-2022, webchills www.webchills.at
* @copyright Portions Copyright 2003-2022 Zen Cart Development Team
* @copyright Portions Copyright 2009 911-need-code-help.blogspot.com
* Zen Cart German Version - www.zen-cart-pro.at
* @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
* @version $Id: export_newsletterdata_all_csv.php 2022-02-15 18:59:10 webchills $
*/


chdir('../');
require_once('includes/application_top.php');

if (!defined('IS_ADMIN_FLAG')) {
die('Illegal Access');
}

global $db;

$newsletterdata = $db->Execute("SELECT 
c.customers_firstname as 'Vorname',
c.customers_lastname as 'Nachname',
c.customers_email_address as 'Email',
c.customers_gender as 'Geschlecht'
FROM
" . TABLE_CUSTOMERS . " c
WHERE
c.customers_newsletter=1");
if ($newsletterdata->EOF) return ''; 
header( 'Content-Type: text/csv' );
header( 'Content-Disposition: attachment;filename=newsletterdaten.csv' );
$header=FALSE;

foreach ($newsletterdata as $row) {  
if (!$header) {
echocsv( array_keys( $row ) );
$header=TRUE;
}
echocsv( $row );
}

function echocsv( $fields )
{
$separator = '';
foreach ( $fields as $field )
{
if ( preg_match( '/[\r\n,"]/', $field ) )
{
$field = '"' . str_replace( '"', '""', $field ) . '"';
}
echo $separator . $field;
$separator = ',';
}
echo "\r\n";
}