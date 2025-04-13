<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\Http\Client;

if (!function_exists('uploadFile')) {
    /**
     * Fungsi untuk upload file dan menyimpan ke storage public
     *
     * @param string $directory
     * @param mixed $file
     * @param string $filename
     * @return string
     */
    function uploadFile($directory, $file, $filename)
    {
        $extensi  = $file->getClientOriginalExtension();
        $filename = "{$filename}_" . date('Ymdhis') . '_' . Str::uuid() . '_' . ".{$extensi}";

        $disk = Storage::disk('public');
        $disk->putFileAs("uploads/$directory", $file, $filename);

        return "uploads/$directory/$filename";
    }
}

if (!function_exists('loadFile')) {
    /**
     * Fungsi untuk load file dari storage public
     *
     * @param string $filepath
     * @return string
     */
    function loadFile($filepath)
    {
        return Storage::disk('public')->url("$filepath");
    }
}

if (!function_exists('downloadFile')) {
    /**
     * Fungsi untuk download file dari storage public
     *
     * @param string $filepath
     * @return string
     */
    function downloadFile($filepath)
    {
        if (Storage::disk('public')->exists("$filepath")) {
            return Storage::disk('public')->download("$filepath");
        }

        abort(404);
    }
}

if (!function_exists('deleteFile')) {
    /**
     * Fungsi untuk hapus file dari storage public
     *
     * @param string $filepath
     * @return bool
     */
    function deleteFile($filepath)
    {
        if (Storage::disk('public')->exists("$filepath")) {
            return Storage::disk('public')->delete("$filepath");
        }

        return false;
    }
}

