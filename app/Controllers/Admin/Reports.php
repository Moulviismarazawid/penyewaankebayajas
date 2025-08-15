<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Reports extends BaseController
{
    public function income()
    {
        $db = \Config\Database::connect();
        $row = $db->query("
            SELECT 
              COALESCE(SUM(ri.daily_price_snapshot * GREATEST(DATEDIFF(r.end_date, r.start_date),1)),0) AS sewa,
              (SELECT COALESCE(SUM(amount),0) FROM fines) AS denda
            FROM rentals r
            JOIN rental_items ri ON ri.rental_id = r.id
            WHERE r.status = 'selesai'
        ")->getRowArray();
        $sewa = (int)($row['sewa'] ?? 0); $denda = (int)($row['denda'] ?? 0); $total = $sewa + $denda;
        return view('admin/reports_income', ['title'=>'Laporan Pendapatan','sewa'=>$sewa,'denda'=>$denda,'total'=>$total]);
    }
}
