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

// This is the Closure function that does the lazy-loading:
private $lz_loader;



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

protected function extracoy ( $rayo, $valo )
{
  if ( !$this->init_flag ) { return false; }
  if ( !is_array($rayo) ) { return false; }
  if ( !array_key_exits($valo,$rayo) ) { return false; }
  return $rayo[$valo];
}

public function init_with_lz ( ) {
  if ( $this->init_flag ) { return false; }
  $this->set_to_dflt();
  
  $prmx = new sophia_argument_platter;
  if ( !realpath($prmx->set01(func_num_args(),func_get_args())) )
  {
    return false;
  }
  
  $lscrip = realpath($prmx->ftr());
  $reta = include($lscrip);
  $lfuna = $reta;
  if ( is_array($reta) )
  {
    $lfuna = false;
    foreach ( $reta as $rtk => $rtv )
    {
      if ( strcmp($rtk,'kill') == 0 ) { $this->kill_on_bad_fnc = $rtv; }
      if ( strcmp($rtk,'load') == 0 ) { $lfuna = $rtv; }
      $rtpx = explode('-',$rtk,2);
      if ( strcmp($rtpx[0],'do') == 0 ) { $this->fnc[$rtpx[1]] = $rtv; }
    }
  }
  $lfunb = Closure::Bind($lfuna,$this,$this);
}

public function fn ( ) {
  $prmx = new sophia_argument_platter;
  if ( !$prmx->set01(func_num_args(),func_get_args()) )
  {
    return false;
  }
  $fncnm = $prmx->ftr();
  if ( array_key_exists($fncnm,$this->fnc) )
  {
    return call_user_func($this->fnc[$fncnm],$prmx);
  }
  
  // Okay - it's a fail. Does the program survive this fail?
  if ( $this->kill_on_bad_fnc )
  {
    die("\nFATAL ERROR (sophia_dynamic_obj.php - we'll know where it was called from in later version)\n\n");
  }
  return false;
}

public function inited ( ) {
  return $this->init_flag;
}


} ?>