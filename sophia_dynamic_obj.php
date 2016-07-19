<?php
require_once(realpath(__DIR__ . '/sophia_argument_platter.php'));
class sophia_dynamic_obj {

// The initiator flag will only become 'true'
// when the object is properly initiated.
private $init_flag = false;

// An array where the variables of private scope
// will go.
private $pv;

// An array where the functions will go.
private $fnc;

// An array that is 'true' if calling an invalid function
// would result in a fatal-error to the PHP page, and 'false'
// otherwise.
private $kill_on_bad_fnc;

private function set_to_dflt ( ) {
  $this->init_flag = false;
  $this->pv = array();
  $this->fnc = array();
  $this->kill_on_bad_fnc = true;
}

private function load_object_fnc ( $thefile ) {
  $srcfnc = include(realpath($thefile));
  $dstfnc = Closure::Bind($srcfnc,$this,$this);
  return $dstfnc;
}

public function init_by_script ( ) {
  $prmx = new sophia_argument_platter;
  $thefile = realpath($prmx->set01(func_num_args(),func_get_args()));
  return $this->hidden_script_initer($thefile,$prmx);
}

public function fn ( ) {
  $prmx = new sophia_argument_platter;
  $fncnm = $prmx->set01(func_num_args(),func_get_args());
  if ( !array_key_exists($fncnm,$this->fnc) )
  {
    if ( $this->kill_on_bad_fnc )
    {
      die("\nFATAL ERROR (sophia_dynamic_obj.php - we'll know where it was called from in later version)\n\n");
    }
    return;
  }
  return call_user_func($this->fnc[$fncnm],$prmx);
}

public function inited ( ) {
  return $this->init_flag;
}

private function hidden_script_initer ( $thescript, $prm ) {
  if ( $this->init_flag ) { return false; }
  $this->set_to_dflt();
  $this->init_flag = include($thescript);
  return $this->init_flag;
}


} ?>