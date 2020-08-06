<?php
   ini_set('display_errors', 1);

   /**
    * Menampung data spesifikasi dan di return dengan type array
    *
    * @return void
    */
   function getSpecification()
   {
      $cpu_name = php_uname('n');
      $os_type = php_uname('s');
      $platform =  php_uname('m');
      $release = php_uname('r');

      $data = explode("\n", file_get_contents("/proc/meminfo"));
      $meminfo = array();

      foreach ($data as $key => $line) {
         // diberikan kondisi dikarekanan pada Index 48 tidak ada data
         // maka dari itu diberikan kondisi agar tidak error pada saat looping
         if ($key != 48) {
            list($key, $val) = explode(":", $line);
            $meminfo[$key] = trim($val);
         }
      }

      $memory_total = substr($meminfo["MemTotal"], 0, -3);
      $memory_free = substr($meminfo["MemFree"], 0, -3);

      // Variabel untuk menampung data
      $specification = [];
      
      array_push($specification, [
         "cpu_name"     => $cpu_name,
         "os_type"      => $os_type,
         "platform"     => $platform,
         "release"      => $release,
         "memory_total" => $memory_total,
         "memory_free"  => $memory_free
      ]);

      return $specification[0];
   }

   /**
    * mengambil data nama_cpu pada fungsi getSpecification
    *
    * @return void
    */
   function getCpuName()
   {
      return getSpecification()['cpu_name'];
   }

   /**
    * mengambil data os_type pada fungsi getSpecification
    *
    * @return void
    */
   function getOSType()
   {
      return getSpecification()['os_type'];
   }

   /**
    * mengambil data platform pada fungsi getSpecification
    *
    * @return void
    */
   function getPlatform()
   {
      return getSpecification()['platform'];
   }

   /**
    * mengambil data release pada fungsi getSpecification
    *
    * @return void
    */
   function getRelease()
   {
      return getSpecification()['release'];
   }

   /**
    * mengambil data memory_total pada fungsi getSpecification
    *
    * @return void
    */
   function getMemoryTotal()
   {
      return getSpecification()['memory_total'];
   }
   
   /**
    * mengambil data memory_free pada fungsi getSpecification
    *
    * @return void
    */
   function getMemoryFree()
   {
      return getSpecification()['memory_free'];
   }
?>