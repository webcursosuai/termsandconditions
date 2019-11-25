<?php
$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('headerconfig', 'block_termsandconditions'),
    get_string('descconfig', 'block_termsandconditions')
));

$query = "SELECT id, shortname FROM {role} order by id asc";

$roles = array();
$enrols = $DB->get_records_sql($query);
//print_r($enrols);
foreach ($enrols as $rols){
    $roles[$rols->id] = $rols->shortname;
}
//print_r($roles);
$settings->add(new admin_setting_configmultiselect(
    'termsandconditions/Allow_rol',
    get_string('labelallowrol', 'block_termsandconditions'),
    get_string('descallowrol', 'block_termsandconditions'),
    array(0,1,4,6),
    $roles
));