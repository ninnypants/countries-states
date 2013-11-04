<?php
$countries = array();
$states = array();

$fp = fopen( 'GeoPC_Regions_ISO3166_2.csv', 'r' );
fgetcsv( $fp, 0, ';' );
while ( $line = fgetcsv( $fp, 0, ';' ) ) {
	if ( !array_key_exists($line[0], $countries ) ) {
		$countries[ $line[0] ] = htmlentities( $line[1] );
	}

	if( !array_key_exists( $line[0], $states ) ) {
		$states[ $line[0] ] = array();
	}

	if ( !array_key_exists( $line[2], $states[ $line[0] ] ) ) {
		$states[ $line[0] ][ $line[2] ] = htmlentities( $line[3] );
	}
}
fclose( $fp );

$new_contents = "<?php\n";
$new_contents .= '$countries = ' . var_export( $countries, true ) . ';' . "\n\n";

$new_contents .= '$states = ' .var_export( $states, true ) . ';' . "\n\n";

$new_contents = str_replace( '  ', "\t", $new_contents );
$new_contents = str_replace( 'array (', 'array(', $new_contents );
$new_contents = preg_replace( '#\n\t+array#', 'array', $new_contents );

file_put_contents( 'country-state-data.php', $new_contents );