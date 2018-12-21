<?php
$settings->add(new admin_setting_heading(
            'headerconfig',
            get_string('headerconfig', 'block_termsandconditions'),
            get_string('descconfig', 'block_termsandconditions')
        ));
 
$settings->add(new admin_setting_configmultiselect(
            'termsandconditions/Allow_HTML',
            get_string('labelallowhtml', 'block_termsandconditions'),
            get_string('descallowhtml', 'block_termsandconditions'),
            array(0,1,4,6),
            $DB->get_fieldset_sql('SELECT shortname FROM {role} ORDER BY id')
        ));