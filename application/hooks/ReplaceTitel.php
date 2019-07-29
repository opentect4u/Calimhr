<?php
class ReplaceTitel {
  public function replaceValue()
  {
      // load the instance
      $this->CI =& get_instance();
       
      // get the actual output
      $titel = $this->CI->output->get_output();
      
       
      // replace the tokens
             
      $titel = str_replace('55 D, DESAPRAN SASHMAL ROAD','Module 7/18, Acropolis, 1858/1, Rajdanga Main Road', $titel);
      $titel = str_replace('55 D, Desapran Sasmal Road','Module 7/18, Acropolis, 1858/1, Rajdanga Main Road', $titel);
       
      $titel  = str_replace('KOLKATA-33', 'Kolkata – 700 107', $titel);
       
      // set the output
      echo $titel;
      
      return;
  }
}