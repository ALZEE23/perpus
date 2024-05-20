<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\peminjaman;
use App\Models\denda;
use Carbon\Carbon;

class CekBukuTerlambat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:buku-terlambat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $currentDate = Carbon::now();
        $overduePeminjamans = peminjaman::where('status', '!=', '3')
            ->where('tgl_kembali', '<', $currentDate)
            ->get();

        foreach ($overduePeminjamans as $peminjaman) {
            $jumlahDenda = $this->calculateFine($peminjaman->tgl_kembali, $currentDate);

            denda::create([
                'id_anggota' => $peminjaman->id_anggota,
                'id_buku' => $peminjaman->id_buku,
                'tgl_pinjam' => $peminjaman->tgl_pinjam,
                'tgl_kembali' => $peminjaman->tgl_kembali,
                'harga_denda' => $jumlahDenda,
                'status'        => $peminjaman->status,
            ]);

            // Update status peminjaman
            $peminjaman->status = '4';
            $peminjaman->save();
        }

        $this->info('Checked for overdue books and applied fines.');
    }

    private function calculateFine($dueDate, $returnDate)
    {
        $weeksLate = Carbon::parse($dueDate)->diffInWeeks($returnDate);
        $finePerWeek = 5000; // Misal 5000 rupiah per minggu
        return $weeksLate * $finePerWeek;
    }
    }

