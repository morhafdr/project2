<?php

namespace App\Traits;

use App\Models\Employee;
use App\Models\Office;
use App\Models\Truck;
use App\Models\User;
use Dompdf\Dompdf;
use Carbon\Carbon;

trait PdfTrait
{
    public function generateMonthlyReport()
    {
        // Simulate fetching the dashboard data from a real source (e.g., a database or service)
        $dashboardData = $this->fetchDashboardData();

        if (!empty($dashboardData)) {
            $dompdf = new Dompdf();
            $htmlContent = '<html><head><style>
                body { font-family: "Helvetica", sans-serif; margin: 40px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style></head><body>';

            // Add a title to the report
            $htmlContent .= '<h2>Monthly Dashboard Report - ' . Carbon::now()->format('F Y') . '</h2>';

            // Add the summary of dashboard data
            $htmlContent .= '<table><thead><tr>
                                <th>Category</th>
                                <th>Count</th>
                             </tr></thead><tbody>';

            $htmlContent .= '<tr>
                                <td>Number of Offices</td>
                                <td>' . $dashboardData['office'] . '</td>
                             </tr>';
            $htmlContent .= '<tr>
                                <td>Number of Trucks</td>
                                <td>' . $dashboardData['truck'] . '</td>
                             </tr>';
            $htmlContent .= '<tr>
                                <td>Number of Employees</td>
                                <td>' . $dashboardData['employee'] . '</td>
                             </tr>';
            $htmlContent .= '<tr>
                                <td>Number of App Clients</td>
                                <td>' . $dashboardData['appClient'] . '</td>
                             </tr>';
            $htmlContent .= '<tr>
                                <td>balance</td>
                                <td>' . $dashboardData['balance'] . '</td>
                             </tr>';

            $htmlContent .= '</tbody></table></body></html>';

            // Generate and stream the PDF
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return $dompdf->stream('dashboard-report-' . now()->format('Y-m') . '.pdf');
        } else {
            return response()->json(['message' => 'No dashboard data found for the current period'], 404);
        }
    }

    // Method to simulate fetching dashboard data
    private function fetchDashboardData()
    {
        // Get the first day and last day of the previous month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->startOfMonth()->addMonth();

        // Fetch data created within the last month
        return [
            'office' => Office::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'truck' => Truck::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'employee' => Employee::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'appClient' => User::role('client')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'balance'=>auth()->user()->wallet->balance
        ];
    }
}
