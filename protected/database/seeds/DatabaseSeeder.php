<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('SeederTableUsers');
        // $this->call('SeederTableBrand');
        // $this->call('SeederTableResto');
		// $this->call('SeederTableFotoResto');
        // $this->call('SeederTableTipeResto');
        // $this->call('SeederTableAkses');
        // $this->call('SeederTableSubscription');
        // $this->call('SeederTableGroupMenu');
        // $this->call('SeederTableMenu');
        // $this->call('SeederTableTag');
        // $this->call('SeederTablePromo');
        // $this->call('SeederTableSyarat');
        // $this->call('SeederTableSyaratPromo');
        // $this->call('SeederTableVoucher');
		// $this->call('SeederTableKategori');
		// $this->call('SeederTableKategoriMenu');
		// $this->call('SeederTableTransaksi');
		// $this->call('SeederTableTransaksiMenu');
		// $this->call('SeederTableDeliveri');
		// $this->call('SeederTableFeedback');
		// $this->call('SeederTableDiskusiFeedback');
    }
}
