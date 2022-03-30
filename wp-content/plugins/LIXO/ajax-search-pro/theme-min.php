<?php

$ds = DIRECTORY_SEPARATOR;
$theme_dir = dirname(__FILE__) . $ds .'backend' . $ds . 'settings' . $ds;
$_t = file_get_contents($theme_dir.'themes.json');
$t = json_decode($_t, true);

$original_size = strlen($_t);

// Step 1 - Match to the 'Default' theme
/*foreach ( $t as $theme=>&$values ) {
    foreach($values as $key => $value) {
        // Is it the same as in the default value set?
        if ( isset($default[$key]) && $default[$key] == $value)
            unset($values[$key]);
    }
}*/

// Match to each other, iterate through thresholds
$thresholds = array(0.8, 0.7, 0.6, 0.5, 0.4, 0.3);
$referenced = array();
foreach ($thresholds as $threshold) {
    foreach ( $t as $theme=>&$values ) {
        // Disabled value, ignore
        if ( $values === false || !is_array($values) )
            continue;
        // Referenced themes cannot be referenced to
        if ( isset($values['_ref']) )
            continue;
        foreach ( $t as $_theme=>&$_values ) {
            // If the same theme, or already has a reference, or the number of value fields does not match, continue
            if (
                $_theme == 'Default' ||
                $_theme == $theme ||
                isset($_values['_ref']) ||
                $_values === false || !is_array($_values) ||
                count($values) != count($_values) ||
                in_array($_theme, $referenced)
            ) continue;

            $matches = 0;
            $match = true;
            $non_matching = array();
            foreach ( $_values as $k => $v ) {
                // If this key does not exist in the original values array, then it is over
                if ( !isset($values[$k]) ) {
                    $match = false;
                    break;
                }
                if ( $v == $values[$k] )
                    ++$matches;
                else
                    $non_matching[$k] = $v;
            }

            /**
             * The $match flag was not set to false
             * and the matches count and the overall key count ration is bigger than 0.5
             * then this is definitely worth referencing
             */
            if ( $match && ($matches / count($_values)) > $threshold ) {
                print "Theme <b>$_theme</b> matches theme <b>$theme</b> in ".number_format($matches / count($_values) * 100, 2)."%<br>";
                // Set the theme to the non matching keys only
                $t[$_theme] = $non_matching;
                // also, add the refence key
                $t[$_theme]['_ref'] = $theme;
                if ( !in_array($theme, $referenced) )
                    $referenced[] = $theme;
            }
        }
    }
}


/*$default = $t['Default'];
foreach ( $t as $theme=>&$values ) {
    if ( $theme == 'Default' )
        continue;
    $matches = 0;
    foreach($values as $key => $value) {
        // Is it the same as in the default value set?
        if ( isset($default[$key]) && $default[$key] == $value) {
            unset($values[$key]);
            ++$matches;
        }
    }
    if ($matches > 0) {
        print "Theme <b>$theme</b> matches the <b>Default</b> in ".$matches." properties, removing them.<br>";
    }
}*/

//$t = array('Default' => $default) + $t;
$new_size = strlen(json_encode($t));
$saved = number_format(100 - ($new_size / $original_size * 100), 2);
$out = json_decode(json_encode( json_encode($t) )); // Forcing to object

file_put_contents($theme_dir . 'themes.min.json',  $out);

print "Original size: $original_size char., new size: $new_size | $saved% saved<br><br>";
print "------------------------------------DUMP----------------------------------------<br><br><br>";
var_dump(json_decode($out));