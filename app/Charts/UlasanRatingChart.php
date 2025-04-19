<?php
namespace App\Charts;

use App\Models\Review;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;

class UlasanRatingChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Data bulan Januari - Desember
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        // Array untuk menyimpan jumlah ulasan per bulan berdasarkan rating
        $ratingCounts = [
            1 => array_fill(0, 12, 0),
            2 => array_fill(0, 12, 0),
            3 => array_fill(0, 12, 0),
            4 => array_fill(0, 12, 0),
            5 => array_fill(0, 12, 0),
        ];

        // Ambil jumlah ulasan berdasarkan bulan dan rating
        foreach (range(1, 5) as $rating) {
            foreach (range(1, 12) as $month) {
                $ratingCounts[$rating][$month - 1] = Review::whereMonth('created_at', $month)
                    ->where('rating', $rating)
                    ->count();
            }
        }
        

        return $this->chart->barChart()
            ->setTitle('Jumlah Ulasan Berdasarkan Rating per Bulan')
            ->setSubtitle('Ulasan dengan Rating 1-5 per Bulan')
            ->setColors(['#FF7F00', '#FF5733', '#C70039', '#900C3F', '#581845']) // Set warna untuk setiap rating
            ->addData('Rating 1', $ratingCounts[1])
            ->addData('Rating 2', $ratingCounts[2])
            ->addData('Rating 3', $ratingCounts[3])
            ->addData('Rating 4', $ratingCounts[4])
            ->addData('Rating 5', $ratingCounts[5])
            ->setHeight(270)
            ->setXAxis($months); // Menampilkan sumbu X dengan nama bulan
    }
}