if (!function_exists('formatTanggal')) {
    /**
     * Fungsi untuk memformat tanggal menjadi tanggal indonesia
     *
     * @param string $date
     * @param boolean $day
     * @return string
     */
    function formatTanggal($date, $day = false)
    {
        if ($date == null || $date == "") {
            return '';
        }

        $days   = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu');
        $months = array(
            1 =>
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $year  = substr($date, 0, 4);
        $month = $months[(int) substr($date, 5, 2)];
        $date2 = substr($date, 8, 2);
        $text  = '';

        if ($day) {
            $day   = date('w', mktime(0, 0, 0, substr($date, 5, 2), $date2, $year));
            $day   = $days[$day];
            $text .= "{$day}, {$date2} {$month} {$year}";

            return $text;
        }

        $text .= "{$date2} {$month} {$year}";
        return $text;
    }
}

if (!function_exists('formatYmd')) {
    /**
     * Fungsi untuk memformat tanggal menjadi format Y-m-d
     *
     * @param string $data
     * @return string
     */
    function formatYmd($date)
    {
        return $date ? now()->parse($date)->format('Y-m-d') : '';
    }
}

if (!function_exists('formatBulan')) {
    /**
     * Fungsi untuk memformat nomor bulan menjadi nama bulan
     *
     * @param integer $month
     * @return string
     */
    function formatBulan($month)
    {

        $months = array(
            1 =>
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $month = $months[(int) $month];

        return $month;
    }
}

if (!function_exists('formatBulanRomawi')) {
    /**
     * Fungsi untuk memformat nomor bulan menjadi romawi
     *
     * @param integer $month
     * @return string
     */
    function formatBulanRomawi($month)
    {
        $months = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $month = $months[(int) $month];

        return $month;
    }
}

if (!function_exists('formatHari')) {
    /**
     * Fungsi untuk memformat nomor hari menjadi nama hari
     *
     * @param string|integer $date
     * @return string
     */
    function formatHari($date)
    {
        $days = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu');
        if (is_string($date)) {
            $day  = date('w', mktime(0, 0, 0, substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)));
            $day  = $days[$day];
        } else {
            $day  = $days[$date];
        }

        return $day;
    }
}

if (!function_exists('formatUang')) {
    /**
     * Fungsi untuk memformat number menjadi format indonesia
     *
     * @param integer $number
     * @return string
     */
    function formatUang($number)
    {
        if (!$number) {
            return 0;
        }

        return number_format($number, 0, ',', '.');
    }
}


if (!function_exists('angkaTerbilang')) {
    /**
     * Fungsi untuk memformat number menjadi format indonesia
     *
     * @param integer $number
     * @return string
     */
    function angkaTerbilang($angka)
    {
        $angka = abs($angka);
        $baca = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
        );
        $terbilang = '';

        if ($angka < 12) {
            $terbilang = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $terbilang = angkaTerbilang($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            $terbilang = angkaTerbilang($angka / 10) . ' puluh' . angkaTerbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' seratus' . angkaTerbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = angkaTerbilang($angka / 100) . ' ratus' . angkaTerbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' seribu' . angkaTerbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = angkaTerbilang($angka / 1000) . ' ribu' . angkaTerbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = angkaTerbilang($angka / 1000000) . ' juta' . angkaTerbilang($angka % 1000000);
        }

        return ucwords($terbilang);
    }
}


if (!function_exists('tanggalTerbilang')) {
    /**
     * Fungsi untuk memformat tanggal menjadi format indonesia
     *
     * @param date $date
     * @return string
     */
    function tanggalTerbilang($date)
    {
        $date = date('Y-m-d', strtotime($date));

        if ($date == '0000-00-00') {
            return 'Tanggal Kosong';
        }

        $tgl = substr($date, 8, 2);
        $bln = substr($date, 5, 2);
        $thn = substr($date, 0, 4);

        switch ($bln) {
            case 1: {
                    $bln = 'Januari';
                }
                break;
            case 2: {
                    $bln = 'Februari';
                }
                break;
            case 3: {
                    $bln = 'Maret';
                }
                break;
            case 4: {
                    $bln = 'April';
                }
                break;
            case 5: {
                    $bln = 'Mei';
                }
                break;
            case 6: {
                    $bln = "Juni";
                }
                break;
            case 7: {
                    $bln = 'Juli';
                }
                break;
            case 8: {
                    $bln = 'Agustus';
                }
                break;
            case 9: {
                    $bln = 'September';
                }
                break;
            case 10: {
                    $bln = 'Oktober';
                }
                break;
            case 11: {
                    $bln = 'November';
                }
                break;
            case 12: {
                    $bln = 'Desember';
                }
                break;
            default: {
                    $bln = 'UnKnown';
                }
                break;
        }

        $hari = date('N', strtotime($date));
        switch ($hari) {
            case 0: {
                    $hari = 'Minggu';
                }
                break;
            case 1: {
                    $hari = 'Senin';
                }
                break;
            case 2: {
                    $hari = 'Selasa';
                }
                break;
            case 3: {
                    $hari = 'Rabu';
                }
                break;
            case 4: {
                    $hari = 'Kamis';
                }
                break;
            case 5: {
                    $hari = "Jum'at";
                }
                break;
            case 6: {
                    $hari = 'Sabtu';
                }
                break;
            default: {
                    $hari = 'UnKnown';
                }
                break;
        }

        $tanggalIndonesia = "Hari " . $hari .
            ", Tanggal " . angkaTerbilang($tgl) . " " . $bln .
            " Tahun" . angkaTerbilang($thn);
        return ucwords($tanggalIndonesia);
    }
}

if (!function_exists('formatTanggalRomawi')) {
    function formatTanggalRomawi($tanggal)
    {
        $pecah = explode("-", $tanggal);
        return $pecah[0] . "/" . formatBulanRomawi($pecah[1]) . "/" . $pecah[2];
    }
}

if (!function_exists('divisionByZero')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function divisionByZero($value1, $value2)
    {
        return $value2 == 0 ? 0 : ($value1 / $value2);
    }
}

if (!function_exists('getDurationFromYoutube')) {
    /**
     * Get the duration of a YouTube video in minutes.
     *
     * @param string $urlVideo
     * @return int|null
     */
    function getDurationFromYoutube($urlVideo)
    {
        // Extract the video ID from the URL
        preg_match('/v=([^&]+)/', $urlVideo, $matches);
        if (!isset($matches[1])) {
            return null; // Invalid URL or video ID not found
        }
        $videoId = $matches[1];

        // Fetch the YouTube page content
        $pageUrl = "https://www.youtube.com/watch?v={$videoId}";
        $pageContent = file_get_contents($pageUrl);
        if ($pageContent === false) {
            return null; // Failed to fetch the YouTube page
        }

        // Extract the duration from the page content
        preg_match('/"approxDurationMs":"(\d+)"/', $pageContent, $matches);
        if (!isset($matches[1])) {
            return null; // Duration not found
        }

        // Convert duration from milliseconds to minutes
        $durationMs = intval($matches[1]);
        return ceil($durationMs / 1000 / 60);
    }
}

if (!function_exists('getDurationFromMP3')) {
    /**
     * Get the duration of an MP3 file in minutes.
     *
     * @param \Illuminate\Http\UploadedFile $uploadSong
     * @return float|null
     */
    function getDurationFromMP3($uploadSong)
    {
        // Initialize getID3
        $getID3 = new getID3();

        // Analyze the MP3 file
        $fileInfo = $getID3->analyze($uploadSong);

        // Check if the playtime_seconds is available
        if (isset($fileInfo['playtime_seconds'])) {
            // Convert seconds to minutes and round up
            return ceil($fileInfo['playtime_seconds'] / 60);
        }

        // Debugging: Log the error message if available
        if (isset($fileInfo['error'])) {
            error_log("getID3 error: " . implode(', ', $fileInfo['error']));
        }

        return null; // Duration not found or failed to analyze the file
    }
}

if (!function_exists('generateUniqueOTP')) {
    /**
     * Generate a unique 6-digit OTP that does not exist in the user's table.
     *
     * @return int
     */
    function generateUniqueOTP()
    {
        do {
            $otp = mt_rand(100000, 999999); // Generate a random 4-digit OTP
        } while (User::where('otp', $otp)->exists()); // Check if OTP exists in the database

        return $otp;
    }
}

if (!function_exists('sendOTP')) {
    /**
     * Send OTP to the user using the external messaging service.
     *
     * @param array $params
     * @return \Illuminate\Http\RedirectResponse|null $response
     */
    function sendOTP($params)
    {
        $client = new Client();

        try {
            $response = $client->post(
                config('services.ultmsg.base_url') . '/' . config('services.ultmsg.instance_id') . "/messages/chat",
                $params
            );

            $responseBody = $response->getBody()->getContents();

            $responseData = json_decode($responseBody, true);

            if (isset($responseData['error']) && is_array($responseData['error']) && !empty($responseData['error'])) {
                $errorMessages = array_map(function ($error) {
                    return $error['to'];
                }, $responseData['error']);

                $errorMessage = implode(', ', $errorMessages);

                return back()->with('flash_message_error', 'An error occurred while sending OTP: ' . $errorMessage);
            }

            return null; // No error
        } catch (Exception $e) {
            return back()->with('flash_message_error', 'An error occurred while sending OTP: ' . $e->getMessage());
        }
    }
}
