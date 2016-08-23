<?php
// any_in_array() is not in the Array Helper, so it defines a new function
function projectname()
{
    $ci=& get_instance();
    return $ci->config->item('projectname');
}

function getconfig($name) 
{
    $ci=& get_instance();
    return $ci->config->item($name);
}

?>