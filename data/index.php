<?php
   ini_set('display_errors', 1);

   include_once "../class/helpers.php";

   try {
      // import class mongo db
      $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

      // untuk kebutuhan insert
      $bulk = new MongoDB\Driver\BulkWrite;

      // menampung data method POST
      $post_input = json_decode(file_get_contents("php://input"), true);

      // Berstatus TRUE jika kosong, dan FALSE jika ada keadaan POST
      $status_post = $post_input == NULL ? true : false;

      if ($status_post) {

         $query = new MongoDB\Driver\Query([]); 
         
         $rows = $mng->executeQuery("dataCPU.data", $query);

         // variabel untuk menampung data array untuk ditampilkan
         $arr = [];
         foreach ($rows as $row) {
            array_push($arr, [
               '_id'       => $row->_id, 
               'nama_cpu'  => $row->nama_cpu,
               'tipe'      => $row->tipe,
               'platform'  => $row->platform,
               'rilis'     => $row->rilis,
               'ram_sisa'  => $row->ram_sisa,
               'ram_total' => $row->ram_total,
               
               ]);
         }
         
         echo(json_encode($arr));

      // jika ada keadaan post
      } else {
         $data = [
            '_id'       => new MongoDB\BSON\ObjectID,
            'nama_cpu'  => getCpuName(),
            'tipe'      => getOSType(),
            'platform'  => getPlatform(),
            'rilis'     => getRelease(),
            'ram_sisa'  => getMemoryFree(),
            'ram_total' => getMemoryTotal(),
         ];

         $bulk->insert($data);
         $mng->executeBulkWrite('dataCPU.data', $bulk);

         echo(json_encode(["status" => 200, "message" => 'success']));
      }
      
   } catch (MongoDB\Driver\Exception\Exception $e) {

      $filename = basename(__FILE__);
      
      echo "The $filename script has experienced an error.\n"; 
      echo "It failed with the following exception:\n";
      
      echo "Exception:", $e->getMessage(), "\n";
      echo "In file:", $e->getFile(), "\n";
      echo "On line:", $e->getLine(), "\n";       
   }
?>