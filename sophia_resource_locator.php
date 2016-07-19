<?php
class sophia_resource_locator {

protected $pathvar = array();
protected $reslvar = array();

public function register_res ( $resnom, $resloc )
{
  if ( array_key_exists($resnom,$this->reslvar) ) { return false; }
  $this->reslvar[$resnom] = $resloc;
  return true;
}

public function locat ( $resnom )
{
  if ( array_key_exists($resnom,$this->reslvar) )
  {
    return $this->reslvar[$resnom];
  }
  
  return false;
}

public function add_to_path ( )
{
  $num = func_num_args();
  $rgx = func_get_args();
  for ( $cnt = 0; $cnt < $num; $cnt++ )
  {
    $this->pathvar[] = $rgx[$cnt];
  }
}

} ?>