<?php class sophia_argument_platter {
// This object is just a convenient way of sending arguments
// to the dynamic methods of the functions - as well as any
// other information that should be sent along.

protected $headarg;
protected $allargs;
protected $allrays;
protected $allobjs;
protected $allrest;

protected $init_flag = false;

public function set01 ( $siz, $ray ) {
  if ( $this->init_flag ) { return false; }
  if ( $siz < 1 ) { return false; }
  $this->init_flag = true;
  
  $cnt = 0;
  $allargs = array();
  $allrays = array();
  $allobjs = array();
  $allrest = array();
  for ( $cnt = 0; $cnt < $siz; $cnt++ )
  {
    if ( $cnt == 0 )
    {
      $this->headarg = $ray[0];
    }
    if ( $cnt > 0 )
    {
      $allargs[] = $ray[$cnt];
      $zok = true;
      if ( is_array($ray[$cnt]) ) { $allrays[] = $ray[$cnt]; $zok = false; }
      if ( is_object($ray[$cnt]) ) { $allobjs[] = $ray[$cnt]; $zok = false; }
      if ( $zok ) { $allrest[] = $ray[$cnt]; }
    }
  }
  
  $this->allargs = $allargs;
  $this->allrays = $allrays;
  $this->allobjs = $allobjs;
  $this->allrest = $allrest;
  return true;
}

} ?>