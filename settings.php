<?php
$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('headerconfig', 'block_termsandconditions'),
    get_string('descconfig', 'block_termsandconditions')
));

$query = "SELECT id, shortname FROM {role} order by id asc";

$roles = array();
$default = array();
$enrols = $DB->get_records_sql($query);

foreach ($enrols as $rols){
    $roles[$rols->id] = $rols->shortname;
    if($rols->shortname == "manager" || $rols->shortname == "profesoreditor" || $rols->shortname == "ayudante"){
        $default[] = $rols->id;
    }
}

$settings->add(new admin_setting_configmultiselect(
    'termsandconditions/Allow_rol',
    get_string('labelallowrol', 'block_termsandconditions'),
    get_string('descallowrol', 'block_termsandconditions'),
    $default,
    $roles
));