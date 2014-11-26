<?php
		function formal_date_date( $tDay, $tFormat = 'Y-m-d' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}			
		function formal_date( $tDay, $tFormat = 'l-M-d' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}
		function formal_date_m( $tDay, $tFormat = 'm' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}
   		function formal_date_j( $tDay, $tFormat = 'j' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}
   		function formal_date_Y( $tDay, $tFormat = 'Y' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}
   		function formal_date_l( $tDay, $tFormat = 'l' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}
   		function formal_date_ls( $tDay, $tFormat = 'D' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}
   		function formal_date_n( $tDay, $tFormat = 'n' ) {
   				$day = intval( $tDay );
    			$day = ( $day == 0 ) ? $day : $day - 1;
    			$offset = intval( intval( $tDay ) * 86400 );
    			$str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
   			return( $str );}
   			
?>