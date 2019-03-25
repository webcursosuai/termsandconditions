<?php
$settings->add(new admin_setting_heading(
            'headerconfig',
            get_string('headerconfig', 'block_termsandconditions'),
            get_string('descconfig', 'block_termsandconditions')
        ));
$settings->add(new admin_setting_configmultiselect(
            'termsandconditions/Allow_rol',
            get_string('labelallowrol', 'block_termsandconditions'),
            get_string('descallowrol', 'block_termsandconditions'),
            array(0,1,4,6),
            $DB->get_fieldset_select('role', 'shortname',true)
        ));