<?php

 function createCategoryHierarcy($data, $deep = 0){
  echo "<ul>";
  foreach($data as $d){
    $opened = '{"opened" : true}';

    if($deep > 2)
      echo "<li data-id='".$d['id_kategori']."' data-count='".$d['count']."'>
              <a href='".url('barang/bykategori/'.$d['id_kategori'])."'>".$d['nama_kategori']."</a>";

    else echo "<li data-id='".$d['id_kategori']."' data-jstree='".$opened."' data-count='".$d['count']."'>
                <a href='".url('barang/bykategori/'.$d['id_kategori'])."'>".$d['nama_kategori']."</a>";

    // echo "<li data-id='".$d['id_kategori']."' data-jstree='".$opened."' data-count='".$d['count']."'>
    //                         <a>".$d['nama_kategori']."</a>";

    if(count($d['child']) > 0){
      createCategoryHierarcy($d['child'], ++$deep);
      --$deep;
    }
    echo "</li>";
  }
    echo "</ul>";
}

function custom_number_format($n) {

    //return number_format($n);

    // first strip any formatting;
    $n = (0+str_replace(",","",$n));

    // is this a number?
    if(!is_numeric($n)) return false;

    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),1).' T';
    else if($n>1000000000) return round(($n/1000000000),1).' B';
    else if($n>1000000) return round(($n/1000000),1).' M';
    // else if($n>1000) return round(($n/1000),1).' K';

    return number_format($n);
}

 ?>
